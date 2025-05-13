<?php
session_start();
include('includes/config.php');
error_reporting(1);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental Portal</title>
  <?php include('includes/head.php'); ?>
</head>

<body class="bg-dark">
  <div class="page">
    <?php include('includes/header.php'); ?>

    <div class="page-header mb-5">
      <div class="container p-5">
        <div class="page-header">
          <div class="page-heading">
            <h1 class="text-white" style="font-size: 6.2vw;">JB CAR RENTALS</h1>
          </div>
          <div aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="section mb-5 mt-5">
      <div class="container col">
        <div class="section-header text-center">
          <h2 class="text-white">Find the Best <span>Car For You</span></h2>
          <p>
            Explore our wide range of vehicles tailored to your needs. From compact cars to luxury SUVs, we have it
            all. Browse below to find the perfect car for your journey.
          </p>
        </div>

        <div class="recent-tab text-center mt-4">
          <ul class="nav nav-tabs bg-danger mb-2 p-3 justify-content-center col-12" role="tablist">
            <li role="presentation" class="active">
              <a href="#resentnewcar" role="tab" data-toggle="tab">New Cars</a>
            </li>
          </ul>
        </div>

        <div class="tab-content mt-4 gap-3">
          <div role="tabpanel" class="tab-pane active" id="resentnewcar">
            <div class="car-listing-grid">
              <?php
              $sql = "SELECT tblvehicles.VehiclesTitle,
                      tblbrands.BrandName,
                      tblvehicles.PricePerDay,
                      tblvehicles.FuelType, 
                      tblvehicles.ModelYear, 
                      tblvehicles.id, 
                      tblvehicles.SeatingCapacity, 
                      tblvehicles.VehiclesOverview, 
                      tblvehicles.Vimage1 
                    FROM tblvehicles 
                    JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                    LIMIT 9";
              $query = $dbh->prepare($sql);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              if ($query->rowCount() > 0) {
                foreach ($results as $result) {
              ?>
                  <div class="card car-card mb-4 border-0">
                    <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>" class="recentcar">
                      <?php if (!empty($result->Vimage1)) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>"
                          class="card-img-top"
                          alt="<?php echo htmlspecialchars($result->VehiclesTitle); ?>">
                      <?php } else { ?>
                        <img src="img/placeholder.jpg"
                          class="card-img-top"
                          alt="No image available">
                      <?php } ?>
                    </a>

                    <div class="card-body">
                      <h5 class="card-title text-uppercase mb-1">
                        <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>"
                          class="text-decoration-none text-dark">
                          <?php echo htmlspecialchars($result->VehiclesTitle); ?>
                        </a>
                      </h5>
                      <div class="fw-bold text-danger mb-1 small">
                        KES <?php echo number_format((int)$result->PricePerDay); ?> /day
                      </div>
                      <p class="card-text text-muted">
                        <?php echo htmlspecialchars(substr($result->VehiclesOverview, 0, 150)); ?> ...
                      </p>
                    </div>

                    <div class="card-footer bg-white border-top-0">
                      <a href="vehical-details.php?vhid=<?php echo htmlspecialchars($result->id); ?>"
                        class="btn btn-danger w-100 d-flex justify-content-between align-items-center">
                        View Details
                        <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                      </a>
                    </div>
                  </div>

                <?php
                }
              } else {
                ?>
                <div class="car-item">
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
                      <h4 class="alert-heading">No vehicles found.</h4>
                      <div class="alert-description">
                        we are yet to list any car, <br>you can check back later for updates
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section fun-facts-section mb-5">
      <div class="container d-grid">
        <div class="row">
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2>
                  <i class="fa-solid fa-calendar-days" aria-hidden="true"></i> 03 +
                </h2>
                <p>Years In Business</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2>
                  <i class="fa-solid fa-earth-oceania" aria-hidden="true"></i>
                  70 +
                </h2>
                <p>New Cars</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2>
                  <i class="fa-solid fa-car" aria-hidden="true"></i> 50 +
                </h2>
                <p>Used Cars </p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6 col-sm-3">
            <div class="fun-facts-m">
              <div class="cell">
                <h2> <i class="fa-solid fa-users-viewfinder" aria-hidden="true"></i>
                  100+</h2>
                <p>Customers</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section testimonial-section parallex-bg mb-5">
      <div class="container">
        <div class="section-header white-text text-center">
          <h2 class="py-6 text-white">Our Satisfied <span>Customers</span></h2>
        </div>
        <div class="testimonial row row-cards p-4">
          <?php
          $tid = 1;
          $sql = "SELECT tbltestimonial.Testimonial, tblusers.FullName 
              FROM tbltestimonial 
              JOIN tblusers ON tbltestimonial.UserEmail = tblusers.EmailId 
              WHERE tbltestimonial.status = :tid 
              LIMIT 4";
          $query = $dbh->prepare($sql);
          $query->bindParam(':tid', $tid, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
              <div class="col-md-6 col-sm-12">
                <div class="testimonial card">
                  <div class="testimonial card-body">
                    <blockquote class="blockquote mb-0">
                      <p><?php echo htmlentities($result->Testimonial); ?></p>
                      <footer class="blockquote-footer"><?php echo htmlentities($result->FullName); ?></footer>
                    </blockquote>
                  </div>
                </div>
              </div>
            <?php }
          } else { ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
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
                  <h4 class="alert-heading">No feedback found.</h4>
                  <div class="alert-description">
                    Would you like to provide your feedback? <a href="post-testimonial.php" class="alert-link">check it out</a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php include('includes/footer.php'); ?>
  </div>

</body>

</html>