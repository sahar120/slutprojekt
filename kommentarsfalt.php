<?php
// Anslut till databasen
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'webbserverprogrammering';

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollera anslutningen
if ($conn->connect_error) {
    die('Kunde inte ansluta till databasen: ' . $conn->connect_error);
}

// Hämta användarens ID från inloggningen eller genom att skicka det som en parameter
$användarID = $_SESSION['user_id']; // Exempelvis från inloggningsprocessen eller via en parameter

// Hämta alla tweets för användaren från databasen
$sql = "SELECT * FROM tweets WHERE användar_id = $användarID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<h2>Mina tweets:</h2>';

    while ($row = $result->fetch_assoc()) {
        $tweetID = $row['tweet_id'];
        $tweetRubrik = $row['rubrik'];
        $tweetDatum = $row['datum'];
        $tweetTid = $row['tid'];

        echo '<div class="tweet">';
        echo '<h3>' . $tweetRubrik . '</h3>';
        echo '<p>Skapad: ' . $tweetDatum . ' ' . $tweetTid . '</p>';

        // Hämta kommentarer för tweeten från databasen baserat på tweetens ID
        $sql2 = "SELECT * FROM kommentarer WHERE tweet_id = $tweetID";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            echo '<h4>Kommentarer:</h4>';

            while ($row2 = $result2->fetch_assoc()) {
                $kommentarText = $row2['kommentar'];

                echo '<p>' . $kommentarText . '</p>';
            }
        }

        echo '</div>';
    }
}

$conn->close();
?>
