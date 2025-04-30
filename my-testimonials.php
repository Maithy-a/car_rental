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
    <title>Car Rental Portal | My Testimonials</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/head.php'); ?>
</head>
<body data-bs-theme="dark" class="bg-dark">
    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <!-- Page content -->
    <div class="page">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page header -->
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="page-title">My Testimonials</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Testimonials</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

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
                                            <span class="avatar avatar-xl rounded" style="background-image: url(assets/images/dealer-logo.jpg)"></span>
                                        </div>
                                        <h3 class="card-title"><?php echo htmlentities($result->FullName); ?></h3>
                                        <div class="text-muted mb-3">
                                            <?php echo htmlentities($result->Address); ?><br>
                                            <?php echo htmlentities($result->City); ?>, <?php echo htmlentities($result->Country); ?>
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

                            <!-- Testimonials List -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">My Testimonials</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // Fetch testimonials
                                        $sql = "SELECT * FROM tbltestimonial WHERE UserEmail=:useremail";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <p class="mb-2"><?php echo htmlentities($result->Testimonial); ?></p>
                                                        <div class="text-muted mb-2">
                                                            <strong>Posting Date:</strong> <?php echo htmlentities($result->PostingDate); ?>
                                                        </div>
                                                        <div>
                                                            <?php if ($result->status == 1) { ?>
                                                                <span class="badge bg-success">Active</span>
                                                            <?php } else { ?>
                                                                <span class="badge bg-warning">Waiting for approval</span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="alert alert-info" role="alert">
                                                No testimonials found.
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

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <script src="assets/switcher/js/switcher.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>