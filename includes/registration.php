<?php
if (isset($_POST['signup'])) {
    $fname = $_POST['fullname'];
    $email = $_POST['emailid'];
    $mobile = $_POST['mobileno'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email already exists
    $check_sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email LIMIT 1";
    $check_query = $dbh->prepare($check_sql);
    $check_query->bindParam(':email', $email, PDO::PARAM_STR);
    $check_query->execute();

    if ($check_query->rowCount() > 0) {
        echo "<script>alert('Email already registered. Please use a different email.');</script>";
    } else {
        $sql = "INSERT INTO tblusers (FullName, EmailId, ContactNo, Password) 
                VALUES (:fname, :email, :mobile, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            echo "<script>alert('Registration successful. Now you can login');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}

?>

<div class="modal modal-blur fade" id="signupform" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">REGISTER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" name="signup" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Jane Doe*" required>
                        <div class="invalid-feedback">Please enter your full name.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" name="mobileno" placeholder="0710007922*" maxlength="10" pattern="[0-9]{10}" required>
                        <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="emailid" id="emailid" onBlur="checkAvailability()" placeholder="Janedoe000@gmail.com*" required>
                        <span id="user-availability-status"></span>
                        <span id="loaderIcon" style="display:none;">Checking...</span>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password*</label>
                        <input type="password" class="form-control" name="password" placeholder="Password*" minlength="8" required>
                        <div class="invalid-feedback">Password must be at least 8 characters long.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password*</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password*" minlength="8" required>
                        <div class="invalid-feedback">Please confirm your password.</div>
                    </div>
                    <div class="mb-1">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" required checked>
                            <span class="form-check-label">I Agree with <a href="#">Terms and Conditions</a></span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" name="signup" id="submit" class="btn btn-danger w-100">Sign Up</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <p class="text-center">Already got an account? <a href="#loginform" data-bs-toggle="modal" data-bs-dismiss="modal">Login Here</a></p>
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
        data: { emailid: email, check_type: 'signup' },
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
