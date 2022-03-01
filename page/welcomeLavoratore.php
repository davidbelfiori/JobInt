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
    <link rel="stylesheet" href="css/welcomeLavoratoreStyle.css">
    <title>JobInt Lavoratore</title>
</head>
<body>
<?php echo "<h1>Welcome " . $_SESSION['username'] ."</h1>"; ?>
<?php


$username = $_SESSION['username'];
$email= $_SESSION['email'];

$sql="select * from user,user_image,curriculum,lavoratore,professione,indirizzo
where user.username='$username' and user.email='$email'
and user.iduser=lavoratore.idUser1
and user_image.idUser1=user.iduser
and lavoratore.idlavoratore=curriculum.idLavoratore1
and indirizzo.idlavoratore1=lavoratore.idlavoratore
and professione.idlavoratore1=lavoratore.idlavoratore
";
$res = mysqli_query($conn, $sql);
$rescheck= mysqli_num_rows($res);

if ($rescheck>0) {
    while ($row = mysqli_fetch_assoc($res)) {
        ?>
        <div class="user-image">
        <img src="uploads/userimage/<?=$row['image_url']?>">
        </div>

        <h1>Benvenuto Lavoratore: id.<?= $row['iduser'] ?> </h1>
        <h2>Nome: <?= $row['nome'] ?> </h2>
       <h2> Cognome: <?= $row['cognome'] ?></h2>
        Sesso: <?= $row['sesso'] ?> <br>
        Data di Nascita: <?= $row['dob'] ?> <br>
        Città: <?= $row['citta'] ?> <br>
        Professione: <?= $row['areaprofessionale'] ?> <br>
        Sotto-area: <?= $row['sottoarea'] ?> <br>
        Categoria: <?= $row['categoria'] ?> <br>
        <button><a href="uploads/curriculum/<?= $row['pdf_url']?>">pfd</a></button>
        <br>

    <?php
    }
} ?>







<a href="logout.php">Logout</a>
</body>
</html>
