<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['send'])) {
  $name = $_POST['fullname'];
  $email = $_POST['email'];
  $contactno = $_POST['contactno'];
  $message = $_POST['message'];
  $sql = "INSERT INTO  tblcontactusquery(name,EmailId,ContactNumber,Message) VALUES(:name,:email,:contactno,:message)";
  $query = $dbh->prepare($sql);
  $query->bindParam(':name', $name, PDO::PARAM_STR);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
  $query->bindParam(':message', $message, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbh->lastInsertId();
  if ($lastInsertId) {
    $msg = "Query Sent. We will contact you shortly";
  } else {
    $error = "Something went wrong. Please try again";
  }
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>Car Rental | Contact Us</title>
  <?php include('includes/head.php'); ?>
</head>

<body class="bg-dark">

  <?php include('includes/header.php'); ?>

  <div class="page-header contactus_page">
    <div class="container">
      <div class="page-header_wrap">
        <div class="page-heading">
          <h1>Contact Us</h1>
        </div>
        <div aria-laria-label="breadcrum">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Contact Us</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="contact_us section">
    <div class="container">
      <div class="row p-4 mt-4">
        <div class="col-md-6 mb-3">
          <h3>Get in touch using the form below</h3>
          <?php if ($error) { ?>
            <div class="alert alert-dismissible alert-danger "><strong>ERROR</strong>:<?php echo htmlentities($error); ?>
              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
          <?php } else if ($msg) { ?>
            <div class="alert alert-dismissible alert-sucess  "><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?>
              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div><?php } ?>
          <div class="contact_form">
            <form method="post">
              <div class="form-group mb-3">
                <label class="control-label mb-2">Full Name <span>*</span></label>
                <input type="text" name="fullname" class="form-control " id="fullname" placeholder="Jone Doe" required>
              </div>
              <div class="form-group mb-3">
                <label class="control-label mb-2">Email Address <span>*</span></label>
                <input type="email" name="email" class="form-control " id="emailaddress" placeholder="Jonedoe@gmail.com" required>
              </div>
              <div class="form-group mb-3">
                <label class="control-label mb-2">Phone Number <span>*</span></label>
                <input type="text" name="contactno" class="form-control " id="phonenumber" placeholder="+254710009011" required
                  maxlength="10" pattern="[0-9]+">
              </div>
              <div class="form-group mb-3">
                <label class="control-label mb-2">Message <span>*</span></label>
                <textarea class="form-control" name="message" rows="4" required></textarea>
              </div>
              <div class="form-group mb-3">
                <button type="submit" class="btn" name="send">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send-2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4.698 4.034l16.302 7.966l-16.302 7.966a.503 .503 0 0 1 -.546 -.124a.555 .555 0 0 1 -.12 -.568l2.468 -7.274l-2.468 -7.274a.555 .555 0 0 1 .12 -.568a.503 .503 0 0 1 .546 -.124z" />
                    <path d="M6.5 12h14.5" />
                  </svg>Send message
                </button>
              </div>
              <style>
                .control-label span {
                  color: red;
                }
              </style>
            </form>
          </div>
        </div>
        <div class="col-md-6 aside p-4 border">
          <div class="container">
            <h3 class="mb-3">Contact Info</h3>
            <?php
            $pagetype = $_GET['type'];
            $sql = "SELECT Address,EmailId,ContactNo from tblcontactusinfo";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            if ($query->rowCount() > 0) {
              foreach ($results as $result) { ?>
                <ul class="nav flex-column">
                  <li class="list-unstyled mb-2">
                    <div class="form-group mb-3">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-radar">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 10a2 2 0 0 1 1.678 .911l.053 .089h7.269l.117 .007a1 1 0 0 1 .883 .993c0 5.523 -4.477 10 -10 10a1 1 0 0 1 -1 -1v-7.269l-.089 -.053a2 2 0 0 1 -.906 -1.529l-.005 -.149a2 2 0 0 1 2 -2m9.428 -1.334a1 1 0 0 1 -1.884 .668a8 8 0 1 0 -10.207 10.218a1 1 0 0 1 -.666 1.886a10 10 0 1 1 12.757 -12.772m-4.628 -.266a1 1 0 0 1 -1.6 1.2a4 4 0 1 0 -5.6 5.6a1 1 0 0 1 -1.2 1.6a6 6 0 1 1 8.4 -8.4" />
                      </svg>
                      <a href="tel:"><?php echo htmlentities($result->Address); ?></a>
                    </div>
                  </li>
                  <li class="list-unstyled mb-2">
                    <div class="form-group mb-3">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 19h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v5.5" />
                        <path d="M16 19h6" />
                        <path d="M19 16v6" />
                        <path d="M3 7l9 6l9 -6" />
                      </svg>
                      <a href="mailto:safarike@admin.com"><?php echo htmlentities($result->EmailId); ?></a>
                    </div>
                  </li>
                  <li class="list-unstyled mb-2">
                    <div class="form-group mb-3">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-phone-call">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        <path d="M15 7a2 2 0 0 1 2 2" />
                        <path d="M15 3a6 6 0 0 1 6 6" />
                      </svg>
                      <a href="tel:"><?php echo htmlentities($result->ContactNo); ?></a>
                    </div>
                  </li>
                </ul>
            <?php }
            } ?>
          </div>
          <style>
            .list-unstyled a {
              color: #cabe15;
              font-size: 16px;
              text-decoration: underline;
              text-underline-offset: 5px;
            }
          </style>
        </div>
      </div>
    </div>
  </section>

  <?php include('includes/footer.php'); ?>

</body>

</html>