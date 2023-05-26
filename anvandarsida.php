<?php
session_start();

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// Logga ut användaren
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Twitter - Användarsida</title>
   
</head>
<body>
    <h1>Välkommen, <?php echo $_SESSION['username']; ?></h1>

    <a href="användarsida.php?logout=true">Logga ut</a>

</body>
</html>