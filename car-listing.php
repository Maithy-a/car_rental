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
      <div class="row" style="padding: 50px;">
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

              <div class="alert alert-info" role="alert">
                <div class="alert-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="icon alert-icon icon-2">
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                    <path d="M12 9h.01" />
                    <path d="M11 12h1v4h1" />
                  </svg>
                </div>
                <div>
                  <h4 class="alert-heading">Number of cars Listed?</h4>
                  <div class="alert-description">
                    <?php echo htmlentities($cnt); ?>
                    Listings
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="car-listing-grid">
            <?php
            $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
              foreach ($results as $result) { ?>
                <div class="car-item">
                  <div class="recent-car-list">
                    <div class="car-info-box">
                      <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                        <?php if (!empty($result->Vimage1)) { ?>
                          <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>" class="car-image"
                            alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                        <?php } else { ?>
                          <img src="img/placeholder.jpg" class="car-image" alt="No image available">
                        <?php } ?>
                      </a>
                      <ul class="car-specs">
                        <li>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" aria-hidden="true"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-gas-station">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 11h1a2 2 0 0 1 2 2v3a1.5 1.5 0 0 0 3 0v-7l-3 -3" />
                            <path d="M4 20v-14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v14" />
                            <path d="M3 20l12 0" />
                            <path d="M18 7v1a1 1 0 0 0 1 1h1" />
                            <path d="M4 11l10 0" />
                          </svg><?php echo htmlentities($result->FuelType); ?>
                        </li>
                        <li>
                          <?php echo htmlentities($result->ModelYear); ?> Model
                        </li>
                        <li>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" aria-hidden="true"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icon-tabler-users">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                          </svg>
                          <?php echo htmlentities($result->SeatingCapacity); ?> Seats
                        </li>
                      </ul>
                      <div class="car-specs">
                        <h5>
                          <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                            <?php echo htmlentities($result->BrandName); ?>,
                            <?php echo htmlentities($result->VehiclesTitle); ?>
                          </a>
                        </h5>
                        <p class="list-price">KES <?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
                      </div>
                      <div class="recent_post_title border-top" style="background-color: white;">
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"
                          class="btn btn-square btn-danger">View Details
                          <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php }
            } ?>
          </div>
        </div>

        <aside class="col-md">
          <div class="sidebar_widget">
            <div class="widget_heading">
              <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
            </div>
            <div class="sidebar_filter">
              <form action="search-carresult.php" method="post">
                <div class="mb-3">
                  <select class="form-select" name="brand" required="required">
                    <option value="">Select Brand</option>
                    <?php
                    $sql = "SELECT * FROM tblbrands";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
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
                  <button type="submit" class="btn btn-block w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                      <path d="M21 21l-6 -6" />
                    </svg>Search
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="sidebar_widget pt-3">
            <div class="widget_heading">
              <p class="text-secondary">
                <i class="fa-solid fa-car"></i> Recently Listed Cars
              </p>
            </div>
            <div class="recent_addedcars">
              <div class="recent_addedcar_list">
                <?php
                $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand ORDER BY id DESC LIMIT 4";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
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