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
		<title>Car Rental Portal | Admin Dashboard</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body>
		<div class="page-wrapper d-flex">
			<div class="container p-1 mt-2">
				<div class="container-fluid py-4">
					<div class="page-body">
						<div class="page-header m-3">
							<div class="row align-items-center">
								<div class="col">
									<div class="page-pretitle">Overview</div>
									<h2 class="page-title">Dashboard</h2>
								</div>
							</div>
						</div>
						<div class="container-xl">
							<div class="row g-4">
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql = "SELECT id from tblusers ";
											$query = $dbh->prepare($sql);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$regusers = $query->rowCount();
											?>
											<h1 class="text-primary mb-2"><?php echo htmlentities($regusers); ?></h1>
											<h6 class="text-uppercase text-muted">Registered Users</h6>
										</div>
										<a href="reg-users.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg>
										</a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql1 = "SELECT id from tblvehicles ";
											$query1 = $dbh->prepare($sql1);
											$query1->execute();
											$results1 = $query1->fetchAll(PDO::FETCH_OBJ);
											$totalvehicle = $query1->rowCount();
											?>
											<h1 class="text-success mb-2"><?php echo htmlentities($totalvehicle); ?>
											</h1>
											<h6 class="text-uppercase text-muted">Listed Vehicles</h6>
										</div>
										<a href="manage-vehicles.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql2 = "SELECT id from tblbooking ";
											$query2 = $dbh->prepare($sql2);
											$query2->execute();
											$results2 = $query2->fetchAll(PDO::FETCH_OBJ);
											$bookings = $query2->rowCount();
											?>
											<h1 class="text-info mb-2"><?php echo htmlentities($bookings); ?></h1>
											<h6 class="text-uppercase text-muted">Total Bookings</h6>
										</div>
										<a href="manage-bookings.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql3 = "SELECT id from tblbrands ";
											$query3 = $dbh->prepare($sql3);
											$query3->execute();
											$results3 = $query3->fetchAll(PDO::FETCH_OBJ);
											$brands = $query3->rowCount();
											?>
											<h1 class="text-warning mb-2"><?php echo htmlentities($brands); ?></h1>
											<h6 class="text-uppercase text-muted">Listed Brands</h6>
										</div>
										<a href="manage-brands.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql4 = "SELECT id from tblsubscribers ";
											$query4 = $dbh->prepare($sql4);
											$query4->execute();
											$results4 = $query4->fetchAll(PDO::FETCH_OBJ);
											$subscribers = $query4->rowCount();
											?>
											<h1 class="text-primary mb-2"><?php echo htmlentities($subscribers); ?></h1>
											<h6 class="text-uppercase text-muted">Subscribers</h6>
										</div>
										<a href="manage-subscribers.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql6 = "SELECT id from tblcontactusquery ";
											$query6 = $dbh->prepare($sql6);
											$query6->execute();
											$results6 = $query6->fetchAll(PDO::FETCH_OBJ);
											$query = $query6->rowCount();
											?>
											<h1 class="text-success mb-2"><?php echo htmlentities($query); ?></h1>
											<h6 class="text-uppercase text-muted">Queries</h6>
										</div>
										<a href="manage-conactusquery.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="card h-100">
										<div class="card-body text-center">
											<?php
											$sql5 = "SELECT id from tbltestimonial ";
											$query5 = $dbh->prepare($sql5);
											$query5->execute();
											$results5 = $query5->fetchAll(PDO::FETCH_OBJ);
											$testimonials = $query5->rowCount();
											?>
											<h1 class="text-info mb-2"><?php echo htmlentities($testimonials); ?></h1>
											<h6 class="text-uppercase text-muted">Testimonials</h6>
										</div>
										<a href="testimonials.php"
											class="card-footer text-center text-primary text-decoration-none">Full
											Detail <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M17 7l-10 10" />
												<path d="M8 7l9 0l0 9" />
											</svg></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<style>
		.card {
			border-radius: 0px;
		}

		.card-footer {
			border-radius: 0px !important;
		}
	</style>

	</html>
<?php } ?>