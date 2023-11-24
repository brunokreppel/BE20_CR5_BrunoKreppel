<?php 
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../index.php");
}

if (isset($_SESSION["adm"])){
  $id = $_GET["id"]??$_SESSION["adm"];
}else{
  $id = $_SESSION["user"];

}

require_once '../components/db_Connect.php';
require_once '../components/clean.php';
require_once '../components/fileUpload.php';

$error = false;
$emailError = "";
$passError = "";

$sql = "SELECT * FROM `user` WHERE user_id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $email = cleanInputs($_POST["email"]);
    $pass = cleanInputs($_POST["password"]);
    $picture = fileUpload($_FILES["picture_url"]);
    $firstName = cleanInputs($_POST["first_name"]);
    $lastName = cleanInputs($_POST["last_name"]);
    $phoneNumber = cleanInputs($_POST["phone_number"]);
    $address = cleanInputs($_POST["address"]);
    $emailError = "";
    $passError = "";

    if(empty($email)){
        $error = true;
        $emailError = "Email can not be empty";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $emailError = "This is not an Email";
    }

    if(empty($pass)){
        $error = true;
        $passError = "Password can not be empty.";
    } elseif(strlen($pass) < 6){
        $error = true;
        $passError = "Password must be at least 8 characters long.";
    }

    if(!$error){
        $pass = hash("sha256", $pass);

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, "UPDATE `user` SET `email`=?, `password`=?, `picture_url`=?, `first_name`=?, `last_name`=?, `phone_number`=?, `address`=? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "sssssssi", $email, $pass, $picture[0], $firstName, $lastName, $phoneNumber, $address, $id);
        $result = mysqli_stmt_execute($stmt);

        if($result){
            echo "
            <div class='alert alert-success mb-0' role='alert'>
                User updated!
            </div>
            ";
        } else {
            echo "
            <div class='alert alert-danger' role='alert'>
                Something went wrong!
            </div>
            ";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
}
?>




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Personal Information Section -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= $row["email"] ?? "" ?>">
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <div class="col-md-4">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control">
                    <span class="text-danger"><?= $passError ?></span>
                </div>
                <div class="col-md-4">
                    <label for="picture_url" class="form-label">Profile Picture:</label>
                    <label for="fileInput" class="file-label">
                        <img src="../assets/<?= $row["picture_url"] ?? 'avatar.png' ?>" alt="User Picture" class="img-fluid rounded-circle pl-3" style="cursor: pointer; width: 80px; height: 80px;">
                    </label>
                    <input type="file" id="fileInput" name="picture_url" class="form-control visually-hidden">
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="<?= $row["first_name"] ?? "" ?>">
                </div>
                <div class="col-md-4">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="<?= $row["last_name"] ?? "" ?>">
                </div>
                <div class="col-md-4">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?= $row["phone_number"] ?? "" ?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" class="form-control"><?= $row["address"] ?? "" ?></textarea>
                </div>
            </div>

            <!-- Update Button Section -->
            <div class="row mt-3">
                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" name="update" class="btn btn-primary">Update Information</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
