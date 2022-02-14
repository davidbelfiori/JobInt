<?php

session_start();

if (!isset($_SESSION['username'],$_SESSION['email'])) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobInt Lavoratore</title>
</head>
<body>
<?php echo "<h1>Welcome " . $_SESSION['username'] ."</h1>"; ?>
<?php echo "<h1>la tua email è: " . $_SESSION['email'] ."</h1>"; ?>
<a href="logout.php">Logout</a>
</body>
</html>