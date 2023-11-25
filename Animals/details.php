<?php
session_start();

require_once '../components/db_Connect.php';

$cards = "";

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $sql = "SELECT * FROM Animal WHERE animal_id = $_GET[id]";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cards .= "
                <div class='p-2 d-flex justify-content-center'>
                    <div class='card position-relative h-100 shadow-md' style='background-color: #f8f9fa; width: 22rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden;'>
                        <img src='{$row['photo_url']}' class='card-img-top object-fit-cover' alt='...' style='height: 22rem; transition: transform 0.3s ease-in-out;' 
                        onmouseover='this.style.transform=\"scale(1.1)\"' onmouseout='this.style.transform=\"scale(1)\"'>
                        <div class='card-body pt-4 pb-4 '>
                            <h5 class='card-title fw-bold'>{$row['name']}</h5>
                            <hr class='my-2'>
                            <p class='card-text fw-light'><span class='fw-bold'>Description:</span> {$row['description']}</p>
                            <p class='card-text fw-light'><span class='fw-bold'>Size:</span> {$row['size']}</p>
                            <p class='card-text fw-light'><span class='fw-bold'>Age:</span> {$row['age']}</p>
                            <p class='card-text fw-light'><span class='fw-bold'>Vaccinated:</span> " . ($row['vaccinated'] ? 'Yes' : 'No') . "</p>
                            <p class='card-text fw-light'><span class='fw-bold'>Breed:</span> {$row['breed']}</p>
                            <p class='card-text fw-light'><span class='fw-bold'>Status:</span> {$row['status']}</p>
                            <p class='card-text fw-light'><span class='fw-bold'>Address:</span> {$row['location']}</p>
                        </div>
                    </div>
                </div>       
            ";
        }
    } else {
        $cards .= "No data found.";
    }
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
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>
    <?php require_once '../components/hero.php'; ?>

    <div class="container">
        <h1 class="fw-bold text-center my-5 display-3">Animal Details <img width="64" height="64" src="https://img.icons8.com/color/64/dog-paw-print.png" alt="dog-paw-print"/> </h1>
        <hr class='my-2 mb-5' style=" color: var(--accent-color);">
    </div>

    <div class="container w-50">
        <?php echo $cards ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
