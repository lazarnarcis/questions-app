<?php
    session_start();
    require "config.php";
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true) {
        header("location: login.php");
        exit;
    }
    $profile_id = $_SESSION['id'];
    $sql = "UPDATE users SET questions=0 WHERE id='$profile_id'";
    mysqli_query($link, $sql);
    $_SESSION['questions'] = 0;
    header("location: index.php");
    mysqli_close($link);
?>