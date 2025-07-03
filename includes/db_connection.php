<?php
$databaseUrl = getenv('DATABASE_URL');  

if (!$databaseUrl) {
    die('DATABASE_URL environment variable is not set.');
}

if (preg_match("/postgres:\/\/(.*):(.*)@(.*):(\d+)\/(.*)/", $databaseUrl, $matches)) {
    $username = $matches[1];
    $password = $matches[2];
    $host = $matches[3];
    $port = $matches[4];
    $dbname = $matches[5];

    $dsn = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname;

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully!";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    die('Invalid DATABASE_URL format.');
}

?>
