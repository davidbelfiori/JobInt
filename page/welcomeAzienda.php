<?php

session_start();
include "../db/config.php";
if (!isset($_SESSION['username'],$_SESSION['email'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobInt Azienda</title>
</head>
<body>
<?php

$username = $_SESSION['username'];
$email= $_SESSION['email'];

$sql= "select * from user,azienda,ateco
where user.iduser=azienda.idUser1 and ateco.idCodiceATECO=azienda.idAzienda and username='$username' and email='$email'";
$result = mysqli_query($conn, $sql);
$resultcheck=mysqli_num_rows($result);
if ($resultcheck > 0) {
    while ($row=mysqli_fetch_assoc($result)) {
        ?>

        <H1> Benvenuta Azienda: id. <?= $row['iduser'] ?> </H1>
        Nome Azienda: <?= $row['nomeAzienda'] ?><br>
        N. dipendenti: <?= $row['numeroDipendenti'] ?><br>
        Settore: <?= $row['settore'] ?><br>
        Sedi: <?= $row['luogoSedi'] ?><br>



  <?php
    }
}?>


<a href="logout.php">Logout</a>
</body>
</html>