<?php
session_start();

if (!isset($_SESSION["adm"])) {
    header("Location: ../index.php");
    exit(); // Ensure the script stops execution after redirect
}

require_once '../components/db_Connect.php';
require_once '../components/navbar.php';

$data = "";

$sql = "SELECT * FROM `user` WHERE `status` != 'adm'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= "
            <tr>
                <th scope='row'>{$row['user_id']}</th>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['address']}</td>
                <td>{$row['phone_number']}</td>
                <td>{$row['email']}</td>
                <td>
                <img src='../assets/" . ($row['picture_url'] ? $row['picture_url'] : 'avatar.png') . "' alt='User Picture' class='img-fluid rounded-circle pl-3' style='width: 80px; height: 80px;'>
                </td>
                <td><a href='update.php?id=$row[user_id]' class='btn btn-warning'>Update</a></td>
            </tr>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Data</title>
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
    h1{
      color: var(--accent-color);
    }
  </style>
</head>

<body>

<div class="container">
    <h1 class="fw-bold text-center my-5 display-3">User Dashboard</h1>
    <hr class='my-2 mb-5' style=" color: var(--accent-color);">
    </div>
    </div>
    </div>
<div class="container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?= $data ?>
            </tbody>
        </table>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
