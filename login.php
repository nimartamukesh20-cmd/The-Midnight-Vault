
<?php
require_once 'game_functions.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter your username and password.';
    } else {
        $usersFile = __DIR__ . '/users.txt';
        $loginSuccess = false;
        if (file_exists($usersFile)) {
            $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                list($savedUser, $savedHash) = explode('|', $line);
                if ($savedUser == $username && password_verify($password, $savedHash)) {
                    $loginSuccess = true;
                    break;
                }
            }
        }
        if ($loginSuccess){
            session_regenerate_id(true);
            $_SESSION['username'] = $username;
            startGame();
            header('Location: room1.php');
            exit();
        }
        else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | The Midnight Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
    <a class="logo" href="index.php">THE MIDNIGHT VAULT</a>
    <nav aria-label="Main navigation">
        <a href="index.php">Home</a>
        <a href="leaderboard.php">Leaderboard</a>
        <a href="about.php">About the Team</a>
    </nav>
</header>

<main class="auth-section">
    <div class="auth-card">
        <div class="auth-icon" aria-hidden="true">🔐</div>
        <p class="eyebrow">SECURE ACCESS PORTAL</p>
        <h1>WELCOME BACK</h1>
        <p>Sign in to enter The Midnight Vault.</p>

        <?php if ($error !== ''): ?>
            <p class="form-error" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                autocomplete="username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <button type="submit" class="primary-btn">
                LOG IN
            </button>
        </form>

        <p class="auth-link">
            New here?
            <a href="register.php">Create an account</a>
        </p>
    </div>
</main>

<footer class="site-footer">
    <p>&copy; 2026 The Midnight Vault | Created by Nimarta &amp; Krishna</p>
</footer>
</body>
</html>
