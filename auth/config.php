<?php
$DB_HOST = getenv('FOODEDU_DB_HOST') ?: '127.0.0.1';
$DB_NAME = getenv('FOODEDU_DB_NAME') ?: 'foodedu';
$DB_USER = getenv('FOODEDU_DB_USER') ?: 'root';
$DB_PASS = getenv('FOODEDU_DB_PASS') !== false ? getenv('FOODEDU_DB_PASS') : '';

if (file_exists(__DIR__ . '/config.override.php')) {
    require __DIR__ . '/config.override.php';
}

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdoBootstrap = new PDO("mysql:host=$DB_HOST;charset=utf8mb4", $DB_USER, $DB_PASS, $options);
    $pdoBootstrap->exec("CREATE DATABASE IF NOT EXISTS `$DB_NAME` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdoBootstrap->exec("USE `$DB_NAME`");
    $pdoBootstrap->exec(
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(20),
            role ENUM('siswa','ortu','sekolah','mbg') NOT NULL,
            username VARCHAR(100) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            sekolah VARCHAR(255),
            anak VARCHAR(255),
            nip VARCHAR(50),
            idk VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_username (username),
            INDEX idx_email (email),
            INDEX idx_role (role)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );
} catch (Exception $e) {
    // silently ignore to let downstream handle
}

$pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, $options);
