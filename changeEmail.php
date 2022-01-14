<?php
    session_start();
    require "config.php";
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true) {
        header("location: login.php");
        exit;
    }
    $profile_id = $_SESSION['id'];
    $profile_email = $_SESSION['email'];
    $email = $_POST["email"];

    $topSql = "SELECT * FROM users WHERE email='$email'";
    $topResult = mysqli_query($link, $topSql);
    $topRow = mysqli_fetch_assoc($topResult);

    if (mysqli_num_rows($topResult) > 0) {
        $search_email = $topRow['email'];
    } else {
        $search_email = null;
    }
    
    if (strlen($email) > 40) {
        $email_err = "Emailul nu poate fi mai lung de 40 de caractere.";
    } else if ($search_email == $email) {
        $email_err = "Acest email exista deja in baza de date!";
    } else {
        $email_1 = $email;
    }

    if (empty($email_err)) {
        $sql = "UPDATE users SET email='$email_1' WHERE id='$profile_id'";
        mysqli_query($link, $sql);
        $_SESSION['email'] = $email_1;
        header("location: profile.php?id=$profile_id");
    } 
    mysqli_close($link);
?>