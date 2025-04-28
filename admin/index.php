<?php
session_start();
include 'includes/config.php';
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
		$message = "Invalid Details";
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/css/tabler.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/js/tabler.min.js">
	</script>
</head>

<body>
	<style>
		body {
			background: url('img/bg.jpg') no-repeat center center fixed;
			background-size: cover;
		}
		.form-control {
			padding: 10px 40px;
			border: 1px solid #ced4da;
			box-shadow: none;
			font-size: 16px;
		}
		.btn{
			padding: 10px 20px;
			font-size: 16px;
			border: none;
			color: #fff;
			border-radius: 5px;
			cursor: pointer;
		}
		.form-control:focus {
			border-color: #007bff;
			box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
		}

		.card {
			backdrop-filter: blur(10px);
			border-radius: 20px;
			padding: 15px;
		}
	</style>
	<div class="d-flex justify-content-center align-items-center vh-100">
		<div class="card" style="width: 380px;">
			<div class="card-body p-4">
				<div class="text-center">
					<h1 class="mb-3">ADMIN</h1>
				</div>
				<p class="text-muted text-center mb-3">Welcome back! Please enter your details.</p>
				<?php if (isset($message)): ?>
					<div class="alert alert-danger text-center">
						<?php echo htmlspecialchars($message); ?>
					</div>
				<?php endif; ?>
				<form class="form" id="login-form" method="post">
					<div class="input-icon mb-4">
						<span class="input-icon-addon">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
								viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
								stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<circle cx="12" cy="7" r="4" />
								<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
							</svg>
						</span>
						<input type="text" id="username" name="username" class="form-control"
							placeholder="Enter username" required autocomplete="off" />
					</div>
					<div class="input-icon mb-4">
						<span class="input-icon-addon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round"
								class="icon icon-tabler icons-tabler-outline icon-tabler-lock-password">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
								<path d="M8 11v-4a4 4 0 1 1 8 0v4" />
								<path d="M15 16h.01" />
								<path d="M12.01 16h.01" />
								<path d="M9.02 16h.01" />
							</svg>
						</span>
						<input type="password" id="password" name="password" class="form-control"
							placeholder="Enter password" required />

					</div>
					<button type="submit" name="login" class="btn btn-primary w-100">Login</button>
				</form>
				<div class="text-center mt-3">
					<a href="../index.php" class="text-decoration-none">Back to Home</a>
				</div>

				<script>
					window.onbeforeunload = () => {
						document.getElementById('login-form').reset();
					};
				</script>
			</div>
		</div>
	</div>

</body>

</html>