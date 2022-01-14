<?php
    require "config.php";

    $username_err = $email_err = $password_err = "";
    $username_1 = $email_1 = $password_1 = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $topSql = "SELECT * FROM users WHERE email='$email' OR username='$username'";
        $topResult = mysqli_query($link, $topSql);
        $topRow = mysqli_fetch_assoc($topResult);

        if (mysqli_num_rows($topResult) > 0) {
            $search_name = $topRow['username'];
            $search_email = $topRow['email'];
        } else {
            $search_name = null;
            $search_email = null;
        }

        if (strlen($username) > 20) {
            $username_err = "Numele nu poate fi mai lung de 20 de caractere.";
        } else if ($search_name == $username) {
            $username_err = "Acest nume exista deja in baza de date!";
        } else {
            $username_1 = $username;
        }

        if (strlen($email) > 20) {
            $email_err = "E-mailul nu poate fi mai lung de 20 de caractere.";
        } else if ($search_email == $email) {
            $email_err = "Acest e-mail exista deja in baza de date!";
        } else {
            $email_1 = $email;
        }

        if (strlen($password) > 20) {
            $password_err = "Parola nu poate fi mai lunga de 20 de caractere.";
        } else {
            $password_1 = $password;
        }

        if (empty($username_err) && empty($password_err) && empty($email_err)) {
            $sql = "INSERT INTO users (username, email, password, admin, age) VALUES ('$username_1', '$email_1', '$password_1', 0, 0)";
            mysqli_query($link, $sql);
            header("location: login.php");
        }
        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inregistrare</title>
    <link rel="stylesheet" href="css/general.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="register">
        <h1>Inregistrare</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div id="form-group">
                <label for="username">Nume de utilizator</label>
                <input type="text" class="input-text" name="username" id="username" value="<?php echo $username_1; ?>" required>
                <span class="err"><i><?php echo $username_err; ?></i></span>
            </div>
            <div id="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="input-text" name="email" id="email" value="<?php echo $email_1; ?>" required>
                <span class="err"><i><?php echo $email_err; ?></i></span>
            </div>
            <div id="form-group">
                <label for="password">Parola</label>
                <input type="password" class="input-text" name="password" id="password" value="<?php echo $password_1; ?>" required>
                <span class="err"><i><?php echo $password_err; ?></i></span>
            </div>
            <input type="submit" id="submit" value="Creeaza cont">
        </form>
        <p><a href="login.php">Ai deja un cont? Conecteaza-te!</a></p>
        <p><a href="index.php">Inapoi la pagina principala</a></p>
    </div>
</body>
</html>