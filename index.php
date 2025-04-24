<?php
session_start();
include('includes/config.php');
error_reporting(0);

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental Portal</title>
</head>
<?php include('includes/head.php'); ?>

<body>

  <?php include('includes/colorswitcher.php'); ?>

  <?php include('includes/header.php'); ?>

  <!-- Banners -->
  <section id="banner" class="banner-section">
    <div class="container">
      <div class="div_zindex">
        <div class="row">
          <div class="col-md-5 col-md-push-7">
            <div class="banner_content">
              <h1>&nbsp;</h1>
              <p>&nbsp; </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Banners -->


  <!-- Resent Cat-->
  <section class="section-padding gray-bg">
    <div class="container">
      <div class="section-header text-center">
        <h2>Find the Best <span>CarForYou</span></h2>
        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in
          some form, by injected humour, or randomised words which don't look even slightly believable. If you are going
          to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of
          text.</p>
      </div>
      <div class="row">

        <!-- Nav tabs -->
        <div class="recent-tab">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">New Car</a></li>
          </ul>
        </div>
        <!-- Recently Listed New Cars -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="resentnewcar">

            <?php $sql = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,tblvehicles.Vimage1 from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand limit 9";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
              foreach ($results as $result) {
                ?>

                <div class="col-list-3">
                  <div class="recent-car-list">
                    <div class="car-info-box"> <a
                        href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>"><img
                          src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive"
                          alt="image"></a>
                      <ul>
                        <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
                        <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?>
                          Model</li>
                        <li><i class="fa fa-user"
                            aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
                      </ul>
                    </div>
                    <div class="car-title-m">
                      <h6><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                          <?php echo htmlentities($result->VehiclesTitle); ?></a></h6>
                      <span class="price">$<?php echo htmlentities($result->PricePerDay); ?> /Day</span>
                    </div>
                    <div class="inventory_info_m">
                      <p><?php echo substr($result->VehiclesOverview, 0, 70); ?></p>
                    </div>
                  </div>
                </div>
              <?php }
            } ?>

          </div>
        </div>
      </div>
  </section>
  <!-- /Resent Cat -->

  <!-- Fun Facts-->
  <section class="fun-facts-section">
    <div class="container div_zindex">
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-calendar" aria-hidden="true"></i>40+</h2>
              <p>Years In Business</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-car" aria-hidden="true"></i>1200+</h2>
              <p>New Cars For Sale</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-car" aria-hidden="true"></i>1000+</h2>
              <p>Used Cars For Sale</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-sm-3">
          <div class="fun-facts-m">
            <div class="cell">
              <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>600+</h2>
              <p>Satisfied Customers</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Fun Facts-->


  <!--Testimonial -->
  <section class="section-padding testimonial-section parallex-bg">
    <div class="container div_zindex">
      <div class="section-header white-text text-center">
        <h2>Our Satisfied <span>Customers</span></h2>
      </div>
      <div class="row">
        <div id="testimonial-slider">
          <?php
          $tid = 1;
          $sql = "SELECT tbltestimonial.Testimonial,tblusers.FullName from tbltestimonial join tblusers on tbltestimonial.UserEmail=tblusers.EmailId where tbltestimonial.status=:tid limit 4";
          $query = $dbh->prepare($sql);
          $query->bindParam(':tid', $tid, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);
          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>


              <div class="testimonial-m">

                <div class="testimonial-content">
                  <div class="testimonial-heading">
                    <h5><?php echo htmlentities($result->FullName); ?></h5>
                    <p><?php echo htmlentities($result->Testimonial); ?></p>
                  </div>
                </div>
              </div>
            <?php }
          } ?>



        </div>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Testimonial-->


  <!--Footer -->
  <?php include('includes/footer.php'); ?>
  <!-- /Footer-->

  <!--Back to top-->
  <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
  <!--/Back to top-->

  <!--Login-Form -->
  <?php include('includes/login.php'); ?>
  <!--/Login-Form -->

  <!--Register-Form -->
  <?php include('includes/registration.php'); ?>

  <!--/Register-Form -->

  <!--Forgot-password-Form -->
  <?php include('includes/forgotpassword.php'); ?>
  <!--/Forgot-password-Form -->

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/interface.js"></script>
  <!--Switcher-->
  <script src="assets/switcher/js/switcher.js"></script>
  <!--bootstrap-slider-JS-->
  <script src="assets/js/bootstrap-slider.min.js"></script>
  <!--Slider-JS-->
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>

</body>

<!-- Mirrored from themes.webmasterdriver.net/carforyou/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Jun 2017 07:22:11 GMT -->

</html>