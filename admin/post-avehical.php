<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_POST['submit'])) {
		$vehicletitle = $_POST['vehicletitle'];
		$brand = $_POST['brandname'];
		$vehicleoverview = $_POST['vehicalorcview'];
		$priceperday = $_POST['priceperday'];
		$fueltype = $_POST['fueltype'];
		$modelyear = $_POST['modelyear'];
		$seatingcapacity = $_POST['seatingcapacity'];
		$vimage1 = $_FILES["img1"]["name"];
		$vimage2 = $_FILES["img2"]["name"];
		$vimage3 = $_FILES["img3"]["name"];
		$vimage4 = $_FILES["img4"]["name"];
		$vimage5 = $_FILES["img5"]["name"];
		$airconditioner = $_POST['airconditioner'];
		$powerdoorlocks = $_POST['powerdoorlocks'];
		$antilockbrakingsys = $_POST['antilockbrakingsys'];
		$brakeassist = $_POST['brakeassist'];
		$powersteering = $_POST['powersteering'];
		$driverairbag = $_POST['driverairbag'];
		$passengerairbag = $_POST['passengerairbag'];
		$powerwindow = $_POST['powerwindow'];
		$cdplayer = $_POST['cdplayer'];
		$centrallocking = $_POST['centrallocking'];
		$crashcensor = $_POST['crashcensor'];
		$leatherseats = $_POST['leatherseats'];
		move_uploaded_file($_FILES["img1"]["tmp_name"], "img/vehicleimages/" . $_FILES["img1"]["name"]);
		move_uploaded_file($_FILES["img2"]["tmp_name"], "img/vehicleimages/" . $_FILES["img2"]["name"]);
		move_uploaded_file($_FILES["img3"]["tmp_name"], "img/vehicleimages/" . $_FILES["img3"]["name"]);
		move_uploaded_file($_FILES["img4"]["tmp_name"], "img/vehicleimages/" . $_FILES["img4"]["name"]);
		move_uploaded_file($_FILES["img5"]["tmp_name"], "img/vehicleimages/" . $_FILES["img5"]["name"]);

		$sql = "INSERT INTO tblvehicles(VehiclesTitle,VehiclesBrand,VehiclesOverview,PricePerDay,FuelType,ModelYear,SeatingCapacity,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,PowerDoorLocks,AntiLockBrakingSystem,BrakeAssist,PowerSteering,DriverAirbag,PassengerAirbag,PowerWindows,CDPlayer,CentralLocking,CrashSensor,LeatherSeats) VALUES(:vehicletitle,:brand,:vehicleoverview,:priceperday,:fueltype,:modelyear,:seatingcapacity,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:powerdoorlocks,:antilockbrakingsys,:brakeassist,:powersteering,:driverairbag,:passengerairbag,:powerwindow,:cdplayer,:centrallocking,:crashcensor,:leatherseats)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
		$query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
		$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
		$query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
		$query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
		$query->bindParam(':vimage1', $vimage1, PDO::PARAM_STR);
		$query->bindParam(':vimage2', $vimage2, PDO::PARAM_STR);
		$query->bindParam(':vimage3', $vimage3, PDO::PARAM_STR);
		$query->bindParam(':vimage4', $vimage4, PDO::PARAM_STR);
		$query->bindParam(':vimage5', $vimage5, PDO::PARAM_STR);
		$query->bindParam(':airconditioner', $airconditioner, PDO::PARAM_STR);
		$query->bindParam(':powerdoorlocks', $powerdoorlocks, PDO::PARAM_STR);
		$query->bindParam(':antilockbrakingsys', $antilockbrakingsys, PDO::PARAM_STR);
		$query->bindParam(':brakeassist', $brakeassist, PDO::PARAM_STR);
		$query->bindParam(':powersteering', $powersteering, PDO::PARAM_STR);
		$query->bindParam(':driverairbag', $driverairbag, PDO::PARAM_STR);
		$query->bindParam(':passengerairbag', $passengerairbag, PDO::PARAM_STR);
		$query->bindParam(':powerwindow', $powerwindow, PDO::PARAM_STR);
		$query->bindParam(':cdplayer', $cdplayer, PDO::PARAM_STR);
		$query->bindParam(':centrallocking', $centrallocking, PDO::PARAM_STR);
		$query->bindParam(':crashcensor', $crashcensor, PDO::PARAM_STR);
		$query->bindParam(':leatherseats', $leatherseats, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			$msg = "Vehicle posted successfully";
		} else {
			$error = "Something went wrong. Please try again";
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

		<title>Car Rental Portal | Admin Post Vehicle</title>

		<?php include("includes/head.php"); ?>

	</head>

	<body class="fluid-body">
	
		<?php include('includes/leftbar.php'); ?>

		<div class="page">
			<div class="page-wrapper">
				<div class="page-body">
					<div class="container-xl">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Post a Vehicle</h3>
							</div>
							<div class="card-body">
								<h4 class="mb-4">Basic Info</h4>
								<?php if ($error) { ?>
									<div class="alert alert-danger">
										<strong>ERROR:</strong><?php echo htmlentities($error); ?>
									</div>
								<?php } else if ($msg) { ?>
										<div class="alert alert-success">
											<strong>SUCCESS:</strong><?php echo htmlentities($msg); ?>
										</div>
								<?php } ?>

								<form method="post" class="form" enctype="multipart/form-data">
									<div class="row g-3 mb-3">
										<div class="col-md-6">
											<label class="form-label required">Vehicle Title</label>
											<input type="text" name="vehicletitle" class="form-control" required>
										</div>
										<div class="col-md-6">
											<label class="form-label required">Select Brand</label>
											<select class="form-select" name="brandname" required>
												<option value="">Select</option>
												<?php
												$ret = "select id,BrandName from tblbrands";
												$query = $dbh->prepare($ret);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												if ($query->rowCount() > 0) {
													foreach ($results as $result) {
														?>
														<option value="<?php echo htmlentities($result->id); ?>">
															<?php echo htmlentities($result->BrandName); ?>
														</option>
													<?php }
												} ?>
											</select>
										</div>
									</div>

									<div class="mb-3">
										<label class="form-label required">Vehicle Overview</label>
										<textarea class="form-control" name="vehicalorcview" rows="4" required></textarea>
									</div>

									<div class="row g-3 mb-3">
										<div class="col-md-6">
											<label class="form-label required">Price Per Day (in KES)</label>
											<input type="text" name="priceperday" class="form-control" required>
										</div>
										<div class="col-md-6">
											<label class="form-label required">Select Fuel Type</label>
											<select class="form-select" name="fueltype" required>
												<option value="">Select</option>
												<option value="Petrol">Petrol</option>
												<option value="Diesel">Diesel</option>
												<option value="CNG">Electric</option>
												<option value="Hybrid">Hybrid</option>
											</select>
										</div>
									</div>

									<div class="row g-3 mb-3">
										<div class="col-md-6">
											<label class="form-label required">Model Year</label>
											<input type="text" name="modelyear" class="form-control" required>
										</div>
										<div class="col-md-6">
											<label class="form-label required">Seating Capacity</label>
											<input type="text" name="seatingcapacity" class="form-control" required>
										</div>
									</div>

									<h4 class="mb-4">Upload Images</h4>
									<div class="row g-3 mb-3">
										<div class="col-md-4">
											<label class="form-label required">Image 1</label>
											<input type="file" name="img1" class="form-control" required>
											<div class="form-text">Max 10 MB. Allowed: jpg, jpeg, png, webp.</div>
										</div>
										<div class="col-md-4">
											<label class="form-label required">Image 2</label>
											<input type="file" name="img2" class="form-control" required>
											<div class="form-text">Max 10 MB. Allowed: jpg, jpeg, png, webp.</div>
										</div>
										<div class="col-md-4">
											<label class="form-label required">Image 3</label>
											<input type="file" name="img3" class="form-control" required>
											<div class="form-text">Max 10 MB. Allowed: jpg, jpeg, png, webp.</div>
										</div>
									</div>
									<div class="row g-3 mb-3">
										<div class="col-md-4">
											<label class="form-label required">Image 4</label>
											<input type="file" name="img4" class="form-control" required>
											<div class="form-text">Max 10 MB. Allowed: jpg, jpeg, png, webp.</div>
										</div>
										<div class="col-md-4">
											<label class="form-label">Image 5</label>
											<input type="file" name="img5" class="form-control">
											<div class="form-text">Max 10 MB. Allowed: jpg, jpeg, png, webp.</div>
										</div>
									</div>

									<h4 class="mb-4">Accessories</h4>
									
									<div class="row g-3 mb-3">
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="airconditioner" name="airconditioner" value="1"
													class="form-check-input">
												<label for="airconditioner" class="form-check-label">Air Conditioner</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="powerdoorlocks" name="powerdoorlocks" value="1"
													class="form-check-input">
												<label for="powerdoorlocks" class="form-check-label">Power Door
													Locks</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="antilockbrakingsys" name="antilockbrakingsys"
													value="1" class="form-check-input">
												<label for="antilockbrakingsys" class="form-check-label">AntiLock Braking
													System</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="brakeassist" name="brakeassist" value="1"
													class="form-check-input">
												<label for="brakeassist" class="form-check-label">Brake Assist</label>
											</div>
										</div>
									</div>
									<div class="row g-3 mb-3">
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="powersteering" name="powersteering" value="1"
													class="form-check-input">
												<label for="powersteering" class="form-check-label">Power Steering</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="driverairbag" name="driverairbag" value="1"
													class="form-check-input">
												<label for="driverairbag" class="form-check-label">Driver Airbag</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="passengerairbag" name="passengerairbag" value="1"
													class="form-check-input">
												<label for="passengerairbag" class="form-check-label">Passenger
													Airbag</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="powerwindow" name="powerwindow" value="1"
													class="form-check-input">
												<label for="powerwindow" class="form-check-label">Power Windows</label>
											</div>
										</div>
									</div>
									<div class="row g-3 mb-3">
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="cdplayer" name="cdplayer" value="1"
													class="form-check-input">
												<label for="cdplayer" class="form-check-label">CD Player</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="centrallocking" name="centrallocking" value="1"
													class="form-check-input">
												<label for="centrallocking" class="form-check-label">Central Locking</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="crashcensor" name="crashcensor" value="1"
													class="form-check-input">
												<label for="crashcensor" class="form-check-label">Crash Sensor</label>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-check">
												<input type="checkbox" id="leatherseats" name="leatherseats" value="1"
													class="form-check-input">
												<label for="leatherseats" class="form-check-label">Leather Seats</label>
											</div>
										</div>
									</div>

									<div class="mt-4">
										<button class="btn btn-square btn-outline-secondary" type="reset">Cancel</button>
										<button class="btn btn-square btn-primary" name="submit" type="submit">Save changes</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</body>

	</html>
<?php } ?>