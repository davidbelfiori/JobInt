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
        $_SESSION['idAzienda']=$row['idAzienda']; ?>


        <h3> Benvenuta Azienda: id. <?= $row['iduser'] ?> </h3>
        Nome Azienda: <?= $row['nomeAzienda'] ?><br>
        N. dipendenti: <?= $row['numeroDipendenti'] ?><br>
        Settore: <?= $row['settore'] ?><br>
        Sedi: <?= $row['luogoSedi'] ?><br>



  <?php
    }
}?>

<h4>Hai bisogno di personale?</h4>
<button style='border: none; background: none; padding: 0;'><a href="ricercaLavoratore.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg></a></button>
<br><br>
<button style='border: none; background: none; padding: 0;' ><a href="logout.php" style="text-decoration: none">Logout</a></button>
<a style='text-decoration: none' href='likeProfili.php'>Like</a>
<a style='text-decoration: none' href='chat.php'>chat</a>
</body>
</html>