<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php');

if (isset($_POST['submit'])) {
    // Validate and read image data
    $images = ['img1', 'img2', 'img3', 'img4', 'img5'];
    $imageData = [];
    foreach ($images as $index => $img) {
        if (!empty($_FILES[$img]['tmp_name'])) {
            // Validate file type and size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 10 * 1024 * 1024; // 10MB
            if (!in_array($_FILES[$img]['type'], $allowedTypes)) {
                $error = "Image " . ($index + 1) . ": Invalid file type. Allowed: jpg, png, webp.";
                break;
            }
            if ($_FILES[$img]['size'] > $maxSize) {
                $error = "Image " . ($index + 1) . ": File too large. Max 10MB.";
                break;
            }
            if ($_FILES[$img]['error'] !== UPLOAD_ERR_OK) {
                $error = "Image " . ($index + 1) . ": Upload error (" . $_FILES[$img]['error'] . ").";
                break;
            }
            // Read the image file as binary data
            $imageData[$img] = file_get_contents($_FILES[$img]['tmp_name']);
            if ($imageData[$img] === false) {
                $error = "Image " . ($index + 1) . ": Failed to read file.";
                break;
            }
        } else {
            $imageData[$img] = null; // Set to NULL for optional images (e.g., img5)
        }
    }

    if (!isset($error)) {
        // Insert into database
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

        $sql = "INSERT INTO tblvehicles(VehiclesTitle,VehiclesBrand,VehiclesOverview,PricePerDay,FuelType,ModelYear,SeatingCapacity,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,PowerDoorLocks,AntiLockBrakingSystem,BrakeAssist,PowerSteering,DriverAirbag,PassengerAirbag,PowerWindows,CDPlayer,CentralLocking,CrashSensor,LeatherSeats) 
                VALUES(:vehicletitle,:brand,:vehicleoverview,:priceperday,:fueltype,:modelyear,:seatingcapacity,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:powerdoorlocks,:antilockbrakingsys,:brakeassist,:powersteering,:driverairbag,:passengerairbag,:powerwindow,:cdplayer,:centrallocking,:crashcensor,:leatherseats)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
        $query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
        $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
        $query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
        $query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
        $query->bindParam(':vimage1', $imageData['img1'], PDO::PARAM_LOB);
        $query->bindParam(':vimage2', $imageData['img2'], PDO::PARAM_LOB);
        $query->bindParam(':vimage3', $imageData['img3'], PDO::PARAM_LOB);
        $query->bindParam(':vimage4', $imageData['img4'], PDO::PARAM_LOB);
        $query->bindParam(':vimage5', $imageData['img5'], PDO::PARAM_LOB);
        $query->bindParam(':airconditioner', $airconditioner, PDO::PARAM_INT);
        $query->bindParam(':powerdoorlocks', $powerdoorlocks, PDO::PARAM_INT);
        $query->bindParam(':antilockbrakingsys', $antilockbrakingsys, PDO::PARAM_INT);
        $query->bindParam(':brakeassist', $brakeassist, PDO::PARAM_INT);
        $query->bindParam(':powersteering', $powersteering, PDO::PARAM_INT);
        $query->bindParam(':driverairbag', $driverairbag, PDO::PARAM_INT);
        $query->bindParam(':passengerairbag', $passengerairbag, PDO::PARAM_INT);
        $query->bindParam(':powerwindow', $powerwindow, PDO::PARAM_INT);
        $query->bindParam(':cdplayer', $cdplayer, PDO::PARAM_INT);
        $query->bindParam(':centrallocking', $centrallocking, PDO::PARAM_INT);
        $query->bindParam(':crashcensor', $crashcensor, PDO::PARAM_INT);
        $query->bindParam(':leatherseats', $leatherseats, PDO::PARAM_INT);

        if ($query->execute()) {
            $msg = "Vehicle posted successfully";
        } else {
            $error = "Database error: " . implode(", ", $query->errorInfo());
        }
    }
}
?>
<!DOCTYPE html>
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
    <div class="page">
        <div class="page-wrapper d-flex">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post a Vehicle</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-4">Basic Info</h4>
						<?php if ($error) { ?>
							<div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>	
						<?php } else if ($msg) { ?>
							<div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
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
                                        <input type="checkbox" id="airconditioner" name="airconditioner" value="1" class="form-check-input">
                                        <label for="airconditioner" class="form-check-label">Air Conditioner</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="powerdoorlocks" name="powerdoorlocks" value="1" class="form-check-input">
                                        <label for="powerdoorlocks" class="form-check-label">Power Door Locks</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="antilockbrakingsys" name="antilockbrakingsys" value="1" class="form-check-input">
                                        <label for="antilockbrakingsys" class="form-check-label">AntiLock Braking System</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="brakeassist" name="brakeassist" value="1" class="form-check-input">
                                        <label for="brakeassist" class="form-check-label">Brake Assist</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="powersteering" name="powersteering" value="1" class="form-check-input">
                                        <label for="powersteering" class="form-check-label">Power Steering</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="driverairbag" name="driverairbag" value="1" class="form-check-input">
                                        <label for="driverairbag" class="form-check-label">Driver Airbag</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="passengerairbag" name="passengerairbag" value="1" class="form-check-input">
                                        <label for="passengerairbag" class="form-check-label">Passenger Airbag</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="powerwindow" name="powerwindow" value="1" class="form-check-input">
                                        <label for="powerwindow" class="form-check-label">Power Windows</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="cdplayer" name="cdplayer" value="1" class="form-check-input">
                                        <label for="cdplayer" class="form-check-label">CD Player</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="centrallocking" name="centrallocking" value="1" class="form-check-input">
                                        <label for="centrallocking" class="form-check-label">Central Locking</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="crashcensor" name="crashcensor" value="1" class="form-check-input">
                                        <label for="crashcensor" class="form-check-label">Crash Sensor</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" id="leatherseats" name="leatherseats" value="1" class="form-check-input">
                                        <label for="leatherseats" class="form-check-label">Leather Seats</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-square btn-primary" name="submit" type="submit">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>