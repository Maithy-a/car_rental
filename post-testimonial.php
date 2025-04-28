<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $testimonoial = $_POST['testimonial'];
    $email = $_SESSION['login'];
    $sql = "INSERT INTO tbltestimonial(UserEmail,Testimonial) VALUES(:email,:testimonoial)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':testimonoial', $testimonoial, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Testimonial submitted successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Car Rental Portal | Post Testimonial</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/head.php'); ?>
    <?php include('includes/header.php'); ?>
</head>

<body data-bs-theme="dark" class=" text-white">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Post Testimonial</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Post Testimonial</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Content -->
    <div class="container-xl py-5">

        <?php
        $useremail = $_SESSION['login'];
        $sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
        $query = $dbh->prepare($sql);
        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            $result = $results[0];
            ?>
            <div class="row g-4">
                <!-- User Info Card -->
                <div class="col-lg-4">
                    <div class="card row align-items-center flex-row flex-md-column text-center text-md-start">
                        <span class="avatar-xl" style="background-image:images/dealer-logo.jpg;"></span>
                        <div class="card-body">
                            <h3 class="card-title text-white"><?php echo htmlentities($result->FullName); ?></h3>
                            <div class="text-muted">
                                <?php echo htmlentities($result->Address); ?><br>
                                <?php echo htmlentities($result->City); ?>,
                                <?php echo htmlentities($result->Country); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar -->
                    <div class="card   mt-4">
                        <div class="card-body">
                            <?php include('includes/sidebar.php'); ?>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Form -->
                <div class="col-lg-8">
                    <div class="card  ">
                        <div class="card-header">
                            <h3 class="card-title text-white">Post a Testimonial</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                </div>
                            <?php } elseif (isset($msg)) { ?>
                                <div class="alert alert-success" role="alert">
                                    <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                </div>
                            <?php } ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label" for="testimonial">Your Testimonial</label>
                                    <textarea class="form-control  text-white " name="testimonial" id="testimonial" rows="6"
                                        required></textarea>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        Submit Testimonial
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <polyline points="9 6 15 12 9 18" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
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

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

</body>

</html>