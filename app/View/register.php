<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
</head>
<body>
<h1>Registrierung</h1>
<form action="<?= dirname(__DIR__, 5).'development/HouseholdManager/public/' ?>index.php?route=register" method="post">
    <label for="email">E-Mail:</label>
    <input type="email" name="email" id="email" required>
    <br><br>
    <label for="password">Passwort:</label>
    <input type="password" name="password" id="password" required>
    <br><br>
    <label for="confirm_password">Passwort bestätigen:</label>
    <input type="password" name="confirm_password" id="confirm_password" required>
    <br><br>
    <button type="submit">Registrieren</button>
</form>
</body>
</html>
