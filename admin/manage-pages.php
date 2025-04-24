<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
		$pagetype = $_GET['type'];
		$pagedetails = $_POST['pgedetails'];
		$sql = "UPDATE tblpages SET detail=:pagedetails WHERE type=:pagetype";
		$query = $dbh->prepare($sql);
		$query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
		$query->bindParam(':pagedetails', $pagedetails, PDO::PARAM_STR);
		$query->execute();
		$msg = "Page data updated successfully";
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
		<title>Car Rental Portal | Admin Manage Pages</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body class="fluid-body">

	<?php include('includes/leftbar.php'); ?>
		<div class="page-wrapper d-flex">

			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Manage Pages</h2>
					<div class="row">
						<div class="col-md-10">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">Page Details</h5>
								</div>
								<div class="card-body">
									<?php if ($msg) { ?>
										<div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
									<?php } ?>
									<form method="post">
										<div class="mb-3">
											<label for="menu1" class="form-label">Select Page</label>
											<select id="menu1" name="menu1" class="form-select"
												onchange="window.location.href=this.value">
												<option value="">Select One</option>
												<option value="manage-pages.php?type=terms" <?php echo $_GET['type'] == 'terms' ? 'selected' : ''; ?>>Terms and Conditions
												</option>
												<option value="manage-pages.php?type=privacy" <?php echo $_GET['type'] == 'privacy' ? 'selected' : ''; ?>>Privacy and Policy
												</option>
												<option value="manage-pages.php?type=aboutus" <?php echo $_GET['type'] == 'aboutus' ? 'selected' : ''; ?>>About Us</option>
												<option value="manage-pages.php?type=faqs" <?php echo $_GET['type'] == 'faqs' ? 'selected' : ''; ?>>FAQs</option>
											</select>
										</div>
										<div class="mb-3">
											<label class="form-label">Selected Page</label>
											<p class="text-muted">
												<?php
												switch ($_GET['type']) {
													case "terms":
														echo "Terms and Conditions";
														break;
													case "privacy":
														echo "Privacy and Policy";
														break;
													case "aboutus":
														echo "About Us";
														break;
													case "faqs":
														echo "FAQs";
														break;
													default:
														echo "No page selected";
														break;
												}
												?>
											</p>
										</div>
										<div class="mb-3">
											<label for="pgedetails" class="form-label">Page Details</label>
											<textarea id="pgedetails" name="pgedetails" class="form-control" rows="8"
												required>
												<?php
												$pagetype = $_GET['type'];
												$sql = "SELECT detail from tblpages where type=:pagetype";
												$query = $dbh->prepare($sql);
												$query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												if ($query->rowCount() > 0) {
													foreach ($results as $result) {
														echo htmlentities($result->detail);
													}
												}
												?>
											</textarea>
										</div>
										<button type="submit" name="submit" value="Update"
											class="btn btn-primary">Update</button>
									</form>
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