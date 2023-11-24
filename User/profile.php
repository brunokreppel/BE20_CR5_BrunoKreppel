<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    exit();
}

require_once '../components/db_Connect.php';

// Assuming you have a table named 'user' with columns 'user_id', 'first_name', 'last_name', 'email', 'picture_url', etc.
$user_id = $_SESSION["user"] ?? $_SESSION["adm"];
$sql = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error, user not found
    echo "User not found!";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/stylesheet.css">
    <style>
        body {
            font-family: 'Bai Jamjuree', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            padding-top: 20px;
        }
        h1, h2 {
            color: #e74c3c;
        }
        .profile-img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-section {
            background-color: #fff;
            margin-top: 70px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h1 class="fw-bold text-center mb-4">Welcome, <?= $user["first_name"] ?></h1>
                <img src="../assets/<?= $user['picture_url'] ?>" alt="Profile Image" class="profile-img">
            </div>
            <div class="col-md-8">
                <div class="profile-section">
                    <h2 class="mb-3">Profile Information</h2>
                    <ul>
                        <li><strong>First Name:</strong> <?= $user["first_name"] ?></li>
                        <li><strong>Last Name:</strong> <?= $user["last_name"] ?></li>
                        <li><strong>Email:</strong> <?= $user["email"] ?></li>
                        <!-- Add more user information as needed -->
                    </ul>

                    <h2 class="mt-4 mb-3">Update Profile / Logout</h2>
                    <!-- Add an update form here with fields for updating user information -->

                    <a href="/php/BE20_CR5_BrunoKreppel/user/update.php" class="btn btn-primary">Update Profile</a>
                    <a href="/php/BE20_CR5_BrunoKreppel/user/logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>

    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
