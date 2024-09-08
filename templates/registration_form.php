<form method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
    <small>Введите 10 цифр</small>

    <button type="submit">Register</button>
</form>

<?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
