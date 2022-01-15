<?php
  session_start();
  require 'config.php';

  $username_err = $email_err = $age_err = "";
  $username_1 = $email_1 = $age_1 = "";
  
  if (!isset($_GET['id'])) {
    header('location: index.php');
    exit();
  } else {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id='$id' ORDER BY username DESC LIMIT 1"; 
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    $userid = $row['id'];
    $username = $row['username'];
    $useremail = $row['email'];
    $userage = $row['age'];
  }
  mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilul lui <?php echo $username; ?></title>
    <link rel="stylesheet" href="css/profile.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include("header.php"); ?>
    <div class='app'>
      <div class='name'>
        <h1>Profilul lui <?php echo $username; ?></h1>
        <?php if ($_SESSION['id'] == $userid) { ?>
          <div id='newName'>
            <span id='change-name' onclick="changeName('change-name', 'form');">Schimba-ti numele</span>
            <form action="changeName.php" method="POST" id="form">
              <input type="text" class='input-text' placeholder="Noul nume" name="username" value="<?php echo $username_1 ?>" required>
              <span><?php echo $username_err; ?></span>
              <input type="submit" id="submit" value="Schimba numele">
            </form>
          </div>
        <?php } ?>
      </div>
      <div class="name">
        <h1>E-mail: <?php echo $useremail; ?></h1>
        <?php if ($_SESSION['id'] == $userid) { ?>
          <div id='newName'>
            <span id='change-email' onclick="changeName('change-email', 'form1');">Schimba-ti emailul</span>
            <form action="changeEmail.php" method="POST" id="form1">
              <input type="email" class='input-text' placeholder="Noul e-mail" name="email" value="<?php echo $email_1 ?>" required>
              <span><?php echo $email_err; ?></span>
              <input type="submit" id="submit" value="Schimba e-mailul">
            </form>
          </div>
        <?php } ?>
      </div>
      <div class="name">
        <h1>Varsta: <?php echo $userage; ?> ani</h1>
        <?php if ($_SESSION['id'] == $userid) { ?>
          <div id='newName'>
            <span id='change-age' onclick="changeName('change-age', 'form2');">Schimba-ti varsta</span>
            <form action="changeAge.php" method="POST" id="form2">
              <input type="number" class='input-text' placeholder="Noua varsta" name="age" value="<?php echo $age_1 ?>" required>
              <span><?php echo $age_err; ?></span>
              <input type="submit" id="submit" value="Schimba varsta">
            </form>
          </div>
        <?php } ?>
      </div>
      <?php if ($_SESSION['questions'] >= 15) {
        if ($_SESSION['id'] == $userid) {
          $word = "Ai";
        } else {
          $word = "A";
        }
        echo "<h1>$word raspuns la cele 15 intrebari!</h1>";
      } ?>
    </div>
    <script src="script/profile.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>
</html>