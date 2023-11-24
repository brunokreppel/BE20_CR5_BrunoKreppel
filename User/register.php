<?php 
session_start();

if (isset($_SESSION["user"]) || isset($_SESSION["adm"]) ){
    header("Location: ../index.php");
}


require_once '../components/db_Connect.php';
require_once '../components/clean.php';
require_once '../components/fileUpload.php';


$error = false;
$emailError = "";
$passError = "";


if(isset($_POST['register'])){
    $email = cleanInputs($_POST["email"]);
    $pass = cleanInputs($_POST["password"]);
    $picture = fileUpload($_FILES["picture_url"]);
    $firstName = cleanInputs($_POST["first_name"]);
    $lastName = cleanInputs($_POST["last_name"]);
    $phoneNumber = cleanInputs($_POST["phone_number"]);
    $address = cleanInputs($_POST["address"]);
    $passError = "";

    if(empty($email)){
        $error = true;
        $emailError = "Email can not be empty"; 
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $emailError = "This is not an Email"; 
    } else {
        $sql = "SELECT * FROM `user` WHERE email = '$email'"; 
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) !== 0){
            $error = true;
            $emailError = "Email already exists.";
        }
    }

    if(empty($pass)){
        $error = true;
        $passError = "Passowrd can not be empty.";
    }
    elseif(strlen($pass) < 6){
        $error = true;
        $passError = "Password must be at leat 8 characters long.";
    }

    if($error === false){
        $pass = hash("sha256", $pass);

        $sql = "INSERT INTO `user` (`email`, `password`, `picture_url`, `first_name`, `last_name`, `phone_number`, `address`, `status`) VALUES ('$email', '$pass', '$picture[0]', '$firstName', '$lastName', '$phoneNumber', '$address', 'user')";
        $result = mysqli_query($conn, $sql);


        if($result){
            echo "
        <div class='alert alert-success' role='alert'>
            New user created!
        </div>";
        }
        else{
            echo "
            <div class='alert alert-danger' role='alert'>
                Something went wrong!
            </div>";
        }
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
        <label class="form-label">
            Picture:
            <input type="file" name="picture_url" class="form-control">
        </label>
        <label>
            First Name:
            <input type="text" name="first_name" class="form-control">
        </label>
        <label>
            Last Name:
            <input type="text" name="last_name" class="form-control">
        </label>
        <label>
            Phone Number:
            <input type="text" name="phone_number" class="form-control">
        </label>
        <label>
            Address:
            <input type="text" name="address" class="form-control">
        </label>
        <input type="submit" value="Register" name="register" class="btn btn-primary mt-3 d-flex">
    </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
