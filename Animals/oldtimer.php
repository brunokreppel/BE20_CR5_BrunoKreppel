<?php
session_start();

require_once '../components/db_Connect.php';

if (isset($_SESSION["user"]) && isset($_POST["adopt"])) {
    $date = date("Y-m-d");
    $animal_id = $_POST["animal"];
    $user_id = $_SESSION["user"];

    $sql = "INSERT INTO `pet_adoption` (`fk_user`, `fk_animal`, `adoption_date`) VALUES ('$_SESSION[user]', '$_POST[animal]', '$date')";

    if (mysqli_query($conn, $sql)) {
        echo "Animal Adopted";
    } else {
        echo "Not Adopted";
    }
}

$sql = "SELECT * FROM Animal WHERE `age` > 7 ";
$result = mysqli_query($conn, $sql);
$cards = "";

// Loop to display all entries in the database
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cards .= "
            <div class='p-2 d-flex justify-content-center'>
                <div class='card position-relative h-100 shadow-md' style='background-color: #f8f9fa; width: 22rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden;'>
                    <img src='{$row['photo_url']}' class='card-img-top object-fit-cover' alt='...' style='height: 22rem; transition: transform 0.3s ease-in-out;' 
                    onmouseover='this.style.transform=\"scale(1.1)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                    <div class='card-body pt-4 pb-4 mb-5'>
                        <h5 class='card-title fw-bold'>{$row['name']}</h5>
                        <hr class='my-2'>
                        <p class='card-text fw-light'><span class='fw-bold'>Description:</span> {$row['description']}</p>
                        <p class='card-text fw-light'><span class='fw-bold'>Size:</span> {$row['size']}</p>
                        <p class='card-text fw-light'><span class='fw-bold'>Age:</span> {$row['age']}</p>
                        <p class='card-text fw-light'><span class='fw-bold'>Vaccinated:</span> " . ($row['vaccinated'] ? 'Yes' : 'No') . "</p>
                        <p class='card-text fw-light'><span class='fw-bold'>Breed:</span> {$row['breed']}</p>
                        <p class='card-text fw-light'><span class='fw-bold'>Status:</span> {$row['status']}</p>
                    </div>
                    <div class='position-absolute bottom-0 start-50 translate-middle-x mb-3 w-100 d-flex justify-content-center'>
                        <a href='../animals/details.php?id={$row['animal_id']}' class='btn btn-info mx-2 rounded'>Details</a>";

        if (isset($_SESSION["user"])) {
            $cards .=
                " 
                    <form action='' method='post'>
                        <input type='hidden' name='animal' value='{$row['animal_id']}'>
                        <button type='submit' name='adopt' class='btn btn-warning mx-2 rounded' style='background-color: #f39c12; border-color: #f39c12;'>
                            <img src='https://img.icons8.com/material-two-tone/24/cat-footprint.png' alt='cat-footprint' class='me-2'/>
                            Adopt
                        </button>
                    </form>
                ";
        }
        $cards .= "
                    </div>
                </div>
            </div>
        ";
    }
} else {
    $cards .= "No data found.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/stylesheet.css">
    <title>Homepage</title>
</head>
<body>
    <?php require_once '../components/navbar.php'; ?>
    <?php require_once '../components/hero.php'; ?>

    <div class="container">
        <h1 class="fw-bold text-center my-5 display-3">Oldtimer</h1>
        <hr class='my-2 mb-5' style=" color: var(--accent-color);">
    </div>

    <div class="container">
        <div class="row row-cols-1 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-1">
            <?php echo $cards ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
