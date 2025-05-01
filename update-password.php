<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

if (isset($_POST['updatepass'])) {
    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);
    $email = $_SESSION['login'];
    $sql = "SELECT Password FROM tblusers WHERE EmailId=:email AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $con = "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        $msg = "Your Password successfully changed";
    } else {
        $error = "Your current password is wrong";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Car Rental Portal | Update Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('includes/head.php'); ?>
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value !== document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="bg-dark">
    <div class="page">
        <?php include('includes/header.php'); ?>

        <div class="page-header mb-5">
            <div class="container p-5">
                <div class="page-header">
                    <div class="page-heading">
                        <h1>Reset Password</h1>
                    </div>
                    <div aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item">Password Reset</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

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
                                <div class="card p-3 d-flex flex-row align-items-center">
                                    <div class="img-thumbnail me-4 flex-shrink-0">
                                        <img src="assets/images/dealer-logo.jpg" alt="Dealer Logo" class="img-fluid">
                                    </div>
                                    <div class="card-body text-start">
                                        <h3 class="card-title mb-2"><?php echo htmlentities($result->FullName); ?></h3>
                                        <div class="text-muted">
                                            <?php
                                            $address = !empty($result->Address) ? htmlentities($result->Address) : 'Empty';
                                            $city = !empty($result->City) ? htmlentities($result->City) : 'Empty';
                                            $country = !empty($result->Country) ? htmlentities($result->Country) : 'Empty';
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
                                <div class="card mt-3 ">
                                    <div class="card-body">
                                        <?php include('includes/sidebar.php'); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Update Form -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Update Password</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($error)) { ?>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 9v2m0 4v.01" />
                                                            <path
                                                                d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="alert-title">Uh oh, something went wrong</h4>
                                                        <div class="text-secondary"><?php echo htmlentities($error); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                            </div>
                                        <?php } elseif (isset($msg)) { ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                    <div class="me-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M5 12l5 5l10 -10" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="alert-title">Wow! Everything worked!</h4>
                                                        <div class="text-secondary"><?php echo htmlentities($msg); ?></div>
                                                    </div>
                                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <form name="chngpwd" method="post" onsubmit="return valid();">
                                            <div class="mb-3">
                                                <label class="form-label" for="password">Current Password</label>
                                                <input type="password" class="form-control" id="password" placeholder="Enter current password" name="password"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="newpassword">New Password</label>
                                                <input type="password" class="form-control" placeholder="Enter new password" id="newpassword"
                                                    name="newpassword" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="confirmpassword">Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="Enter new password" id="confirmpassword"
                                                    name="confirmpassword" required>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" name="updatepass" class="btn btn-danger">
                                                    Update Password
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon ms-2 icon-tabler icons-tabler-outline icon-tabler-chevron-right">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M9 6l6 6l-6 6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
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
    <?php include('includes/footer.php'); ?>

</body>

</html>