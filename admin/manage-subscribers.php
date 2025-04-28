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
		$id = intval($_GET['del']);
		$sql = "DELETE FROM tblsubscribers WHERE id = :id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Subscriber deleted successfully";
		} else {
			$error = "Failed to delete subscriber. Please try again.";
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
	<title>Car Rental Portal | Admin Manage Subscribers</title>
	<?php include("includes/head.php"); ?>
</head>
<body class="fluid-body">
	
	<div class="page-wrapper d-flex">
		<div class="page-content flex-grow-1">
			<div class="container-fluid py-4">
				<h2 class="mb-4">Manage Subscribers</h2>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5 class="mb-0">Subscribers Details</h5>
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
												<th>Email</th>
												<th>Subscription Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM tblsubscribers";
											$query = $dbh->prepare($sql);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt = 1;
											if ($query->rowCount() > 0) {
												foreach ($results as $result) { ?>
													<tr>
														<td><?php echo htmlentities($cnt); ?></td>
														<td><?php echo htmlentities($result->SubscriberEmail); ?></td>
														<td><?php echo htmlentities($result->PostingDate); ?></td>
														<td>
															<a href="manage-subscribers.php?del=<?php echo htmlentities($result->id); ?>" class="btn btn-sm btn-danger" title="Delete Subscriber" onclick="return confirm('Are you sure you want to delete this subscriber?');"><i class="ti ti-trash"></i> Delete</a>
														</td>
													</tr>
													<?php $cnt++;
												}
											} else { ?>
												<tr>
													<td colspan="4" class="text-center">No subscribers found.</td>
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