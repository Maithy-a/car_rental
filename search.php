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
  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->

  <!--Page Header-->
  <div class="page-header">
    <div class="container p-5">
      <div class="page-header">
        <div aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Home</a></li>
            <li class="breadcrumb-item">Search Result</li>
          </ol>
        </div>
        <div class="page-heading mt-4">
          <h2>Search Result for " <?php echo htmlentities($_POST['searchdata']); ?> "</h2>
        </div>
      </div>
    </div>
  </div>
  <!-- /Page Header-->

  <!-- Listing Section -->
  <section class="listing-page py-5" style="min-height: 30rem;">
    <div class="container">
      <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
          <div class="mb-4">
            <?php
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
            <h5><?php echo htmlspecialchars($cnt); ?> Listings found against search</h5>
          </div>

          <div class="row">
            <?php
            $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
                  JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                  WHERE tblvehicles.VehiclesTitle = :search OR tblvehicles.FuelType = :search OR tblbrands.BrandName = :search OR tblvehicles.ModelYear = :search";
            $query = $dbh->prepare($sql);
            $query->bindParam(':search', $searchdata, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
              foreach ($results as $result) { ?>
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="card border-0">
                    <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>">
                      <?php if (!empty($result->Vimage1)) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>"
                          class="card-img-top car-image" alt="<?php echo htmlspecialchars($result->VehiclesTitle); ?>">
                      <?php } else { ?>
                        <img src="img/placeholder.jpg" class="card-img-top car-image" alt="No image available">
                      <?php } ?>
                    </a>

                    <div class="card-body">
                      <p class="card-title">
                        <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>" class="text-decoration-none text-dark">
                          <?php echo htmlspecialchars($result->VehiclesTitle); ?>
                        </a>
                      </p>
                      <!-- <p class="card-text small"><?php echo htmlspecialchars(substr($result->VehiclesOverview, 0, 100)); ?>...</p> -->
                      <span class="text-danger">KES <?php echo number_format((int)$result->PricePerDay); ?> /Day</span>
                    </div>

                    <div class="card-footer bg-white border-top">
                      <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>" class="btn btn-danger w-100 d-flex justify-content-between align-items-center"> View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                      </a>
                    </div>
                  </div>
                </div>
              <?php }
            } else { ?>
              <div class="alert alert-info col-12">No vehicles found matching your search criteria.</div>
            <?php } ?>
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
                    <select class="form-select" name="brand" required>
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
        <!--end -->
      </div>
    </div>
  </section>


  <?php include('includes/footer.php'); ?>

</body>

</html>