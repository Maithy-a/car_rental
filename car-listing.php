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
  <div class="page-header">
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
                <div class="car-info-box card car-card mb-4 border-0">
                  <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>">
                    <?php if (!empty($result->Vimage1)) { ?>
                      <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>"
                        class="car-image card-img-top"
                        alt="<?php echo htmlspecialchars($result->VehiclesTitle); ?>">
                    <?php } else { ?>
                      <img src="img/placeholder.jpg"
                        class="car-image card-img-top"
                        alt="No image available">
                    <?php } ?>
                  </a>

                  <ul class="car-specs list-unstyled px-3 py-2">
                    <li class="mb-1 d-flex align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 11h1a2 2 0 0 1 2 2v3a1.5 1.5 0 0 0 3 0v-7l-3 -3" />
                        <path d="M4 20v-14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v14" />
                        <path d="M3 20l12 0" />
                        <path d="M18 7v1a1 1 0 0 0 1 1h1" />
                        <path d="M4 11l10 0" />
                      </svg>
                      <?php echo htmlspecialchars($result->FuelType); ?>
                    </li>
                    <li class="mb-1">
                      <?php echo htmlspecialchars($result->ModelYear); ?>Model
                    </li>
                    <li class="mb-1 d-flex align-items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                      </svg>
                      <?php echo htmlspecialchars($result->SeatingCapacity); ?>Seats
                    </li>
                  </ul>

                  <div class="card-body">
                    <h5 class="card-title text-uppercase mb-1">
                      <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>"
                        class="text-dark">
                        <?php echo htmlspecialchars($result->VehiclesTitle); ?>
                      </a>
                    </h5>
                    <div class="text-danger mb-1 small">
                      KES <?php echo number_format((int)$result->PricePerDay); ?> Per day
                    </div>
                    <p class="card-text text-muted">
                      <?php echo htmlspecialchars(substr($result->VehiclesOverview, 0, 150)); ?> ...
                    </p>
                  </div>

                  <div class="card-footer bg-white border-top">
                    <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>" class="btn btn-danger w-100 d-flex justify-content-between align-items-center">View Details
                      <span class="angle_arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right-dashed">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M5 12h.5m3 0h1.5m3 0h6" />
                          <path d="M15 16l4 -4" />
                          <path d="M15 8l4 4" />
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>


            <?php }
            } ?>
          </div>
        </div>

        <!-- Sidebar -->
        <aside class="col-md-3">
          <!-- Filter Form -->
          <div class="mb-4">
            <div class="card shadow-sm">
              <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fa fa-filter me-2"></i> Find Your Car</h6>
              </div>
              <div class="card-body">
                <form action="search-carresult.php" method="post">
                  <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <select class="form-select" name="brand">
                      <option value="">Select Brand</option>
                      <?php
                      $sql = "SELECT * FROM tblbrands";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $brands = $query->fetchAll(PDO::FETCH_OBJ);
                      foreach ($brands as $brand) {
                        echo '<option value="' . htmlspecialchars($brand->id) . '">' . htmlspecialchars($brand->BrandName) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Fuel Type</label>
                    <select class="form-select" name="fueltype">
                      <option value="">Select Fuel Type</option>
                      <option value="Petrol">Petrol</option>
                      <option value="Diesel">Diesel</option>
                      <option value="Electric">Electric</option>
                      <option value="Hybrid">Hybrid</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-danger w-100">
                    <i class="fa fa-search me-2"></i> Search Car
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Recently Listed Cars -->
          <div class="card shadow-sm">
            <div class="card-header bg-white">
              <h6 class="mb-0"><i class="fa fa-car me-2"></i>Recently Listed Cars</h6>
            </div>
            <div class="card-body">
              <?php
              $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
                    JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                    ORDER BY tblvehicles.id DESC LIMIT 4";
              $query = $dbh->prepare($sql);
              $query->execute();
              $recentCars = $query->fetchAll(PDO::FETCH_OBJ);

              foreach ($recentCars as $car) { ?>
                <div class="d-flex mb-3">
                  <div class="me-2" style="width: 80px;">
                    <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($car->id); ?>">
                      <?php if (!empty($car->Vimage1)) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($car->Vimage1); ?>"
                          class="avatar avatar-lg" alt="<?php echo htmlspecialchars($car->VehiclesTitle); ?>">
                      <?php } else { ?>
                        <img src="assets/images/placeholder.jpg" class="img-fluid" alt="No image available">
                      <?php } ?>
                    </a>
                  </div>
                  <div>
                    <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($car->id); ?>" class="text-decoration-none d-block fw-bold small">
                      <?php echo htmlspecialchars($car->BrandName); ?>, <?php echo htmlspecialchars($car->VehiclesTitle); ?>
                    </a>
                    <span class="text-muted small">KES <?php echo number_format((int)$car->PricePerDay); ?> Per Day</span>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </aside>

      </div>
    </div>
  </section>
  <?php include('includes/footer.php'); ?>
</body>

</html>