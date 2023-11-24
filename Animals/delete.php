<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: /php/BE20_CR5_BrunoKreppel/index.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: /php/BE20_CR5_BrunoKreppel/index.php");
    exit();
}

require_once '../components/db_Connect.php';

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];

    $selectSql = "SELECT * FROM `animal` WHERE `animal_id` = ?";
    $stmt = mysqli_prepare($conn, $selectSql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $deleteSql = "DELETE FROM `animal` WHERE `animal_id` = ?";
        $stmt = mysqli_prepare($conn, $deleteSql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["delete_message"] = "Record deleted successfully";
        } else {
            $_SESSION["delete_message"] = "Error deleting record: " . mysqli_stmt_error($stmt);
        }
    }
}

mysqli_close($conn);

header("Location: /php/BE20_CR5_BrunoKreppel/index.php");
exit();
?>