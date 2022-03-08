<?php
session_start();
include "../db/config.php";
$username = $_SESSION['username'];
$email= $_SESSION['email'];

if(isset($_GET['id'])){

    $idlavoratore=$_GET['id'];

    $sql= "select * from user,user_image,curriculum,lavoratore,professione,indirizzo
where lavoratore.idlavoratore='$idlavoratore'
and user.iduser=lavoratore.idUser1
and user_image.idUser1=user.iduser
and lavoratore.idlavoratore=curriculum.idLavoratore1
and indirizzo.idlavoratore1=lavoratore.idlavoratore
and professione.idlavoratore1=lavoratore.idlavoratore";

    $res = mysqli_query($conn,$sql);
    $rescheck= mysqli_num_rows($res);

if($rescheck>0){
    while ($row = mysqli_fetch_assoc($res)){
        if(isset($_POST['view_pdf'])){
            $file_name=$row['pdf_url'];

            header("content-type: application/pdf");
            readfile("uploads/curriculum/$file_name");
        }

        if(isset($_POST['like'])){

            $sql= "select * from user,azienda,ateco
            where user.iduser=azienda.idUser1 and ateco.idCodiceATECO=azienda.idAzienda and username='$username' and email='$email'";
            $result = mysqli_query($conn, $sql);
            while($row1 = mysqli_fetch_array($result))
            {

              $lavoratorenome=$row['nome'];
              $lavoratorecognome=$row['cognome'];
              $nomeAzienda=$row1['nomeAzienda'];
              $settore=$row1['settore'];
              $emaillavoratore=$row['email'];

            $subject = "Interessi ad una azienda!";
            $message = "Ciao Lavoratore: $lavoratorenome $lavoratorecognome \n l'azienda $nomeAzienda che lavora nel settore $settore ha manifestato il suo interesse per te. \n Buona fortuna dal team JobInt";
            $sender = "From: noreply.jobint@gmail.com";
            if(!mail($emaillavoratore, $subject, $message, $sender)){
                echo "<script>alert('Failed while sending email!')</script>";
            }}

        }

        ?>
        <div class="user-image" style="width: 200px;
    height: 120px;">
            <img src="uploads/userimage/<?=$row['image_url']?>" alt="" style="   width: 100%;
    height: auto;">
        </div>

        <p> <b> <?= $row['nome'] ?> <?= $row['cognome'] ?></b> </p>
        Sesso: <?= $row['sesso'] ?> <br>
        Data di Nascita: <?= $row['dob'] ?> <br>
        Città: <?= $row['citta'] ?> <br>
        Professione: <?= $row['areaprofessionale'] ?> <br>
        Sotto-area: <?= $row['sottoarea'] ?> <br>
        Categoria: <?= $row['categoria'] ?> <br>
        Contact: <a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>

        <form action="" method="post">
            <button name="view_pdf"  style="border: none; background: none; padding: 0;"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                    <path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.517.517 0 0 1 .145-.04c.013.03.028.092.032.198.005.122-.007.277-.038.465z"/>
                    <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.651 11.651 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.856.856 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.844.844 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.76 5.76 0 0 0-1.335-.05 10.954 10.954 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.238 1.238 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a19.697 19.697 0 0 1-1.062 2.227 7.662 7.662 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103z"/>
                </svg></button>
        </form>
        <form action="" method="post">
      <a href="ricercaLavoratore.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg></a>

        <button name="like" style="border: none; background: none; padding: 0"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
        </svg></button>
        </form>


    <?php }} }?>
