
<?php
require_once 'game_functions.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error = 'Username must be 3–20 characters using letters, numbers, or underscores.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $usersFile = __DIR__ . '/users.txt';
        if (file_exists($usersFile)) {
            $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
            foreach ($lines as $line) {
                list($savedUser, $savedHash) = explode('|', $line);
                if (strcasecmp($savedUser, $username) === 0) {
                    $error = 'Username already exists. Please choose another.';
                    break;
                }
            }
        }
        if ($error === '') {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newUser = $username . '|' . $hashedPassword . PHP_EOL;
            if (file_put_contents($usersFile, $newUser, FILE_APPEND | LOCK_EX) === false) {
                $error = "Unable to create account.";
            } else {
                header('Location: login.php?registered=1');
                exit();
            }
            
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | The Midnight Vault</title>
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
        <p class="eyebrow">NEW SECURITY CLEARANCE</p>
        <h1>CREATE ACCOUNT</h1>
        <p>Register to begin your escape.</p>

        <?php if ($error !== ''): ?>
            <p class="form-error" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                minlength="3"
                maxlength="20"
                autocomplete="username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                autocomplete="new-password"
                required
            >

            <label for="confirm_password">Confirm Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                minlength="8"
                autocomplete="new-password"
                required
            >

            <button type="submit" class="primary-btn">
                CREATE ACCOUNT
            </button>
        </form>

        <p class="auth-link">
            Already have an account?
            <a href="login.php">Log in</a>
        </p>
    </div>
</main>

<footer class="site-footer">
    <p>&copy; 2026 The Midnight Vault | Created by Nimarta &amp; Krishna</p>
</footer>

</body>
</html>
