<?php
session_start();
error_reporting(E_ALL); // Enable error reporting for debugging
ini_set('display_errors', 1); // Display errors on screen for debugging
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit();
}

// Generate CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$msg = '';
$error = '';

// Handle booking actions (confirm, cancel, delete)
if (isset($_REQUEST['aeid'])) {
    $aeid = intval($_GET['aeid']);
    $status = 1; // Confirmed
    $csrf_token = $_GET['csrf_token'] ?? '';
    if ($csrf_token !== $_SESSION['csrf_token']) {
        $error = "Invalid CSRF token.";
    } else {
        $sql = "UPDATE tblbooking SET Status = :status WHERE id = :aeid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_INT);
        if ($query->execute() && $query->rowCount() > 0) {
            $msg = "Booking Successfully Confirmed";
        } else {
            $error = "Failed to confirm booking: " . implode(", ", $query->errorInfo());
        }
    }
}

if (isset($_REQUEST['eid'])) {
    $eid = intval($_GET['eid']);
    $status = 2; // Cancelled
    $csrf_token = $_GET['csrf_token'] ?? '';
    if ($csrf_token !== $_SESSION['csrf_token']) {
        $error = "Invalid CSRF token.";
    } else {
        $sql = "UPDATE tblbooking SET Status = :status WHERE id = :eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':eid', $eid, PDO::PARAM_INT);
        if ($query->execute() && $query->rowCount() > 0) {
            $msg = "Booking Successfully Cancelled";
        } else {
            $error = "Failed to cancel booking: " . implode(", ", $query->errorInfo());
        }
    }
}

if (isset($_REQUEST['del'])) {
    $delid = intval($_GET['del']);
    $csrf_token = $_GET['csrf_token'] ?? '';
    if ($csrf_token !== $_SESSION['csrf_token']) {
        $error = "Invalid CSRF token.";
    } else {
        $sql = "DELETE FROM tblbooking WHERE id = :delid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':delid', $delid, PDO::PARAM_INT);
        if ($query->execute() && $query->rowCount() > 0) {
            $msg = "Booking Successfully Deleted";
        } else {
            $error = "Failed to delete booking: " . implode(", ", $query->errorInfo());
        }
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
    <title>Car Rental Portal | Admin Manage Bookings</title>
    <?php include("includes/head.php"); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="page-wrapper d-flex">
        <div class="container p-3 mt-4">
            <div class="container-fluid">
                <div class="page-body">
                    <div class="container">
                        <div class="page-header mt-5 m-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="page-pretitle">Overview</div>
                                    <h2 class="page-title">Booking Management</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Bookings Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($error) { ?>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <?php echo htmlentities($error); ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php } elseif ($msg) { ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <?php echo htmlentities($msg); ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php } ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Vehicle</th>
                                                        <th>From Date</th>
                                                        <th>To Date</th>
                                                        <th>Message</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Check database connection
                                                    if (!$dbh) {
                                                        echo "<tr><td colspan='9' class='text-center text-danger'>Database connection failed.</td></tr>";
                                                        exit();
                                                    }

                                                    $sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.created_at, tblbooking.id 
                                                            FROM tblbooking 
                                                            LEFT JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId 
                                                            LEFT JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail 
                                                            LEFT JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id";
                                                    try {
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;

                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <tr>
                                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                                    <td><?php echo htmlentities($result->FullName ?? 'N/A'); ?></td>
                                                                    <td>
                                                                        <?php if ($result->VehiclesTitle && $result->BrandName) { ?>
                                                                            <a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid); ?>"
                                                                                title="Edit Vehicle"><?php echo htmlentities($result->BrandName); ?>,
                                                                                <?php echo htmlentities($result->VehiclesTitle); ?></a>
                                                                        <?php } else { ?>
                                                                            N/A
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td><?php echo htmlentities($result->FromDate); ?></td>
                                                                    <td><?php echo htmlentities($result->ToDate); ?></td>
                                                                    <td><?php echo htmlentities($result->message); ?></td>
                                                                    <td>
                                                                        <?php
                                                                        switch ($result->Status) {
                                                                            case 0:
                                                                                echo '<span class="badge bg-warning">Not Confirmed</span>';
                                                                                break;
                                                                            case 1:
                                                                                echo '<span class="badge bg-success">Confirmed</span>';
                                                                                break;
                                                                            case 2:
                                                                                echo '<span class="badge bg-danger">Cancelled</span>';
                                                                                break;
                                                                            default:
                                                                                echo '<span class="badge bg-secondary">Unknown</span>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo htmlentities($result->created_at); ?></td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">
                                                                            <?php if ($result->Status != 1) { ?>
                                                                                <a href="manage-bookings.php?aeid=<?php echo htmlentities($result->id); ?>&csrf_token=<?php echo htmlentities($_SESSION['csrf_token']); ?>"
                                                                                    class="btn btn-success me-1" title="Confirm Booking"
                                                                                    onclick="return confirm('Are you sure you want to confirm this booking?');">
                                                                                    Confirm
                                                                                </a>
                                                                            <?php } ?>
                                                                            <?php if ($result->Status != 2) { ?>
                                                                                <a href="manage-bookings.php?eid=<?php echo htmlentities($result->id); ?>&csrf_token=<?php echo htmlentities($_SESSION['csrf_token']); ?>"
                                                                                    class="btn btn-warning me-1" title="Cancel Booking"
                                                                                    onclick="return confirm('Are you sure you want to cancel this booking?');">
                                                                                    Cancel
                                                                                </a>
                                                                            <?php } ?>
                                                                            <a href="manage-bookings.php?del=<?php echo htmlentities($result->id); ?>&csrf_token=<?php echo htmlentities($_SESSION['csrf_token']); ?>"
                                                                                class="btn btn-danger" title="Delete Booking"
                                                                                onclick="return confirm('Are you sure you want to delete this booking?');">
                                                                                Delete
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php $cnt++;
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='9' class='text-center'>No bookings found.</td></tr>";
                                                        }
                                                    } catch (PDOException $e) {
                                                        echo "<tr><td colspan='9' class='text-center text-danger'>Query failed: " . htmlentities($e->getMessage()) . "</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <%/div>
        </div>
    </div>
</body>

</html>
<?php
// Log query results for debugging
file_put_contents('debug.log', "Query executed: " . $sql . "\nRow count: " . ($query->rowCount() ?? 'N/A') . "\n", FILE_APPEND);
?>