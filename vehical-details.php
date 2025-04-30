<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
        echo "<script>alert('Please log in to book a vehicle.');</script>";
        echo "<script>document.location = 'vehical-details.php?vhid=" . intval($_GET['vhid']) . "';</script>";
        exit;
    }

    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
    $useremail = $_SESSION['login'];
    $status = 0;
    $vhid = intval($_GET['vhid']);
    $today = date('Y-m-d');

    error_log("Booking attempt by user: $useremail");

    if (strtotime($fromdate) < strtotime($today)) {
        echo "<script>alert('From date cannot be in the past.');</script>";
        echo "<script>document.location = 'vehical-details.php?vhid=$vhid';</script>";
        exit;
    }
    if (strtotime($todate) <= strtotime($fromdate)) {
        echo "<script>alert('To date must be after from date.');</script>";
        echo "<script>document.location = 'vehical-details.php?vhid=$vhid';</script>";
        exit;
    }

    try {
        do {
            $bookingno = sprintf("%09d", mt_rand(0, 999999999)); // Ensure 9 digits
            $sql_check = "SELECT BookingNumber FROM tblbooking WHERE BookingNumber = :bookingno";
            $query_check = $dbh->prepare($sql_check);
            $query_check->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
            $query_check->execute();
        } while ($query_check->rowCount() > 0);

        // Check for overlapping bookings
        $ret = "SELECT * FROM tblbooking WHERE VehicleId = :vhid AND (
            (:fromdate BETWEEN FromDate AND ToDate) OR 
            (:todate BETWEEN FromDate AND ToDate) OR 
            (FromDate BETWEEN :fromdate AND :todate)
        )";
        $query1 = $dbh->prepare($ret);
        $query1->bindParam(':vhid', $vhid, PDO::PARAM_INT);
        $query1->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query1->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query1->execute();

        if ($query1->rowCount() == 0) {
            $sql = "INSERT INTO tblbooking(BookingNumber, userEmail, VehicleId, FromDate, ToDate, message, Status) 
                    VALUES(:bookingno, :useremail, :vhid, :fromdate, :todate, :message, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
            $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
            $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
            $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
            $query->bindParam(':todate', $todate, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_INT);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                echo "<script>alert('Booking successful.');</script>";
                echo "<script>document.location = 'my-booking.php';</script>";
            } else {
                error_log("Booking insertion failed for VehicleId: $vhid, User: $useremail");
                echo "<script>alert('Something went wrong. Please try again.');</script>";
                echo "<script>document.location = 'vehical-details.php?vhid=$vhid';</script>";
            }
        } else {
            echo "<script>alert('Car already booked for these days.');</script>";
            echo "<script>document.location = 'vehical-details.php?vhid=$vhid';</script>";
        }
    } catch (PDOException $e) {
        error_log("Booking error: " . $e->getMessage());
        echo "<script>alert('Database error: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>document.location = 'vehical-details.php?vhid=$vhid';</script>";
    }
}

