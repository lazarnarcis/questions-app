<?php
    session_start();
    require "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scorul general al utilizatorilor</title>
    <link rel="stylesheet" href="css/showScore.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include("header.php"); ?>
    <div class="app">
        <h1>Mai jos puteti vedea (daca exista) o lista cu toti utilizatorii si scorul acestora:</h1>
        <?php
            $sql = "SELECT * FROM users ORDER BY questions DESC";
            $result = mysqli_query($link, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $user_score = $row['questions'];
                    $user_name = $row['username'];
                    $user_email = $row['email'];
                    $user_id = $row['id'];
                    if ($user_score == 15) {
                        $total_points = "<span style='color: red'>$user_score puncte</span> (a terminat de raspuns la toate intrebarile. felicitari!)";
                    } else {
                        $total_points = "<span style='color: black'>$user_score puncte</span>";
                    }
                    echo "<h2><a href='profile.php?id=$user_id'>$user_name</a> ($user_email) - $total_points</h2>";
                }
            }
            mysqli_close($link);
        ?>
    </div>
</body>
</html>