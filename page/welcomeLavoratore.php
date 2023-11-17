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
    <link rel="stylesheet" href="css/bozza-home-lavoratore.css">


    <title>JobInt Lavoratore</title>
</head>
<body>

<?php


$username = $_SESSION['username'];
$email = $_SESSION['email'];

$sql = "select * from user,user_image,curriculum,lavoratore,professione,indirizzo
where user.username='$username' and user.email='$email'
and user.iduser=lavoratore.idUser1
and user_image.idUser1=user.iduser
and lavoratore.idlavoratore=curriculum.idLavoratore1
and indirizzo.idlavoratore1=lavoratore.idlavoratore
and professione.idlavoratore1=lavoratore.idlavoratore
";
$res = mysqli_query($conn, $sql);
$rescheck = mysqli_num_rows($res);

if($rescheck > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $_SESSION['idlavoratore'] = $row['idlavoratore'];
        if(isset($_POST['view_pdf'])) {
            $file_name = $row['pdf_url'];

            header("content-type: application/pdf");
            readfile("uploads/curriculum/$file_name");
        }



        ?>

        <div class="container">
            <div class="navbar">
                <div class="logo-container">
                    <div class="logo">
                        <img class="logo-image" src="../Resource/logo.png">
                    </div>
                    <div class="title-container">
                        <h1>Lavoratore</h1>
                    </div>
                </div>
                <div class="menu">
                    <nav>
                        <div onclick="location.href=' chat.php'" class="home"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                            </svg></div>
                        <div onclick="location.href=' help.php'" class="home"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-question-octagon" viewBox="0 0 16 16">
                                <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                            </svg></div>
                        <div onclick="location.href='logout.php '" class="home"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
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

                                <form action="" method="post">
                                    <button name="view_pdf" class="pdf-image">  <img class="pdf-image" src="../Resource/pdf.png"></button>
                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="destra">
                        <div class="sopra-destra">
                            <h3><?= $row['nome'] ?> <?=$row['cognome'] ?></h3>
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





    <?php }
    } ?>


</body>
</html>
