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
    <link href="css/style6.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">
</head>
<body>
<?php

$username = $_SESSION['username'];
$email= $_SESSION['email'];

$sql= "select * from user,azienda,ateco
where user.iduser=azienda.idUser1 and ateco.idCodiceATECO=azienda.idAzienda and username='$username' and email='$email'";
$result = mysqli_query($conn, $sql);
$resultcheck=mysqli_num_rows($result);
if($resultcheck > 0){
    while($row=mysqli_fetch_assoc($result)){
        $_SESSION['idAzienda']=$row['idAzienda'];
        $idAzienda=$row['idAzienda'];

        ?>
<div class="navbar">
    <div class="logo-container">
        <div class="logo">
            <img class="logo-img" src="../Resource/logo.png">
        </div>
        <div class="title-container">
            <h1 class="title">Azienda</h1>
        </div>
    </div>
    <div class="menu">
        <nav>
            <div onclick="location.href=' chat.php'" class="messaggi"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                </svg></div>
            <div onclick="location.href=' '" class="notifiche"><img src="../Resource/notification.png" alt="notifiche" id="notifiche"></div>
            <div onclick="location.href='logout.php '" class="home"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg></div>
        </nav>
    </div>
</div>
<div class="content">
    <div class="box-chat">
        <h2 style="font-family: 'Lato', sans-serif;">Persone a cui hai messo like</h2>
        <?php
        $sql = "select * from user,azienda,`like`,lavoratore,curriculum,professione
where `like`.idAzienda='$idAzienda' and  user.iduser=azienda.idUser1   and `like`.idAzienda=azienda.idAzienda
and `like`.idLavoratore=lavoratore.idlavoratore
and `like`.idLavoratore= curriculum.idLavoratore1
and professione.idlavoratore1=`like`.idLavoratore";

        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);
        if ($queryResult > 0) {
            while ($row1 = mysqli_fetch_assoc($result)) {

                echo "<div style='text-align: center'>
    &ensp;
    <h3>" . $row1["nome"] . " " . $row1["cognome"] . "</h3>

    <p>" . $row1['areaprofessionale'] . "  &ensp;     " . $row1['sottoarea'] . "   &ensp;      " . $row1['categoria'] . "</p>
   
    <form action='' method='post'>
        <button style='border: none; background: none; padding: 0;'><a  style='text-decoration: none' href='dettagli.php?id=".$row1['idlavoratore']."'>view</a></button>
        <button style='border: none; background: none; padding: 0;' > <a  style='text-decoration: none' href='Unlike.php?id=".$row1['idlavoratore']."' >unlike</a></button>
    </form>
</div>";

            }} ?>



    </div>
    <div class="destra">
        <div class="personale">
            <div class="titolo-personale">
                <h2 style="font-family: 'Lato', sans-serif;">Hai bisogno di personale?</h2>
            </div>
            <div class="bottone-personale">
                <button id="bottone-personale" type="button"><a id="a-personale" href="ricercaLavoratore.php">Cerca</a></button>
            </div>
        </div>
        <br>

        <div class="box-informazioni">
            <div class="informazioni-titolo">
                <h1 style="font-family: 'Lato', sans-serif;">Informazioni</h1>
            </div>
            <div class="informazioni-content" style="font-size: medium">
                <div class="informazioni">
                    <div class="title-group">
                        <p>Nome azienda:  </p>
                    </div>
                    <div class="title-group">
                        <p>N.dipendenti: </p>
                    </div>
                    <div class="title-group">
                        <p>Sedi: </p>
                    </div>
                    <div class="title-group">
                        <p>Settore:</p>
                    </div>
                </div>
                <div class="input-informazioni">
                    <div class="title-group">
                        <p><?= $row['nome'] ?></p>
                    </div>
                    <div class="title-group">
                        <p><?= $row['numeroDipendenti'] ?></p>
                    </div>
                    <div class="title-group">
                        <p><?= $row['settore'] ?></p>
                    </div>
                    <div class="title-group">
                        <p> <?= $row['luogoSedi'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php  } }?>








</body>
</html>