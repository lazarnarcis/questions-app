<link rel="stylesheet" href="css/header.css?v=<?php echo time(); ?>">
<div id="header">
    <p id="logo">Questions</p>
    <ul>
        <li><a href="index.php" id='header-link'>Acasa</a></li>
        <?php 
            if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
                $user_id = $_SESSION['id'];
                $user_name = $_SESSION['username'];
                echo "
                    <li><a href='profile.php?id=$user_id' id='header-link'>Profil ($user_name)</a></li>
                    <li><a href='logout.php' id='header-link'>Deconecteaza-te</a></li>
                ";
            } else {
                echo "
                    <li><a href='login.php' id='header-link'>Conecteaza-te</a></li>
                    <li><a href='register.php' id='header-link'>Creeaza-ti un cont</a></li>
                ";
            }
        ?>
    </ul>
</div>