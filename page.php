<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental Portal | Page details</title>
  <?php include('includes/head.php'); ?>
</head>

<body bs-theme="dark" class="bg-dark">
  <?php include('includes/header.php'); ?>
  <?php
  $pagetype = $_GET['type'];
  $sql = "SELECT type,detail,PageName from tblpages where type=:pagetype";
  $query = $dbh->prepare($sql);
  $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
      <section class="page-header aboutus_page"  style="background-image: url(https://images.pexels.com/photos/31779012/pexels-photo-31779012/free-photo-of-white-car-at-night-on-urban-street-in-kokotow.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);">
        <div class="container">
          <div class="page-header">
            <div class="page-heading">
              <h1><?php echo htmlentities($result->PageName); ?></h1>
            </div>
            <nav aria-label="breadcrum">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Home</a></li>
                <li class="breadcrumb-item"><?php echo htmlentities($result->PageName); ?></li>
              </ol>
            </nav>
          </div>
        </div>
        <!-- Dark Overlay-->
        <div class="dark-overlay"></div>
      </section>
      <section class="about_us section-padding mt-5 mb-5">
        <div class="container">
          <div class="section-header text-center">
            <h2><?php echo htmlentities($result->PageName); ?></h2>
            <p><?php echo $result->detail; ?> </p>
          </div>
        <?php }
  } ?>
    </div>
  </section>

  <?php include('includes/footer.php'); ?>

</body>

</html>