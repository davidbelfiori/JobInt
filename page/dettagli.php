<?php
session_start();
include "../db/config.php";
$username = $_SESSION['username'];
$email= $_SESSION['email'];

if (isset($_GET['id'])) {
    $idlavoratore=$_GET['id'];

    $sql= "select * from user,user_image,curriculum,lavoratore,professione,indirizzo
where lavoratore.idlavoratore='$idlavoratore'
and user.iduser=lavoratore.idUser1
and user_image.idUser1=user.iduser
and lavoratore.idlavoratore=curriculum.idLavoratore1
and indirizzo.idlavoratore1=lavoratore.idlavoratore
and professione.idlavoratore1=lavoratore.idlavoratore";

    $res = mysqli_query($conn, $sql);
    $rescheck= mysqli_num_rows($res);

    if ($rescheck>0) {
        while ($row = mysqli_fetch_assoc($res)) {
            if (isset($_POST['view_pdf'])) {
                $file_name=$row['pdf_url'];

                header("content-type: application/pdf");
                readfile("uploads/curriculum/$file_name");
            }

            if (isset($_POST['like'])) {
                $sql= "select * from user,azienda,ateco
            where user.iduser=azienda.idUser1 and ateco.idCodiceATECO=azienda.idAzienda and username='$username' and email='$email'";
                $result = mysqli_query($conn, $sql);
                while ($row1 = mysqli_fetch_array($result)) {
                    $idAzienda=$row1['idAzienda'];

                    $lavoratorenome=$row['nome'];
                    $lavoratorecognome=$row['cognome'];
                    $nomeAzienda=$row1['nome'];
                    $settore=$row1['settore'];
                    $emaillavoratore=$row['email'];

                    $sql3="select * from `like` where idAzienda='$idAzienda' and idLavoratore='$idlavoratore'";
                    $result=mysqli_query($conn, $sql3);
                    if ($result->num_rows>0) {
                        echo "like gia messo";
                        header('location: ricercaLavoratore.php');
                    } else {
                        $sql2="insert into `like` (idAzienda, idLavoratore) VALUES ('$idAzienda','$idlavoratore')";
                        $res1=mysqli_query($conn, $sql2);

                        $subject = "Interessi ad una azienda!";
                        $message = "Ciao Lavoratore: $lavoratorenome $lavoratorecognome \n l'azienda $nomeAzienda che lavora nel settore $settore ha manifestato il suo interesse per te. \n Buona fortuna dal team JobInt";
                        $sender = "From: jobint.help@gmail.com";
                        if (!mail($emaillavoratore, $subject, $message, $sender)) {
                            echo "<script>alert('Failed while sending email!')</script>";
                        }
                    }
                }
            } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dettagli_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">
    <title>JobInt Lavoratore</title>
</head>

<body>
<div class="container">
<div class="navbar">
    <div class="logo-container">
        <div class="logo">
            <img class="logo-image" src="../Resource/logo.png">
        </div>
        <div class="title-container">
            <h1>Azienda</h1>
        </div>
    </div>
    <div class="menu">
        <nav>
            <div onclick="location.href=' chat.php'" class="home"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                </svg></div>
            <div onclick="location.href=' '" class="home"><img src="../Resource/search-interface-symbol.png" alt="search" id="cerca"></div>
            <div onclick="location.href='welcomeAzienda.php '" class="home"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg></div>
        </nav>
    </div>
</div>
    <div class="content">
        <div class="container-utente">
            <div class="sinistra">
                <div class="sopra-sinistra">


                    <img src="uploads/userimage/<?=$row['image_url']?>" alt="Avatar" style="width: 150px;height: 150px; border-radius: 50% ;overflow: hidden;">


                </div>
                <div class="sotto-sinistra">
                    <div class="titolo-utente">
                        <h3 style="font-family: 'Lato', sans-serif;">Visualizza curriculum</h3>
                    </div>
                    <div class="immagine-curriculum">
<nav>
                        <form action="" method="post">
                            <button name="view_pdf" class="pdf-image">  <img class="pdf-image" src="../Resource/pdf.png"></button>
                            <button name="like" style="border: none; background: none"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                </svg></button>
                        </form>
                        </nav>

                    </div>
                </div>
            </div>
            <div class="destra">
                <div class="sopra-destra">
                    <h2 style=" font-family: 'Lato', sans-serif;"><?= $row['nome']?> <?= $row['cognome']?></h2>
                </div>
                <div class="sotto-destra">
                    <div class="descrizione">
                        <p>
                            Sesso: <?= $row['sesso'] ?>
                        </p>
                        <p>
                            Data di nascita:   <?= $row['dob'] ?>
                        </p>
                        <p>
                            Città: <?= $row['citta'] ?>
                        </p>
                        <p>
                            Professione: <?= $row['areaprofessionale'] ?>
                        </p>
                        <p>
                            Sotto-area: <?= $row['sottoarea'] ?>
                        </p>
                        <p>
                            Categoria: <?= $row['categoria'] ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>






</body>
    <?php
        }
    }
}?>

</html>