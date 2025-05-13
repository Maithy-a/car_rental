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

<body class="bg-dark p-0" style="padding: 0; margin: 0;">
  <?php include('includes/header.php'); ?>
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
  <section class="py-5 bg-dark">
    <div class="container">
      <div class="row">
        <!-- Listings Column -->
        <div class="col-lg-9">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $brand = $_POST['brand'];
            $fueltype = $_POST['fueltype'];

            // Count Matching Cars
            $sql = "SELECT COUNT(*) as total FROM tblvehicles WHERE VehiclesBrand = :brand AND FuelType = :fueltype";
            $query = $dbh->prepare($sql);
            $query->bindParam(':brand', $brand, PDO::PARAM_STR);
            $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
            $query->execute();
            $countResult = $query->fetch(PDO::FETCH_ASSOC);
            $totalListings = $countResult['total'];
          ?>

            <div class="alert alert-info alert-dismissible fade show text-white" role="alert">
              <div class="d-flex align-items-start">
                <div class="me-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12.01" y2="8" />
                    <polyline points="11 12 12 12 12 16 13 16" />
                  </svg>
                </div>
                <div>
                  <h4 class="alert-title mb-1">Result!</h4>
                  <div class="text-white">
                    <?php echo htmlentities($totalListings); ?> cars found matching your criteria.
                  </div>
                </div>
              </div>
              <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>



            <?php
            // Fetch Matching Cars
            $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
                  JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                  WHERE VehiclesBrand = :brand AND FuelType = :fueltype";
            $query = $dbh->prepare($sql);
            $query->bindParam(':brand', $brand, PDO::PARAM_STR);
            $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
              foreach ($results as $car) {
            ?>

                <div class="card mb-4 border-0">
                  <div class="row g-0">
                    <div class="col-md-4">
                      <a href="vehical-details.php?vhid=<?php echo htmlentities($car->id); ?>">
                        <?php if (!empty($car->Vimage1)) { ?>
                          <img src="data:image/jpeg;base64,<?php echo base64_encode($car->Vimage1); ?>" style="height: 100%;" class="img-fluid rounded-start"
                            alt="<?php echo htmlentities($car->VehiclesTitle); ?>">
                        <?php } else { ?>
                          <img src="assets/images/placeholder.jpg" class="img-fluid rounded-start" alt="No image available">
                        <?php } ?>
                      </a>
                    </div>

                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title">
                          <a href="vehical-details.php?vhid=<?php echo htmlentities($car->id); ?>" class="text-decoration-none text-dark">
                            <?php echo htmlentities($car->BrandName); ?> — <?php echo htmlentities($car->VehiclesTitle); ?>
                          </a>
                        </h5>
                        <p class="card-text mb-2 text-muted"><?php echo substr($car->VehiclesOverview, 0, 300); ?></p>
                        <ul class="car-specs">
                          <li class="list-inline-item text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                              <path d="M16 3v4" />
                              <path d="M8 3v4" />
                              <path d="M4 11h16" />
                              <path d="M7 14h.013" />
                              <path d="M10.01 14h.005" />
                              <path d="M13.01 14h.005" />
                              <path d="M16.015 14h.005" />
                              <path d="M13.015 17h.005" />
                              <path d="M7.01 17h.005" />
                              <path d="M10.01 17h.005" />
                            </svg>

                            <?php echo htmlentities($car->ModelYear); ?>
                          </li>
                          <li class="list-inline-item text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-gas-station">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M14 11h1a2 2 0 0 1 2 2v3a1.5 1.5 0 0 0 3 0v-7l-3 -3" />
                              <path d="M4 20v-14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v14" />
                              <path d="M3 20l12 0" />
                              <path d="M18 7v1a1 1 0 0 0 1 1h1" />
                              <path d="M4 11l10 0" />
                            </svg>
                            <?php echo htmlentities($car->FuelType); ?>
                          </li>
                          <li class="list-inline-item text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-armchair">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M5 11a2 2 0 0 1 2 2v2h10v-2a2 2 0 1 1 4 0v4a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-4a2 2 0 0 1 2 -2z" />
                              <path d="M5 11v-5a3 3 0 0 1 3 -3h8a3 3 0 0 1 3 3v5" />
                              <path d="M6 19v2" />
                              <path d="M18 19v2" />
                            </svg>
                            <?php echo htmlentities($car->SeatingCapacity); ?> seats
                          </li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                          <span class="fw-bold text-danger">KES <?php echo number_format((int)$car->PricePerDay); ?> / Day</span>
                          <a href="vehical-details.php?vhid=<?php echo htmlentities($car->id); ?>" class="btn btn-danger">View Details</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              <?php }
            } else { ?>
              <div class="alert alert-warning text-white w-50">No vehicles found matching your filters.</div>
          <?php }
          } ?>
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
                    <select class="form-select" name="brand" required>
                      <option value="">Select Brand</option>
                      <?php
                      $sql = "SELECT * FROM tblbrands";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $brands = $query->fetchAll(PDO::FETCH_OBJ);
                      foreach ($brands as $b) {
                        echo '<option value="' . htmlentities($b->id) . '">' . htmlentities($b->BrandName) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Fuel Type</label>
                    <select class="form-select" name="fueltype" required>
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
                        <img src="assets/images/placeholder.jpg" class="avatar avatar-lg" alt="No image available">
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
        <!--/Side-Bar-->
      </div>
    </div>
    </div>
    <!-- /Listing-->
  </section>
  <?php include('includes/footer.php'); ?>

</body>

</html>