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
		$status = 1;
		$sql = "UPDATE tblcontactusquery SET status = :status WHERE id = :eid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':eid', $eid, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Query marked as read successfully";
		} else {
			$error = "Failed to mark query as read. Please try again.";
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
		<title>Car Rental Portal | Admin Manage Queries</title>
		<?php include("includes/head.php"); ?>

	</head>

	<body class="fluid-body">
	
		<?php include('includes/leftbar.php'); ?>
		<div class="page-wrapper d-flex">
			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Manage Contact Us Queries</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">User Queries</h5>
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
													<th>Contact No</th>
													<th>Message</th>
													<th>Posting Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT * FROM tblcontactusquery";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->name); ?></td>
															<td><?php echo htmlentities($result->EmailId); ?></td>
															<td><?php echo htmlentities($result->ContactNumber); ?></td>
															<td><?php echo htmlentities($result->Message); ?></td>
															<td><?php echo htmlentities($result->PostingDate); ?></td>
															<td>
																<?php if ($result->status == 1) { ?>
																	<span class="badge bg-success">Read</span>
																<?php } else { ?>
																	<a href="manage-conactusquery.php?eid=<?php echo htmlentities($result->id); ?>"
																		class="btn btn-sm btn-primary"
																		onclick="return confirm('Are you sure you want to mark this query as read?');"><i
																			class="ti ti-eye"></i> Mark as Read</a>
																<?php } ?>
															</td>
														</tr>
														<?php $cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="7" class="text-center">No queries found.</td>
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