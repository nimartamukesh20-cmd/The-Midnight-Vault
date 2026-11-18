
<?php
require_once 'game_functions.php';

$players = $_SESSION['leaderboard'] ?? [];

if (!is_array($players)) {
    $players = [];
}

usort($players, function ($a, $b) {
    return $b['score'] <=> $a['score'];
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard | The Midnight Vault</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .leaderboard-container {
            max-width: 850px;
            margin: 60px auto;
            padding: 35px;
            background: #141414;
            border: 1px solid #b89548;
            border-radius: 12px;
            color: #f2e8d4;
            text-align: center;
        }
        .leaderboard-container h1 {
            color: #d9b96e;
        }
        .leaderboard-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        .leaderboard-container th,
        .leaderboard-container td {
            padding: 14px 10px;
            border-bottom: 1px solid #555;
        }
        .leaderboard-container th {
            background: #b89548;
            color: #111;
        }
        .leaderboard-container a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            border: 1px solid #d9b96e;
            border-radius: 6px;
            color: #d9b96e;
            text-decoration: none;
        }
    </style>
</head>
<body style="background:#090909;">

<main class="leaderboard-container">
    <h1>THE LEADERBOARD</h1>
    <p>Only the greatest minds escape the vault.</p>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Player</th>
                <th>Score</th>
                <th>Escape Time</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($players)): ?>
                <tr>
                    <td colspan="4">
                        No completed games recorded in this session.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($players as $index => $player): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars(
                            $player['username'], ENT_QUOTES, 'UTF-8'
                        ); ?></td>
                        <td><?php echo (int)$player['score']; ?></td>
                        <td><?php echo htmlspecialchars(
                            $player['time'], ENT_QUOTES, 'UTF-8'
                        ); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php">Home</a>
    <a href="about.php">About</a>
</main>

</body>
</html>
