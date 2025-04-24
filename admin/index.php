<?php
session_start();
include('includes/config.php');
if (isset($_POST['login'])) {
	$email = $_POST['username'];
	$password = md5($_POST['password']);
	$sql = "SELECT UserName,Password FROM admin WHERE UserName=:email and Password=:password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		$_SESSION['alogin'] = $_POST['username'];
		echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
	} else {
		echo "<script>alert('Invalid Details');</script>";
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Car Rental Portal | Admin Login</title>
	<?php include('includes/head.php') ?>
</head>
<body class="fluid-body">
	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="card shadow-sm" style="width: 400px;">
			<div class="card-header text-center bg-primary text-white">
				<span class="card-title mb-0">Admin Login</span>
			</div>
			<div class="card-body">
				<form method="post">
					<div class="form-group mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
					</div>
					<div class="form-group mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
					</div>
					<button type="submit" name="login" class="btn btn-primary w-100">Login</button>
				</form>
				<div class="text-center mt-3">
					<a href="../index.php" class="text-decoration-none">Back to Home</a>
				</div>
			</div>
		</div>
	</div>

</body>
</html>