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
    $sql = "INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
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
?>

<footer class="bg-dark text-white py-5">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mb-4">
          <h6 class="text-uppercase mb-3">About Us</h6>
          <ul class="list-unstyled">
            <li><a href="page.php?type=aboutus" class="text-white text-decoration-none">About Us</a></li>
            <li><a href="page.php?type=faqs" class="text-white text-decoration-none">FAQs</a></li>
            <li><a href="page.php?type=privacy" class="text-white text-decoration-none">Privacy</a></li>
            <li><a href="page.php?type=terms" class="text-white text-decoration-none">Terms of Use</a></li>
            <li><a href="admin/" class="text-white text-decoration-none">Admin Login</a></li>
          </ul>
        </div>

        <div class="col-md-3 col-sm-6 ms-auto mb-4">
          <h6 class="text-uppercase mb-3">Subscribe Newsletter</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="mb-3">
                <input type="email" name="subscriberemail" class="form-control" required placeholder="Enter Email Address" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-primary w-100">Subscribe <i class="fa fa-angle-right ms-1" aria-hidden="true"></i></button>
            </form>
            <p class="text-muted mt-2 small">*We send great deals and the latest auto news to our subscribed users every week.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom bg-secondary py-3">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="copy-right mb-0 text-white">Car Rental Portal.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="footer_widget">
            <p class="d-inline-block text-white me-3">Connect with Us:</p>
            <ul class="list-inline mb-0">
              <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a></li>
              <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a></li>
              <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-linkedin-square fa-lg" aria-hidden="true"></i></a></li>
              <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a></li>
              <li class="list-inline-item"><a href="#" class="text-white"><i class="fa fa-instagram fa-lg" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
.footer-top a:hover,
.footer-bottom a:hover {
  color: #206bc4 !important; 
  text-decoration: none;
}
</style>