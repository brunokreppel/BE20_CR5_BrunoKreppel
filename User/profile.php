<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    exit();
}

require_once '../components/db_Connect.php';

// Assuming you have a table named 'user' with columns 'user_id', 'name', 'email', 'img', etc.
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
    body{
      font-family: var(--font);
      background-color: var(--primary-color);
      color: var(--text-color);
    }
  </style>
</head>

<?php require_once '../components/navbar.php'; ?>


<body>
    <h1>Welcome, <?= $user["first_name"] ?></h1>
    <img src="../assets/<?= $user['picture_url'] ?>" alt="Profile Image" width="250px" height="250px">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
