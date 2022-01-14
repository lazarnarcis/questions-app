<?php
    $randomNumber=0;
    session_start();
    require "config.php";
    $checkbox_err = $question1_err = "";

    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
        $userid = $_SESSION['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['checkbox'])) {
                $checkbox = $_POST['checkbox'];

                $sql = "UPDATE users SET response=1 WHERE id=$userid";
                mysqli_query($link, $sql);
                $_SESSION['response'] = 1;
            } else {
                $checkbox_err = "Bifeaza casuta daca vrei sa raspunzi la acele intrebari!";
            }

            if (isset($_POST['questions'])) {
                if (empty($_POST['question'])) {
                    $question1_err = "Va rugam sa raspundeti la aceasta intrebare!";
                } else if ($_POST['question'] != $_POST['corResVal']) {
                    $question1_err = "Raspunsul nu este corect!";
                } else if (!empty($_POST['question'])) {
                    $sql = "UPDATE users SET questions=questions+1 WHERE id=$userid";
                    $_SESSION['questions'] = $_SESSION['questions']+1;
                    mysqli_query($link, $sql);
                } 
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Principala</title>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include("header.php"); ?>
    <div class='app'>
        <?php
            if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                echo "
                    <h1>Salut, <i>" . $_SESSION['username'] . "</i>!</h1>
                ";
            } else {
                echo "
                    <div class='new-on-page'>
                        <p class='text-right-bottom'>Salut... Daca nu ai un cont iti poti crea unul apasand <a href='register.php'>aici</a>, iar daca ai deja un cont te poti <a href='login.php'>conecta</a>.</p>
                    </div>
                ";
            }
        ?>
        <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) { ?>
            <div>
                <?php if ($_SESSION['response'] == 0) { ?>
                    <h2>Esti de acord sa raspunzi la 15 intrebari?</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="checkbox" name="checkbox" id="checkbox">
                        <label for="checkbox">Bifand aceasta casuta confirmati ca vreti sa raspundeti la cele 15 intrebari.</label>
                        <p><?php echo $checkbox_err; ?></p>
                        <input type="submit" value="Sunt de acord">
                    </form>
                <?php } else {
                    $myAge = $_SESSION['age'];

                    $newSql = "SELECT questions FROM users WHERE id=$userid";
                    $newResult = mysqli_query($link, $newSql);
                    $newRow = mysqli_fetch_assoc($newResult);
                    $user_questions = $newRow['questions'] + 1;

                    if ($newRow['questions'] >= 15) {
                        echo "Felicitari! Ai acumulat cele 15 puncte! Apasa aici pentru a ti le reseta! <a href='resetPoints.php'>Reseteaza punctele</a>";
                    } else {
                        $results = mysqli_query($link, "SELECT COUNT(*) FROM `questions` WHERE minAge<=$myAge");
                        $rows = mysqli_fetch_row($results)[0];
                        $randomNumber = rand(1, $rows);

                        $sql = "SELECT * FROM questions WHERE minAge<=$myAge AND id=$randomNumber";
                        $result = mysqli_query($link, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $question = $row['question'];

                            $correctResponse = $row['correctResponse'];
                            $question_id = $row['id'];
                            $action_php = $_SERVER['PHP_SELF'];
                            $newString = "";
                            
                            for ($number = 1; $number <= 4; $number++) {
                                $question_num = $row['resp'.$number.''];
                                $secondvar = $number . $question_id;

                                $newString .= "<input type='radio' id='question$secondvar' value='$number' name='question'/><label for='question$secondvar'>$question_num</label></li>";
                            }
                            $button_number_question = $user_questions + 1;
                            echo "
                                <div class='question'>
                                    <form action='$action_php' method='POST'>
                                        <h2>" . $user_questions . ". " . $question . "</h2>
                                        $newString
                                        <input type='text' name='corResVal' value='$correctResponse' style='display: none' />
                                        <p id='error'>$question1_err</p>
                                        <input type='submit' name='questions' id='send-responses' value='Urmatoarea intrebare ($button_number_question)' />
                                    </form>
                                </div>
                            ";
                        }
                    }
                } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>