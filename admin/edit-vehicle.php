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
		$airconditioner = isset($_POST['airconditioner']) ? 1 : 0;
		$powerdoorlocks = isset($_POST['powerdoorlocks']) ? 1 : 0;
		$antilockbrakingsys = isset($_POST['antilockbrakingsys']) ? 1 : 0;
		$brakeassist = isset($_POST['brakeassist']) ? 1 : 0;
		$powersteering = isset($_POST['powersteering']) ? 1 : 0;
		$driverairbag = isset($_POST['driverairbag']) ? 1 : 0;
		$passengerairbag = isset($_POST['passengerairbag']) ? 1 : 0;
		$powerwindow = isset($_POST['powerwindow']) ? 1 : 0;
		$cdplayer = isset($_POST['cdplayer']) ? 1 : 0;
		$centrallocking = isset($_POST['centrallocking']) ? 1 : 0;
		$crashcensor = isset($_POST['crashcensor']) ? 1 : 0;
		$leatherseats = isset($_POST['leatherseats']) ? 1 : 0;
		$id = intval($_GET['id']);

		$sql = "UPDATE tblvehicles SET VehiclesTitle=:vehicletitle, VehiclesBrand=:brand, VehiclesOverview=:vehicleoverview, PricePerDay=:priceperday, FuelType=:fueltype, ModelYear=:modelyear, SeatingCapacity=:seatingcapacity, AirConditioner=:airconditioner, PowerDoorLocks=:powerdoorlocks, AntiLockBrakingSystem=:antilockbrakingsys, BrakeAssist=:brakeassist, PowerSteering=:powersteering, DriverAirbag=:driverairbag, PassengerAirbag=:passengerairbag, PowerWindows=:powerwindow, CDPlayer=:cdplayer, CentralLocking=:centrallocking, CrashSensor=:crashcensor, LeatherSeats=:leatherseats WHERE id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
		$query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
		$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
		$query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
		$query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
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
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		if ($query->execute()) {
			$msg = "Vehicle data updated successfully";
		} else {
			$error = "Failed to update vehicle data. Please try again.";
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
		<title>Car Rental Portal | Admin Edit Vehicle</title>
		<?php include("includes/head.php"); ?>
	</head>

	<body class="fluid-body">
	
		<?php include('includes/leftbar.php'); ?>
		<div class="page-wrapper d-flex">
			<div class="page-content flex-grow-1">
				<div class="container-fluid py-4">
					<h2 class="mb-4">Edit Vehicle</h2>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">Basic Info</h5>
								</div>
								<div class="card-body">
									<?php if ($error) { ?>
										<div class="alert alert-danger" role="alert"><?php echo htmlentities($error); ?></div>
									<?php } elseif ($msg) { ?>
										<div class="alert alert-success" role="alert"><?php echo htmlentities($msg); ?></div>
									<?php } ?>
									<?php
									$id = intval($_GET['id']);
									$sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand WHERE tblvehicles.id = :id";
									$query = $dbh->prepare($sql);
									$query->bindParam(':id', $id, PDO::PARAM_STR);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									if ($query->rowCount() > 0) {
										foreach ($results as $result) { ?>
											<form method="post">
												<div class="row g-3">
													<div class="col-md-6">
														<label for="vehicletitle" class="form-label">Vehicle Title <span
																class="text-danger">*</span></label>
														<input type="text" id="vehicletitle" name="vehicletitle"
															class="form-control"
															value="<?php echo htmlentities($result->VehiclesTitle); ?>" required>
													</div>
													<div class="col-md-6">
														<label for="brandname" class="form-label">Select Brand <span
																class="text-danger">*</span></label>
														<select id="brandname" name="brandname" class="form-select" required>
															<option value="<?php echo htmlentities($result->bid); ?>">
																<?php echo htmlentities($result->BrandName); ?>
															</option>
															<?php
															$ret = "SELECT id, BrandName FROM tblbrands WHERE BrandName != :brandname";
															$query2 = $dbh->prepare($ret);
															$query2->bindParam(':brandname', $result->BrandName, PDO::PARAM_STR);
															$query2->execute();
															$brands = $query2->fetchAll(PDO::FETCH_OBJ);
															foreach ($brands as $brand) { ?>
																<option value="<?php echo htmlentities($brand->id); ?>">
																	<?php echo htmlentities($brand->BrandName); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<div class="col-12">
														<label for="vehicalorcview" class="form-label">Vehicle Overview <span
																class="text-danger">*</span></label>
														<textarea id="vehicalorcview" name="vehicalorcview" class="form-control"
															rows="4"
															required><?php echo htmlentities($result->VehiclesOverview); ?></textarea>
													</div>
													<div class="col-md-6">
														<label for="priceperday" class="form-label">Price Per Day (in KES) <span
																class="text-danger">*</span></label>
														<input type="number" id="priceperday" name="priceperday"
															class="form-control"
															value="<?php echo htmlentities($result->PricePerDay); ?>" required>
													</div>
													<div class="col-md-6">
														<label for="fueltype" class="form-label">Select Fuel Type <span
																class="text-danger">*</span></label>
														<select id="fueltype" name="fueltype" class="form-select" required>
															<option value="<?php echo htmlentities($result->FuelType); ?>">
																<?php echo htmlentities($result->FuelType); ?>
															</option>
															<?php
															$fuel_types = ['Petrol', 'Diesel', 'Electric', 'Hybrid'];
															foreach ($fuel_types as $type) {
																if ($type != $result->FuelType) {
																	echo "<option value=\"$type\">$type</option>";
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-6">
														<label for="modelyear" class="form-label">Model Year <span
																class="text-danger">*</span></label>
														<input type="number" id="modelyear" name="modelyear" class="form-control"
															value="<?php echo htmlentities($result->ModelYear); ?>" required>
													</div>
													<div class="col-md-6">
														<label for="seatingcapacity" class="form-label">Seating Capacity <span
																class="text-danger">*</span></label>
														<input type="number" id="seatingcapacity" name="seatingcapacity"
															class="form-control"
															value="<?php echo htmlentities($result->SeatingCapacity); ?>" required>
													</div>
												</div>
												<hr class="my-4">
												<h5 class="mb-3">Vehicle Images</h5>
												<div class="row g-3">
													<?php for ($i = 1; $i <= 5; $i++) {
														$image_field = "Vimage$i";
														$image = $result->$image_field;
														?>
														<div class="col-md-4">
															<label class="form-label">Image
																<?php echo $i; ?>
																<?php echo $i <= 4 ? ' <span class="text-danger">*</span>' : ''; ?></label>
															<div class="card">
																<?php if ($image) { ?>
																	<img src="img/vehicleimages/<?php echo htmlentities($image); ?>"
																		class="card-img-top" alt="Vehicle Image"
																		style="height: 150px; object-fit: cover;">
																<?php } else { ?>
																	<div class="card-body text-center text-muted">No image available</div>
																<?php } ?>
																<div class="card-footer text-center">
																	<a href="changeimage<?php echo $i; ?>.php?imgid=<?php echo htmlentities($result->id); ?>"
																		class="text-primary">Change Image <?php echo $i; ?></a>
																</div>
															</div>
														</div>
													<?php } ?>
												</div>
												<hr class="my-4">
												<h5 class="mb-3">Accessories</h5>
												<div class="row g-3">
													<?php
													$accessories = [
														['name' => 'airconditioner', 'label' => 'Air Conditioner', 'value' => $result->AirConditioner],
														['name' => 'powerdoorlocks', 'label' => 'Power Door Locks', 'value' => $result->PowerDoorLocks],
														['name' => 'antilockbrakingsys', 'label' => 'AntiLock Braking System', 'value' => $result->AntiLockBrakingSystem],
														['name' => 'brakeassist', 'label' => 'Brake Assist', 'value' => $result->BrakeAssist],
														['name' => 'powersteering', 'label' => 'Power Steering', 'value' => $result->PowerSteering],
														['name' => 'driverairbag', 'label' => 'Driver Airbag', 'value' => $result->DriverAirbag],
														['name' => 'passengerairbag', 'label' => 'Passenger Airbag', 'value' => $result->PassengerAirbag],
														['name' => 'powerwindow', 'label' => 'Power Windows', 'value' => $result->PowerWindows],
														['name' => 'cdplayer', 'label' => 'CD Player', 'value' => $result->CDPlayer],
														['name' => 'centrallocking', 'label' => 'Central Locking', 'value' => $result->CentralLocking],
														['name' => 'crashcensor', 'label' => 'Crash Sensor', 'value' => $result->CrashSensor],
														['name' => 'leatherseats', 'label' => 'Leather Seats', 'value' => $result->LeatherSeats]
													];
													foreach ($accessories as $accessory) { ?>
														<div class="col-sm-3">
															<div class="form-check">
																<input type="checkbox" id="<?php echo $accessory['name']; ?>"
																	name="<?php echo $accessory['name']; ?>" value="1"
																	class="form-check-input" <?php echo $accessory['value'] == 1 ? 'checked' : ''; ?>>
																<label for="<?php echo $accessory['name']; ?>"
																	class="form-check-label"><?php echo $accessory['label']; ?></label>
															</div>
														</div>
													<?php } ?>
												</div>
												<div class="mt-4">
													<button type="reset" class="btn btn-outline-secondary me-2">Cancel</button>
													<button type="submit" name="submit" class="btn btn-primary">Save
														Changes</button>
												</div>
											</form>
										<?php }
									} else { ?>
										<div class="alert alert-warning" role="alert">Vehicle not found.</div>
									<?php } ?>
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