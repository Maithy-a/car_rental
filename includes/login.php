<?php
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);
  $sql = "SELECT EmailId,Password,FullName FROM tblusers WHERE EmailId=:email and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    $_SESSION['login'] = $_POST['email'];
    $_SESSION['fname'] = $results['']->FullName;
    $currentpage = $_SERVER['REQUEST_URI'];
    echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
  } else {
    echo "<script>alert('Invalid Details');</script>";
  }}
?>

<div class="modal modal-blur fade" id="loginform" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">LOGIN FORM</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
             <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Jonedoe@gmail.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password*" required>
          </div>
          <div class="mb-3">
            <label class="form-check">
              <input type="checkbox" class="form-check-input">
              <span class="form-check-label">Remember me</span>
            </label>
          </div>
          <div class="mb-0">
            <button type="submit" name="login" class="btn btn-danger w-100">Login</button>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0">
        <div>Don't have an account? <a href="#signupform" data-bs-toggle="modal" data-bs-dismiss="modal">Register</a></div>
        <div>Forgot Password? <a href="#forgotpassword" class="text-danger " data-bs-toggle="modal" data-bs-dismiss="modal">Reset password</a></div>
        <style>
          .m-f p a{
            text-underline-offset: 5px;
            text-decoration: underline;
            font-size: 16px;
          }
        </style>
      </div>
    </div>
  </div>
</div>
