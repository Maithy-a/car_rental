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
    <title>Car Rental Portal | My Feedback</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/head.php'); ?>
</head>

<body class="bg-dark">
    <!-- Header -->
    <?php include('includes/header.php'); ?>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">My Feedback</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Feedback</li>
                    </ol>
                </nav>
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

                            <!-- Feedback List -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">My Feedback</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        // Fetch Feedback
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
                                            <div class="alert alert-info d-flex align-items-start" role="alert">
                                                <div class="me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon alert-icon">
                                                        <path d="M12 9v4" />
                                                        <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636-2.87l-8.106-13.536a1.914 1.914 0 0 0-3.274 0z" />
                                                        <path d="M12 16h.01" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="alert-heading mb-1">Uh-oh, something went wrong</h4>
                                                    <p class="mb-0">Sorry, it seems you don’t have any testimonials yet.</p>
                                                    <a class="mt-3" href="post-testimonials.php" style="text-underline-offset: 6px; text-decoration: underline;">Post Feedback !!</a>
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
                    echo '<div class="alert alert-danger" role="alert">No user found.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

</body>

</html>