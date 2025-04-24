<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	// Code for change password	
	if (isset($_POST['submit'])) {
		$brand = $_POST['brand'];
		$id = $_GET['id'];
		$sql = "update  tblbrands set BrandName=:brand where id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();

		$msg = "Brand Update successfully";

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

		<title>Car Rental Portal | Update Brand</title>

		<?php include("includes/head.php"); ?>

	</head>

	<body class="fluid-body">
	
		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Update Brand</h2>

							<div class="row">
								<div class="col-md-10">
									<div class="panel panel-default">
										<div class="panel-heading">Update Brand</div>
										<div class="panel-body">
											<form method="post" name="chngpwd" class="form-horizontal"
												onSubmit="return valid();">


												<?php if ($error) { ?>
													<div class="errorWrap">
														<strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?>
														<div class="succWrap">
															<strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
												<?php } ?>

												<?php
												$id = $_GET['id'];
												$ret = "select * from tblbrands where id=:id";
												$query = $dbh->prepare($ret);
												$query->bindParam(':id', $id, PDO::PARAM_STR);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) {
														?>

														<div class="form-group">
															<label class="col-sm-4 control-label">Brand Name</label>
															<div class="col-sm-8">
																<input type="text" class="form-control"
																	value="<?php echo htmlentities($result->BrandName); ?>"
																	name="brand" id="brand" required>
															</div>
														</div>
														<div class="hr-dashed"></div>

													<?php }
												} ?>


												<div class="form-group">
													<div class="col-sm-8 col-sm-offset-4">

														<button class="btn btn-primary" name="submit"
															type="submit">Submit</button>
													</div>
												</div>

											</form>

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