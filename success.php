
<?php
require_once 'game_functions.php';

requireGameLogin();

if (!isset($_SESSION['room']) || $_SESSION['room'] < 4) {
    header("Location: room1.php");
    exit();
}

$seconds = max(0, (int)getEscapeTime());
$minutes = floor($seconds / 60);
$remainingSeconds = $seconds % 60;
$escapeTime = $minutes . " min " . $remainingSeconds . " sec";

$username = $_SESSION['username'];
$score = max(0, (int)($_SESSION['score'] ?? 0));
$wrongAttempts = $_SESSION['wrong_attempts'] ?? 0;
$hintsUsed = $_SESSION['hints_used'] ?? 0;

// Handle counts stored either as numbers or per-room arrays.
if (is_array($wrongAttempts)) {
    $wrongAttempts = array_sum($wrongAttempts);
}
if (is_array($hintsUsed)) {
    $hintsUsed = array_sum($hintsUsed);
}

// Session-based leaderboard.
if (!isset($_SESSION['leaderboard']) ||
    !is_array($_SESSION['leaderboard'])) {
    $_SESSION['leaderboard'] = [];
}

// Save only once for each completed game.
if (empty($_SESSION['score_saved'])) {
    $_SESSION['leaderboard'][] = [
        'username' => $username,
        'score' => $score,
        'time' => $escapeTime
    ];

    $_SESSION['score_saved'] = true;
}

// Highest scores first.
usort($_SESSION['leaderboard'], function ($a, $b) {
    return $b['score'] <=> $a['score'];
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault Unlocked | The Midnight Vault</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-container {
            max-width: 850px;
            margin: 60px auto;
            padding: 35px;
            background: #141414;
            color: #f2e8d4;
            border: 1px solid #b89548;
            border-radius: 12px;
            text-align: center;
        }
        .success-container h1,
        .success-container h2 {
            color: #d9b96e;
        }
        .success-container .score-box {
            font-size: 1.5rem;
            color: #d9b96e;
            margin: 25px 0;
        }
        .success-container .feedback {
            margin: 25px 0;
        }
        .success-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        .success-container th,
        .success-container td {
            padding: 12px;
            border-bottom: 1px solid #555;
        }
        .success-container th {
            background: #b89548;
            color: #111;
        }
        .success-container .button-group a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            color: #d9b96e;
            border: 1px solid #d9b96e;
            border-radius: 6px;
            text-decoration: none;
        }
        .success-container .button-group a:hover {
            background: #d9b96e;
            color: #111;
        }
    </style>
</head>
<body style="background:#090909;">

<main class="success-container">
    <h1>VAULT UNLOCKED!</h1>

    <div class="success">
        Congratulations,
        <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!
        <p>You successfully unlocked The Midnight Vault!</p>
    </div>

    <div class="score-box">
        Final Score: <?php echo $score; ?>
    </div>

    <div class="feedback">
        <h2>Game Summary</h2>
        <p>Escape Time:
            <?php echo htmlspecialchars($escapeTime); ?>
        </p>
        <p>Wrong Attempts: <?php echo (int)$wrongAttempts; ?></p>
        <p>Total Hints Used: <?php echo (int)$hintsUsed; ?></p>
    </div>

    <h2>Leaderboard</h2>
    <table>
        <thead>
            <tr>
                <th>Player</th>
                <th>Score</th>
                <th>Escape Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['leaderboard'] as $player): ?>
                <tr>
                    <td><?php echo htmlspecialchars(
                        $player['username'], ENT_QUOTES, 'UTF-8'
                    ); ?></td>
                    <td><?php echo (int)$player['score']; ?></td>
                    <td><?php echo htmlspecialchars(
                        $player['time'], ENT_QUOTES, 'UTF-8'
                    ); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="button-group">
        <a href="leaderboard.php">View Leaderboard</a>
        <a href="logout.php">Logout</a>
    </div>
</main>

</body>
</html>
