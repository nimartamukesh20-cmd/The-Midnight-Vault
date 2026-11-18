
<?php
require_once 'game_functions.php';

// Only logged-in players who reached Room 1 can enter.
requireRoom(1);

$error = '';
$answer = '';

$hints = [
    "The answer isn't a number, but numbers will lead you to it.",
    "Not every number is written with digits.",
    "The symbols may look unfamiliar, but you've probably seen them on a clock."
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'answer') {
        $answer = trim($_POST['answer'] ?? '');

        if (strtoupper($answer) === 'KEY') {
            completeRoom(1);
            header('Location: room2.php');
            exit;
        }

        if ($answer === '') {
            $error = 'Please enter a password.';
        } else {
            wrongAnswer(1);
            $error = 'ACCESS DENIED. Incorrect password. -50 points.';
        }
    } elseif ($action === 'hint') {
        if (useHint(1)) {
            $error = 'Hint unlocked. -100 points.';
        } else {
            $error = 'All three hints have already been unlocked.';
        }
    }
}

$hintsUsed = $_SESSION['room_hints'][1];
$score = $_SESSION['score'];
$attempts = $_SESSION['room_attempts'][1];

// Rule-based adaptive feedback after repeated wrong answers.
$feedback = '';
if ($attempts >= 3) {
    $feedback = 'Security analysis: The symbols are part of a familiar numbering system.';
} elseif ($attempts >= 2) {
    $feedback = 'Security analysis: Try interpreting the symbols before entering letters.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room 1 | The Midnight Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <a class="logo" href="index.php">THE MIDNIGHT VAULT</a>
    <nav aria-label="Main navigation">
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main class="room-section">
    <div class="room-container">

        <div class="room-top">
            <span>CHAMBER 01 / 03</span>
            <span class="score-display">
                SCORE: <?= (int) $score ?>
            </span>
        </div>

        <div class="room-panel">
            <p class="eyebrow">SECURITY TERMINAL ACTIVE</p>
            <h1>THE HIDDEN CODE</h1>

            <p class="room-story">
                You enter a dark chamber. A locked security
                terminal blocks your path. Its screen flashes
                ACCESS DENIED.
            </p>

            <div class="terminal">
                <p class="terminal-status">ACCESS DENIED</p>
                <p>Three mysterious symbols are scratched beneath the keypad:</p>

                <div class="puzzle-code">XI – V – XXV</div>

                <p class="terminal-instruction">
                    ENTER THE THREE-LETTER PASSWORD
                </p>
            </div>

            <?php if ($error !== ''): ?>
                <p class="room-message" role="status">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>

            <?php if ($feedback !== ''): ?>
                <p class="adaptive-feedback">
                    <?= htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>

            <form action="room1.php" method="POST" class="puzzle-form">
                <input type="hidden" name="action" value="answer">

                <label for="answer">Security Password</label>
                <input
                    type="text"
                    id="answer"
                    name="answer"
                    maxlength="3"
                    placeholder="Enter 3 letters"
                    value="<?= htmlspecialchars($answer, ENT_QUOTES, 'UTF-8') ?>"
                    autocomplete="off"
                    required
                >

                <button type="submit" class="primary-btn">
                    UNLOCK DOOR
                </button>
            </form>

            <div class="hint-panel">
                <h2>Need a Hint?</h2>
                <p>Each hint costs 100 points. Maximum 3 hints.</p>

                <?php for ($i = 0; $i < $hintsUsed; $i++): ?>
                    <p class="hint-item">
                        <strong>Hint <?= $i + 1 ?>:</strong>
                        <?= htmlspecialchars($hints[$i], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endfor; ?>

                <?php if ($hintsUsed < 3): ?>
                    <form action="room1.php" method="POST">
                        <input type="hidden" name="action" value="hint">
                        <button type="submit" class="hint-btn">
                            REVEAL HINT <?= $hintsUsed + 1 ?> (-100)
                        </button>
                    </form>
                <?php else: ?>
                    <p>All hints revealed.</p>
                <?php endif; ?>
            </div>

            <p class="attempt-counter">
                Incorrect attempts: <?= (int) $attempts ?>
            </p>
        </div>
    </div>
</main>

<footer class="site-footer">
    <p>&copy; 2026 The Midnight Vault | Created by Nimarta &amp; Krishna</p>
</footer>

</body>
</html>
