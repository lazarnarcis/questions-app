<?php
    require "config.php";
    session_start();

    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
        header("location: index.php");
    }

    $username_err = $password_err = "";
    $username_1 = $password_1 = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            $session_user_name = $row['username'];
            $session_user_password = $row['password'];
        } else {
            $session_user_name = null;
            $session_user_password = null;
        }

        if ($session_user_name == null) {
            $username_err = "Nu exista un cont cu acest nume!";
        } else {
            $username_1 = $username;
        }

        if ($session_user_password != $password) {
            $password_err = "Parola este incorecta!";
        } else {
            $password_1 = $password;
        }

        if (empty($username_err) && empty($password_err) && empty($email_err)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['admin'] = $row['admin'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['age'] = $row['age'];
            $_SESSION['response'] = $row['response'];
            $_SESSION['questions'] = $row['questions'];
            $_SESSION['logged'] = true;
            header("location: index.php");
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
    <title>Logare</title>
    <link rel="stylesheet" href="css/general.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="register">
        <h1>Logare</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div id="form-group">
                <label for="username">Nume de utilizator</label>
                <input type="text" class="input-text" name="username" id="username" value="<?php echo $username_1; ?>" required>
                <span class="err"><?php echo $username_err; ?></span>
            </div>
            <div id="form-group">
                <label for="password">Parola</label>
                <input type="password" class="input-text" name="password" id="password" value="<?php echo $password_1; ?>" required>
                <span class="err"><?php echo $password_err; ?></span>
            </div>
            <input type="submit" id="submit" value="Conecteaza-te">
        </form>
        <p><a href="register.php">Nu ai un cont? Inregistreaza-te!</a></p>
        <p><a href="index.php">Inapoi la pagina principala</a></p>
    </div>
</body>
</html>