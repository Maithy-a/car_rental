<?php
require_once("includes/config.php");

if (!empty($_POST["emailid"])) {
    $email = trim($_POST["emailid"]);
    $type = isset($_POST["check_type"]) ? $_POST["check_type"] : 'signup';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span style='color:red'>Invalid email format.</span>";
        echo "<script>$('#submit, #login-button').prop('disabled', true);</script>";
        exit;
    }

    $sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $emailExists = $query->rowCount() > 0;

    if ($type === 'signup') {
        if ($emailExists) {
            echo "<span style='color:red'>Email already exists</span>";
            echo "<script>$('#submit').prop('disabled', true);</script>";
        } else {
            echo "<span class='mt-3 text-success'> Email available for Registration. </span>";
            echo "<script>$('#submit').prop('disabled', false);</script>";
        }
    } elseif ($type === 'login') {
        if ($emailExists) {
            echo "<span class='text-success'>Email found. You can login.</span>";
            echo "<script>$('#login-button').prop('disabled', false);</script>";
        } else {
            echo "<span class='text-danger'>Email not found. Please register to continue...</span>";
            echo "<script>$('#login-button').prop('disabled', true);</script>";
        }
    }
}
?>
