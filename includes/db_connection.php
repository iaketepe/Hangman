<?php
$databaseUrl = getenv('DATABASE_URL');  

if (!$databaseUrl) {
    error_log('DATABASE_URL environment variable is not set.');
    exit(1);
}

$components = parse_url($databaseUrl);

if ($components) {
    $username = $components['user'];
    $password = $components['pass'];
    $host = $components['host'];
    $port = $components['port'] ?? 5432;
    $dbname = ltrim($components['path'], '/');

    parse_str($components['query'] ?? '', $queryParams);

    $sslmode = $queryParams['sslmode'] ?? 'prefer';
    $channelBinding = $queryParams['channel_binding'] ?? null;
    
    $dsn = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';sslmode=' . $sslmode;
    
    if ($channelBinding) {
        $dsn .= ";channel_binding=$channelBinding";
    }

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully!";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit(1);
    }
} else {
    die('Invalid DATABASE_URL format.');
}

?>
