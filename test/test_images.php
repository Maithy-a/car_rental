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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css">
    <style>
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
    </style>
    <!-- <style>
        .card {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 0px;
        }

        .card-body {
            padding: 2.5rem;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }



        .img-thumbnail {
            max-width: 100%;
            height: auto;
            border-radius: 0px;
        }

        .image-container {
            text-align: center;
            border-radius: 0px;
        }

        .text-muted {
            color: #6c757d !important;
            margin-bottom: 0.5rem;
        }

        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        p{
            border-radius: 0px;
        }
    </style> -->
</head>

<body data-bs-theme="dark">
    <div class="container">
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
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h3 class='card-title'>" . htmlentities($result->VehiclesTitle) . " (ID: " . htmlentities($result->id) . ")</h3>";

                echo "<div class='image-gallery'>";
                $imageFields = ['Vimage1', 'Vimage2', 'Vimage3', 'Vimage4', 'Vimage5'];
                foreach ($imageFields as $index => $field) {
                    $imageData = $result->$field;
                    echo "<div class='image-container'>";
                    echo "<p class='text-muted'>Image " . ($index + 1) . ": " . ($imageData ? "Data exists (" . strlen($imageData) . " bytes)" : "Not set") . "</p>";

                    if (!empty($imageData)) {
                        echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Image " . ($index + 1) . "' class='img-thumbnail'>";
                    }
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>No vehicles found in the database.</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/js/tabler.min.js"></script>
</body>

</html>