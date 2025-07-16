<?php
require_once './_config.php';
require_once "../app/models/HangmanGame.php";
require_once '../includes/db_connection.php';
session_start();





header("Content-Type: application/json");

$game = new hang\HangmanGame;



if (!isset($_SESSION['game'])) {
    $game->initializeGame();
    //$test = $game.getObject();
    $_SESSION['game'] = $game;
    //$game = $_SESSION['game'];

    if (isset($_SESSION['is_admin'])) {
        unset($_SESSION['is_admin']);
    }
    
}
else {
    // Try to unserialize the game object from the session
    $game = $_SESSION['game'];
}


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'initialize':

            
           // $_SESSION['game'] = $game;

            $currWordState = $game->getCurrentWordList();

            $currImg = $game->getCurrentHangman();

            $ch = $game->getChosenWord();

            echo json_encode(['initialized' => [
                'wordState' => $currWordState,
                'hangman' => $currImg,
                'chos' => $ch
                ]]);

            break;
        case 'decidingCheckLetter':

            if (isset($_GET['KKey'])) {
                $KKey = $_GET['KKey'];
            }
            //error_log("KKey: " . $KKey);
            //print($KKey);
            //var_dump($KKey);


            $Result = $game->checkLetter($KKey);
            $currWordState = $game->getCurrentWordList();

            echo json_encode(['result' =>  $Result]);
        
            break;
        case 'update':

            if (isset($_GET['resu'])) {
                $resu = $_GET['resu'];
            }


             if($resu == 0 || $resu == 1) {
                //updateLeaderboard
                $score = $game->getCurrentScore();
                $_SESSION['currentUser'][1] = $score;

                /*array_push($_SESSION['leaderboard'], $_SESSION['currentUser']);
                usort($_SESSION['leaderboard'], 'compareScores');

                if(count($_SESSION['leaderboard']) >= 10) {

                    while(count($_SESSION['leaderboard']) > 10) {
                        array_pop($_SESSION['leaderboard']);
                    }
                }*/

                try {

                    $pdo->beginTransaction();

                    $query = 'INSERT INTO "LeaderboardSchema"."LeaderboardTable" (player_name, score) VALUES (:player_name, :score)';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([
                        'player_name' => $_SESSION['currentUser'][0],
                        'score' => $_SESSION['currentUser'][1]
                    ]);

                    $query = 'SELECT COUNT(*) FROM "LeaderboardSchema"."LeaderboardTable"';
                    $stmt = $pdo->query($query);
                    $recordCount = $stmt->fetchColumn();

                    if ($recordCount > 10) {
                        $query = 'DELETE FROM "LeaderboardSchema"."LeaderboardTable" WHERE player_name NOT IN (
                                    SELECT player_name FROM "LeaderboardSchema"."LeaderboardTable" ORDER BY score DESC LIMIT 10
                                )';
                        $pdo->exec($query);
                    }

                    $pdo->commit();

                } catch (PDOException $e) {
                    // Rollback in case of error
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    echo "Error: " . $e->getMessage();
                }

                

                //send end state
                $currWordState = $game->getCurrentWordList();
                $promptMsg = "You won!";
                echo json_encode(['State01' => [
                    'wordState' => $currWordState,
                    'promptMsg' => $resu == 0 ? "You won!" : "You ran out of moves :( The word was: " . $game->getChosenWord()
                    ]]);
            }

            elseif($resu == 2) {
                $currWordState = $game->getCurrentWordList();
                $currImg = $game->getCurrentHangman();
                echo json_encode(['State2' => [
                    'wordState' => $currWordState,
                    'hangman' => $currImg
                    ]]);
            }

            elseif($resu == 3) {
                $currWordState = $game->getCurrentWordList();
                $currImg = $game->getCurrentHangman();
                echo json_encode(['State2' => [
                    'wordState' => $currWordState,
                    'hangman' => $currImg,
                    'failCheck' => true
                    ]]);
            }

            break;
        case 'sendUserName':
            //&UserName

            //var_dump("ASDFSDFSDF");
            //error_log("TEST.");
            //var_dump("POST data: " . print_r($_POST, true));

            if (isset($_GET['userName'])) {
                //var_dump("teeheeF");
                //error_log("Username not set in session.");
                $userName = $_GET['userName'];
                $_SESSION['currentUser'] = [$userName, 0];
                var_dump($username);
            }

            //var_dump("Yes");



            echo json_encode(['messaged' => $_SESSION['currentUser']]);

            break;
        case 'getLeaderboard':
            $query = 'SELECT player_name, score FROM "LeaderboardSchema"."LeaderboardTable" ORDER BY score DESC LIMIT 10';
            $stmt = $pdo->query($query);
            $_SESSION['leaderboard'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $leaderboard = $_SESSION['leaderboard'];

            /*foreach ($leaderboard as $entry) {
                var_dump($entry);
            }*/

            echo json_encode(['leaderboard' =>  $leaderboard]);
            break;
        case 'checkIfAdmin':

            if ($_GET['action'] == 'checkIfAdmin') {
                $potentialAdminUser = $_GET['potUser'];
                $potentialAdminPass = $_GET['potPass'];
            
                // Perform the admin check logic here
                // Example:
                //var_dump($potentialAdminUser);
                //var_dump($potentialAdminPass);

            
                if($potentialAdminUser === getenv('ADMIN_USERNAME') && $potentialAdminPass === getenv('ADMIN_PASSWORD')){
                    $_SESSION['is_admin'] = true;
                    echo json_encode(['adminStatus' =>  true, 'adminRedirect' => "admin.php"]);

                }
                else {
                    echo json_encode(['adminStatus' =>  false]);
                }
            }







            break;
        case 'deleteUserFromLeaderboard':

                if (isset($_GET['playerName'])) {
                    //var_dump("teeheeF");
                    //error_log("Username not set in session.");
                    $playerName = $_GET['playerName'];
                    //$_SESSION['currentUser'] = [$playerName, 0];
                }
                

                if (isset($_GET['playerScore'])) {
                    //var_dump("teeheeF");
                    //error_log("Username not set in session.");
                    $playerScore = $_GET['playerScore'];
                    
                    //$_SESSION['currentUser'] = [$playerName, 0];
                }

                //var_dump($playerName);
                //var_dump($playerScore);

                try {

                    $pdo->beginTransaction();

                    $query = 'DELETE FROM "LeaderboardSchema"."LeaderboardTable" WHERE "player_name" = :playerName AND "score" = :playerScore';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(['playerName' => $playerName, 'playerScore' => $playerScore]);

                    $pdo->commit();
            
                } catch (PDOException $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    echo json_encode(['error' => $e->getMessage()]);
                }

                //echo json_encode(['error' => $e->getMessage()]);
    
                break;

        default:
            // Invalid action
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
}


function compareScores($a, $b) {
    return $b[1] - $a[1]; 
}

