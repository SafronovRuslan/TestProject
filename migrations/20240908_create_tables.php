<?php

use PDO;

require __DIR__ . '/../vendor/autoload.php';

// Подключаемся к базе данных
$pdo = require __DIR__ . '/../config/database.php';

try {
    $pdo->beginTransaction();

    // Создание таблицы users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            token VARCHAR(32) NOT NULL UNIQUE,
            expires_at DATETIME NOT NULL
        );
    ");

    // Создание таблицы history
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            random_number INT NOT NULL,
            result ENUM('Win', 'Lose') NOT NULL,
            win_amount DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
    ");

    $pdo->commit();

    echo "Миграции выполнены успешно!";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Ошибка выполнения миграций: " . $e->getMessage();
}
