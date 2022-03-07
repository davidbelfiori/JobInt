<?php
session_start();
include "../db/config.php";

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
            } ?>
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
            <button name="view_pdf">Curriculum</button>
        </form>

      <a href="ricercaLavoratore.php">ricerca</a>
    <?php
        }
    }
}?>
