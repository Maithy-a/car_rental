<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<header>
  <!-- Topbar -->
  <div class="header-top bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-sm-3 col-md-2">
          <div class="logo d-flex align-items-center">
            <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000" style="width: 40px; height: 40px;">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <path
                  d="M277.333333 789.333333a21.333333 21.333333 0 0 0-21.333333-21.333333H192a21.333333 21.333333 0 0 0-21.333333 21.333333v106.666667a21.333333 21.333333 0 0 0 21.333333 21.333333h64a21.333333 21.333333 0 0 0 21.333333-21.333333v-106.666667zM853.333333 789.333333a21.333333 21.333333 0 0 0-21.333333-21.333333h-64a21.333333 21.333333 0 0 0-21.333333 21.333333v106.666667a21.333333 21.333333 0 0 0 21.333333 21.333333h64a21.333333 21.333333 0 0 0 21.333333-21.333333v-106.666667z"
                  fill="#6D4C41"></path>
                <path
                  d="M768 640H256s71.658667-192 85.333333-213.333333 35.669333-21.333333 42.666667-21.333334h256c4.565333 0 29.994667-0.661333 42.666667 21.333334 10.752 18.688 85.333333 213.333333 85.333333 213.333333z"
                  fill="#E3F2FD"></path>
                <path
                  d="M810.666667 618.666667l-298.666667-21.333334-298.666667 21.333334a42.666667 42.666667 0 0 0-42.666666 42.666666v170.666667a21.333333 21.333333 0 0 0 21.333333 21.333333h640a21.333333 21.333333 0 0 0 21.333333-21.333333v-170.666667a42.666667 42.666667 0 0 0-42.666666-42.666666z"
                  fill="#FF3D00"></path>
                <path
                  d="M640 426.666667c7.232 0 44.437333 2.837333 67.114667 58.709333 4.544 11.157333 42.581333 106.432 42.581333 106.453333L760.426667 618.666667H263.594667l10.709333-26.901334c12.842667-32.277333 38.229333-95.978667 42.389333-106.026666C339.562667 430.912 373.994667 426.666667 384 426.666667h256m0.064-42.666667H640 384c-6.997333 0-71.104 0-106.666667 85.333333-5.418667 13.013333-42.666667 106.666667-42.666666 106.666667H149.333333a21.333333 21.333333 0 0 0-21.333333 21.333333v42.666667a21.333333 21.333333 0 0 0 21.333333 21.333333h725.333334a21.333333 21.333333 0 0 0 21.333333-21.333333v-42.666667a21.333333 21.333333 0 0 0-21.333333-21.333333h-85.333334s-38.122667-95.488-42.666666-106.666667c-34.666667-85.333333-100.224-85.333333-106.666667-85.333333h-0.128 0.192z"
                  fill="#FF3D00"></path>
                <path
                  d="M810.666667 746.666667a21.333333 21.333333 0 0 1-21.333334 21.333333H234.666667a21.333333 21.333333 0 0 1-21.333334-21.333333v-64a21.333333 21.333333 0 0 1 21.333334-21.333334h554.666666a21.333333 21.333333 0 0 1 21.333334 21.333334v64z"
                  fill="#37474F"></path>
                <path d="M266.666667 714.666667m-32 0a32 32 0 1 0 64 0 32 32 0 1 0-64 0Z" fill="#FFF176"></path>
                <path d="M757.333333 714.666667m-32 0a32 32 0 1 0 64 0 32 32 0 1 0-64 0Z" fill="#FFF176"></path>
                <path
                  d="M704 234.666667H426.666667V149.333333h106.666666v42.666667l42.666667-42.666667h42.666667v42.666667l42.666666-42.666667h42.666667l42.666667 21.290667V213.333333z"
                  fill="#FFA000"></path>
                <path
                  d="M384 85.333333c-58.922667 0-106.666667 47.744-106.666667 106.666667s47.744 106.666667 106.666667 106.666667 106.666667-47.744 106.666667-106.666667-47.744-106.666667-106.666667-106.666667z m-42.666667 128a21.333333 21.333333 0 1 1 0-42.666666 21.333333 21.333333 0 1 1 0 42.666666z"
                  fill="#FFA000"></path>
                <path d="M533.333333 234.666667V149.333333h-51.669333a105.792 105.792 0 0 1 0 85.333334H533.333333z"
                  fill="#D67C05"></path>
              </g>
            </svg>
            <a href="index.php" class="fw-bold text-dark text-decoration-none">CAR RENTAL</a>
          </div>
        </div>
        <div class="col-sm-9 col-md-10">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <?php
            $sql = "SELECT EmailId,ContactNo from tblcontactusinfo";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            foreach ($results as $result) {
              $email = $result->EmailId;
              $contactno = $result->ContactNo;
            }
            ?>
            <div class="d-flex align-items-center gap-2">
              <span class="avatar avatar-sm bg-primary text-white"><i class="fa fa-envelope"></i></span>
              <div>
                <small class="text-muted">Support Email:</small><br>
                <a href="mailto:<?php echo htmlentities($email); ?>" class="text-primary"><?php echo htmlentities($email); ?></a>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="avatar avatar-sm bg-primary text-white"><i class="fa fa-phone"></i></span>
              <div>
                <small class="text-muted">Helpline:</small><br>
                <a href="tel:<?php echo htmlentities($contactno); ?>" class="text-primary"><?php echo htmlentities($contactno); ?></a>
              </div>
            </div>
            <?php if (strlen($_SESSION['login']) == 0) { ?>
              <a href="#loginform" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-dismiss="modal">Login / Register</a>
            <?php } else { ?>
              <span class="text-muted">Welcome to Car Rental Portal</span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="page.php?type=aboutus">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="car-listing.php">Car Listing</a></li>
          <li class="nav-item"><a class="nav-link" href="page.php?type=faqs">FAQs</a></li>
          <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact Us</a></li>
        </ul>
        <div class="d-flex align-items-center gap-3">
          <div class="dropdown">
            <?php if ($_SESSION['login']) { ?>
              <a href="#" class="dropdown-toggle text-white" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user-circle me-1"></i>
                <?php
                $email = $_SESSION['login'];
                $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email";
                $query = $dbh->prepare($sql);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                  foreach ($results as $result) {
                    echo htmlentities($result->FullName);
                  }
                }
                ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profile.php">Profile Settings</a></li>
                <li><a class="dropdown-item" href="update-password.php">Update Password</a></li>
                <li><a class="dropdown-item" href="my-booking.php">My Booking</a></li>
                <li><a class="dropdown-item" href="post-testimonial.php">Post a Testimonial</a></li>
                <li><a class="dropdown-item" href="my-testimonials.php">My Testimonial</a></li>
                <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
              </ul>
            <?php } ?>
          </div>
          <form action="search.php" method="post" class="d-flex" id="header-search-form">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search..." name="searchdata" required>
              <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </nav>
</header>

<style>
.logo a:hover {
  color: #206bc4 !important; 
}
.navbar-nav .nav-link {
  padding: 0.75rem 1rem;
  font-weight: 500;
}
.navbar-nav .nav-link:hover {
  color: #206bc4 !important;
}
.dropdown-menu {
  border: none;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.dropdown-item:hover {
  background-color: #f8f9fa;
}
</style>