$vhid = isset($_GET['vhid']) ? intval($_GET['vhid']) : 0;
if ($vhid <= 0) {
    echo "<script>alert('Invalid vehicle ID.');</script>";
    echo "<script>document.location = 'car-listing.php';</script>";
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Car Rental | Vehicle Details</title>
    <?php include('includes/head.php'); ?>
</head>
<body class="bg-dark">
    <?php include('includes/header.php'); ?>

    <div class="page-header mb-5">
        <div class="container p-5">
            <div class="page-header">
                <div class="page-heading">
                    <h1>Vehicle Details</h1>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vehicle Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php
    $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid 
            FROM tblvehicles 
            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
            WHERE tblvehicles.id = :vhid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['brndid'] = $result->bid;
            $images = [
                ['src' => $result->Vimage1, 'alt' => 'Vehicle Image 1'],
                ['src' => $result->Vimage2, 'alt' => 'Vehicle Image 2'],
                ['src' => $result->Vimage3, 'alt' => 'Vehicle Image 3'],
                ['src' => $result->Vimage4, 'alt' => 'Vehicle Image 4'],
            ];
            if (!empty($result->Vimage5)) {
                $images[] = ['src' => $result->Vimage5, 'alt' => 'Vehicle Image 5'];
            }
    ?>
        <section id="vehicle-carousel" class="mb-5">
            <div class="container">
                <div class="row">
                    <!-- Carousel -->
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div id="vehicleCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <ol class="carousel-indicators carousel-indicators-thumb">
                                <?php foreach ($images as $index => $image) { ?>
                                    <li data-bs-target="#vehicleCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>">
                                        <?php if (!empty($image['src'])) { ?>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($image['src']); ?>" alt="<?php echo htmlentities($image['alt']); ?>" class="img-fluid">
                                        <?php } else { ?>
                                            <img src="img/placeholder.jpg" alt="<?php echo htmlentities($image['alt']); ?>" class="img-fluid">
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php foreach ($images as $index => $image) { ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                        <?php if (!empty($image['src'])) { ?>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($image['src']); ?>" class="d-block w-100 img-fluid" alt="<?php echo htmlentities($image['alt']); ?>">
                                        <?php } else { ?>
                                            <img src="img/placeholder.jpg" class="d-block w-100 img-fluid" alt="<?php echo htmlentities($image['alt']); ?>">
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#vehicleCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#vehicleCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <!-- Listing Detail -->
                    <div class="col-md-6 listing-detail">
                        <div class="card p-4" style="background: rgba(0, 0, 0, 0.25); backdrop-filter: blur(10px); border: none;">
                            <div class="listing_detail_head d-flex flex-wrap align-items-center mb-4">
                                <div class="me-auto">
                                    <div class="page-pretitle text-muted"><?php echo htmlentities($result->BrandName); ?></div>
                                    <h2 class="page-title"><?php echo htmlentities($result->VehiclesTitle); ?></h2>
                                </div>
                                <div class="price_info text-end">
                                    <p class="text-danger fs-3 mb-0">KES <?php echo number_format($result->PricePerDay, 2); ?></p>
                                    <p class="page-pretitle text-muted">Per Day</p>
                                </div>
                            </div>
                            <div class="main_features mb-4">
                                <div class="row g-3">
                                    <div class="col-4 text-center text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                            <path d="M18 14v4h4" />
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M15 3v4" />
                                            <path d="M7 3v4" />
                                            <path d="M3 11h16" />
                                        </svg>
                                        <h5 class="mt-2"><?php echo htmlentities($result->ModelYear); ?></h5>
                                        <p class="text-muted">Reg. Year</p>
                                    </div>
                                    <div class="col-4 text-center text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-gas-station">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 11h1a2 2 0 0 1 2 2v3a1.5 1.5 0 0 0 3 0v-7l-3 -3" />
                                            <path d="M4 20v-14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v14" />
                                            <path d="M3 20l12 0" />
                                            <path d="M18 7v1a1 1 0 0 0 1 1h1" />
                                            <path d="M4 11l10 0" />
                                        </svg>
                                        <h5 class="mt-2"><?php echo htmlentities($result->FuelType); ?></h5>
                                        <p class="text-muted">Fuel Type</p>
                                    </div>
                                    <div class="col-4 text-center text-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-armchair">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 11a2 2 0 0 1 2 2v2h10v-2a2 2 0 1 1 4 0v4a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-4a2 2 0 1 1 2 -2z" />
                                            <path d="M5 11v-5a3 3 0 0 1 3 -3h8a3 3 0 0 1 3 3v5" />
                                            <path d="M6 19v2" />
                                            <path d="M18 19v2" />
                                        </svg>
                                        <h5 class="mt-2"><?php echo str_pad($result->SeatingCapacity, 2, '0', STR_PAD_LEFT); ?></h5>
                                        <p class="text-muted">Seats</p>
                                    </div>
                                </div>
                            </div>
                            <div class="listing_more_info">
                                <ul class="nav nav-tabs border-0 mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#vehicle-overview" role="tab" data-bs-toggle="tab">Vehicle Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#accessories" role="tab" data-bs-toggle="tab">Accessories</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                                        <p><?php echo htmlentities($result->VehiclesOverview); ?></p>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="accessories">
                                        <table class="table table-dark table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Accessory</th>
                                                    <th>Available</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $accessories = [
                                                    'Air Conditioner' => $result->AirConditioner,
                                                    'AntiLock Braking System' => $result->AntiLockBrakingSystem,
                                                    'Power Steering' => $result->PowerSteering,
                                                    'Power Windows' => $result->PowerWindows,
                                                    'CD Player' => $result->CDPlayer,
                                                    'Leather Seats' => $result->LeatherSeats,
                                                    'Central Locking' => $result->CentralLocking,
                                                    'Power Door Locks' => $result->PowerDoorLocks,
                                                    'Brake Assist' => $result->BrakeAssist,
                                                    'Driver Airbag' => $result->DriverAirbag,
                                                    'Passenger Airbag' => $result->PassengerAirbag,
                                                    'Crash Sensor' => $result->CrashSensor,
                                                ];
                                                foreach ($accessories as $name => $value) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $name; ?></td>
                                                        <td><i class="fa fa-<?php echo $value == 1 ? 'check' : 'close'; ?>" aria-hidden="true"></i></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="share_vehicle my-4">
                                <p class="text-white mb-2">Share with:</p>
                                <a href="#" class="text-danger me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                    </svg>
                                </a>
                                <a href="#" class="text-danger me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M16.5 7.5v.01" />
                                    </svg>
                                </a>
                                <a href="#" class="text-danger me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-threads">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19 7.5c-1.333 -3 -3.667 -4.5 -7 -4.5c-5 0 -8 2.5 -8 9s3.5 9 8 9s7 -3 7 -5s-1 -5 -7 -5c-2.5 0 -3 1.25 -3 2.5c0 1.5 1 2.5 2.5 2.5c2.5 0 3.5 -1.5 3.5 -5s-2 -4 -3 -4s-1.833 .333 -2.5 1" />
                                    </svg>
                                </a>
                                <a href="#" class="text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                                    </svg>
                                </a>
                            </div>
                            <div class="sidebar_widget">
                                <h5 class="mb-3">Book Now</h5>
                                <form method="post" onsubmit="return validateDates()">
                                    <div class="mb-3">
                                        <label class="form-label">From Date:</label>
                                        <input type="date" class="form-control bg-dark text-white border-0" name="fromdate" id="fromdate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">To Date:</label>
                                        <input type="date" class="form-control bg-dark text-white border-0" name="todate" id="todate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Reason:</label>
                                        <select class="form-select bg-dark text-white border-0" name="message" required>
                                            <option value="" disabled selected>Select booking reason</option>
                                            <option value="Function/Ceremony">Function/Ceremony</option>
                                            <option value="Business Trip">Business Trip</option>
                                            <option value="Personal Use">Personal Use</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <?php if (isset($_SESSION['login']) && !empty($_SESSION['login'])) { ?>
                                        <button type="submit" name="submit" class="btn btn-primary w-100">Book Now</button>
                                    <?php } else { ?>
                                        <a href="#loginform" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal">Login to Book</a>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <div class="similar_cars mt-5">
                            <h3 class="mb-4">Similar Cars</h3>
                            <div class="row g-3">
                                <?php
                                $bid = $_SESSION['brndid'];
                                $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 
                                        FROM tblvehicles 
                                        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                                        WHERE tblvehicles.VehiclesBrand = :bid AND tblvehicles.id != :vhid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':bid', $bid, PDO::PARAM_INT);
                                $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>
                                        <div class="col-md-6">
                                            <div class="card product-listing-m">
                                                <div class="product-listing-img">
                                                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                                                        <?php if (!empty($result->Vimage1)) { ?>
                                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($result->Vimage1); ?>" class="img-fluid" alt="<?php echo htmlentities($result->VehiclesTitle); ?>">
                                                        <?php } else { ?>
                                                            <img src="img/placeholder.jpg" class="img-fluid" alt="No image available">
                                                        <?php } ?>
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="text-white"><?php echo htmlentities($result->BrandName); ?> <?php echo htmlentities($result->VehiclesTitle); ?></a></h5>
                                                    <p class="list-price text-danger mb-2">KES <?php echo number_format($result->PricePerDay, 2); ?></p>
                                                    <ul class="features_list list-unstyled d-flex flex-wrap gap-2">
                                                        <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
                                                        <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlentities($result->ModelYear); ?> model</li>
                                                        <li><i class="fa fa-car" aria-hidden="true"></i> <?php echo htmlentities($result->FuelType); ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } else { ?>
                                    <p class="text-muted">No similar cars found.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            function validateDates() {
                const fromDate = document.getElementById('fromdate').value;
                const toDate = document.getElementById('todate').value;
                const today = new Date().toISOString().split('T')[0];

                if (fromDate < today) {
                    alert('From date cannot be in the past.');
                    return false;
                }
                if (toDate <= fromDate) {
                    alert('To date must be after from date.');
                    return false;
                }
                return true;
            }
        </script>

        <style>
            .carousel-indicators-thumb {
                bottom: -60px;
            }
            .carousel-indicators-thumb li {
                width: 80px;
                height: 50px;
                margin: 0 5px;
                border: 2px solid #fff;
                border-radius: 5px;
                overflow: hidden;
                opacity: 0.7;
                transition: opacity 0.3s ease, border-color 0.3s ease;
            }
            .carousel-indicators-thumb li.active {
                opacity: 1;
                border-color: #dc3545;
            }
            .carousel-indicators-thumb li img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .carousel-item img {
                height: 450px;
                object-fit: cover;
            }
            .carousel-control-prev,
            .carousel-control-next {
                width: 5%;
                background: rgba(0, 0, 0, 0.3);
            }
            .listing-detail .card {
                background: rgba(0, 0, 0, 0.25);
                backdrop-filter: blur(10px);
                border: none;
            }
            .listing-detail .nav-link {
                color: #fff;
                border: none;
                border-bottom: 2px solid transparent;
            }
            .listing-detail .nav-link.active {
                border-bottom: 2px solid #dc3545;
                background: none;
            }
            .listing-detail .form-control,
            .listing-detail .form-select {
                background: rgba(255, 255, 255, 0.1);
                border: none;
                color: #fff;
            }
            .listing-detail .form-control:focus,
            .listing-detail .form-select:focus {
                box-shadow: none;
                border-color: #dc3545;
            }
            .listing-detail .btn-primary {
                background: #dc3545;
                border: none;
            }
            .listing-detail .btn-outline-primary {
                border-color: #dc3545;
                color: #dc3545;
            }
            .listing-detail .btn-outline-primary:hover {
                background: #dc3545;
                color: #fff;
            }
            .similar_cars .card {
                background: rgba(255, 255, 255, 0.05);
            }
            .similar_cars .card img {
                height: 150px;
                object-fit: cover;
                border-radius: 10px 10px 0 0;
            }
        </style>
    <?php
        }
    } else {
        echo "<div class='container col-3'><p class='text-danger'>Vehicle not found.</p></div>";
    }
    ?>

    <?php include('includes/footer.php'); ?>
</body>
</html>