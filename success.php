<?php
require_once 'game_functions.php';

requireGameLogin();
if($_SESSION['room'] < 4){
    header("Location: room1.php");
    exit();
}

$seconds = getEscapeTime();
$minutes = floor($seconds / 60);    
$remainingSeconds = $seconds % 60;
$escapeTime = $minutes . " min " . $remainingSeconds . " sec";

//leaderboard
if (!isset($_SESSION['leaderboard'])){
    $_SESSION['leaderboard']=array();
}
$_SESSION['leaderboard'][] = array("username" => $_SESSION['username'], "score" => $_SESSION['score'], "time" => $escapeTime);

usort($_SESSION['leaderboard'], function($a, $b){
    return $b['score'] - $a['score'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault Unlocked</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <h1>VAULT UNLOCKED!</h1>
    <div class="success">
        Congratulations, <?php echo htmlspecialchars($_SESSION['username']); ?> 
        <br><br>
        You successfully unlocked The Midnight Vault!!!
    </div>
    <br>
    <div class="score-box">
        Final Score: <?php echo $_SESSION['score']; ?>
    </div>
    <div class="feedback">
        <h2>Game Summary</h2>
        <p>Escape time: 
            <?php echo $escapeTime; ?>  </p>
        <p> Wrong attempts: <?php echo $_SESSION['wrong_attempts'];?>
        </p>
        <p>Total hints used: <?php echo $_SESSION['hints_used']; ?>
        </p>
    </div>

    <h2>Leaderboard</h2>
    <table>
        <tr>
            <th>Player</th>
            <th>Score</th>
            <th>Escape Time</th>
        </tr>

        <?php
        foreach ($_SESSION['leaderboard'] as $player){
            echo "<tr>";
            echo "<td>" . htmlspecialchars($player['username']) . "</td>";
            echo "<td>" . $player['score'] . "</td>";
            echo "<td>" . $player['time'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <div class="button-group">
        <form action="leaderboard.php" method="get">
            <input type="submit" value="View Leaderboard">
        </form>
        <br>
        <form action="logout.php" method="post">
            <input type="submit" value="Play Again">
        </form>
    </div>
</div>
</body>
</html>
