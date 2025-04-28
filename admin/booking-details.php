<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$msg = '';
	$error = '';
	$bid = intval($_GET['bid']);
	// Handle Confirm Action
	if (isset($_GET['aeid'])) {
		$id = intval($_GET['aeid']);
		$status = 1; // Confirmed
		$sql = "UPDATE tblbooking SET Status = :status, LastUpdationDate = CURRENT_TIMESTAMP WHERE id = :id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Booking confirmed successfully";
		} else {
			$error = "Failed to confirm booking. Please try again.";
		}
	}
	// Handle Cancel Action
	if (isset($_GET['eid'])) {
		$id = intval($_GET['eid']);
		$status = 2; // Cancelled
		$sql = "UPDATE tblbooking SET Status = :status, LastUpdationDate = CURRENT_TIMESTAMP WHERE id = :id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Booking cancelled successfully";
		} else {
			$error = "Failed to cancel booking. Please try again.";
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
		<title>Car Rental Portal | Admin Booking Details</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body class="fluid-body">
		<div class="page-wrapper d-flex">
			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Booking Details</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header d-flex justify-content-between align-items-center">
									<h5 class="mb-0">Booking Info</h5>
									<button onclick="window.print()" class="btn btn-outline-secondary no-print"><i
											class="ti ti-printer"></i> Print</button>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger no-print" role="alert">
											<?php echo htmlentities($error); ?>
										</div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success no-print" role="alert"><?php echo htmlentities($msg); ?>
										</div>
									<?php } ?>
									<?php
									$sql = "SELECT tblusers.*, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber, DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) as totalnodays, tblvehicles.PricePerDay FROM tblbooking JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id WHERE tblbooking.id = :bid";
									$query = $dbh->prepare($sql);
									$query->bindParam(':bid', $bid, PDO::PARAM_STR);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									if ($query->rowCount() > 0) {
										$result = $results[0];
										?>
										<h3 class="text-center mb-4">Booking
											#<?php echo htmlentities($result->BookingNumber); ?></h3>
										<div class="row">
											<div class="col-md-6">
												<div class="card mb-4">
													<div class="card-header">
														<h6 class="mb-0">User Details</h6>
													</div>
													<div class="card-body">
														<dl class="row mb-0">
															<dt class="col-sm-4">Booking No.</dt>
															<dd class="col-sm-8">
																<a href="javascript:void(0);" class="text-green">
																	<?php echo htmlentities($result->BookingNumber); ?>
																</a>

															</dd>
															<dt class="col-sm-4">Name</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->FullName); ?>
															</dd>
															<dt class="col-sm-4">Email</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->EmailId); ?>
															</dd>
															<dt class="col-sm-4">Contact No.</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->ContactNo); ?>
															</dd>
															<dt class="col-sm-4">Address</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->Address); ?>
															</dd>
															<dt class="col-sm-4">City</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->City); ?></dd>
															<dt class="col-sm-4">Country</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->Country); ?>
															</dd>
														</dl>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="card mb-4">
													<div class="card-header">
														<h6 class="mb-0">Booking Details</h6>
													</div>
													<div class="card-body">
														<dl class="row mb-0">
															<dt class="col-sm-4">Vehicle</dt>
															<dd class="col-sm-8">
																<a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"
																	class="text-primary"><?php echo htmlentities($result->BrandName); ?>,
																	<?php echo htmlentities($result->VehiclesTitle); ?>
																</a>
															</dd>
															<dt class="col-sm-4">Booking Date</dt>
															<dd class="col-sm-8">
																<?php echo htmlentities($result->PostingDate); ?>
															</dd>
															<dt class="col-sm-4">From Date</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->FromDate); ?>
															</dd>
															<dt class="col-sm-4">To Date</dt>
															<dd class="col-sm-8"><?php echo htmlentities($result->ToDate); ?>
															</dd>
															<dt class="col-sm-4">Total Days</dt>
															<dd class="col-sm-8">
																<?php echo htmlentities($tdays = $result->totalnodays); ?>
															</dd>
															<dt class="col-sm-4">Rent Per Day</dt>
															<dd class="col-sm-8">
																<?php echo htmlentities($ppdays = $result->PricePerDay); ?>
															</dd>
															<dt class="col-sm-4">Grand Total</dt>
															<dd class="col-sm-8"><?php echo htmlentities($tdays * $ppdays); ?>
															</dd>
															<dt class="col-sm-4">Status</dt>
															<dd class="col-sm-8">
																<?php
																if ($result->Status == 0) {
																	echo '<span class="badge bg-warning">Pending</span>';
																} elseif ($result->Status == 1) {
																	echo '<span class="badge bg-success">Confirmed</span>';
																} else {
																	echo '<span class="badge bg-danger">Cancelled</span>';
																}
																?>
															</dd>
															<dt class="col-sm-4">Last Updated</dt>
															<dd class="col-sm-8">
																<?php echo htmlentities($result->LastUpdationDate ?: 'N/A'); ?>
															</dd>
														</dl>
													</div>
												</div>
											</div>
										</div>
										
										<?php if ($result->Status == 0) { ?>
											<div class="text-end no-print">
												<a href="booking-details.php?aeid=<?php echo htmlentities($result->id); ?>"
													class="btn btn-success me-2"
													onclick="return confirm('Are you sure you want to confirm this booking?');">
													Confirm Booking</a>
												<a href="booking-details.php?eid=<?php echo htmlentities($result->id); ?>"
													class="btn btn-danger"
													onclick="return confirm('Are you sure you want to cancel this booking?');">
													Cancel Booking</a>
											</div>
										<?php } ?>
									<?php } else { ?>
										<div class="alert alert-warning" role="alert">Booking not found.</div>
									<?php } ?>
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