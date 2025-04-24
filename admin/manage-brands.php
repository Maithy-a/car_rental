<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$msg = '';
	$error = '';
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		$sql = "DELETE FROM tblbrands WHERE id = :id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Brand deleted successfully";
		} else {
			$error = "Failed to delete brand. Please try again.";
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
		<title>Car Rental Portal | Admin Manage Brands</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body class="fluid-body">
	
		<?php include('includes/leftbar.php'); ?>
		<div class="page-wrapper d-flex">
			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Manage Brands</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header d-flex justify-content-between align-items-center">
									<h5 class="mb-3">Listed Brands</h5>
									<a href="create-brand.php" class="btn btn-outline-primary">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
											fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round"
											class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
											<path stroke="none" d="M0 0h24v24H0z" fill="none" />
											<path d="M12 5l0 14" />
											<path d="M5 12l14 0" />
										</svg>
										New Brand</a>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger" role="alert"><?php echo htmlentities($error); ?></div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
									<?php } ?>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>Brand Name</th>
													<th>Creation Date</th>
													<th>Updation Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT * FROM tblbrands";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->BrandName); ?></td>
															<td><?php echo htmlentities($result->CreationDate); ?></td>
															<td><?php echo htmlentities($result->UpdationDate); ?></td>
															<td>
																<a href="edit-brand.php?id=<?php echo $result->id; ?>"
																	class="btn btn-icon btn-primary me-1">
																	<i class="fa-regular fa-pen-to-square"></i>
																</a>
																<a href="manage-brands.php?del=<?php echo $result->id; ?>"
																	class="btn btn-icon btn-danger"
																	onclick="return confirm('Are you sure you want to delete this brand?');">
																	<i class="fa-regular fa-trash-can"></i>
																</a>
															</td>
														</tr>
														<?php $cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="5" class="text-center">No brands found.</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
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