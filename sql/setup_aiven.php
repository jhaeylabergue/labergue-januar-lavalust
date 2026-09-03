<?php
$root = dirname(__DIR__);
$envFile = $root . DIRECTORY_SEPARATOR . '.env';
foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
        continue;
    }
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);
    if (strlen($value) >= 2 && in_array($value[0], ['"', "'"], true) && $value[-1] === $value[0]) {
        $value = substr($value, 1, -1);
    }
    putenv("$key=$value");
}

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$ca   = getenv('DB_SSL_CA');
$dbname = getenv('DB_DATABASE') ?: 'mydb';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_SSL_CA => $ca,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
];

echo "Connecting to {$host}:{$port} as {$user}...\n";
$pdo = new PDO("mysql:host={$host};port={$port};dbname=defaultdb;charset=utf8mb4", $user, $pass, $options);
echo "Connected to defaultdb.\n";

$pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "Database {$dbname} is ready.\n";

$pdo->exec("USE `{$dbname}`");
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    username VARCHAR(100) NOT NULL
)");

$pdo->exec("INSERT INTO users (id, firstname, lastname, email, username) VALUES
    (1, 'Jhaey', 'Fernandez', 'jhaey@email.com', 'jhaeyfernandez'),
    (2, 'Maria', 'Santos', 'maria@email.com', 'mariasantos'),
    (3, 'Pedro', 'Garcia', 'pedro@email.com', 'pedrogarcia'),
    (4, 'Ana', 'Reyes', 'ana@email.com', 'anareyes'),
    (5, 'Jose', 'Mendoza', 'jose@email.com', 'josemendoza')
    ON DUPLICATE KEY UPDATE
        firstname = VALUES(firstname),
        lastname = VALUES(lastname),
        email = VALUES(email),
        username = VALUES(username)");
echo "Sample users inserted or updated.\n";

$rows = $pdo->query('SELECT id, firstname, lastname, email, username FROM users')->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    echo implode("\t", $row) . "\n";
}

echo "OK\n";
