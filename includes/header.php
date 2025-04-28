<?php
$sql = "SELECT EmailId, ContactNo FROM tblcontactusinfo";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$email = '';
$contactno = '';
foreach ($results as $result) {
  $email = htmlentities($result->EmailId);
  $contactno = htmlentities($result->ContactNo);
}

if (isset($_SESSION['login'])) {
  $userEmail = $_SESSION['login'];
  $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $userEmail, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $fullName = '';
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $fullName = htmlentities($result->FullName);
    }
  }
}
?>

<header>
  <div class="bg-light py-3 border-bottom shadow-sm" >
    <div class="container">
      <div class="row align-items-center gy-3">
        <div class="col-md-2 col-6">
          <div class="d-flex align-items-center">
            <img src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp" alt="Safari Logo" width="50" class="me-2">
            <a href="index.php" class="fw-bold text-dark text-decoration-none">SAFARI</a>
          </div>
        </div>
        <div class="col-md-10 col-6">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
              <span class="avatar avatar-sm bg-primary-lt">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <rect x="3" y="5" width="18" height="14" rx="2"/>
                  <polyline points="3 7 12 13 21 7"/>
                </svg>
              </span>
              <div>
                <small class="text-muted">Support Email:</small><br>
                <a href="mailto:<?php echo $email; ?>" class="text-primary"><?php echo $email; ?></a>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="avatar avatar-sm bg-primary-lt">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"/>
                </svg>
              </span>
              <div>
                <small class="text-muted">Helpline:</small><br>
                <a href="tel:<?php echo $contactno; ?>" class="text-primary"><?php echo $contactno; ?></a>
              </div>
            </div>
            <?php if (strlen($_SESSION['login']) == 0) { ?>
              <a href="#loginform" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginform">Login / Register</a>
            <?php } else { ?>
              <span class="text-muted">Welcome to Safari KE Portal</span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="page.php?type=aboutus">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="car-listing.php">Listings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="page.php?type=faqs">FAQs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact-us.php">Contact</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center gap-4">
          <li class="nav-item">
            <form action="search.php" method="post">
              <div class="row g-2 align-items-center">
                <div class="col">
                  <input type="text" class="form-control" placeholder="Search for…" name="searchdata" required />
                </div>
                <div class="col-auto">
                  <button type="submit" class="btn btn-icon" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <circle cx="10" cy="10" r="7"/>
                      <line x1="21" y1="21" x2="15" y2="15"/>
                    </svg>
                  </button>
                </div>
              </div>
            </form>
          </li>
          <?php if (isset($_SESSION['login'])) { ?>
            <li class="nav-item dropdown border">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <circle cx="12" cy="12" r="9"/>
                  <circle cx="12" cy="10" r="3"/>
                  <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"/>
                </svg>
                <span><?php echo $fullName; ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php">Profile Settings</a></li>
                <li><a class="dropdown-item" href="update-password.php">Update Password</a></li>
                <li><a class="dropdown-item" href="my-booking.php">My Booking</a></li>
                <li><a class="dropdown-item" href="post-testimonial.php">Post a Testimonial</a></li>
                <li><a class="dropdown-item" href="my-testimonials.php">My Testimonial</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Sign Out</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
</header>