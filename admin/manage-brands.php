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

		<div class="page-wrapper d-flex">
			<div class="container p-6 mt-5">
				<div class="container-fluid">
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
										<div class="alert alert-danger alert-dismissible" role="alert">
											<?php echo htmlentities($error); ?>
											<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
										</div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success alert-dismissible" role="alert">
											<?php echo htmlentities($msg); ?>
											<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
										</div>
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
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
																		viewBox="0 0 24 24" fill="none" stroke="currentColor"
																		stroke-width="2" stroke-linecap="round"
																		stroke-linejoin="round"
																		class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
																		<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																		<path
																			d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
																		<path
																			d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
																		<path d="M16 5l3 3" />
																	</svg>
																</a>
																<a href="manage-brands.php?del=<?php echo $result->id; ?>"
																	class="btn btn-icon btn-danger"
																	onclick="return confirm('Are you sure you want to delete this brand?');">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
																		viewBox="0 0 24 24" fill="none" stroke="currentColor"
																		stroke-width="2" stroke-linecap="round"
																		stroke-linejoin="round"
																		class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
																		<path stroke="none" d="M0 0h24v24H0z" fill="none" />
																		<path d="M4 7l16 0" />
																		<path d="M10 11l0 6" />
																		<path d="M14 11l0 6" />
																		<path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
																		<path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
																	</svg>
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