<?php

session_start();
include "../db/config.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ricerca lavoratore</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
<div class="container" style="text-align: center">
    <form action="ricercaLavoratore.php" method="post">
<h3> Ricerca lavoratore</h3>
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
<label for="">
    Area professionale <br>
    <select name="Area_professionale" id="Area_professionale"  class="form-control action" required >
        <option selected disabled>Area Professionale</option>
        <?php echo $area; ?>
    </select><br>
    <label for="">
        Sotto-area professionale <br>
        <select name="Sotto_area_professionale" id="Sotto_area_professionale" class="form-control action" >
            <option selected disabled>Sotto Area professionale</option>

        </select>
    </label><br><br>
    <label for="">
        Categoria Professionale <br>
        <select name="Categoria_professionale" id="Categoria_professionale" class="form-control" >
            <option selected disabled>Categoria professionale</option>

        </select><br>
        <button name="cerca">Cerca </button>
    
    </form>
<br>
        <a href="welcomeAzienda.php" style="text-decoration: none">Home</a>
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

                    echo "<div> 
        &ensp;
        <h3>" . $row["nome"] . " " . $row["cognome"] . "</h3> 
        
         <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p>
        
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

                    echo "<div> 
        &ensp;
        <h3>" . $row["nome"] . " " . $row["cognome"] . "</h3> 
        
         <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p>
        
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

                    echo "<div> 
        &ensp;
        <h3>" . $row["nome"] . " " . $row["cognome"] . "</h3> 
        
         <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p>
        
        </div>";
                }

            }
        }
       

    }?>
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