<?php
    session_start();
    include "../../config/database.php";

    //only admin can access this page
    if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
        header("Location: ../../index.php");
        exit();
    }

    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    //Delete SQL Command
    mysqli_query($conn, "DELETE FROM subjects WHERE id = $id");

    header("Location: index.php?message=Subject deleted successfully");
    exit;
?>