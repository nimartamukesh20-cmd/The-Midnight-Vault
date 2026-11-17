
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Start a new game after login.
function startGame() {
    $_SESSION['score'] = 1000;
    $_SESSION['room'] = 1;
    $_SESSION['start_time'] = time();
    $_SESSION['wrong_attempts'] = 0;
    $_SESSION['hints_used'] = 0;
    $_SESSION['room_attempts'] = [1 => 0, 2 => 0, 3 => 0];
    $_SESSION['room_hints'] = [1 => 0, 2 => 0, 3 => 0];
    unset($_SESSION['end_time']);
}

function requireGameLogin() {
    if (empty($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['room'])) {
        header('Location: index.php');
        exit;
    }
}

// Prevent players from skipping or revisiting rooms.
function requireRoom($room) {
    requireGameLogin();

    if ($_SESSION['room'] != $room) {
        $current = (int) $_SESSION['room'];

        if ($current >= 1 && $current <= 3) {
            header('Location: room' . $current . '.php');
        } else {
            header('Location: success.php');
        }
        exit;
    }
}

// Deduct 50 points for an incorrect answer.
function wrongAnswer($room) {
    $_SESSION['score'] = max(0, $_SESSION['score'] - 50);
    $_SESSION['wrong_attempts']++;
    $_SESSION['room_attempts'][$room]++;
}

function useHint($room) {
    if ($_SESSION['room_hints'][$room] >= 3) {
        return false;
    }

    $_SESSION['room_hints'][$room]++;
    $_SESSION['hints_used']++;
    $_SESSION['score'] = max(0, $_SESSION['score'] - 100);

    return true;
}

// Unlock the next room after a correct answer.
function completeRoom($room) {
    if ($_SESSION['room'] != $room) {
        return false;
    }

    $_SESSION['room'] = $room + 1;

    if ($room == 3) {
        $_SESSION['end_time'] = time();
    }

    return true;
}

// Total escape time 
function getEscapeTime() {
    if (!isset($_SESSION['start_time'])) {
        return 0;
    }

    return ($_SESSION['end_time'] ?? time())
        - $_SESSION['start_time'];
}
