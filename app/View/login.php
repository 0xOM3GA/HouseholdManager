<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form action="<?= dirname(__DIR__, 5).'development/HouseholdManager/public/' ?>index.php?route=login" method="post">
    <label for="email">E-Mail:</label>
    <input type="email" name="email" id="email" required>
    <br><br>
    <label for="password">Passwort:</label>
    <input type="password" name="password" id="password" required>
    <br><br>
    <button type="submit">Einloggen</button>
</form>
<p>Noch nicht registriert? <a href="/index.php?route=register">Registrieren</a></p>
</body>
</html>
