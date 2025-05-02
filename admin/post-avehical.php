<?php
session_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 1); 
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location: index.php');
    exit();
}

$msg = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Validate and sanitize inputs
    $vehicletitle = filter_input(INPUT_POST, 'vehicletitle', FILTER_SANITIZE_STRING);
    $brand = filter_input(INPUT_POST, 'brandname', FILTER_VALIDATE_INT); // Expecting brand ID
    $vehicleoverview = filter_input(INPUT_POST, 'vehicalorcview', FILTER_SANITIZE_STRING);
    $priceperday = filter_input(INPUT_POST, 'priceperday', FILTER_VALIDATE_FLOAT);
    $fueltype = filter_input(INPUT_POST, 'fueltype', FILTER_SANITIZE_STRING);
    $modelyear = filter_input(INPUT_POST, 'modelyear', FILTER_VALIDATE_INT);
    $seatingcapacity = filter_input(INPUT_POST, 'seatingcapacity', FILTER_VALIDATE_INT);

    // Validate required fields
    if (empty($vehicletitle) || !$brand || empty($vehicleoverview) || $priceperday === false || empty($fueltype) || $modelyear === false || $seatingcapacity === false) {
        $error = "Please fill all required fields with valid data.";
    } else {
        // Handle image uploads
        $images = ['img1', 'img2', 'img3', 'img4', 'img5'];
        $imageData = [];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        foreach ($images as $index => $img) {
            if (!empty($_FILES[$img]['tmp_name']) && $_FILES[$img]['error'] === UPLOAD_ERR_OK) {
                if (!in_array($_FILES[$img]['type'], $allowedTypes)) {
                    $error = "Image " . ($index + 1) . ": Invalid file type. Allowed: jpg, png, webp.";
                    break;
                }
                if ($_FILES[$img]['size'] > $maxSize) {
                    $error = "Image " . ($index + 1) . ": File too large. Max 10MB.";
                    break;
                }
                $imageData[$img] = file_get_contents($_FILES[$img]['tmp_name']);
                if ($imageData[$img] === false) {
                    $error = "Image " . ($index + 1) . ": Failed to read file.";
                    break;
                }
            } else {
                $imageData[$img] = null; // Allow null for optional images
            }
        }
        if (!$imageData['img1']) {
            $error = "Image 1 is required.";
        }

        if (!$error) {
            // Accessories (checkboxes)
            $accessories = [
                'airconditioner', 'powerdoorlocks', 'antilockbrakingsys', 'brakeassist',
                'powersteering', 'driverairbag', 'passengerairbag', 'powerwindow',
                'cdplayer', 'centrallocking', 'crashsensor', 'leatherseats'
            ];
            $accessoryValues = [];
            foreach ($accessories as $accessory) {
                $accessoryValues[$accessory] = isset($_POST[$accessory]) && $_POST[$accessory] == '1' ? 1 : 0;
            }

            // Insert into database
            try {
                $sql = "INSERT INTO tblvehicles (
                    VehiclesTitle, VehiclesBrand, VehiclesOverview, PricePerDay, FuelType, ModelYear, SeatingCapacity,
                    Vimage1, Vimage2, Vimage3, Vimage4, Vimage5,
                    AirConditioner, PowerDoorLocks, AntiLockBrakingSystem, BrakeAssist, PowerSteering,
                    DriverAirbag, PassengerAirbag, PowerWindows, CDPlayer, CentralLocking, CrashSensor, LeatherSeats,
                    RegDate, UpdationDate
                ) VALUES (
                    :vehicletitle, :brand, :vehicleoverview, :priceperday, :fueltype, :modelyear, :seatingcapacity,
                    :vimage1, :vimage2, :vimage3, :vimage4, :vimage5,
                    :airconditioner, :powerdoorlocks, :antilockbrakingsys, :brakeassist, :powersteering,
                    :driverairbag, :passengerairbag, :powerwindow, :cdplayer, :centrallocking, :crashsensor, :leatherseats,
                    NOW(), NOW()
                )";
                $query = $dbh->prepare($sql);
                $query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
                $query->bindParam(':brand', $brand, PDO::PARAM_INT); // Bind as INT
                $query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
                $query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
                $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
                $query->bindParam(':modelyear', $modelyear, PDO::PARAM_INT);
                $query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_INT);
                $query->bindParam(':vimage1', $imageData['img1'], PDO::PARAM_LOB);
                $query->bindValue(':vimage2', $imageData['img2'], $imageData['img2'] !== null ? PDO::PARAM_LOB : PDO::PARAM_NULL);
                $query->bindValue(':vimage3', $imageData['img3'], $imageData['img3'] !== null ? PDO::PARAM_LOB : PDO::PARAM_NULL);
                $query->bindValue(':vimage4', $imageData['img4'], $imageData['img4'] !== null ? PDO::PARAM_LOB : PDO::PARAM_NULL);
                $query->bindValue(':vimage5', $imageData['img5'], $imageData['img5'] !== null ? PDO::PARAM_LOB : PDO::PARAM_NULL);
                foreach ($accessories as $accessory) {
                    $query->bindParam(':' . $accessory, $accessoryValues[$accessory], PDO::PARAM_INT);
                }

                if ($query->execute()) {
                    $msg = "Vehicle posted successfully.";
                } else {
                    $error = "Database error: Unable to save vehicle.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
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
<div class="page-wrapper d-flex">
    <div class="container p-6 mt-5">
        <div class="container-fluid">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post a Vehicle</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-4">Basic Info</h4>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger alert-dismissible" role="alert"><strong>ERROR</strong>: <?php echo htmlspecialchars($error); ?>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        <?php } elseif ($msg) { ?>
                            <div class="alert alert-success alert-dismissible" role="alert" >
                                <strong>SUCCESS</strong>: <?php echo htmlspecialchars($msg); ?>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
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
                                        $ret = "SELECT id, BrandName FROM tblbrands";
                                        $query = $dbh->prepare($ret);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($results as $result) {
                                            echo "<option value='" . htmlspecialchars($result->id) . "'>" . htmlspecialchars($result->BrandName) . "</option>";
                                        }
                                        ?>
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
                                    <input type="number" step="0.01" name="priceperday" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Select Fuel Type</label>
                                    <select class="form-select" name="fueltype" required>
                                        <option value="">Select</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Electric">Electric</option>
                                        <option value="Hybrid">Hybrid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Model Year</label>
                                    <input type="number" name="modelyear" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Seating Capacity</label>
                                    <input type="number" name="seatingcapacity" class="form-control" required>
                                </div>
                            </div>

                            <h4 class="mb-4">Upload Images</h4>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label required">Image 1</label>
                                    <input type="file" name="img1" class="form-control" accept="image/jpeg,image/png,image/webp" required>
                                    <div class="form-text">Max 10 MB. Allowed: jpg, png, webp.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Image 2</label>
                                    <input type="file" name="img2" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    <div class="form-text">Max 10 MB. Allowed: jpg, png, webp.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Image 3</label>
                                    <input type="file" name="img3" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    <div class="form-text">Max 10 MB. Allowed: jpg, png, webp.</div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Image 4</label>
                                    <input type="file" name="img4" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    <div class="form-text">Max 10 MB. Allowed: jpg, png, webp.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Image 5</label>
                                    <input type="file" name="img5" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    <div class="form-text">Max 10 MB. Allowed: jpg, png, webp.</div>
                                </div>
                            </div>

                            <h4 class="mb-4">Accessories</h4>
                            <div class="row g-3 mb-3">
                                <?php
                                $accessories = [
                                    'airconditioner' => 'Air Conditioner',
                                    'powerdoorlocks' => 'Power Door Locks',
                                    'antilockbrakingsys' => 'AntiLock Braking System',
                                    'brakeassist' => 'Brake Assist',
                                    'powersteering' => 'Power Steering',
                                    'driverairbag' => 'Driver Airbag',
                                    'passengerairbag' => 'Passenger Airbag',
                                    'powerwindow' => 'Power Windows',
                                    'cdplayer' => 'CD Player',
                                    'centrallocking' => 'Central Locking',
                                    'crashsensor' => 'Crash Sensor',
                                    'leatherseats' => 'Leather Seats'
                                ];
                                $counter = 0;
                                foreach ($accessories as $name => $label) {
                                    if ($counter % 4 === 0 && $counter > 0) {
                                        echo '</div><div class="row g-3 mb-3">';
                                    }
                                    ?>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" class="form-check-input">
                                            <label for="<?php echo $name; ?>" class="form-check-label"><?php echo $label; ?></label>
                                        </div>
                                    </div>
                                    <?php
                                    $counter++;
                                }
                                ?>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>