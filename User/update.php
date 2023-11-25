<?php 
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../index.php");
}

if (isset($_SESSION["adm"])) {
    $id = $_GET["id"] ?? $_SESSION["adm"];
} else {
    $id = $_SESSION["user"];
}

if (isset($_SESSION['update_message'])) {
    $updateMessage = $_SESSION['update_message'];
    echo "
    <div class='alert alert-success mb-0' role='alert'>
        $updateMessage
    </div>";
    unset($_SESSION['update_message']); 
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

if (isset($_POST['update'])) {
    $email = cleanInputs($_POST["email"]);
    $pass = cleanInputs($_POST["password"]);
    $picture = fileUpload($_FILES["picture_url"]);
    $firstName = cleanInputs($_POST["first_name"]);
    $lastName = cleanInputs($_POST["last_name"]);
    $phoneNumber = cleanInputs($_POST["phone_number"]);
    $address = cleanInputs($_POST["address"]);
    $emailError = "";
    $passError = "";

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
    } elseif (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must be at least 8 characters long.";
    }

    if (!$error) {
        $pass = hash("sha256", $pass);

        if ($_FILES["picture_url"]["error"] == 0) {
            if ($row["picture_url"] !== "avatar.png") {
                unlink("../assets/$row[picture_url]");
            }
            $sql = "UPDATE `user` SET `email`= '$email', `password`= '$pass', `picture_url`= '$picture[0]', `first_name`= '$firstName', `last_name`= '$lastName', `phone_number`= '$phoneNumber', `address`= '$address' WHERE user_id = $id";
        } else {
            $sql = "UPDATE `user` SET `email`= '$email', `password`= '$pass', `first_name`= '$firstName', `last_name`= '$lastName', `phone_number`= '$phoneNumber', `address`= '$address' WHERE user_id = $id";
        }

        $result = mysqli_query($conn, $sql);

       
        if ($result) {
            $_SESSION['update_message'] = "User updated!";
            header("Location: ../user/update.php");
        } else {
            $_SESSION['update_message'] = "Something went wrong!";
            header("Location: ../user/update.php");
        }
            }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/stylesheet.css">
    <style>
        .container1 {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-label {
            margin-top: 10px;
            display: block;
        }

        .file-label {
            cursor: pointer;
            display: block;
        }

        .img-fluid {
            border: 2px solid #f8f9fa;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out;
        }

        .img-fluid:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>

    <div class="container pt-5">
        <h1 class="fw-bold text-center my-5 display-3">Update Profile</h1>
        <hr class='my-2 mb-5' style="color: var(--accent-color);">
    </div>

    <div class="container container1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="picture_url" class="form-label">Profile Picture:</label>
                    <div class="d-flex justify-content-around">
                        <input type="file" id="fileInput" name="picture_url" class="form-control visually-hidden">
                        <label for="fileInput" class="file-label me-2">
                            <img src="../assets/<?= $row["picture_url"] ?? 'avatar.png' ?>" alt="User Picture" class="img-fluid object-fit-cover" style="cursor: pointer; width: 80px; height: 80px; border-radius: 50%;">
                        </label>
                    </div>
                </div>
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
            </div>
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
            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" name="update" class="btn btn-primary">Update Information</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
