<?php
session_start();

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// Hantera skapandet av tweet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rubrik = $_POST['rubrik'];
    $kommentar = $_POST['kommentar'];
    $lösenord = $_POST['lösenord'];

    // Validera rubrik, kommentar och lösenord

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

    // Kontrollera att lösenordet matchar användarens lösenord (från databasen)
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM användare WHERE användarnamn = '$username' AND lösenord = '$lösenord'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Spara tweeten i databasen
        $sql = "INSERT INTO tweets (rubrik, kommentar) VALUES ('$rubrik', '$kommentar')";

        if ($conn->query($sql) === TRUE) {
            // Tweeten har sparats, omdirigera till användarsidan
            header('Location: användarsida.php');
            exit;
        } else {
            $error = 'Fel vid skapande av tweet.';
        }
    } else {
        $error = 'Ogiltigt lösenord.';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Twitter - Skapa tweet</title>
    
</head>
<body>
    <h1>Skapa en ny tweet</h1>

    <?php if (isset($error)) {
        echo '<p>' . $error . '</p>';
    } ?>

    <form method="POST" action="skapatweet.php">
        <label>Rubrik:</label>
        <input type="text" name="rubrik" required><br>

        <label>Kommentar:</label>
        <input type="text" name="kommentar" required><br>

        <label>Lösenord:</label>
        <input type="password" name="lösenord" required><br>

        <button type="submit">Publicera tweet</button>
    </form>
</body>
</html>