<?php
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

// Hantera skapandet av konto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validera användarnamn och lösenord

    // Kontrollera om användarnamnet redan finns i databasen
    $sql = "SELECT * FROM användare WHERE användarnamn = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = 'Användarnamnet är redan upptaget.';
    } else {
        // Spara användaren i databasen
        $sql = "INSERT INTO användare (användarnamn, lösenord) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Användaren har skapats, omdirigera till inloggningssidan
            header('Location: index.php');
            exit;
        } else {
            $error = 'Fel vid skapande av konto.';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Twitter - Skapa konto</title>
</head>
<body>
    <h1>Skapa ett nytt konto</h1>

    <?php if (isset($error)) {
        echo '<p>' . $error . '</p>';
    } ?>

    <form method="POST" action="skapakonto.php">
        <label>Användarnamn:</label>
        <input type="text" name="username" required><br>

        <label>Lösenord:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Skapa konto</button>
    </form>
</body>
</html>