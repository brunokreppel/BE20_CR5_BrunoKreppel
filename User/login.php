<?php
session_start();

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    header("Location: ../index.php");
}

require_once '../components/db_Connect.php';
require_once '../components/clean.php';
$emailError = "";
$passError = "";

if (isset($_POST["login"])) {
    $email = cleanInputs($_POST["email"]);
    $pass = cleanInputs($_POST["password"]);
    $error = false; // Initialize error variable

    if (empty($email)) {
        $error = true;
        $emailError = "Email can not be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "This is not an Email";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Password can not be empty.";
    }

    if (!$error) {
        $pass = hash("sha256", $pass);

        $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row["status"] === "user") {
                // Code for user status
                $_SESSION["user"] = $row["user_id"];
                header("Location: profile.php"); 
                exit();
            } elseif ($row["status"] === "adm") {
                // Code for admin status
                $_SESSION["adm"] = $row["user_id"];
                header("Location: profile.php"); 
                exit();
            }
        } else {
            echo "
            <div class='alert alert-danger' role='alert'>
                Invalid email or password!
            </div>
            ";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/stylesheet.css">
    <style>
        .container1 {
            margin: auto;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>
    <?php require_once '../components/hero.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="container container1">
                    <h1 class="fw-bold text-center my-5 display-3">Login <img width="64" height="64" src="https://img.icons8.com/color/64/dog-paw-print.png" alt="dog-paw-print" /></h1>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <span class="text-danger"><?= $emailError ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="text-danger"><?= $passError ?></span>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="login" class="btn btn-primary mt-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
