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
                header("Location: ../index.php");
                
                exit();
            } elseif ($row["status"] === "adm") {
                // Code for admin status
                $_SESSION["adm"] = $row["user_id"];
                header("Location: ../index.php");
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background-color: #DEDEDE;
        }
    </style>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>
    <div class="container">
        <form action="" method="post">
            <label>
                Email:
                <input type="email" name="email" class="form-control">
                <span><?= $emailError ?></span>
            </label>
            <label>
                Password:
                <input type="password" name="password" class="form-control">
                <span><?= $passError ?></span>
            </label>
            <input type="submit" value="Login" name="login" class="btn btn-primary mt-3 d-flex">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
