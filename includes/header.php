<?php
// Fetch contact details
$sql = "SELECT EmailId, ContactNo FROM tblcontactusinfo";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$email = $results[0]->EmailId ?? '';
$contactno = $results[0]->ContactNo ?? '';

// Fetch logged-in user details
$fullName = '';
if (isset($_SESSION['login'])) {
  $userEmail = $_SESSION['login'];
  $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $userEmail, PDO::PARAM_STR);
  $query->execute();
  $user = $query->fetch(PDO::FETCH_OBJ);
  if ($user) {
    $fullName = htmlentities($user->FullName);
  }
}
?>

<header>
  <div class="bg-light py-3 border-bottom shadow-sm navbar-expand-lg">
    <div class="container">
      <div class="row align-items-center gy-3">
        <div class="col-md-2 col-6">
          <div class="d-flex align-items-center">
            <img src="assets/images/dealer-logo.jpg" alt="Safari Logo" width="50" class="me-2">
            <a href="index.php" class="fw-bold text-dark text-decoration-none" style="font-size: 2vw;">JMCR</a>&TRADE;
          </div>
        </div>

        <div class="col-md-10 col-6">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <!-- Support Email -->
            <div class="d-flex align-items-center gap-2">
              <span class="avatar bg-danger-lt" style="border-radius: 0px;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <rect x="3" y="5" width="18" height="14" rx="2" />
                  <polyline points="3 7 12 13 21 7" />
                </svg>
              </span>
              <div>
                <small class="text-muted">Support Email:</small><br>
                <a href="mailto:<?php echo $email; ?>" class="text-danger" style="text-underline-offset:6px; text-decoration:underline;"><?php echo $email; ?></a>
              </div>
            </div>
            <!-- Contact Number -->
            <div class="d-flex align-items-center gap-2">
              <span class="avatar bg-danger-lt" style="border-radius: 0px;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                </svg>
              </span>
              <div>
                <small class="text-muted">Helpline:</small><br>
                <a href="tel:<?php echo $contactno; ?>" class="text-danger" style="text-underline-offset:6px; text-decoration: underline;"><?php echo $contactno; ?></a>
              </div>
            </div>

            <?php if (!isset($_SESSION['login']) || empty($_SESSION['login'])) { ?>
              <a href="#loginform" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#loginform">Sign In / Register</a>
            <?php } else { ?>
              <span class="text-secondary text-uppercase">Welcome to JMCR Portal</span>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="page.php?type=aboutus">About</a></li>
          <li class="nav-item"><a class="nav-link" href="car-listing.php">Listings</a></li>
          <li class="nav-item"><a class="nav-link" href="page.php?type=faqs">FAQs</a></li>
          <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact</a></li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center gap-4">
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#searchModal">
              <svg class="icon icon-tabler icon-tabler-search" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="10" cy="10" r="7" />
                <line x1="21" y1="21" x2="15" y2="15" />
              </svg>
            </a>
          </li>

          <?php if (!empty($fullName)) {  ?>
            <li class="nav-item dropdown border">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <circle cx="12" cy="12" r="9" />
                  <circle cx="12" cy="10" r="3" />
                  <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                </svg>
                <span><?php echo $fullName; ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="update-password.php">Update Password</a></li>
                <li><a class="dropdown-item" href="my-booking.php">My Booking</a></li>
                <li><a class="dropdown-item" href="post-testimonial.php">Post Feedback</a></li>
                <li><a class="dropdown-item" href="my-testimonials.php">My Feedbacks</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Sign Out</a>
                </li>
              </ul>
            </li>
          <?php } else { ?>
           <li class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginform">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <circle cx="12" cy="12" r="9" />
                <circle cx="12" cy="10" r="3" />
                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
              </svg>
              <span>USER</span>
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  
</header>

<!-- Search Modal -->
<div class="modal modal-blur fade" id="searchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Search</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="search.php" method="post">
        <div class="modal-body">
          <div class="input-icon">
            <span class="input-icon-addon">
              <svg class="icon icon-tabler icon-tabler-search" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="10" cy="10" r="7" />
                <line x1="21" y1="21" x2="15" y2="15" />
              </svg>
            </span>
            <input type="text" class="form-control" name="searchdata" placeholder="What are you looking for..." required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger w-100">Search</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">Are you sure you want to log out?</p>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="/includes/logout.php" class="btn btn-danger">Yes, Log Out</a>
        </div>
      </div>
    </div>
  </div>
</div>
