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

<body bs-theme="dark" class="bg-dark">
    <!-- Header -->
    <?php include('includes/header.php'); ?>
    <div class="page-header mb-5"
        style="background-image: url(https://images.pexels.com/photos/31779012/pexels-photo-31779012/free-photo-of-white-car-at-night-on-urban-street-in-kokotow.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);">
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
                    $result = $results[0]; // Expecting only one user
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
                                        <h3 class="card-title"><?php echo htmlentities($result->FullName); ?></h3>
                                        <div class="text-muted mb-3">
                                            <?php echo htmlentities($result->Address); ?><br>
                                            <?php echo htmlentities($result->City); ?>,
                                            <?php echo htmlentities($result->Country); ?>
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
                                    <div class="card-header">
                                        <h3 class="card-title">My Bookings</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // Fetch bookings
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
                                            foreach ($results as $result) { ?>
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h4 class="text-danger mb-3">Booking No
                                                            #<?php echo htmlentities($result->BookingNumber); ?></h4>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <a
                                                                    href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                                                                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>"
                                                                        alt="vehicle" class="img-fluid rounded">
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
                                                                        <span class="badge bg-success">Confirmed</span>
                                                                    <?php } elseif ($result->Status == 2) { ?>
                                                                        <span class="badge bg-danger">Cancelled</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-warning">Not Confirmed Yet</span>
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
                                                                        <td><?php echo htmlentities($tds = $result->totaldays); ?>
                                                                        </td>
                                                                        <td><?php echo htmlentities($ppd = $result->PricePerDay); ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="4" class="text-center">Grand Total</th>
                                                                        <th><?php echo htmlentities($tds * $ppd); ?></th>
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

    <!-- Back to top -->
    <div id="back-top" class="back-top">
        <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    </div>

    <!-- Login/Registration/Forgot Password Includes -->
    <?php include('includes/login.php'); ?>
    <?php include('includes/registration.php'); ?>
    <?php include('includes/forgotpassword.php'); ?>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/switcher/js/switcher.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
</body>

</html>