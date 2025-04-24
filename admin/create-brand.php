<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$brand = $_POST['brand'];
		$sql = "INSERT INTO tblbrands(BrandName) VALUES(:brand)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			$msg = "Brand created successfully";
		} else {
			$error = "Something went wrong. Please try again";
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
		<title>Car Rental Portal | Admin Create Brand</title>
		<?php include("includes/head.php"); ?>
		
	</head>

	<body class="fluid-body">

		<?php include('includes/leftbar.php'); ?>
		<div class="page">
			<div class="page-wrapper">
				<div class="container-xl">
					<div class="page-header d-print-none">
						<div class="row align-items-center">
							<div class="col">
								<h2 class="page-title">Create Brand</h2>
							</div>
						</div>
					</div>
					<div class="row row-deck row-cards">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Add New Brand</h3>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger" role="alert">
											<?php echo htmlentities($error); ?>
										</div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success" role="alert">
											<?php echo htmlentities($msg); ?>
										</div>
									<?php } ?>
									<form method="post">
										<div class="mb-3">
											<label for="brand" class="form-label">Brand Name <span class="text-danger">*</span></label>
											<input type="text" id="brand" name="brand" class="form-control" required>
										</div>
										<div class="form-footer">
											<button type="submit" name="submit" class="btn btn-square btn-primary">Submit</button>
								
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