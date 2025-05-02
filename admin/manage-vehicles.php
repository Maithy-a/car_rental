<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$msg = '';
	$error = '';
	if (isset($_REQUEST['del'])) {
		$delid = intval($_GET['del']);
		$sql = "DELETE FROM tblvehicles WHERE id = :delid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':delid', $delid, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Vehicle record deleted successfully";
		} else {
			$error = "Failed to delete vehicle. Please try again.";
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
		<title>Car Rental Portal | Admin Manage Vehicles</title>
		<?php include("includes/head.php"); ?>

	</head>

	<body class="fluid-body">
		<div class="page-wrapper d-flex">
			<div class="container p-6 mt-5">
				<div class="container-fluid">
					<h2 class="mb-4">Manage Vehicles</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">Vehicle Details</h5>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger alert-dismissible" role="alert">
											<div class="alert-icon">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
													viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
													stroke-linecap="round" stroke-linejoin="round"
													class="icon alert-icon icon-2">
													<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
													<path d="M12 8v4" />
													<path d="M12 16h.01" />
												</svg>
											</div>
											<?php echo htmlentities($error); ?>
											<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
										</div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success alert-dismissible" role="alert">
											<div class="alert-icon">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
													height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
													fill="none" stroke-linecap="round" stroke-linejoin="round">
													<path stroke="none" d="M0 0h24v24H0z" fill="none" />
													<path d="M5 12l5 5l10 -10" />
												</svg>
											</div>
											<?php echo htmlentities($msg); ?>
											<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
										</div>
									<?php } ?>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>Vehicle Title</th>
													<th>Brand</th>
													<th>Price Per Day</th>
													<th>Fuel Type</th>
													<th>Model Year</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->VehiclesTitle); ?></td>
															<td><?php echo htmlentities($result->BrandName); ?></td>
															<td><?php echo htmlentities($result->PricePerDay); ?></td>
															<td><?php echo htmlentities($result->FuelType); ?></td>
															<td><?php echo htmlentities($result->ModelYear); ?></td>
															<td>
																<div class="btn-group">
																	<a href="edit-vehicle.php?id=<?php echo htmlentities($result->id); ?>"
																		class="btn  btn-primary me-1" title="Edit Vehicle">Edit</a>
																	<a href="manage-vehicles.php?del=<?php echo htmlentities($result->id); ?>"
																		class="btn btn-icon btn-danger" title="Delete Vehicle"
																		onclick="return confirm('Are you sure you want to delete this vehicle?');">
																		<i class="fa-solid fa-trash"></i>
																	</a>
																</div>

															</td>
														</tr>
													<?php $cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="7" class="text-center">No vehicles found.</td>
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