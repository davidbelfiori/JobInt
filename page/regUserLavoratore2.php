<?php
include '../db/config.php';

session_start();
error_reporting(0);




if (isset($_SESSION['info'])) {
    extract($_SESSION['info']);


    if (isset($_POST['submit'])) {
        $pw=md5($password);
        $cpw=md5($cpassword);
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        $dob=$_POST['dob'];
        $sesso=$_POST['sesso'];
        $cf=$_POST['cf'];
        $qualificatore=$_POST['qualificatore'];
        $indirizzo=$_POST['indirizzo'];
        $numeroCivico=$_POST['numeroCivico'];
        $comune=$_POST['Comune'];
        $provincia=$_POST['provincia'];
        $CAP=$_POST['CAP'];
        $citta=$_POST['Citta'];
        $nCell=$_POST['numeroCellulare'];
        $areaProfessionale=$_POST['Area_professionale'];
        $categoriaProfessionale=$_POST['Categoria_professionale'];
        $sottoAreaProfessionale=$_POST['Sotto_area_professionale'];
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $curriculum_name = $_FILES['curriculum']['name'];
        $curriculum_size = $_FILES['curriculum']['size'];
        $tmp_name1 = $_FILES['curriculum']['tmp_name'];

        if ($pw==$cpw) {
            $sql="select * from jobint.user where email='$email' and username='$username'";
            $result=mysqli_query($conn, $sql);
            if (!$result -> num_rows > 0) {
                $sql="select * from jobint.lavoratore where codicefiscale='$cf'";
                $result=mysqli_query($conn, $sql);
                if (!$result -> num_rows > 0) {
                    $sql="select * from jobint.lavoratore where tel='$ceell'";
                    $result=mysqli_query($conn, $sql);



                    if (!$result->num_rows > 0) {
                        if ($img_size<500000) {
                            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                            $img_ex_lc = strtolower($img_ex);
                            $allowed_exs = array("jpg", "jpeg", "png");

                            if (in_array($img_ex_lc, $allowed_exs)) {
                                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                                $img_upload_path = 'uploads/' . $new_img_name;
                                move_uploaded_file($tmp_name, $img_upload_path);

                                if ($curriculum_size<500000) {
                                    $curr_ex=pathinfo($curriculum_name, PATHINFO_EXTENSION);
                                    $curr_ex_lc=strtolower($curr_ex);
                                    $allowed_exs1 = array("pdf", "doc", "docx");

                                    if (in_array($curr_ex_lc, $allowed_exs1)) {
                                        $new_curr_name = uniqid("CURRICULUM-", true) . '.' . $curr_ex_lc;
                                        $curr_upload_path = '../curriculum/' . $new_curr_name;
                                        move_uploaded_file($tmp_name, $curr_upload_path);


                                        $sql = "insert into jobint.user (email, password, typeuser, username) values ('$email','$pw','Lavoratore','$username');";
                                        $res = mysqli_query($conn, $sql);


                                        $sql2 = "insert into lavoratore (nome, cognome, dob, sesso, codicefiscale, tel, idUser1) VALUES ('$nome','$cognome','$dob','$sesso','$cf','$nCell',(select jobint.user.iduser from user where username='$username' and email='$email'))";
                                        $res = mysqli_query($conn, $sql2);

                                        $sql3 = " insert into indirizzo (qualificatore, nomevia, ncivico, cap, comune, provincia, citta, idlavoratore1) 
                        values  ('$qualificatore','$indirizzo','$numeroCivico', '$CAP' ,'$comune','$provincia','$citta',(select idlavoratore from lavoratore where codicefiscale='$cf'))";
                                        $res = mysqli_query($conn, $sql3);

                                        $sql4 = "insert into professione (areaprofessionale, sottoarea, categoria, idlavoratore1) VALUES ('$areaProfessionale','$sottoAreaProfessionale','$categoriaProfessionale',(select idlavoratore from lavoratore where codicefiscale='$cf'))";
                                        $res = mysqli_query($conn, $sql4);

                                        $sql5 = "insert into user_image (image_url, idUser1) VALUES ('$new_img_name',(select jobint.user.iduser from user where username='$username' and email='$email'))";
                                        $res = mysqli_query($conn, $sql5);

                                        $sql6="insert into curriculum (pdf_url, idLavoratore1) VALUES ('$new_curr_name',(select idlavoratore from lavoratore where codicefiscale='$cf'))";
                                        $res = mysqli_query($conn, $sql6);


                                        if ($res) {
                                            echo "<script> alert('registrazione completata')</script>";
                                            header("location: index.php");
                                            exit;
                                        } else {
                                            echo mysqli_error($conn);
                                            echo "<script>alert('Qualcosa è andato storto.')</script>";
                                        }
                                    } else {
                                        echo "<script>alert('errore2 curriculum')</script>";
                                    }
                                } else {
                                    echo "<script>alert('errore1 curriculum')</script>";
                                }
                            } else {
                                echo "<script>alert('errore2')</script>";
                            }
                        } else {
                            echo "<script>alert('errore1')</script>";
                        }
                    } else {
                        echo "<script>alert('numero di telefono gia inserito')</script>";
                    }
                } else {
                    echo "<script>alert('Codice fiscale errato o gia inserito')</script>";
                }
            } else {
                echo  "<script>alert('username or email already used')</script>";
            }
        } else {
            echo "<script>alert('le password non corrispondono.')</script>";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrazione Lavoratore</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    
<form action="regUserLavoratore2.php" method="post" enctype="multipart/form-data">


    <label>
        <input type="file" name="my_image" placeholder="user image">
    </label> <br> <br>
<h3>Dati personali</h3><br>
<label for="Nome">
    Nome <br>
    <input type="text" name="nome" placeholder="nome" required>
</label>
<br><br>
<label for="Cognome">
    Cognome <br>
    <input type="text" name="cognome" placeholder="cognome" required>
</label>
<br><br>
<label for="dob">
    Data di Nascita <br>
    <input type="date" name="dob" placeholder="data di nascita">
</label> <br><br>
<label for="">
   Sesso <br>
<select name="sesso" id="" >
    <option selected></option>
    <option value="M"> M</option>
    <option value="F"> F</option>
</select>
</label><br><br>
<label for="cf">
    Codice fiscale <br>
    <input type="text" placeholder="Codice fiscale" name="cf"  maxlength="16" minlength="16"  required>
</label>
<br><br>
Qualificatore <br>
<select  name="qualificatore" aria-label="Default select example">
  <option selected></option>
  <option value="via">Via</option>
  <option value="piazza">Piazza</option>
  <option value="largo">Largo</option>
</select><br><br>
<label for="indirizzo">
    indirizzo <br>
    <input type="text" name="indirizzo" placeholder="indirizzo" required>
</label>
<br><br>
<label for="numero civico">
    Numero Civico <br>
    <input type="number" name="numeroCivico" placeholder="Numero Civico" required>
</label>
<br><br>
<label for="Comune">
    Comune <br>
    <input type="text" name="Comune" placeholder="Comune" required>
</label>
<br><br>
<label for="Provincia">
    Provincia <br>
    <input type="text" name="provincia" placeholder="Provincia" required>
</label>
<br><br>
<label for="CAP">
    CAP <br>
    <input type="number" name="CAP" placeholder="CAP" required>
</label>
<br><br>
    <label for="citta">
        Citta<br>
        <input type="text" name="Citta" placeholder="Città" required>
    </label>
    <br><br>
<label for="numero civico">
    Numero cellulare <br>
    <input type="text" name="numeroCellulare" placeholder="Numero cellulare" maxlength="10" required>
</label>
<br><br>
<label for="">
    Area professionale <br>
<select name="Area_professionale" id="" >
    <option selected>/option>
    <option value="it e digital"> it e digital</option>
</select><br><br>
<label for="">
   Sotto-area professionale <br>
<select name="Sotto_area_professionale" id="" >
    <option selected></option>
    <option value="Analisi | sviluppo | web">Analisi | sviluppo | web</option>
</select>
</label><br><br>
<label for="">
   Categoria Professionale <br>
<select name="Categoria_professionale" id="" >
    <option selected></option>
    <option value="Programmatore Java"> Programmatore Java</option>
    <option value="Programmatore Php">Programmatore Php</option>
</select>
    <br>
    <br>
    <label>
        <input type="file" name="curriculum" placeholder="user image">
    </label> <br> <br>

<button class="button" type="submit" name="submit"><a class="button-a">Registrati</a></button>
</form>

</body>
</html>
