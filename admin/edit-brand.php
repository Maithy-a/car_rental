<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit'])) {
		$brand = $_POST['brand'];
		$newBrandName = $_POST['newBrandName'];
		$id = $_GET['id'];

		$sql = "update tblbrands set BrandName=:newBrandName where id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':newBrandName', $newBrandName, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$msg = "Brand updated successfully";
	}
	?>

	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<title>Car Rental Portal | Update Brand</title>
		<?php include('includes/head.php') ?>
	</head>

	<body>
		<div class="page-wrapper d-flex">
			<div class="container p-3 mt-3">
				<div class="container-fluid py-4">
					<div class="page-wrapper">
						<div class="container-xl">
							<div class="page-header d-print-none">
								<div class="row align-items-center">
									<div class="col">
										<h2 class="page-title">Update Brand</h2>
									</div>
								</div>
							</div>
							<div class="page-body col-6">
								<div class="container ">
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Edit Brand</h3>
										</div>
										<div class="card-body">
											<form method="post">
												<?php if ($msg) { ?>
													<div class="alert alert-success">
														<strong>Success:</strong> <?php echo htmlentities($msg); ?>
													</div>
												<?php } ?>

												<?php
												$id = $_GET['id'];
												$ret = "select * from tblbrands where id=:id";
												$query = $dbh->prepare($ret);
												$query->bindParam(':id', $id, PDO::PARAM_STR);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												if ($query->rowCount() > 0) {
													foreach ($results as $result) {
														?>
														<div class="mb-3">
															<label class="form-label">Current Brand Name</label>
															<select class="form-select" name="brand" id="brand" required>
																<?php
																$sql = "SELECT * FROM tblbrands";
																$query = $dbh->prepare($sql);
																$query->execute();
																$brands = $query->fetchAll(PDO::FETCH_OBJ);
																foreach ($brands as $brand) {
																	$selected = ($brand->id == $result->id) ? 'selected' : '';
																	echo "<option value='{$brand->id}' {$selected}>{$brand->BrandName}</option>";
																}
																?>
															</select>
														</div>

														<div class="mb-3">
															<label class="form-label">New Brand Name</label>
															<input type="text" class="form-control" name="newBrandName"
																value="<?php echo htmlentities($result->BrandName); ?>" required>
														</div>
													<?php }
												} ?>

												<div class="form-footer">
													<button type="submit" name="submit"
														class="btn btn-primary w-100">EDIT</button>
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