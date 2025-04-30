<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
}
// Initialize message
$msg = '';

if (isset($_POST['submit']) && $_POST['submit'] === "Update") {
    $pagetype = $_POST['menu1'];
    $pagename = $_POST['pagename'];
    $pagedetails = $_POST['pgedetails'];

    if (empty($pagetype) || empty($pagedetails)) {
        $msg = "Please select a page type and provide details.";
    } else {
        try {
            // Check if page exists
            $sql_check = "SELECT id FROM tblpages WHERE type = :pagetype";
            $query_check = $dbh->prepare($sql_check);
            $query_check->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
            $query_check->execute();

            if ($query_check->rowCount() > 0) {
                // Update existing page
                $sql = "UPDATE tblpages SET PageName = :pagename, detail = :pagedetails WHERE type = :pagetype";
                $query = $dbh->prepare($sql);
                $query->bindParam(':pagename', $pagename, PDO::PARAM_STR);
                $query->bindParam(':pagedetails', $pagedetails, PDO::PARAM_STR);
                $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
                $query->execute();
                $msg = "Page '$pagetype' updated successfully.";
            } else {
                // Insert new page
                $sql = "INSERT INTO tblpages (PageName, type, detail) VALUES (:pagename, :pagetype, :pagedetails)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':pagename', $pagename, PDO::PARAM_STR);
                $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
                $query->bindParam(':pagedetails', $pagedetails, PDO::PARAM_STR);
                $query->execute();
                $msg = "Page '$pagetype' created successfully.";
            }
        } catch (PDOException $e) {
            $msg = "Database error: " . $e->getMessage();
        }
    }
}

$sql_types = "SELECT type, PageName FROM tblpages";
$query_types = $dbh->prepare($sql_types);
$query_types->execute();
$page_types = $query_types->fetchAll(PDO::FETCH_OBJ);


$predefined_pages = [
    'terms' => 'Terms and Conditions',
    'privacy' => 'Privacy and Policy',
    'aboutus' => 'About Us',
    'faqs' => 'FAQs'
];

$dropdown_options = [];
foreach ($page_types as $page) {
    $dropdown_options[$page->type] = $page->PageName ?: $page->type;
}
foreach ($predefined_pages as $type => $name) {
    if (!isset($dropdown_options[$type])) {
        $dropdown_options[$type] = $name;
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
    <title>Car Rental Portal | Admin Manage Pages</title>
    <?php include("includes/head.php"); ?>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/7teypp3yuja3sddii2s7f6fleb0mtlwp2322pqigkabydlxs/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#tiny',
            plugins: [
                'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +
                'bullist numlist checklist outdent indent | removeformat | code table help',
            setup: function(editor) {
                editor.on('Submit', function() {
                    editor.save();
                });
            }
        });
    </script>
</head>

<body class="fluid-body">
    <div class="page-wrapper d-flex">
        <div class="container p-6 mt-5">
            <div class="container-fluid">
                <h2 class="mb-4">Manage Pages</h2>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Page Details</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($msg) { ?>
                                    <div class="alert alert-<?php echo strpos($msg, 'successfully') !== false ? 'success' : 'danger'; ?> alert-dismissible fade show col-6" role="alert">
                                        <?php echo htmlentities($msg); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php } ?>
                                <form method="post" onsubmit="tinymce.triggerSave();">
                                    <div class="mb-3">
                                        <label for="menu1" class="form-label">Select or Create Page</label>
                                        <select id="menu1" name="menu1" class="form-select" onchange="window.location.href='manage-pages.php?type=' + this.value" required>
                                            <option value="">Select One</option>
                                            <?php foreach ($dropdown_options as $type => $name) { ?>
                                                <option value="<?php echo htmlentities($type); ?>" <?php echo isset($_GET['type']) && $_GET['type'] == $type ? 'selected' : ''; ?>>
                                                    <?php echo htmlentities($name); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pagename" class="form-label">Page Display Name</label>
                                        <input type="text" id="pagename" name="pagename" class="form-control" value="<?php
                                                                                                                        $pagetype = isset($_GET['type']) ? $_GET['type'] : '';
                                                                                                                        if ($pagetype) {
                                                                                                                            $sql = "SELECT PageName FROM tblpages WHERE type = :pagetype";
                                                                                                                            $query = $dbh->prepare($sql);
                                                                                                                            $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
                                                                                                                            $query->execute();
                                                                                                                            $result = $query->fetch(PDO::FETCH_OBJ);
                                                                                                                            echo htmlentities($result ? $result->PageName : ($predefined_pages[$pagetype] ?? ucfirst($pagetype)));
                                                                                                                        }
                                                                                                                        ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Selected Page</label>
                                        <p class="text-muted">
                                            <?php
                                            if ($pagetype) {
                                                echo htmlentities($dropdown_options[$pagetype] ?? ucfirst($pagetype));
                                            } else {
                                                echo "No page selected";
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pgedetails" class="form-label">Page Details</label>
                                        <textarea id="tiny" name="pgedetails" class="form-control" rows="8" required>
                                            <?php
                                            if ($pagetype) {
                                                $sql = "SELECT detail FROM tblpages WHERE type = :pagetype";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                        echo htmlentities($result->detail);
                                                    }
                                                }
                                            }
                                            ?>
                                        </textarea>
                                    </div>
                                    <button type="submit" name="submit" value="Update" class="btn btn-primary col-6" style="border-radius:3px">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>