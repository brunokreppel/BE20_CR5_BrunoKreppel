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
    <link rel="stylesheet" href="/php/BE20_CR5_BrunoKreppel/style/stylesheet.css">
    <style>
        body {
            font-family: var(--font);
            background-color: var(--primary-color);
            color: var(--text-color);
        }
        h2 {
            color: var(--accent-color);
        }
        .profile-img {
            max-width: 100%;
            height: 523px; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }
        .profile-section {
            background-color: #fff;
            height: 523px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            min-height: 300px; /* Adjusted min-height for smaller screens */
        }
    </style>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <div class="row">
        <h1 class="fw-bold mb-5 text-start">Welcome, <?= $user["first_name"] ?>.</h1>
            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12  mb-4">
            
                <img src="../assets/<?= $user['picture_url'] ?>" alt="Profile Image" class="profile-img">
            </div>
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12  position-relative">
                
                <div class="profile-section position-relative">
                    
                <div class="pb-5 ">
                       
                       <p><h2>Thank you, <?= $user["first_name"] ?>!</h2></p>
                       <p class="px-3 pt-4"> We're delighted to have you as part of our community. Thank you for being a valued member. Below, you'll find your profile information. If anything needs updating, feel free to use the "Update Profile" button. If you have any questions or concerns, please don't hesitate to reach out. Enjoy your time here!</p>
                       </div>
       
                    <h2 class="mb-3">Profile Information</h2>

                    <ul>

                        <li><strong>First Name:</strong> <?= $user["first_name"] ?></li>
                        <li><strong>Last Name:</strong> <?= $user["last_name"] ?></li>
                        <li><strong>Email:</strong> <?= $user["email"] ?></li>
                        <img style="position: absolute; left: 60%; bottom: 20%;" width="148" height="148" src="https://img.icons8.com/color/148/dog-paw-print.png" alt="dog-paw-print"/>
<!-- Add more user information as needed -->
</ul>

                    <div class="btn-group position-absolute bottom-0 left-0 mb-4">
                        
                        <a href="/php/BE20_CR5_BrunoKreppel/user/update.php" class="btn btn-primary">Update Profile</a>
                        <a href="/php/BE20_CR5_BrunoKreppel/user/logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
