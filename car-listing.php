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
</head>

<body class="bg-dark">
  <?php include('includes/header.php'); ?>
  <div class="page-header listing_page">
    <div class="container p-5">
      <div class="page-header_wrap">
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
  <section class="listing-page mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-md-push-3">
          <div class="result-sorting-wrapper">
            <div class="sorting-count">
              <?php
              $sql = "SELECT id FROM tblvehicles";
              $query = $dbh->prepare($sql);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = $query->rowCount();
              ?>
              <p><span><?php echo htmlentities($cnt); ?> Listings</span></p>
            </div>
          </div>

          <?php
          $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand";
          $query = $dbh->prepare($sql);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
              <div class="col-md">
                <div class="recent-car-list">
                  <div class="car-info-box">
                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                      <?php if (!empty($result->Vimage1)) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>" class=""
                          alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                      <?php } else { ?>
                        <img src="img/placeholder.jpg" class="" alt="No image available">
                      <?php } ?>
                    </a>
                    <div class="car-specs">
                      <h5>
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <?php echo htmlentities($result->BrandName); ?>,
                          <?php echo htmlentities($result->VehiclesTitle); ?>
                        </a>
                      </h5>
                      <p class="list-price">KES <?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
                      <ul>
                        <li><i class="fa fa-user"
                            aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?>
                          seats</li>
                        <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?>
                          model</li>
                        <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                      </ul>
                    </div>
                    <div class="recent_post_title border-top">
                      <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"
                        class="btn btn-square">View Details
                        <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                    </div>
                  </div>

                </div>
              </div>
          <?php }
          } ?>
        </div>

        <aside class="col-md">
          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
            </div>
            <div class="sidebar_filter">
              <form action="search-carresult.php" method="post">
                <div class="mb-3">
                  <select class="form-select" name="brand" required="required" required>
                    <option value="">Select Brand</option>
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
                <div class="mb-3">
                  <label class="form-label">Select Fuel Type</label>
                  <select class="form-select" name="fueltype">
                    <option value="">Select Fuel Type</option>
                    <option value="Petrol" <?php echo ($fueltype == 'Petrol') ? 'selected' : ''; ?>>Petrol</option>
                    <option value="Diesel" <?php echo ($fueltype == 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                    <option value="Electric" <?php echo ($fueltype == 'Electric') ? 'selected' : ''; ?>>Electric</option>
                    <option value="Hybrid" <?php echo ($fueltype == 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                  </select>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-block">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                      <path d="M21 21l-6 -6" />
                    </svg> Search
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="sidebar_widget">
            <div class="widget_heading">
              <h3>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-car-suv">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M16 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M5 9l2 -4h7.438a2 2 0 0 1 1.94 1.515l.622 2.485h3a2 2 0 0 1 2 2v3" />
                  <path d="M10 9v-4" />
                  <path d="M2 7v4" />
                  <path
                    d="M22.001 14.001a4.992 4.992 0 0 0 -4.001 -2.001a4.992 4.992 0 0 0 -4 2h-3a4.998 4.998 0 0 0 -8.003 .003" />
                  <path d="M5 12v-3h13" />
                </svg> Recently Listed Cars
              </h3>
            </div>

            <div class="recent_addedcars">
              <div class="recent_addedcar_list">
                <?php
                $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand ORDER BY id DESC LIMIT 4";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) { ?>
                    <div class="gap-3 border">
                      <div class="recent_post_img mt-3">
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <?php if (!empty($result->Vimage1)) { ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>"
                              alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                          <?php } else { ?>
                            <img src="img/placeholder.jpg" alt="No image available">
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
                  <?php }
                } ?>
                    </div>
              </div>
            </div>
        </aside>
      </div>
    </div>
  </section>
  <?php include('includes/footer.php'); ?>

</body>

</html>