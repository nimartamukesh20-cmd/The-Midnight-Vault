
<?php
session_start();

$isLoggedIn = !empty($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | The Midnight Vault</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .info-container {
            max-width: 850px;
            margin: 65px auto;
            padding: 35px;
            background: #141414;
            border: 1px solid #b89548;
            border-radius: 12px;
            color: #f2e8d4;
            line-height: 1.8;
        }
        .info-container h1, .info-container h2 {
            color: #d9b96e;
            text-align: center;
        }
        .info-container h2 { margin-top: 30px; }
        .info-container p { margin: 15px 0; }
        .info-container ul { padding-left: 25px; }
        .info-nav {
            text-align: center;
            margin-top: 35px;
        }
        .info-nav a {
            display: inline-block;
            margin: 8px;
            padding: 10px 18px;
            border: 1px solid #d9b96e;
            border-radius: 6px;
            color: #d9b96e;
            text-decoration: none;
        }
        .info-nav a:hover {
            background: #d9b96e;
            color: #111;
        }
    </style>
</head>
<body style="background:#090909;">

<main class="info-container">
    <h1>THE MIDNIGHT VAULT</h1>

    <p>
        Welcome to The Midnight Vault, an interactive
        escape-room adventure where every answer brings
        you closer to freedom.
    </p>

    <p>
        You are trapped inside a mysterious vault.
        To escape, you must solve three challenging
        puzzles before reaching the final exit.
    </p>

    <h2>How to Play</h2>
    <ul>
        <li>Create an account or log in.</li>
        <li>Begin with 1,000 points.</li>
        <li>Solve three puzzles in order.</li>
        <li>Each wrong answer costs 50 points.</li>
        <li>Each hint costs 100 points.</li>
        <li>You can use up to three hints per room.</li>
        <li>Your score cannot fall below zero.</li>
        <li>Complete all three rooms to escape.</li>
    </ul>

    <h2>Meet the Developers</h2>
    <p style="text-align:center;">
        Nimarta &amp; Krishna
    </p>

    <p style="text-align:center;">
        Created for CSC 4370 - Web Programming<br>
        Georgia State University
    </p>

    <div class="info-nav">
        <a href="index.php">Home</a>
        <a href="leaderboard.php">Leaderboard</a>
        <?php if ($isLoggedIn): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
