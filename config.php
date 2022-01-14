<?php
    $link = mysqli_connect("localhost", "root", "", "random-questions");

    if ($link === false) {
        die("Conectarea la baza de date nu a reusit!");
    }
?>