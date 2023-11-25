<?php 
session_start();

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    header("Location: ../index.php");
}

require_once '../components/db_Connect.php';
require_once '../components/clean.php';
require_once '../components/fileUpload.php';

$error = false;
$emailError = "";
$passError = "";
$registrationMessage = "";

if (isset($_POST['register'])) {
    $email = cleanInputs($_POST["email"]);
    $pass = cleanInputs($_POST["password"]);
    $picture = fileUpload($_FILES["picture_url"]);
    $firstName = cleanInputs($_POST["first_name"]);
    $lastName = cleanInputs($_POST["last_name"]);
    $phoneNumber = cleanInputs($_POST["phone_number"]);
    $address = cleanInputs($_POST["address"]);
    $passError = "";

    if (empty($email)) {
        $error = true;
        $emailError = "Email can not be empty"; 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "This is not an Email"; 
    } else {
        $sql = "SELECT * FROM `user` WHERE email = '$email'"; 
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) !== 0) {
            $error = true;
            $emailError = "Email already exists.";
        }
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Password can not be empty.";
    } elseif (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must be at least 8 characters long.";
    }

    if ($error === false) {
        $pass = hash("sha256", $pass);

        $sql = "INSERT INTO `user` (`email`, `password`, `picture_url`, `first_name`, `last_name`, `phone_number`, `address`, `status`) VALUES ('$email', '$pass', '$picture[0]', '$firstName', '$lastName', '$phoneNumber', '$address', 'user')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $registrationMessage = "<div id='registrationMessage' class='alert alert-success mt-3' role='alert'>
                    Registration successful! Would you like to <a href='../user/login.php' class='alert-link'>login</a> now?
                  </div>";
        } else {
            $registrationMessage = "<div id='registrationMessage' class='alert alert-danger mt-3' role='alert'>
                    Something went wrong. Please try again.
                  </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/stylesheet.css">
    <style>
        .container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        .alert {
            margin-top: 20px;
        }

        .alert a {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>

    <div>
        <h1 class="fw-bold text-center my-2 display-3"> <img width="64" height="64" src="https://img.icons8.com/color/64/dog-paw-print.png" alt="dog-paw-print"/>
        </h1>
        <hr class='my-2 mb-2' style=" color: var(--accent-color);">
    </div>

    <div class="container">
        <?php echo $registrationMessage; ?>
        <h2 class="fw-bold text-center mb-4">User Registration</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
            <span class="text-danger"><?= $emailError ?></span>

            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
            <span class="text-danger"><?= $passError ?></span>

            <label for="picture_url" class="form-label">Profile Picture:</label>
            <input type="file" name="picture_url" class="form-control">

            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" name="first_name" class="form-control">

            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" name="last_name" class="form-control">

            <label for="phone_number" class="form-label">Phone Number:</label>
            <input type="text" name="phone_number" class="form-control">

            <label for="address" class="form-label">Address:</label>
            <input type="text" name="address" class="form-control">

            <button type="submit" class="btn btn-primary mt-3" name="register">Register</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
