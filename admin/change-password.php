<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$msg = '';
	$error = '';
	if (isset($_POST['submit'])) {
		$password = $_POST['password'];
		$newpassword = $_POST['newpassword'];
		$confirmpassword = $_POST['confirmpassword'];
		$username = $_SESSION['alogin'];

		// Validate password strength
		if (strlen($newpassword) < 8 || !preg_match("/[A-Za-z]/", $newpassword) || !preg_match("/[0-9]/", $newpassword)) {
			$error = "New password must be at least 8 characters long and contain letters and numbers.";
		} elseif ($newpassword !== $confirmpassword) {
			$error = "New password and confirm password do not match.";
		} else {
			// Verify current password
			$sql = "SELECT Password FROM admin WHERE UserName = :username";
			$query = $dbh->prepare($sql);
			$query->bindParam(':username', $username, PDO::PARAM_STR);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			if ($result && password_verify($password, $result->Password)) {
				// Update password
				$newpassword_hashed = password_hash($newpassword, PASSWORD_DEFAULT);
				$con = "UPDATE admin SET Password = :newpassword WHERE UserName = :username";
				$chngpwd = $dbh->prepare($con);
				$chngpwd->bindParam(':username', $username, PDO::PARAM_STR);
				$chngpwd->bindParam(':newpassword', $newpassword_hashed, PDO::PARAM_STR);
				if ($chngpwd->execute()) {
					$msg = "Your password has been successfully changed.";
				} else {
					$error = "Failed to update password. Please try again.";
				}
			} else {
				$error = "Your current password is not valid.";
			}
		}
	}
	?>
	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">
		<title>Car Rental Portal | Admin Change Password</title>
		<?php include("includes/head.php"); ?>
		<script>
			function validateForm() {
				const newpassword = document.getElementById('newpassword').value;
				const confirmpassword = document.getElementById('confirmpassword').value;
				const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
				if (!passwordRegex.test(newpassword)) {
					alert('New password must be at least 8 characters long and contain letters and numbers.');
					document.getElementById('newpassword').focus();
					return false;
				}
				if (newpassword !== confirmpassword) {
					alert('New password and confirm password do not match.');
					document.getElementById('confirmpassword').focus();
					return false;
				}
				return true;
			}
		</script>
	</head>

	<body class="fluid-body">
	

		<div class="page-wrapper d-flex">
			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Change Password</h2>
					<div class="row">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">Update Password</h5>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger" role="alert"><?php echo htmlentities($error); ?></div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
									<?php } ?>
									<form method="post" name="chngpwd" onsubmit="return validateForm();">
										<div class="mb-3">
											<label for="password" class="form-label">Current Password</label>
											<input type="password" class="form-control" name="password" id="password"
												required>
										</div>
										<div class="mb-3">
											<label for="newpassword" class="form-label">New Password</label>
											<input type="password" class="form-control" name="newpassword" id="newpassword"
												required>
											<div class="form-text">Must be at least 8 characters long and contain letters
												and numbers.</div>
										</div>
										<div class="mb-3">
											<label for="confirmpassword" class="form-label">Confirm Password</label>
											<input type="password" class="form-control" name="confirmpassword"
												id="confirmpassword" required>
										</div>
										<div class="text-end">
											<button type="submit" name="submit" class="btn btn-primary"><i
													class="ti ti-check"></i> Save Changes</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

	</html>
<?php } ?>