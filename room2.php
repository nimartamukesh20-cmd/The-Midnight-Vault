
<?php
require_once("game_functions.php");

requireRoom(2);
$message = "";

//Hint button
if (isset($_POST['hint'])){
    useHint(2);
}
//Unlocking door
if (isset($_POST['unlock'])){
    $answer = strtoupper(trim($_POST['answer']));
    if ($answer=="ECHO"){
        completeRoom(2);
        header('Location: room3.php');
        exit();
    }
    else{
        wrongAnswer(2);
        if ($_SESSION['room_attempts'][2] >= 3) {
            $message = "Still not right! Remember, the answer is something that can be heard more than once.";
        }
        elseif ($_SESSION['room_attempts'][2] == 2) {
            $message = "Incorrect! Think about what happens to a sound when it bounces off a surface.";
        }
        else {
            $message = "Incorrect! Try again. Think about a sound that comes back to you.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room2 - The Whispering Chamber</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <h1>The Whispering Chamber</h1>
    <div class="score-box">
        Current Score: <?php echo $_SESSION['score']; ?>
    </div>
    <div class="puzzle-box">
        <h2>Room 2</h2>
        <p>You enter a dark chamber. A mysterious voice whispers from the darkness...</p><br>
        <h3> 
            "I speak without a mouth and hear without ears.
            I have no body, but I come alive with sound.
            WHAT AM I?"
        </h3>
    </div>
    <!--Feedback-->
    <?php 
    if ($message != ""){echo "<div class='error'>$message</div>";}
    ?>

    <form method="POST">
        <label>Enter your answer: </label>
        <input type="text" name="answer" autocomplete="off" required>
        <input type="submit" name="unlock" value="Unlock Door">
    </form>

    <form method="POST">
        <button type="submit" name="hint">Use Hint (-100 points)</button>
    </form>

    <!--Displaying Hint-->
    <?php
    if ($_SESSION['room_hints'][2]>=1) {
        echo "<div class='hint-box'>";
        echo "<strong>Hint1: </strong><br>";
        echo "Sometimes, what you hear is not coming from someone else.";
        echo "</div>";
    }
    if ($_SESSION['room_hints'][2]>=2){
        echo "<div class='hint-box'>";
        echo "<strong>Hint2: </strong><br>";
        echo "Mountains and tunnels are good places to find me";
        echo "</div>";
    }
    if ($_SESSION['room_hints'][2]>=3){
        echo "<div class='hint-box'>";
        echo "<strong>Hint3: </strong><br>";
        echo "Some sounds have a way of returning.";
        echo "</div>";
    }
    ?>

    <!--Game Stats-->
    <div class="feedback">
        <p>Room 2 Attempts: <?php echo $_SESSION['room_attempts'][2]; ?>  </p>
        <br>
        <p>Total Attempts: <?php echo $_SESSION['wrong_attempts']; ?>  </p>
        <br>
        <p>Total Hints used: <?php echo $_SESSION['hints_used']; ?>  </p>
    </div>
    <div class="button-group">
        <p>Solve the riddle correctly to unlock the next chamber! </p>
    </div>
</div>
</body>
</html>
