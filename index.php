
<?php
session_start();
$isLoggedIn = !empty($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Midnight Vault | Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <a class="logo" href="index.php">THE MIDNIGHT VAULT</a>

    <nav aria-label="Main navigation">
        <a href="index.php">Home</a>
        <a href="leaderboard.php">Leaderboard</a>
        <a href="about.php">About the Team</a>
        <?php if ($isLoggedIn): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <section class="hero">
        <div class="vault-symbol" aria-hidden="true">🔐</div>
        <p class="eyebrow">CLASSIFIED // SECURITY LEVEL 03</p>

        <h1>THE MIDNIGHT <span>VAULT</span></h1>

        <p class="story">
            You've been trapped inside a high-security vault.
            Three locked chambers stand between you and freedom.
            Solve the puzzles, unlock the doors, and escape
            before it's too late.
        </p>

        <a class="primary-btn"
           href="<?php echo $isLoggedIn ? 'room1.php' : 'login.php'; ?>">
            ENTER THE VAULT
        </a>

        <p class="hero-note">THREE ROOMS. THREE CHALLENGES. ONE ESCAPE.</p>
    </section>

    <section class="instructions" id="instructions">
        <h2>HOW TO PLAY</h2>
        <p>Every decision counts. Can you escape with a perfect score?</p>

        <div class="instruction-grid">
            <article class="instruction-card">
                <div class="card-icon">01</div>
                <h3>Solve the Puzzles</h3>
                <p>Complete three different challenges to unlock the vault.</p>
            </article>

            <article class="instruction-card">
                <div class="card-icon">02</div>
                <h3>Use Hints Wisely</h3>
                <p>Get up to three hints per room. Each hint costs 100 points.</p>
            </article>

            <article class="instruction-card">
                <div class="card-icon">03</div>
                <h3>Protect Your Score</h3>
                <p>Start with 1,000 points. Each incorrect answer costs 50 points.</p>
            </article>
        </div>

        <p class="score-note">
            Your score cannot fall below zero.
            Escape all three rooms to reach the leaderboard.
        </p>
    </section>
</main>

<footer class="site-footer">
    <p>&copy; 2026 The Midnight Vault | Created by Nimarta &amp; Krishna</p>
</footer>

</body>
</html>
