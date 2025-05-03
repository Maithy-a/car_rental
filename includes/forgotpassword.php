<?php
if (isset($_POST['update'])) {
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $newpassword = $_POST['newpassword'];

    if (strlen($newpassword) < 8) {
        echo "<script>alert('Password must be at least 8 characters long');</script>";
    } else {
        $sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email AND ContactNo = :mobile";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_OBJ);

        if ($user) {
            $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE tblusers SET Password = :password WHERE EmailId = :email AND ContactNo = :mobile";
            $updateQuery = $dbh->prepare($updateSql);
            $updateQuery->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
            $updateQuery->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $updateQuery->execute();

            echo "<script>alert('Your password was successfully changed.');</script>";
        } else {
            echo "<script>alert('Invalid email or mobile number.');</script>";
        }
    }
}
?>

<div class="modal modal-blur fade" id="forgotpassword" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-uppercase">Password Recovery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form name="chngpwd" method="post" onsubmit="return valid();">
          <div class="mb-3">
            <label class="form-label">Your Email address*</label>
            <input type="email" name="email" class="form-control" placeholder="Janedoe000@gmail.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Your Registered Mobile*</label>
            <input type="text" name="mobile" class="form-control" placeholder="0710007922" pattern="[0-9]{10}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">New Password*</label>
            <input type="password" name="newpassword" class="form-control" placeholder="New Password" minlength="8" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password*</label>
            <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" minlength="8" required>
          </div>
          <div class="form-footer">
            <button type="submit" name="update" class="btn btn-danger w-100">Reset My Password</button>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0">
        <p class="mb-0">* For security reasons we don’t store your password. You’ll need to set a new one.</p>
        <a href="#loginform" data-bs-toggle="modal" data-bs-dismiss="modal">Back to Login</a>
      </div>
    </div>
  </div>
</div>

<script>
  function valid() {
    const newPassword = document.chngpwd.newpassword.value;
    const confirmPassword = document.chngpwd.confirmpassword.value;

    if (newPassword.length < 8) {
        alert("Password must be at least 8 characters long!");
        return false;
    }

    if (newPassword !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}

</script>