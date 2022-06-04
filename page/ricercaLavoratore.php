<?php

session_start();
include "../db/config.php";
$username = $_SESSION['username'];
$email= $_SESSION['email'];

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ricerca lavoratore</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- CSS only -->
    <link href="css/ricercastyle.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

</head>

<body>
<div class="container">
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
            <div onclick="location.href=' chat.php'" class="messaggi"><img src="../Resource/email.png" alt="messaggi" id="messaggi"></div>
            <div onclick="location.href=' '" class="notifiche"><img src="../Resource/notification.png" alt="notifiche" id="notifiche"></div>
            <div onclick="location.href='welcomeAzienda.php'" class="notifiche"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg></div>


        </nav>
    </div>
</div>

    <?php
    // $con = mysqli_connect("localhost", "admin", "admin", "countrydb");
    $area = '';
    $query = "SELECT area FROM categoriaprofessionale GROUP BY area ORDER BY area ASC";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $area .= '<option value="'.$row["area"].'">'.$row["area"].'</option>';
    }
    ?>

<div class="content" >
<div class="container-ricerca">
<div class="sinistra">
    <div class="input-group">
    <p class="sinistra-titolo"> Ricerca lavoratore</p>
</div>
    <form action="ricercaLavoratore.php" method="post">
   <div class="input-group">
       <p> Area professionale </p>
        <select name="Area_professionale" id="Area_professionale"  class="form-control action" required >
            <option selected disabled>Area Professionale</option>
            <?php echo $area; ?>
        </select></div>
        <div class="input-group">
           <p> Sotto-area professionale </p>
            <select name="Sotto_area_professionale" id="Sotto_area_professionale" class="form-control action" >
                <option selected disabled>Sotto Area professionale</option>

            </select>
        </div>
        <div class="input-group">
          <p>  Categoria Professionale</p>
            <select name="Categoria_professionale" id="Categoria_professionale" class="form-control" >
                <option selected disabled>Categoria professionale</option>

            </select></div><br>
            <button name="cerca" style="border-radius: 50px;
    background-color: black;
    border-style: none; color: white; width: 80px;">Cerca </button>

            </form>

</div>




<div class="destra" style="overflow:auto;">

    <?php
    if (isset($_POST['cerca'])) {

        $areaProfessionale = null;
        $categoriaProfessionale = null;
        $sottoAreaProfessionale = null;

        if (isset($_POST['Area_professionale']) and empty($_POST['Categoria_professionale']) and empty($_POST['Sotto_area_professionale'])) {
            $areaProfessionale = $_POST['Area_professionale'];

            $sql1 = "select * from professione,user,user_image,curriculum,lavoratore
    where user.iduser=lavoratore.idUser1
    and user_image.idUser1=user.iduser
    and lavoratore.idlavoratore=curriculum.idLavoratore1
    and professione.idlavoratore1=lavoratore.idlavoratore
    and professione.areaprofessionale='$areaProfessionale'";

            $result1 = mysqli_query($conn, $sql1);
            $queryResult1 = mysqli_num_rows($result1);
            if ($queryResult1 > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {


                    echo " <div class='persone'>
        <div class='circle'> </div>
       <div class='descrizione'>
       <div class='nome'> <p>" . $row["nome"] . " " . $row["cognome"] . "</p> </div>
        
       <div class='campo'> <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p></div> </div>
        <div class='azioni'>  <a style='text-decoration: none' href='dettagli.php?id=".$row['idlavoratore']."'><img src='../Resource/view.png' id='notifiche' ></a> </div>
        </div>";
                }

            }


        }

        if (isset($_POST['Area_professionale']) and isset($_POST['Sotto_area_professionale']) and empty($_POST['Categoria_professionale'])) {
            $areaProfessionale = $_POST['Area_professionale'];
            $sottoAreaProfessionale = $_POST['Sotto_area_professionale'];
            $sql1 = "select * from professione,user,user_image,curriculum,lavoratore
    where user.iduser=lavoratore.idUser1
    and user_image.idUser1=user.iduser
    and lavoratore.idlavoratore=curriculum.idLavoratore1
    and professione.idlavoratore1=lavoratore.idlavoratore
    and professione.areaprofessionale='$areaProfessionale'
    and professione.sottoarea='$sottoAreaProfessionale'";

            $result1 = mysqli_query($conn, $sql1);
            $queryResult2= mysqli_num_rows($result1);
            if ($queryResult2 > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {

                    echo "<div class='persone'>
        <div class='circle'> </div>
       <div class='descrizione'>
       <div class='nome'> <p>" . $row["nome"] . " " . $row["cognome"] . "</p> </div>
        
       <div class='campo'> <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p></div> </div>
        <div class='azioni'>  <a style='text-decoration: none' href='dettagli.php?id=".$row['idlavoratore']."'><img src='../Resource/view.png' id='notifiche' ></a> </div>
        </div>";
                }

            }


        }
        if (isset($_POST['Area_professionale']) and isset($_POST['Sotto_area_professionale']) and isset($_POST['Categoria_professionale'])) {
            $areaProfessionale = $_POST['Area_professionale'];
            $sottoAreaProfessionale = $_POST['Sotto_area_professionale'];
            $categoriaProfessionale = $_POST['Categoria_professionale'];
            $sql = "select * from professione,user,user_image,curriculum,lavoratore
        where user.iduser=lavoratore.idUser1
        and user_image.idUser1=user.iduser
        and lavoratore.idlavoratore=curriculum.idLavoratore1
        and professione.idlavoratore1=lavoratore.idlavoratore
        and professione.areaprofessionale='$areaProfessionale'
        and professione.sottoarea='$sottoAreaProfessionale'
        and categoria='$categoriaProfessionale'";

            $result = mysqli_query($conn, $sql);
            $queryResult = mysqli_num_rows($result);
            if ($queryResult > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<div class='persone'>
        <div class='circle'> </div>
       <div class='descrizione'>
       <div class='nome'> <p>" . $row["nome"] . " " . $row["cognome"] . "</p> </div>
        
       <div class='campo'> <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p></div> </div>
        <div class='azioni'>  <a style='text-decoration: none' href='dettagli.php?id=".$row['idlavoratore']."'><img src='../Resource/view.png' id='notifiche' ></a> </div>
        </div>";
                }

            }
        }


    }?>
    
</div>
</div>
</div>
        </body>
        </html>
<script>
    $(document).ready(function(){
        $('.action').change(function(){
            if($(this).val() != '')
            {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == "Area_professionale")
                {
                    result = 'Sotto_area_professionale';
                }
                else
                {
                    result = 'Categoria_professionale';
                }
                $.ajax({
                    url:"fetchdata.php",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data){
                        $('#'+result).html(data);
                    }
                })
            }
        });
    });
</script>