<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Vehicle Images</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .vehicle { margin-bottom: 20px; border: 1px solid #ccc; padding: 10px; }
        img { max-width: 200px; height: auto; margin: 10px 0; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Test Vehicle Images</h2>
    <?php
    $sql = "SELECT id, VehiclesTitle, Vimage1, Vimage2, Vimage3, Vimage4, Vimage5 
            FROM tblvehicles 
            LIMIT 5";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            echo "<div class='vehicle'>";
            echo "<h3>" . htmlentities($result->VehiclesTitle) . " (ID: " . htmlentities($result->id) . ")</h3>";

            $imageFields = ['Vimage1', 'Vimage2', 'Vimage3', 'Vimage4', 'Vimage5'];
            foreach ($imageFields as $index => $field) {
                $imageData = $result->$field;
                echo "<p>Image " . ($index + 1) . ": " . ($imageData ? "Data exists (" . strlen($imageData) . " bytes)" : "Not set") . "</p>";

                if (!empty($imageData)) {
                    echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Image " . ($index + 1) . "'>";
                }
            }
            echo "</div>";
        }
    } else {
        echo "<p class='error'>No vehicles found in the database.</p>";
    }
    ?>
</body>
</html>