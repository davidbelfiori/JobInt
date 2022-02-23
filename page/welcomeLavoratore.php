<?php

session_start();

include "../db/config.php";

if (!isset($_SESSION['username'],$_SESSION['email'])) {
    header("Location: index.php");
}

$username = $_SESSION['username'];
$email= $_SESSION['email'];

$sql="select * from user,user_image,curriculum,lavoratore,professione,indirizzo
where user.username='$username' and user.email='$username'
and user.iduser=lavoratore.idUser1
and user_image.idUser1=user.iduser
and lavoratore.idlavoratore=curriculum.idLavoratore1
and indirizzo.idlavoratore1=lavoratore.idlavoratore
and professione.idlavoratore1=lavoratore.idlavoratore
";
$res = mysqli_query($conn,$sql);




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