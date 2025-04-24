<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	// Code for change password	
	if (isset($_POST['update'])) {
		$vimage = $_FILES["img3"]["name"];
		$id = intval($_GET['imgid']);
		move_uploaded_file($_FILES["img3"]["tmp_name"], "img/vehicleimages/" . $_FILES["img3"]["name"]);
		$sql = "update tblvehicles set Vimage3=:vimage where id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':vimage', $vimage, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();

		$msg = "Image updated successfully";
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

		<title>Car Rental Portal | Admin Update Image 3</title>

		<?php include("includes/head.php"); ?>

	</head>

	<body class="fluid-body">
	
		<?php include('includes/leftbar.php'); ?>
		<div class="ts-main-content">
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Vehicle Image 3 </h2>

							<div class="row">
								<div class="col-md-10">
									<div class="panel panel-default">
										<div class="panel-heading">Vehicle Image 3 Details</div>
										<div class="panel-body">
											<form method="post" class="form-horizontal" enctype="multipart/form-data">


												<?php if ($error) { ?>
													<div class="errorWrap">
														<strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?>
														<div class="succWrap">
															<strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
												<?php } ?>



												<div class="form-group">
													<label class="col-sm-4 control-label">Current Image3</label>
													<?php
													$id = intval($_GET['imgid']);
													$sql = "SELECT Vimage3 from tblvehicles where tblvehicles.id=:id";
													$query = $dbh->prepare($sql);
													$query->bindParam(':id', $id, PDO::PARAM_STR);
													$query->execute();
													$results = $query->fetchAll(PDO::FETCH_OBJ);
													$cnt = 1;
													if ($query->rowCount() > 0) {
														foreach ($results as $result) { ?>

															<div class="col-sm-8">
																<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3); ?>"
																	width="300" height="200" style="border:solid 1px #000">
															</div>
														<?php }
													} ?>
												</div>

												<div class="form-group">
													<label class="col-sm-4 control-label">Upload New Image 3<span
															style="color:red">*</span></label>
													<div class="col-sm-8">
														<input type="file" name="img3" required>
													</div>
												</div>
												<div class="hr-dashed"></div>




												<div class="form-group">
													<div class="col-sm-8 col-sm-offset-4">

														<button class="btn btn-primary" name="update"
															type="submit">Update</button>
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