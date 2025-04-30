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

<body class="bg-dark">
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
      <section class="page-header aboutus_page">
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
      </section>
      <style>
        .page-detail p {
          line-height: 1.2rem;
        }

        .page-detail {
          text-decoration: underline;
          text-underline-offset: 4px;
          font-size: 15px;
          color: #cabe15;
        }

        ul {
          list-style: none;
        }
      </style>
      <section class="about_us section-padding mt-5 mb-5">
        <div class="container page">
          <div class="section-header">
            <h2 class="mb-4"><?php echo htmlentities($result->PageName); ?></h2>
          </div>
          <div class="page-detail">
            <div class="mb-5 col-md-6 text-white"><?php echo $result->detail; ?> </div>
          </div>

      <?php }
  } ?>
        </div>
      </section>

      <?php include('includes/footer.php'); ?>

</body>

</html>