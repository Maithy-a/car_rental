<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/config.php';

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

$message = '';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Invalid CSRF token.";

        error_log("CSRF Token Mismatch: Submitted: " . ($_POST['csrf_token'] ?? 'none') . ", Expected: " . $_SESSION['csrf_token']);
    } else {
        // Sanitize inputs
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_UNSAFE_RAW));
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $message = "Please enter both username and password.";
        } else {
            try {
                $sql = "SELECT UserName, Password FROM admin WHERE UserName = :username";
                $query = $dbh->prepare($sql);
                $query->bindParam(':username', $username, PDO::PARAM_STR);
                $query->execute();
                $admin = $query->fetch(PDO::FETCH_ASSOC);

                if ($admin && password_verify($password, $admin['Password'])) {
                    $_SESSION['alogin'] = $admin['UserName'];
                    session_regenerate_id(true);
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $message = "Invalid username or password.";
                }
            } catch (PDOException $e) {
                $message = "Database error. Please try again later.";
                error_log("Database error: " . $e->getMessage());
            }
        }
    }
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $csrf_token = $_SESSION['csrf_token'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Car Rental Portal | Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/css/tabler.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.2.0/dist/js/tabler.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="img/favicon_io/site.webmanifest">
    <style>
        body {
            background: url('img/bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .form-control {
            padding: 10px 40px;
            border: 1px solid #ced4da;
            box-shadow: none;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .card {
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card border-0" style="width: 400px;">
            <div class="card-body p-4">
                <div class="text-center">
                    <h1 class="mb-3">ADMIN</h1>
                </div>
                <p class="text-muted text-center mb-3">Welcome back! Please enter your details.</p>
                <?php if ($message): ?>
                    <div class="alert alert-danger alert-dismissible text-center" style="border-left:2px solid red;">
                        <div class="alert-icon">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon alert-icon icon-2">
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 8v4" />
                                <path d="M12 16h.01" />
                            </svg>
                        </div>
                        <?php echo htmlspecialchars($message); ?>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                <?php endif; ?>
                <form class="form" id="login-form" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                    <div class="input-icon mb-4">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </span>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required autocomplete="off" />
                    </div>
                    <div class="input-icon mb-4">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock-password">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                <path d="M15 16h.01" />
                                <path d="M12.01 16h.01" />
                                <path d="M9.02 16h.01" />
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required />
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="../index.php" class="text-decoration-none">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('login-form').reset();
        });
    </script>
</body>

</html>