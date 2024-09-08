<?php foreach ($history as $record): ?>
    <p>Число: <?= $record->getRandomNumber() ?>, Результат: <?= $record->getResult() ?>, Выигрыш: <?= $record->getWinAmount() ?></p>
<?php endforeach; ?>

