<?php
session_start();

if (!isset($_SESSION["adm"])) {
    header("Location: /php/BE20_CR5_BrunoKreppel/index.php");
    exit(); // Make sure to stop the script after redirecting
}

require_once '../components/db_Connect.php';

// Initialize variables to store existing data
$id = $name = $photo_url = $location = $description = $size = $age = $vaccinated = $breed = $status = '';

// Fetch existing data for the specified ID
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $selectQuery = "SELECT * FROM `animal` WHERE `animal_id`='$id'";
    $result = mysqli_query($conn, $selectQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Extract data for pre-populating the form
        $name = $row["name"];
        $photo_url = $row["photo_url"];
        $location = $row["location"];
        $description = $row["description"];
        $size = $row["size"];
        $age = $row["age"];
        $vaccinated = $row["vaccinated"];
        $breed = $row["breed"];
        $status = $row["status"];
    } else {
        echo "
        <div class='alert alert-danger mb-0' role='alert'>
            No data found for the specified ID.
        </div>
        ";
    }
}

if (isset($_POST["update"])) {
  // Remove the line below as "animal_id" is auto-incremented and doesn't need to be updated
  // $id = $_POST["animal_id"];

  $name = $_POST["name"];
  $photo_url = $_POST["photo_url"];
  $location = $_POST["location"];
  $description = $_POST["description"];
  $size = $_POST["size"];
  $age = $_POST["age"];
  $vaccinated = isset($_POST["vaccinated"]) ? 1 : 0;
  $breed = $_POST["breed"];
  $status = $_POST["status"];

  // Use prepared statements to prevent SQL injection
  $sql = "UPDATE `animal` SET 
          `name`=?, 
          `photo_url`=?, 
          `location`=?, 
          `description`=?, 
          `size`=?, 
          `age`=?, 
          `vaccinated`=?, 
          `breed`=?, 
          `status`=? 
          WHERE `animal_id`=?";

  $stmt = mysqli_prepare($conn, $sql);

  // Bind parameters
  mysqli_stmt_bind_param($stmt, "sssssiissi", $name, $photo_url, $location, $description, $size, $age, $vaccinated, $breed, $status, $id);

  // Execute the statement
  if (mysqli_stmt_execute($stmt)) {
      echo "
      <div class='alert alert-success mb-0' role='alert'>
          Entry was updated successfully.
      </div>
      ";
  } else {
      echo "
      <div class='alert alert-danger mb-0' role='alert'>
          Something went wrong during the update.
      </div>
      ";
  }

  // Close the statement
  mysqli_stmt_close($stmt);
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
  <style>
    body{
      font-family: var(--font);
      background-color: var(--primary-color);
      color: var(--text-color);
    }
  </style>

  <title>Homepage</title>
</head>

<body>
    <?php require_once '../components/navbar.php'; ?>

    <div class="container">
        <h1 class="fw-bold text-center my-5 display-4">Update Animal Entry</h1>
        <hr class='my-2 mb-5'>
    </div>

    <div class="container">
    <form action="" method="post" name="updateForm" onsubmit="return checkFormLength();">

        <label for="name" class="form-label">Name:</label>
        <input type="text" name="name" class="form-control mb-2" value="<?php echo $name; ?>" required>

        <label for="photo_url" class="form-label">Photo URL (or file name):</label>
        <input type="text" name="photo_url" class="form-control mb-2" value="<?php echo $photo_url; ?>" required>

        <label for="location" class="form-label">Location:</label>
        <input type="text" name="location" class="form-control mb-2" value="<?php echo $location; ?>" required>

        <label for="description" class="form-label">Description:</label>
        <textarea name="description" class="form-control mb-2" required><?php echo $description; ?></textarea>

        <label for="size" class="form-label">Size:</label>
        <input type="text" name="size" class="form-control mb-2" value="<?php echo $size; ?>" required>

        <label for="age" class="form-label">Age:</label>
        <input type="number" name="age" class="form-control mb-2" value="<?php echo $age; ?>" required>

        <label for="vaccinated" class="form-check-label">Vaccinated:</label>
        <input type="checkbox" name="vaccinated" class="form-check-input mb-2" <?php echo ($vaccinated == 1) ? 'checked' : ''; ?>>
        <br>

        <label for="breed" class="form-label">Breed:</label>
        <input type="text" name="breed" class="form-control mb-2" value="<?php echo $breed; ?>" required>

        <label for="status" class="form-label">Status:</label>
        <select name="status" class="form-control mb-2" required>
            <option value="Adopted" <?php echo ($status == 'Adopted') ? 'selected' : ''; ?>>Adopted</option>
            <option value="Available" <?php echo ($status == 'Available') ? 'selected' : ''; ?>>Available</option>
        </select>

        <input type="submit" value="Update" name="update" class="btn btn-warning mt-3 mb-5">
    </form>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>

</html>
