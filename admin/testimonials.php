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
		$status = 0;
		$sql = "UPDATE tbltestimonial SET status = :status WHERE id = :eid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':eid', $eid, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Testimonial successfully set to inactive";
		} else {
			$error = "Failed to set testimonial to inactive. Please try again.";
		}
	}

	if (isset($_REQUEST['aeid'])) {
		$aeid = intval($_GET['aeid']);
		$status = 1;
		$sql = "UPDATE tbltestimonial SET status = :status WHERE id = :aeid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Testimonial successfully set to active";
		} else {
			$error = "Failed to set testimonial to active. Please try again.";
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
		<title>Car Rental Portal | Admin Manage Testimonials</title>
		<?php include("includes/head.php"); ?>

	</head>

	<body class="fluid-body">
		<div class="page-wrapper d-flex">
			<div class="container p-6 mt-5">
				<div class="container-fluid">
					<h2 class="mb-4">Manage Testimonials</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">User Testimonials</h5>
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
													<th>Email</th>
													<th>Testimonial</th>
													<th>Posting Date</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT tblusers.FullName, tbltestimonial.UserEmail, tbltestimonial.Testimonial, tbltestimonial.PostingDate, tbltestimonial.status, tbltestimonial.id FROM tbltestimonial JOIN tblusers ON tblusers.Emailid = tbltestimonial.UserEmail";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->FullName); ?></td>
															<td><?php echo htmlentities($result->UserEmail); ?></td>
															<td><?php echo htmlentities($result->Testimonial); ?></td>
															<td><?php echo htmlentities($result->PostingDate); ?></td>
															<td>
																<?php if ($result->status == 0) { ?>
																	<span class="badge bg-warning">Inactive</span>
																<?php } else { ?>
																	<span class="badge bg-success">Active</span>
																<?php } ?>
															</td>
															<td>
																<div class="btn-group" role="group">
																	<?php if ($result->status == 0) { ?>
																		<a href="testimonials.php?aeid=<?php echo htmlentities($result->id); ?>"
																			class="btn btn-success me-1" title="Activate Testimonial"
																			onclick="return confirm('Are you sure you want to activate this testimonial?');">
																			Activate</a>
																	<?php } else { ?>
																		<a href="testimonials.php?eid=<?php echo htmlentities($result->id); ?>"
																			class="btn btn-warning me-1" title="Deactivate Testimonial"
																			onclick="return confirm('Are you sure you want to deactivate this testimonial?');">
																			Deactivate
																		</a>
																	<?php } ?>
																	<a href="testimonials.php?del=<?php echo htmlentities($result->id); ?>"
																		class="btn btn-icon btn-danger" title="Delete Testimonial"
																		onclick="return confirm('Are you sure you want to delete this testimonial?');">
																		<i class="fa-solid fa-trash"></i>
																	</a>
																</div>
															</td>
														</tr>
														<?php $cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="7" class="text-center">No testimonials found.</td>
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