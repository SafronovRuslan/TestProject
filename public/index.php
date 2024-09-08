<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Controller\PageAController;
use App\Controller\RegistrationController;
use App\Repository\HistoryRepository;
use App\Repository\UserRepository;

// Получаем PDO соединение
$pdo = Database::getConnection();
$userRepository = new UserRepository($pdo);
$historyRepository = new HistoryRepository($pdo);

// Если в GET-запросе есть параметр token, обрабатываем его для страницы A
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $controller = new PageAController($userRepository, $historyRepository);
    $user = $controller->checkToken($token);

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'feelinglucky':
                    $result = $controller->generateRandomNumber();
                    echo "Число: {$result['number']}, Результат: {$result['result']}, Сумма выигрыша: {$result['win']}";
                    $controller->saveHistory($user->getId(), $result['number'], $result['result'], $result['win']);
                    break;

                case 'newlink':
                    $newLink = $controller->generateNewLink($user);
                    echo "Новая ссылка: <a href='$newLink'>$newLink</a>";
                    break;

                case 'deactivate':
                    $controller->deactivateLink($user);
                    echo "Ссылка деактивирована.";
                    break;

                case 'history':
                    $history = $controller->getHistory($user->getId());

                    require __DIR__ . '/../templates/history.php';
                    break;

                default:
                    echo "Неверное действие.";
                    break;
            }
        } else {
            require __DIR__ . '/../templates/page_a.php';
        }
    } else {
        echo "Неверный или просроченный токен.";
    }
} else {
    $error = '';
    try {
        $controller = new RegistrationController($userRepository);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $phone = $_POST['phone'];
            $link = $controller->registerUser($username, $phone);
            echo "Ваша уникальная ссылка: <a href='$link'>$link</a>";
        } else {
            require __DIR__ . '/../templates/registration_form.php';
        }
    } catch (\InvalidArgumentException $e) {
        $error = $e->getMessage();
    }
}
