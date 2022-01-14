<?php
    session_start();
    require "config.php";
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true) {
        header("location: login.php");
        exit;
    }
    $profile_id = $_SESSION['id'];
    $profile_username = $_SESSION['username'];
    $username = $_POST["username"];

    $topSql = "SELECT * FROM users WHERE username='$username'";
    $topResult = mysqli_query($link, $topSql);
    $topRow = mysqli_fetch_assoc($topResult);

    if (mysqli_num_rows($topResult) > 0) {
        $search_name = $topRow['username'];
    } else {
        $search_name = null;
    }
    
    if (strlen($username) > 20) {
        $username_err = "Numele nu poate fi mai lung de 20 de caractere.";
    } else if ($search_name == $username) {
        $username_err = "Acest nume exista deja in baza de date!";
    } else {
        $username_1 = $username;
    }

    if (empty($username_err)) {
        $sql = "UPDATE users SET username='$username_1' WHERE id='$profile_id'";
        mysqli_query($link, $sql);
        $_SESSION['username'] = $username_1;
        header("location: profile.php?id=$profile_id");
    } 
    mysqli_close($link);
?>