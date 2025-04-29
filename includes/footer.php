<?php
if (isset($_POST['emailsubscibe'])) {
  $subscriberemail = $_POST['subscriberemail'];
  $sql = "SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
  $query = $dbh->prepare($sql);
  $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    echo "<script>alert('Already Subscribed.');</script>";
  } else {
    $sql = "INSERT INTO tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
      echo "<script>alert('Subscribed successfully.');</script>";
    } else {
      echo "<script>alert('Something went wrong. Please try again');</script>";
    }
  }
}
include('auth.php');
?>

<footer class="footer bg-dark">
    <div class="row gy-4">
      <div class="col-md me-6">
        <h3 class="h2 text-uppercase mb-3">Welcome to Our Car Listing Website</h3>
        <p class="text-muted mt-2">We provide a wide range of services including car listings, reviews, and expert
          advice to help you make informed decisions. Our team of experts is dedicated to providing you with the best
          experience possible. We are committed to helping you find the perfect car for your needs.</p>
        <p class="text-muted mt-2">Thank you for choosing us as your trusted partner in the car buying and selling
          process.</p>
      </div>
      <div class="col">
        <h3 class="h5 text-uppercase mb-4">About Us</h3>
        <ul class="list-unstyled">
          <li class="mb-4"><a href="page.php?type=aboutus" class="text-white text-decoration-none">About Us</a></li>
          <li class="mb-4"><a href="page.php?type=faqs" class="text-white text-decoration-none">FAQs</a></li>
          <li class="mb-4"><a href="page.php?type=privacy" class="text-white text-decoration-none">Privacy</a></li>
          <li class="mb-4"><a href="page.php?type=terms" class="text-white text-decoration-none">Terms of Use</a></li>
          <li class="mb-4"><a href="admin/" class="text-white text-decoration-none">Admin Login</a></li>
        </ul>
      </div>
      <div class="col">
        <h3 class="h5 text-uppercase mb-3">Contact Us</h3>
        <ul class="list-unstyled">
          <li class="mb-4"><a href="page.php?type=contactus" class="text-white text-decoration-none">Contact Us</a></li>
          <li class="mb-4"><a href="page.php?type=privacy" class="text-white text-decoration-none">Privacy Policy</a>
          </li>
          <li class="mb-4"><a href="page.php?type=terms" class="text-white text-decoration-none">Terms of Use</a></li>
          <li class="mb-4"><a href="<script void(0)>" class="text-white text-decoration-none">Disclaimer</a></li>
          <li class="mb-4"><a href="page.php?type=help" class="text-white text-decoration-none">Help</a></li>
        </ul>
      </div>
      <div class="col-md">
        <h3 class="h5 text-uppercase mb-3">Subscribe Newsletter</h3>
        <form method="post">
          <div class="mb-3">
            <input type="email" name="subscriberemail" class="form-control" required
              placeholder="Enter Email Address" />
          </div>
          <button type="submit" name="emailsubscibe" class="btn btn-square btn-danger w-100">
            Subscribe <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24"
              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
              stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="9 6 15 12 9 18" />
            </svg>
          </button>
        </form>
        <p class="text-muted mt-2 small">* We send great deals and the latest auto news to our subscribed users every
          week.
        </p>
      </div>
      <div class="col-12 text-center">
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#" class="text-">Facebook</a></li>
          <li class="list-inline-item"><a href="#" class="text-">Twitter</a></li>
          <li class="list-inline-item"><a href="#" class="text-">LinkedIn</a></li>
          <li class="list-inline-item"><a href="#" class="text-">Instagram</a></li>
          <li class="list-inline-item"><a href="#" class="text-">Google</a></li>
        </ul>
      </div>
      <div class="text-center">
        &copy;<?php echo date('Y'); ?> Safari Rental, All rights reserved.
      </div>
    </div>
</footer>