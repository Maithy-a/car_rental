<?php
session_start();
include('includes/config.php');
error_reporting(0);

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental Portal</title>
  <?php include('includes/head.php'); ?>
</head>

<body class="bg-dark">
  <?php include('includes/header.php'); ?>
  <div class="page-header mb-5"
    style="background-image: url(https://images.pexels.com/photos/31779012/pexels-photo-31779012/free-photo-of-white-car-at-night-on-urban-street-in-kokotow.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2);">
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

  <div class="section mb-5 mt-5">
    <div class="container col">
      <div class="section-header text-center">
        <h2>Find the Best <span>Car For You</span></h2>
        <p>
          Explore our wide range of vehicles tailored to your needs. From compact cars to luxury SUVs, we have it
          all.
          Browse
          below to find the perfect car for your journey.
        </p>
      </div>
      <div class="recent-tab text-center mt-4">
        <ul class=" nav nav-tabs bg-danger mb-2 p-3 justify-content-center col-12" role="tablist">
          <li role="presentation" class="active">
            <a href="#resentnewcar" role="tab" data-toggle="tab">
              New Cars</a>
          </li>
        </ul>
      </div>
      <!-- Recently Listed New Cars -->
      <div class="tab-content mt-4">
        <div role="tabpanel" class="tab-pane active" id="resentnewcar">
          <div class="row">
            <?php
            $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 
                    FROM tblvehicles 
                    JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                    LIMIT 9";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
              foreach ($results as $result) {
                ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="recent-car-list">
                    <div class="car-info-box">
                      <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                        <?php if (!empty($result->Vimage1)) { ?>
                          <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>" class=" car-image"
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
                    </div>
                    <div class="car-title-m">
                      <h6 class="title">
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <?php echo htmlentities($result->VehiclesTitle); ?>
                        </a>
                      </h6>
                      <span class="price">KES <?php echo htmlentities($result->PricePerDay); ?> / Day</span>
                    </div>
                    <div class="inventory_info_m">
                      <p><?php echo substr($result->VehiclesOverview, 0, 100); ?></p>
                    </div>
                  </div>
                </div>
                <?php
              }
            } else {
              ?>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="alert alert-info text-center" role="alert">No vehicles found.</div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section fun-facts-section mb-5">
    <div class="container div_zindex">
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2>
                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i> 3+
              </h2>
              <p>Years In Business</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa-solid fa-earth-oceania" aria-hidden="true"></i>
                100+
              </h2>
              <p>New Cars</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2>
                <i class="fa-solid fa-car" aria-hidden="true"></i> 50+
              </h2>
              <p>Used Cars </p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2> <i class="fa-solid fa-users-viewfinder" aria-hidden="true"></i> 300+</h2>
              <p>Satisfied Customers</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </div>

  <div class="section testimonial-section parallex-bg mb-5">
    <div class="container div_zindex">
      <div class="section-header white-text text-center">
        <h2 class="py-6">Our Satisfied <span>Customers</span></h2>
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
          <div class="col-12">
            <div class="alert alert-info text-center" role="alert">No testimonials found.</div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="dark-overlay"></div>
  </div>
  <?php include('includes/footer.php'); ?>
</body>

</html>