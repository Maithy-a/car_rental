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
		$address = trim($_POST['address']);
		$email = trim($_POST['email']);
		$contactno = trim($_POST['contactno']);
		$csrf_token = $_POST['csrf_token'];

		// Validate inputs
		if (empty($address)) {
			$error = "Address is required.";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = "Invalid email format.";
		} elseif (!preg_match('/^[0-9]{10}$/', $contactno)) {
			$error = "Contact number must be a 10-digit number.";
		} elseif ($csrf_token !== $_SESSION['csrf_token']) {
			$error = "Invalid CSRF token.";
		} else {
			$sql = "UPDATE tblcontactusinfo SET Address = :address, EmailId = :email, ContactNo = :contactno";
			$query = $dbh->prepare($sql);
			$query->bindParam(':address', $address, PDO::PARAM_STR);
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
			if ($query->execute()) {
				$msg = "Contact info updated successfully";
			} else {
				$error = "Failed to update contact info. Please try again.";
			}
		}
	}
	// Generate CSRF token
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
	<title>Car Rental Portal | Admin Update Contact Info</title>
	<?php include("includes/head.php"); ?>
	<script>
		function validateForm() {
			const address = document.getElementById('address').value.trim();
			const email = document.getElementById('email').value.trim();
			const contactno = document.getElementById('contactno').value.trim();
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			const contactnoRegex = /^[0-9]{10}$/;
			if (!address) {
				alert('Address is required.');
				document.getElementById('address').focus();
				return false;
			}
			if (!emailRegex.test(email)) {
				alert('Please enter a valid email address.');
				document.getElementById('email').focus();
				return false;
			}
			if (!contactnoRegex.test(contactno)) {
				alert('Contact number must be a 10-digit number.');
				document.getElementById('contactno').focus();
				return false;
			}
			return true;
		}
	</script>
</head>
<body class="fluid-body">

	<?php include('includes/leftbar.php'); ?>
	
	<div class="page-wrapper d-flex">
		<div class="page-content flex-grow-1">
			<div class="container-fluid py-4">
				<h2 class="mb-4">Update Contact Info</h2>
				<div class="row">
					<div class="col-md-8">
						<div class="card">
							<div class="card-header">
								<h5 class="mb-0">Contact Information</h5>
							</div>
							<div class="card-body">
								<?php if ($error) { ?>
									<div class="alert alert-danger" role="alert"><?php echo htmlentities($error); ?></div>
								<?php } elseif ($msg) { ?>
									<div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
								<?php } ?>
								<form method="post" onsubmit="return validateForm();">
									<?php
									$sql = "SELECT Address, EmailId, ContactNo FROM tblcontactusinfo LIMIT 1";
									$query = $dbh->prepare($sql);
									$query->execute();
									$result = $query->fetch(PDO::FETCH_OBJ);
									?>
									<div class="mb-3">
										<label for="address" class="form-label">Address</label>
										<textarea class="form-control" name="address" id="address" rows="4" required><?php echo htmlentities($result->Address ?? ''); ?></textarea>
									</div>
									<div class="mb-3">
										<label for="email" class="form-label">Email</label>
										<input type="email" class="form-control" name="email" id="email" value="<?php echo htmlentities($result->EmailId ?? ''); ?>" required>
									</div>
									<div class="mb-3">
										<label for="contactno" class="form-label">Contact Number</label>
										<input type="text" class="form-control" name="contactno" id="contactno" value="<?php echo htmlentities($result->ContactNo ?? ''); ?>" required>
										<div class="form-text">Enter a 10-digit phone number (e.g., 1234567890).</div>
									</div>
									<input type="hidden" name="csrf_token" value="<?php echo htmlentities($_SESSION['csrf_token']); ?>">
									<div class="text-end">
										<button type="submit" name="submit" class="btn btn-primary"><i class="ti ti-check"></i> Update</button>
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