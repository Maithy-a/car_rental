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
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <span class="avatar avatar-xl"
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
                                            <div class="alert alert-danger" role="alert">
                                                <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } elseif (isset($msg)) { ?>
                                            <div class="alert alert-success" role="alert">
                                                <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } ?>
                                        <form name="chngpwd" method="post" onsubmit="return valid();">
                                            <div class="mb-3">
                                                <label class="form-label" for="password">Current Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="newpassword">New Password</label>
                                                <input type="password" class="form-control" id="newpassword"
                                                    name="newpassword" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="confirmpassword">Confirm Password</label>
                                                <input type="password" class="form-control" id="confirmpassword"
                                                    name="confirmpassword" required>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" name="updatepass" class="btn btn-danger">
                                                    Update Password
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon ms-2 icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
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