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

<body data-bs-theme="dark" class="bg-dark">
  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->

  <!--Page Header-->
  <div class="page-header listing_page mb-5"
    style="background-image: url(https://images.pexels.com/photos/31779012/pexels-photo-31779012/free-photo-of-white-car-at-night-on-urban-street-in-kokotow.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);">
    <div class="container p-5">
      <div class="page-header">
        <div class="page-heading">
          <h1>Search Result of keyword "<?php echo htmlentities($_POST['searchdata']); ?>"</h1>
        </div>
        <div aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Home</a></li>
            <li class="breadcrumb-item">Car Listing</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-30"></div>
  </div>
  <!-- /Page Header-->

  <!--Listing-->
  <section class="listing-page">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-md-push-3">
          <div class="result-sorting-wrapper">
            <div class="sorting-count">
              <?php
              // Query for Listing count
              $searchdata = $_POST['searchdata'];
              $sql = "SELECT tblvehicles.id FROM tblvehicles 
                      JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                      WHERE tblvehicles.VehiclesTitle = :search OR tblvehicles.FuelType = :search OR tblbrands.BrandName = :search OR tblvehicles.ModelYear = :search";
              $query = $dbh->prepare($sql);
              $query->bindParam(':search', $searchdata, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $cnt = $query->rowCount();
              ?>
              <p><span><?php echo htmlentities($cnt); ?> Listings found against search</span></p>
            </div>
          </div>

          <?php
          $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles 
                  JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                  WHERE tblvehicles.VehiclesTitle = :search OR tblvehicles.FuelType = :search OR tblbrands.BrandName = :search OR tblvehicles.ModelYear = :search";
          $query = $dbh->prepare($sql);
          $query->bindParam(':search', $searchdata, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
              <div class="product-listing-m gray-bg">
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
          } else { ?>
            <div class="alert alert-info">No vehicles found matching your search criteria.</div>
          <?php } ?>
        </div>

        <!--Side-Bar-->
        <aside class="col-md-3 col-md-pull-9">
          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
            </div>
            <div class="sidebar_filter">
              <form action="search-carresult.php" method="post">
                <div class="fform-group select mb-3">
                  <select class="form-select mb-3" name="brand">
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
                <div class="form-group select mb-3">
                  <select class="form-select mb-3" name="fueltype">
                    <option value="">Select Fuel Type</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <button type="submit" class="btn btn-block">
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
              <h5>
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
                </svg>
                Recently Listed Cars
              </h5>
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
                    <aside class="featured-car-listing">
                      <div class="recent_addedcars_img gap-2">
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
                    </aside>
                  <?php }
                } ?>
              </ul>
            </div>
          </div>
        </aside>
        <!--/Side-Bar-->
      </div>
    </div>
  </section>

  <?php include('includes/footer.php'); ?>

</body>

</html>