<?php
require_once './_config.php';
session_start();

if (isset($_SESSION['game'])) {
    //$_SESSION['game'] = new YatzyGame();
    //$game = $_SESSION['game'];

    unset($_SESSION['game']);
}

if (isset($_SESSION['currentUser'])) {
    //$_SESSION['game'] = new YatzyGame();
    //$game = $_SESSION['game'];

    unset($_SESSION['currentUser']);
}

if (!isset($_SESSION['leaderboard'])) {
    //$_SESSION['game'] = new YatzyGame();
    //$game = $_SESSION['game'];

    $_SESSION['leaderboard'] = [];
}


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != true) {
    header("Location: index.php");
    exit;
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman</title>
    <link  type="text/css" rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="start">
        <h1>Hangman</h1>
        <button id="start-button" onclick="backToHome()">Back To Home</button>
    </div>
    <div class="items">
        <h2>Leaderboard</h2>
        <table id="leaderboard">
                        <tr>
                            <th>Name</th>
                            <th>Score</th>
                            <th>Delete?</th>
                        </tr>
        </table>
    </div>
</body>
<script src="admin.js"></script>
</html>
