<?php
session_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 1);
include('includes/config.php');

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {
    header('location: index.php');
    exit();
}

$msg = $error = '';

// Validate image number (1 to 5) from query parameter
$imageNumber = isset($_GET['image']) ? intval($_GET['image']) : 0;
if ($imageNumber < 1 || $imageNumber > 5) {
    $error = "Invalid image number. Please select an image between 1 and 5.";
}

$imageField = "Vimage" . $imageNumber; // Dynamically determine the field name (e.g., Vimage1, Vimage2, etc.)

if (!$error && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $vehicleId = intval($_GET['imgid']);

    if (isset($_FILES['vehicleImage']) && $_FILES['vehicleImage']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['vehicleImage'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 10 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            $error = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
        } elseif ($file['size'] > $maxSize) {
            $error = "Image size exceeds the 10MB limit.";
        } else {
            $imageData = file_get_contents($file['tmp_name']);
            if ($imageData === false) {
                $error = "Failed to read uploaded file.";
            } else {
                try {
                    $sql = "UPDATE tblvehicles SET $imageField = :image WHERE id = :vehicleid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':image', $imageData, PDO::PARAM_LOB);
                    $query->bindParam(':vehicleid', $vehicleId, PDO::PARAM_INT);

                    if ($query->execute()) {
                        $msg = "Image $imageNumber updated successfully.";
                    } else {
                        $error = "Database error while updating image.";
                    }
                } catch (PDOException $e) {
                    $error = "Database error: " . $e->getMessage();
                }
            }
        }
    } else {
        $uploadError = $_FILES['vehicleImage']['error'] ?? UPLOAD_ERR_NO_FILE;
        if ($uploadError !== UPLOAD_ERR_NO_FILE) {
            $error = "Upload error code: " . $uploadError;
        } else {
            $error = "No file selected.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Vehicle Image <?php echo $imageNumber; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('includes/head.php'); ?>
    <style>
        .alert-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }
    </style>
</head>

<body class="fluid-body">
    <div class="page-wrapper d-flex">
        <div class="container p-1 mt-2">
            <div class="container-fluid py-4">
                <div class="page-body">
                    <div class="page-header m-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="page-pretitle">Image Update</div>
                                <h2 class="page-title">Image (<?php echo $imageNumber; ?>)</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-6">
                        <div class="card-header">
                            <h4>Update Image <?php echo $imageNumber; ?> for Vehicle ID: <?php echo htmlspecialchars($_GET['imgid']); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible d-flex align-items-start" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="alert-icon icon icon-tabler icon-tabler-alert-triangle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 9v2m0 4v.01"></path>
                                        <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                                    </svg>
                                    <div>
                                        <strong>ERROR</strong>: <?php echo htmlspecialchars($error); ?>
                                    </div>
                                    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            <?php elseif ($msg): ?>
                                <div class="alert alert-success alert-dismissible d-flex align-items-start" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="alert-icon icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                    <div>
                                        <strong>SUCCESS</strong>: <?php echo htmlspecialchars($msg); ?>
                                    </div>
                                    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Current Image <?php echo $imageNumber; ?></label>
                                <?php
                                $vehicleId = intval($_GET['imgid']);
                                $sql = "SELECT $imageField FROM tblvehicles WHERE id = :vehicleid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':vehicleid', $vehicleId, PDO::PARAM_INT);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                        $imageData = $result->$imageField;
                                        if ($imageData) {
                                            echo '<div>';
                                            echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" width="300" height="200" style="border:solid 1px #000">';
                                            echo '</div>';
                                        } else {
                                            echo '<div><p>No image available</p></div>';
                                        }
                                    }
                                } else {
                                    echo '<div><p>Vehicle not found</p></div>';
                                }
                                ?>
                            </div>

                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="vehicleImage" class="form-label">Select New Image <?php echo $imageNumber; ?></label>
                                    <input type="file" name="vehicleImage" id="vehicleImage" class="form-control mb-2" accept="image/jpeg,image/png,image/webp" required>
                                    <div class="form-text">Max 10MB. Allowed: jpg, png, webp.</div>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary">Update Image</button>
                                <a href="manage-vehicles.php" class="btn btn-secondary">Back to Vehicles</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>