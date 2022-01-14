<?php
    session_start();
    require "config.php";
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true) {
        header("location: login.php");
        exit;
    }
    $profile_id = $_SESSION['id'];
    $profile_age = $_SESSION['age'];
    $age = $_POST["age"];
    
    if ($age > 60) {
        $age_err = "Varsta nu poate fi mai mare de 60 de ani.";
    } else if ($age < 14) {
        $age_err = "Varsta nu poate fi mai mica de 14 de ani.";
    } else {
        $age_1 = $age;
    }

    if (empty($age_err)) {
        $sql = "UPDATE users SET age='$age_1' WHERE id='$profile_id'";
        mysqli_query($link, $sql);
        $_SESSION['age'] = $age_1;
        header("location: profile.php?id=$profile_id");
    } 
    mysqli_close($link);
?>