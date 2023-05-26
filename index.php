<?php
session_start();

// Kontrollera om användaren redan är inloggad
if (isset($_SESSION['username'])) {
    header('Location: anvandarsida.php');
    exit;
}

// Hantera inloggning
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validera användarnamn och lösenord

    // Anslut till databasen
    $servername = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'webbserverprogrammering';

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Kontrollera anslutningen
    if ($conn->connect_error) {
        die('Kunde inte ansluta till databasen: ' . $conn->connect_error);
    }

    // Hämta användaren från databasen baserat på användarnamn och lösenord
    $sql = "SELECT * FROM användare WHERE användarnamn = '$username' AND lösenord = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Logga in användaren och omdirigera till användarsidan
        $_SESSION['username'] = $username;
        header('Location: användarsida.php');
        exit;
    } else {
        $error = 'Ogiltigt användarnamn eller lösenord.';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Twitter - Logga in</title>
   
</head>
<body>
    <h1>Logga in på Twitter</h1>

    <?php if (isset($error)) {
        echo '<p>' . $error . '</p>';
    } ?>

    <form method="POST" action="index.php">
        <label>Användarnamn:</label>
        <input type="text" name="username" required><br>

        <label>Lösenord:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Logga in</button>
    </form>
</body>
</html>