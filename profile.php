<?php
session_start();
error_reporting(0);
include 'includes/config.php';

if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
  exit();
}

if (isset($_POST['updateprofile'])) {
  $name = $_POST['fullname'];
  $mobileno = $_POST['mobilenumber'];
  $dob = $_POST['dob'];
  $adress = $_POST['address'];
  $city = $_POST['city'];
  $country = $_POST['country'];
  $email = $_SESSION['login'];
  $sql = "UPDATE tblusers SET FullName=:name, ContactNo=:mobileno, dob=:dob, Address=:adress, City=:city, Country=:country WHERE EmailId=:email";
  $query = $dbh->prepare($sql);
  $query->bindParam(':name', $name, PDO::PARAM_STR);
  $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
  $query->bindParam(':dob', $dob, PDO::PARAM_STR);
  $query->bindParam(':adress', $adress, PDO::PARAM_STR);
  $query->bindParam(':city', $city, PDO::PARAM_STR);
  $query->bindParam(':country', $country, PDO::PARAM_STR);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->execute();
  $msg = "Profile Updated Successfully";
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental Portal | My Profile</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include 'includes/head.php'; ?>
</head>
<?php include 'includes/header.php'; ?>

<body  class="bg-dark">

  <!-- Page Header -->
  <div class="page-header py-5">
    <div class="container">
      <div class="text-center">
        <h1 class="display-4 fw-bold text-white">User Profile</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">My Profile</li>
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
        <!-- Profile Card -->
        <div class="col-lg-4 -lg-4">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-3">
                <span class="avatar avatar-xl"
                  style="background-image: url(assets/images/dealer-logo.jpg)"></span>
              </div>
              <h3 class="card-title"><?php echo htmlentities($result->FullName); ?></h3>
              <div class="">
                <?php echo htmlentities($result->Address); ?><br>
                <?php echo htmlentities($result->City); ?>, <?php echo htmlentities($result->Country); ?>
              </div>
            </div>
          </div>
          <!-- Sidebar -->
          <div class="card mt-4">
            <div class="card-body">
              <?php include('includes/sidebar.php'); ?>
            </div>
          </div>
        </div>

        <!-- Profile Form -->
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <?php if (isset($msg)) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                  <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
              <?php } ?>
              <form method="post">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Registration Date</label>
                    <div class="form-control-plaintext "><?php echo htmlentities($result->RegDate); ?></div>
                  </div>
                  <?php if ($result->UpdationDate != "") { ?>
                    <div class="col-md-6">
                      <label class="form-label">Last Updated</label>
                      <div class="form-control-plaintext "><?php echo htmlentities($result->UpdationDate); ?>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="col-md-6">
                    <label class="form-label" for="fullname">Full Name</label>
                    <input type="text" class="form-control  " name="fullname" id="fullname"
                      value="<?php echo htmlentities($result->FullName); ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" class="form-control  " name="emailid" id="email"
                      value="<?php echo htmlentities($result->EmailId); ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="phone-number">Phone Number</label>
                    <input type="text" class="form-control  " name="mobilenumber" id="phone-number"
                      value="<?php echo htmlentities($result->ContactNo); ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="birth-date">Date of Birth (dd/mm/yyyy)</label>
                    <input type="text" class="form-control " name="dob" id="birth-date"
                      value="<?php echo htmlentities($result->dob); ?>" placeholder="dd/mm/yyyy">
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="address">Address</label>
                    <textarea class="form-control " name="address" id="address"
                      rows="4"><?php echo htmlentities($result->Address); ?></textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="country">Country</label>
                    <input type="text" class="form-control " name="country" id="country"
                      value="<?php echo htmlentities($result->Country); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="city">City</label>
                    <input type="text" class="form-control " name="city" id="city"
                      value="<?php echo htmlentities($result->City); ?>">
                  </div>
                  <div class="col-12">
                    <button type="submit" name="updateprofile" class="btn btn-danger">
                      Save Changes
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <polyline points="9 6 15 12 9 18" />
                      </svg>
                    </button>
                  </div>
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

  <?php include 'includes/footer.php'; ?>
</body>

</html>