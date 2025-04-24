<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$msg = '';
	$error = '';
	if (isset($_REQUEST['eid'])) {
		$eid = intval($_GET['eid']);
		$status = 2;
		$csrf_token = $_GET['csrf_token'];
		if ($csrf_token !== $_SESSION['csrf_token']) {
			$error = "Invalid CSRF token.";
		} else {
			$sql = "UPDATE tblbooking SET Status = :status WHERE id = :eid";
			$query = $dbh->prepare($sql);
			$query->bindParam(':status', $status, PDO::PARAM_STR);
			$query->bindParam(':eid', $eid, PDO::PARAM_STR);
			if ($query->execute()) {
				$msg = "Booking successfully cancelled";
			} else {
				$error = "Failed to cancel booking. Please try again.";
			}
		}
	}

	if (isset($_REQUEST['aeid'])) {
		$aeid = intval($_GET['aeid']);
		$status = 1;
		$csrf_token = $_GET['csrf_token'];
		if ($csrf_token !== $_SESSION['csrf_token']) {
			$error = "Invalid CSRF token.";
		} else {
			$sql = "UPDATE tblbooking SET Status = :status WHERE id = :aeid";
			$query = $dbh->prepare($sql);
			$query->bindParam(':status', $status, PDO::PARAM_STR);
			$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
			if ($query->execute()) {
				$msg = "Booking successfully confirmed";
			} else {
				$error = "Failed to confirm booking. Please try again.";
			}
		}
	}

	if (isset($_REQUEST['del'])) {
		$delid = intval($_GET['del']);
		$csrf_token = $_GET['csrf_token'];
		if ($csrf_token !== $_SESSION['csrf_token']) {
			$error = "Invalid CSRF token.";
		} else {
			$sql = "DELETE FROM tblbooking WHERE id = :delid";
			$query = $dbh->prepare($sql);
			$query->bindParam(':delid', $delid, PDO::PARAM_STR);
			if ($query->execute()) {
				$msg = "Booking successfully deleted";
			} else {
				$error = "Failed to delete booking. Please try again.";
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
		<title>Car Rental Portal | Admin Manage Bookings</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body class="fluid-body">
	
		<?php include('includes/leftbar.php'); ?>
		<!-- Page content -->
		<div class="page-wrapper d-flex">
			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Manage Bookings</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">Bookings Info</h5>
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
													<th>Name</th>
													<th>Vehicle</th>
													<th>From Date</th>
													<th>To Date</th>
													<th>Message</th>
													<th>Status</th>
													<th>Posting Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id FROM tblbooking JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->FullName); ?></td>
															<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"
																	title="Edit Vehicle"><?php echo htmlentities($result->BrandName); ?>,
																	<?php echo htmlentities($result->VehiclesTitle); ?></a></td>
															<td><?php echo htmlentities($result->FromDate); ?></td>
															<td><?php echo htmlentities($result->ToDate); ?></td>
															<td><?php echo htmlentities($result->message); ?></td>
															<td>
																<?php if ($result->Status == 0) { ?>
																	<span class="badge bg-warning">Not Confirmed</span>
																<?php } elseif ($result->Status == 1) { ?>
																	<span class="badge bg-success">Confirmed</span>
																<?php } else { ?>
																	<span class="badge bg-danger">Cancelled</span>
																<?php } ?>
															</td>
															<td><?php echo htmlentities($result->PostingDate); ?></td>
															<td>
																<div class="btn-group">
																	<?php if ($result->Status != 1) { ?>
																		<a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id); ?>&csrf_token=<?php echo htmlentities($_SESSION['csrf_token']); ?>"
																			class="btn btn-success me-1" title="Confirm Booking"
																			onclick="return confirm('Are you sure you want to confirm this booking?');"><i
																				class="ti ti-check"></i> Confirm</a>
																	<?php } ?>
																	<?php if ($result->Status != 2) { ?>
																		<a href="manage-bookings.php?eid=<?php echo htmlentities($result->id); ?>&csrf_token=<?php echo htmlentities($_SESSION['csrf_token']); ?>"
																			class="btn btn-warning me-1" title="Cancel Booking"
																			onclick="return confirm('Are you sure you want to cancel this booking?');">
																			Cancel
																		</a>
																	<?php } ?>
																	<a href="manage-bookings.php?del=<?php echo htmlentities($result->id); ?>&csrf_token=<?php echo htmlentities($_SESSION['csrf_token']); ?>"
																		class="btn btn-icon btn-danger" title="Delete Booking"
																		onclick="return confirm('Are you sure you want to delete this booking?');">
																		<i class="fa-solid fa-trash"></i>
																	</a>
																</div>
															</td>
														</tr>
														<?php $cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="9" class="text-center">No bookings found.</td>
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