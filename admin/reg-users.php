<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	$msg = '';
	$error = '';
	// Placeholder for delete logic (if needed)
	if (isset($_GET['del'])) {
		$id = $_GET['del'];
		// Example: Delete user from tblusers (uncomment and adjust as needed)
		/*
									  $sql = "DELETE FROM tblusers WHERE id=:id";
									  $query = $dbh->prepare($sql);
									  $query->bindParam(':id', $id, PDO::PARAM_STR);
									  if ($query->execute()) {
										  $msg = "User deleted successfully";
									  } else {
										  $error = "Failed to delete user. Please try again.";
									  }
									  */
		$error = "Delete functionality is disabled. Please implement the correct logic.";
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
		<title>Car Rental Portal | Admin Registered Users</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body class="fluid-body">
		<div class="page-wrapper d-flex">
			<div class="container p-6 mt-5">
				<div class="container-fluid">
					<h2 class="mb-4">Registered Users</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">User List</h5>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger" role="alert"><?php echo htmlentities($error); ?></div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
									<?php } ?>
									<div class="table-responsive">
										<table class="table table-responsive table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>Name</th>
													<th>Email</th>
													<th>Contact No</th>
													<th>DOB</th>
													<th>Address</th>
													<th>City</th>
													<th>Country</th>
													<th>Reg Date</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT * FROM tblusers";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) { ?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->FullName); ?></td>
															<td><?php echo htmlentities($result->EmailId); ?></td>
															<td><?php echo htmlentities($result->ContactNo); ?></td>
															<td><?php echo htmlentities($result->dob); ?></td>
															<td><?php echo htmlentities($result->Address); ?></td>
															<td><?php echo htmlentities($result->City); ?></td>
															<td><?php echo htmlentities($result->Country); ?></td>
															<td><?php echo htmlentities($result->RegDate); ?></td>
														</tr>
														<?php $cnt++;
													}
												} else { ?>
													<tr>
														<td colspan="9" class="text-center">No users found.</td>
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