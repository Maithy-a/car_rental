<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}
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
    <!-- Header -->
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
                            <!-- User Info Card and Sidebar -->
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <span class="avatar avatar-xl rounded"
                                                style="background-image: url(assets/images/dealer-logo.jpg)"></span>
                                        </div>
                                        <h3 class="card-title"><?php echo htmlentities($user->FullName); ?></h3>
                                        <div class="text-muted mb-3">
                                            <?php echo htmlentities($user->Address); ?><br>
                                            <?php echo htmlentities($user->City); ?>,
                                            <?php echo htmlentities($user->Country); ?>
                                        </div>
                                    </div>
                                </div>
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
                                                                        href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>" >
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
                                                                        <span class="badge bg-success p-2 text-white">Confirmed</span>
                                                                    <?php } elseif ($result->Status == 2) { ?>
                                                                        <span class="badge bg-danger p-2 text-white">Cancelled</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-warning p-2 text-white">Not Confirmed Yet</span>
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
                                                                        <button type="button"
                                                                                class="btn btn-danger w-100 pay-now-btn"
                                                                                data-amount="<?php echo $amount; ?>"
                                                                                data-booking="<?php echo htmlentities($result->BookingNumber); ?>"
                                                                                <?php echo ($result->Status != 1) ? 'disabled' : ''; ?>>
                                                                                PAY NOW
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-info" role="alert">
                                                No bookings found.
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo '<div class="alert alert-danger" role="alert">No user found.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const payButtons = document.querySelectorAll('.pay-now-btn');
            
            payButtons.forEach(button => {
                button.addEventListener('click', function (e) {
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
                        amount: Math.round(amount * 100), // Convert to kobo
                        currency: 'KES',
                        ref: 'CR_' + bookingNumber + '_' + Math.floor((Math.random() * 1000000000) + 1),
                        metadata: {
                            booking_number: bookingNumber,
                            user_id: '<?php echo htmlspecialchars($user->EmailId); ?>'
                        },
                        onClose: function () {
                            alert('Transaction was not completed, window closed.');
                        },
                        callback: function (response) {
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
                                    window.location.reload(); // Refresh to show updated status
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