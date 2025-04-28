<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
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
		<title>Car Rental Portal | Admin New Bookings</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body>
		<div class="page-wrapper d-flex">
			<div class="page-body">
				<div class="page-header m-3">
					<div class="row align-items-center">
						<div class="col">
							<h2 class="page-title">New Bookings</h2>
						</div>
					</div>
				</div>
				<div class="container-xl">
					<div class="row g-4">
						<div class="col-md-12">
							<div class="row g-4">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header">
											<h5 class="mb-0">Bookings Info</h5>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-striped table-hover">
													<thead>
														<tr>
															<th>#</th>
															<th>Name</th>
															<th>Booking No.</th>
															<th>Vehicle</th>
															<th>From Date</th>
															<th>To Date</th>
															<th>Status</th>
															<th>Posting Date</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$status = 0;
														$sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber FROM tblbooking JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id WHERE tblbooking.Status = :status";
														$query = $dbh->prepare($sql);
														$query->bindParam(':status', $status, PDO::PARAM_STR);
														$query->execute();
														$results = $query->fetchAll(PDO::FETCH_OBJ);
														$cnt = 1;
														if ($query->rowCount() > 0) {
															foreach ($results as $result) { ?>
																<tr>
																	<td><?php echo htmlentities($cnt); ?></td>
																	<td><?php echo htmlentities($result->FullName); ?></td>
																	<td><?php echo htmlentities($result->BookingNumber); ?></td>
																	<td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"
																			class="text-primary"><?php echo htmlentities($result->BrandName); ?>,
																			<?php echo htmlentities($result->VehiclesTitle); ?></a>
																	</td>
																	<td><?php echo htmlentities($result->FromDate); ?></td>
																	<td><?php echo htmlentities($result->ToDate); ?></td>
																	<td>
																		<?php
																		if ($result->Status == 0) {
																			echo '<span class="badge bg-warning-lt">Pending</span>';
																		} elseif ($result->Status == 1) {
																			echo '<span class="badge bg-success-lt">Confirmed</span>';
																		} else {
																			echo '<span class="badge bg-danger-lt">Cancelled</span>';
																		}
																		?>
																	</td>
																	<td><?php echo htmlentities($result->PostingDate); ?></td>
																	<td>
																		<a href="booking-details.php?bid=<?php echo htmlentities($result->id); ?>"
																			class="btn btn-primary">
																			View</a>
																	</td>
																</tr>
																<?php $cnt++;
															}
														} else { ?>
															<tr>
																<td colspan="9" class="text-center">No new bookings found.
																</td>
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
			</div>
	</body>

	</html>
<?php } ?>