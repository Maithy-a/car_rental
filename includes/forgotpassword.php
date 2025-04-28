<?php
if (isset($_POST['update'])) {
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $newpassword = md5($_POST['newpassword']);
  $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email and ContactNo=:mobile";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    $con = "update tblusers set Password=:newpassword where EmailId=:email and ContactNo=:mobile";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
    $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    echo "<script>alert('Your Password succesfully changed');</script>";
  } else {
    echo "<script>alert('Email id or Mobile no is invalid');</script>";
  }
}

?>
<script type="text/javascript">
  function valid() {
    if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
      alert("New Password and Confirm Password Field do not match  !!");
      document.chngpwd.confirmpassword.focus();
      return false;
    }
    return true;
  }
</script>

<div class="modal modal-blur fade" id="forgotpassword" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Password Recovery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form name="chngpwd" method="post" onSubmit="return valid();">
          <div class="mb-3">
            <label class="form-label">Your Email address*</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email address*" required="">
          </div>
          <div class="mb-3">
            <label class="form-label">Your Reg. Mobile*</label>
            <input type="text" name="mobile" class="form-control" placeholder="Your Reg. Mobile*" required="">
          </div>
          <div class="mb-3">
            <label class="form-label">New Password*</label>
            <input type="password" name="newpassword" class="form-control" placeholder="New Password*" required="">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password*</label>
            <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password*" required="">
          </div>
          <div class="form-footer">
            <button type="submit" name="update" class="btn btn-primary w-100">Reset My Password</button>
          </div>
        </form>
        <div class="text-center mt-3">
          <p class="text-muted">For security reasons we don't store your password. Your password will be reset and a new one will be sent.</p>
          <p><a href="#loginform" data-bs-toggle="modal"
          data-bs-target="#loginform">
          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg> Back to Login</a></p>
        </div>
      </div>
    </div>
  </div>
</div>