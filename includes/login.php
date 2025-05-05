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
    }
}
?>

<div class="modal modal-blur fade" id="loginform" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">LOGIN FORM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="loginemail" onBlur="checkLoginEmail()" placeholder="JonDoe@gmail.com*" required>
                        <span id="login-availability-status"></span>
                        <span id="loginLoaderIcon" style="display:none;">Checking...</span>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password*" required>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <div class="mb-0">
                        <button type="submit" name="login" id="login-button" class="btn btn-danger w-100">Login</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <div>Don't have an account? <a href="#signupform" data-bs-toggle="modal" data-bs-dismiss="modal">Register</a></div>
                <div>Forgot Password? <a href="#forgotpassword" class="text-danger" data-bs-toggle="modal" data-bs-dismiss="modal">Reset password</a></div>
            </div>
        </div>
    </div>
</div>

<script>
    function checkAvailability() {
        var email = $("#emailid").val();
        if (email === "") return;

        $("#loaderIcon").show();
        $.ajax({
            url: "check_availability.php",
            type: "POST",
            data: {
                emailid: email,
                check_type: 'signup'
            },
            success: function(data) {
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", status, error);
                $("#user-availability-status").html("<span class='text-danger'>Error checking availability</span>");
                $("#loaderIcon").hide();
            }
        });
    }
</script>