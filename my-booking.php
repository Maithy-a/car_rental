<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

// Check for payment success message
$paymentSuccess = isset($_SESSION['payment_success']) ? $_SESSION['payment_success'] : null;
unset($_SESSION['payment_success']); // Clear the message after displaying
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Car Rental Portal | My Booking</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/head.php'); ?>
</head>

<body class="bg-dark">
    <?php include('includes/header.php'); ?>
    <div class="page-header mb-5">
        <div class="container p-5">
            <div class="page-header">
                <div class="page-heading">
                    <h1>BOOKINGS</h1>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item">My Bookings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="page">
        <div class="page-wrapper">
            <div class="container-xl">
                <?php
                $useremail = $_SESSION['login'];
                // Fetch user data
                $sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
                $query = $dbh->prepare($sql);
                $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() > 0) {
                    $user = $results[0]; // Expecting only one user
                ?>
                    <div class="page-body">
                        <div class="row row-cards">
                            <div class="col-lg-4">
                                <div class="card p-3 d-flex flex-row align-items-center">
                                    <div class="img-thumbnail me-4 flex-shrink-0">
                                        <img src="assets/images/dealer-logo.jpg" alt="Dealer Logo" class="img-fluid">
                                    </div>
                                    <div class="card-body text-start">
                                        <h3 class="card-title mb-2"><?php echo htmlentities($user->FullName); ?></h3>
                                        <div class="text-muted">
                                            <?php
                                            $address = !empty($user->Address) ? htmlentities($user->Address) : 'Empty';
                                            $city = !empty($user->City) ? htmlentities($user->City) : 'Empty';
                                            $country = !empty($user->Country) ? htmlentities($user->Country) : 'Empty';
                                            echo $address . '<br>' . $city . ', ' . $country;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .img-thumbnail {
                                        width: 100px;
                                        height: 100px;
                                        overflow: hidden;
                                        border-radius: 0px;
                                        background-color: transparent;
                                        box-shadow: none;
                                    }

                                    .img-thumbnail img {
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                    }
                                </style>
                                <!-- Sidebar -->
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <?php include('includes/sidebar.php'); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Bookings List -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <h3 class="card-title h2">MY BOOKINGS</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($paymentSuccess) { ?>
                                            <div class="alert alert-success d-flex align-items-start" role="alert">
                                                <div class="me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="alert-heading mb-1">Payment Successful!</h4>
                                                    <p class="mb-0"><?php echo htmlentities($paymentSuccess); ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $sql = "SELECT tblvehicles.Vimage1 as Vimage1, tblvehicles.VehiclesTitle, tblvehicles.id as vid, tblbrands.BrandName, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.Status, tblvehicles.PricePerDay, DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) as totaldays, tblbooking.BookingNumber 
                                                FROM tblbooking 
                                                JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id 
                                                JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                                                WHERE tblbooking.userEmail = :useremail 
                                                ORDER BY tblbooking.id DESC";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                $totalDays = max(1, (int)$result->totaldays); // Ensure at least 1 day
                                                $pricePerDay = (float)$result->PricePerDay;
                                                $amount = $totalDays * $pricePerDay;

                                                // Check if a successful transaction exists for this booking
                                                $transactionSql = "SELECT * FROM tbltransactions WHERE BookingNumber = :bookingNumber AND PaymentStatus = 1";
                                                $transactionQuery = $dbh->prepare($transactionSql);
                                                $transactionQuery->bindParam(':bookingNumber', $result->BookingNumber, PDO::PARAM_STR);
                                                $transactionQuery->execute();
                                                $transaction = $transactionQuery->fetch(PDO::FETCH_OBJ);
                                                $isPaid = $transactionQuery->rowCount() > 0;
                                        ?>
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h4 class="text-danger mb-3">Booking No
                                                            #<?php echo htmlentities($result->BookingNumber); ?></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <a
                                                                    href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>"
                                                                        class="image"
                                                                        alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h5>
                                                                    <a
                                                                        href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                                                                        <?php echo htmlentities($result->BrandName); ?>,
                                                                        <?php echo htmlentities($result->VehiclesTitle); ?>
                                                                    </a>
                                                                </h5>
                                                                <p class="text-muted">
                                                                    <strong>From:</strong>
                                                                    <?php echo htmlentities($result->FromDate); ?> <br>
                                                                    <strong>To:</strong>
                                                                    <?php echo htmlentities($result->ToDate); ?>
                                                                </p>
                                                                <p><strong>Message:</strong>
                                                                    <?php echo htmlentities($result->message); ?></p>
                                                                <div>
                                                                    <?php if ($result->Status == 1) { ?>
                                                                        <span class="badge bg-success me-2 text-white">Confirmed</span>
                                                                    <?php } elseif ($result->Status == 2) { ?>
                                                                        <span class="badge bg-danger me-2 text-white">Cancelled</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-warning me-2 text-white">Not Confirmed Yet</span>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h5 class="mt-4 text-primary">Invoice</h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Car Name</th>
                                                                        <th>From Date</th>
                                                                        <th>To Date</th>
                                                                        <th>Total Days</th>
                                                                        <th>Rent / Day</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><?php echo htmlentities($result->VehiclesTitle); ?>,
                                                                            <?php echo htmlentities($result->BrandName); ?>
                                                                        </td>
                                                                        <td><?php echo htmlentities($result->FromDate); ?></td>
                                                                        <td><?php echo htmlentities($result->ToDate); ?></td>
                                                                        <td><?php echo htmlentities($totalDays); ?>
                                                                        </td>
                                                                        <td><?php echo htmlentities($pricePerDay); ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="4" class="text-center">Grand Total</th>
                                                                        <th><?php echo htmlentities($amount); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <?php if ($isPaid) { ?>
                                                                                <button type="button" class="btn btn-success w-100" disabled>
                                                                                    PAID
                                                                                </button>
                                                                            <?php } else { ?>
                                                                                <button type="button"
                                                                                    class="btn btn-danger w-100 pay-now-btn"
                                                                                    data-amount="<?php echo $amount; ?>"
                                                                                    data-booking="<?php echo htmlentities($result->BookingNumber); ?>"
                                                                                    <?php echo ($result->Status != 1) ? 'disabled' : ''; ?>>
                                                                                    PAY NOW
                                                                                </button>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-info d-flex align-items-start" role="alert">
                                                <div class="me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon alert-icon icons-tabler-outline icon-tabler-message-2-exclamation">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M8 9h8" />
                                                        <path d="M8 13h6" />
                                                        <path d="M15 18l-3 3l-3 -3h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5" />
                                                        <path d="M19 16v3" />
                                                        <path d="M19 22v.01" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="alert-heading mb-1">Uh-oh, something went wrong</h4>
                                                    <p class="mb-0">Sorry, it seems you don’t have any bookings yet.</p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<div class="alert alert-danger" role="alert">No user yet.</div>';
                }
                ?>
            </div>
            <?php include('includes/footer') ?>
        </div>
    </div>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const payButtons = document.querySelectorAll('.pay-now-btn');

            payButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const amount = parseFloat(this.getAttribute('data-amount'));
                    const bookingNumber = this.getAttribute('data-booking');

                    if (!amount || amount <= 0) {
                        alert('Invalid payment amount');
                        return;
                    }

                    let handler = PaystackPop.setup({
                        key: '<?php echo htmlspecialchars($PublicKey); ?>',
                        email: '<?php echo htmlspecialchars($user->EmailId); ?>',
                        amount: Math.round(amount * 100),
                        currency: 'KES',
                        ref: 'CR_' + bookingNumber + '_' + Math.floor((Math.random() * 1000000000) + 1),
                        metadata: {
                            booking_number: bookingNumber,
                            user_id: '<?php echo htmlspecialchars($user->EmailId); ?>'
                        },
                        onClose: function() {
                            alert('Transaction was not completed, window closed.');
                        },
                        callback: function(response) {
                            // Verify transaction on server
                            fetch('api/verify_transaction.php?reference=' + response.reference, {
                                    method: 'GET',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        alert('Payment successful! Reference: ' + response.reference);
                                        window.location.reload();
                                    } else {
                                        alert('Payment verification failed: ' + (data.message || 'Unknown error'));
                                    }
                                })
                                .catch(error => {
                                    alert('Error verifying payment: ' + error.message);
                                });
                        }
                    });

                    handler.openIframe();
                });
            });
        });
    </script>
</body>

</html>