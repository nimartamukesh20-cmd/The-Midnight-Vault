
<?php
require_once 'game_functions.php';


if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

requireRoom(3);
$message = "";

//Hint button
if(isset($_POST['hint'])){
    useHint(3);
}

//submitting combination
if(isset($_POST['unlock'])){
    $A = isset($_POST['A']); //ON
    $B = isset($_POST['B']); //OFF
    $C = isset($_POST['C']); //OFF
    $D = isset($_POST['D']); //ON

    if ($A && !$B && !$C && $D){
        completeRoom(3);
        header("Location: success.php");
        exit();
    }
    else {
        wrongAnswer(3);

        if ($_SESSION['room_attempts'][3] >= 3) {
            $message = "Still not right! Remember that exactly two switches must be activated.";
        } elseif ($_SESSION['room_attempts'][3] == 2) {
            $message = "Incorrect! Check how the switches are related to each other.";
        } else {
            $message = "Incorrect! Try again. Think about how the switches are connected.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room3 - Final Security Lock</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Final Security Lock</h1>
    <div class="score-box">
        Current Score: <?php echo $_SESSION['score']; ?> 
    </div>
    <div class="puzzle-box">
        <h2>Security Protocol</h2>
        <p>The final vault door is protected by four security switches. Set the switches correctly to unlock the vault! </p> <br>
        <strong>Rules:</strong>
        <ol>
            <li>Exactly two swithces must be activated.</li>
            <li>Switch A and Switch C must always be in opposite positions.</li>
            <li>Switch B cannot be activated unless Switch D is activated.</li>
            <li>Switch D must remain in the same position as Switch A.</li>
            <li>Switch A must be activated whenever Switch D is activated.</li>
        </ol>
    </div>
    <?php 
    if($message != ""){
        echo "<div class='feedback'>$message</div>";
    }
    ?>

    <form method="POST">
        <label>
            <input type="checkbox" name="A">
            Switch A 
        </label>
        <br><br>
        <label>
            <input type="checkbox" name="B">
            Switch B 
        </label>
        <br><br>
        <label>
            <input type="checkbox" name="C">
            Switch C 
        </label>
        <br><br>
        <label>
            <input type="checkbox" name="D">
            Switch D 
        </label>
        <br><br>
        <input type="submit" name="unlock" value="Unlock Vault">
    </form>

    <form method="POST">
        <button type="submit" name="hint">Use Hint (-100 points)</button>
    </form>

    <!--Displaying hint-->
    <?php
    if ($_SESSION['room_hints'][3]>=1) {
        echo "<div class='hint-box'>";
        echo "<strong>Hint1: </strong><br>";
        echo "THe switches are connected. Changing one may affect what the others should be";
        echo "</div>";
    }
    if ($_SESSION['room_hints'][3]>=2) {
        echo "<div class='hint-box'>";
        echo "<strong>Hint2: </strong><br>";
        echo "Some hints describe relationships, not individual switch positions.";
        echo "</div>";
    }
    if ($_SESSION['room_hints'][3]>=3) {
        echo "<div class='hint-box'>";
        echo "<strong>Hint3: </strong><br>";
        echo "Sometimes, figuring out which switches must stay OFF is easier than figuring out which ones should be ON.";
        echo "</div>";
    }
    ?>

    <!--Player stats-->
    <div class="feedback">
        <p>Room 3 Attempts: <?php echo $_SESSION['room_attempts'][3]; ?>  </p>
        <br>
        <p>Total Wrong Attempts: <?php echo $_SESSION['wrong_attempts']; ?>  </p>
        <p>Total Hints used: <?php echo $_SESSION['hints_used']; ?>  </p>
    </div>
    <div class="button-group">
        <p>Select the correct switch combination to unlock the vault.</p>
    </div>
</div>
</body>
</html>
