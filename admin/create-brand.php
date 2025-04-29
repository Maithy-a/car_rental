<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$brand = strtoupper(trim($_POST['brand'])); // Convert to uppercase and trim whitespace
		$sql = "SELECT BrandName FROM tblbrands WHERE BrandName = :brand";
		$query = $dbh->prepare($sql);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);

		if ($result) {
			$error = "Brand already exists. Please try a different name.";
		} else {
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
	}
	?>
	<!doctype html>
	<?php include "includes/head.php"; ?>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">
		<title>Car Rental Portal | Admin Create Brand</title>
	</head>

	<body>
		<div class="page-wrapper d-flex">
			<div class="container py-2 mt-3">
				<div class="container-fluid py-4">
						<div class="page-body">
							<div class="page-header m-3">
								<div class="row align-items-center">
									<div class="col">
										<h2 class="page-title">Create Brand</h2>
									</div>
								</div>
							</div>
							<div class="container-xl">
								<div class="row g-4">
									<div class="col-md-6">
										<div class="card">
											<div class="card-header">
												<h3 class="card-title">Existing Brands</h3>
											</div>
											<div class="card-body">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>#</th>
															<th>Brand Name</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sql = "SELECT BrandName FROM tblbrands ORDER BY BrandName ASC";
														$query = $dbh->prepare($sql);
														$query->execute();
														$brands = $query->fetchAll(PDO::FETCH_ASSOC);
														$counter = 1;
														foreach ($brands as $brand) {
															echo "<tr>";
															echo "<td>" . $counter++ . "</td>";
															echo "<td>" . htmlentities($brand['BrandName']) . "</td>";
															echo "</tr>";
														}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
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
														<label for="brand" class="form-label">Brand Name <span
																class="text-danger">*</span></label>
														<input type="text" id="brand" name="brand" class="form-control"
															required>
													</div>
													<div class="form-footer">
														<button type="submit" name="submit"
															class="btn btn-primary">Submit</button>
													</div>
												</form>
											</div>
										</div>
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