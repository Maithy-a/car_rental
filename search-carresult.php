<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental Portal | Car Listing</title>
  <?php include('includes/head.php'); ?>
  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->
</head>

<body class="bg-dark p-0" style="padding: 0; margin: 0;">
  <div class="page-header listing_page mb-5">
    <div class="container p-5">
      <div class="page-header">
        <div class="page-heading">
          <h1>Car Listing</h1>
        </div>
        <div aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Home</a></li>
            <li class="breadcrumb-item">Car Listing</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!--Listing-->
  <div class="listing-page mb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-md-push-3">
          <div class="result-sorting-wrapper">
            <div class="sorting-count">
              <?php
              $brand = $_POST['brand'];
              $fueltype = $_POST['fueltype'];
              $sql = "SELECT id FROM tblvehicles WHERE tblvehicles.VehiclesBrand = :brand AND tblvehicles.FuelType = :fueltype";
              $query = $dbh->prepare($sql);
              $query->bindParam(':brand', $brand, PDO::PARAM_STR);
              $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = $query->rowCount();
              ?>
              <p><span><?php echo htmlentities($cnt); ?> Listings</span></p>
            </div>
          </div>

          <?php
          $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand WHERE tblvehicles.VehiclesBrand = :brand AND tblvehicles.FuelType = :fueltype";
          $query = $dbh->prepare($sql);
          $query->bindParam(':brand', $brand, PDO::PARAM_STR);
          $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
              <div class="product-listing-m">
                <div class="product-listing-img">
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                    <?php if (!empty($result->Vimage1)) { ?>
                      <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>" class="img-responsive"
                        alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                    <?php } else { ?>
                      <img src="assets/images/placeholder.jpg" class="img-responsive" alt="No image available">
                    <?php } ?>
                  </a>
                </div>
                <div class="product-listing-content">
                  <h5>
                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                      <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?>
                    </a>
                  </h5>
                  <p class="list-price">KES <?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
                  <ul>
                    <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?>
                      seats</li>
                    <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?>
                      model</li>
                    <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                  </ul>
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View Details <span
                      class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                </div>
              </div>
            <?php }
          } ?>
        </div>

        <!--Side-Bar-->
        <aside class="col-md-3 col-md-pull-9">
          <div class="sidebar_widget">
            <div class="widget_heading">
              <h3 class="widget-title text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path
                    d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                </svg>
                Find Your Car
              </h3>
            </div>
            <div class="sidebar_filter">
              <form action="#" method="get">
                <div class="form-group select mb-3">
                  <select class="form-select mb-3">
                    <option>Select Brand</option>
                    <?php
                    $sql = "SELECT * FROM tblbrands";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                      foreach ($results as $result) { ?>
                        <option value="<?php echo htmlentities($result->id); ?>">
                          <?php echo htmlentities($result->BrandName); ?>
                        </option>
                      <?php }
                    } ?>
                  </select>
                </div>
                <div class="form-group select mb-3">
                  <select class="form-select mb-3">
                    <option>Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="CNG">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <button type="submit" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                      <path d="M21 21l-6 -6" />
                    </svg> Search Car</button>
                </div>
              </form>
            </div>
          </div>

          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-car" aria-hidden="true"></i> Recently Listed Cars</h5>
            </div>
            <div class="recent_addedcars">
              <ul>
                <?php
                $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand ORDER BY id DESC LIMIT 4";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) { ?>
                    <li class="gray-bg">
                      <div class="recent_post_img">
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <?php if (!empty($result->Vimage1)) { ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>"
                              alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                          <?php } else { ?>
                            <img src="assets/images/placeholder.jpg" alt="No image available">
                          <?php } ?>
                        </a>
                      </div>
                      <div class="recent_post_title">
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <?php echo htmlentities($result->BrandName); ?>,
                          <?php echo htmlentities($result->VehiclesTitle); ?>
                        </a>
                        <p class="widget_price">KES <?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
                      </div>
                    </li>
                  <?php }
                } ?>
              </ul>
            </div>
          </div>
        </aside>
        <!--/Side-Bar-->
      </div>
    </div>
  </div>
  <!-- /Listing-->

  <?php include('includes/footer.php'); ?>

</body>

</html>