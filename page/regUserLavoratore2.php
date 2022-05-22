<?php
include '../db/config.php';
include "validate_email.php";

session_start();
error_reporting(0);

//controllo se sono state compilate le informazioni alla pagina precedente

/*if(empty($_SESSION['info'])){
    header("Location: regUserLavoratore.php");
}*/


if (isset($_SESSION['info'])) {
    //estrazione informazioni array info
    extract($_SESSION['info']);


    if (isset($_POST['submit'])) {
        //crittografia delle password Hash
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

        //controllo attraverso funzione se l'email è valida
        if (ValidateEmail($email)==='valid') {

        //confronto e controllo tra password e conferma password
            if ($pw==$cpw) {

        //controllo se le credenziali inserite esistono gia nel db
                $sql="select * from jobint.user where email='$email' and username='$username'";
                $result=mysqli_query($conn, $sql);
                if (!$result -> num_rows > 0) {

        //controllo attraverso il cf se il lavoratore è gia stato inserito nel sistema
                    $sql="select * from jobint.lavoratore where codicefiscale='$cf'";
                    $result=mysqli_query($conn, $sql);
                    if (!$result -> num_rows > 0) {

            //controllo se il numero di telefono è gia presente nel sistema
                        $sql="select * from jobint.lavoratore where tel='$ceell'";
                        $result=mysqli_query($conn, $sql);



                        if (!$result->num_rows > 0) {
                            $today = date("Y-m-d");
                            $diff = date_diff(date_create($dob), date_create($today));
                            $age= $diff->format('%y');
                            if ($age>18) {
                                echo "<script>alert('minore')</script>";


                                //controllo della grandezza del immagine
                                if ($img_size<5000000) {
                                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                                    $img_ex_lc = strtolower($img_ex);
                                    $allowed_exs = array("jpg", "jpeg", "png");

                                    //controllo estenzione immagine
                                    if (in_array($img_ex_lc, $allowed_exs)) {
                                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                                        $img_upload_path = 'uploads/userimage/' . $new_img_name;
                                        move_uploaded_file($tmp_name, $img_upload_path);
                                        //controllo grandezza curriculum
                                        if ($curriculum_size<500000) {
                                            $curr_ex=pathinfo($curriculum_name, PATHINFO_EXTENSION);
                                            $curr_ex_lc=strtolower($curr_ex);
                                            $allowed_exs1 = array("pdf", "doc", "docx");
                                            //controllo estenzione file
                                            if (in_array($curr_ex_lc, $allowed_exs1)) {
                                                $new_curr_name = uniqid("CURRICULUM-", true) . '.' . $curr_ex_lc;
                                                $curr_upload_path = 'uploads/curriculum/' . $new_curr_name;
                                                move_uploaded_file($tmp_name1, $curr_upload_path);

                                                //generazione codice randomico da inviare come otp
                                                $code=rand(999999, 111111);

                                                //inizio fase di iserimeto dati nel db

                                                //inserimento dati tab user
                                                $sql = "insert into jobint.user (email, password, typeuser, username,code) values ('$email','$pw','Lavoratore','$username','$code');";
                                                $res = mysqli_query($conn, $sql);

                                                //inserimeto dati tab lavoratore
                                                $sql2 = "insert into lavoratore (nome, cognome, dob, sesso, codicefiscale, tel, idUser1) VALUES ('$nome','$cognome','$dob','$sesso','$cf','$nCell',(select jobint.user.iduser from user where username='$username' and email='$email'))";
                                                $res = mysqli_query($conn, $sql2);

                                                //inserimento dati tab indirizzo
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

                           //inizio procedura invio codice otp
                                                    $subject = "Profile Verification Code";
                                                    $message = "Here is the verification code .$code.";
                                                    $sender = "From: noreply.jobint@gmail.com ";
                                                    if (mail($email, $subject, $message, $sender)) {
                                                        echo"<script>alert('We have sent a passwrod reset otp to your email - $email')</script>";
                                                        $_SESSION['info'] = $info;
                                                        $_SESSION['email'] = $email;
                                                        header('location: verificationcode.php');
                                                        exit();
                                                    } else {
                                                        echo "<script>alert('Failed while sending code!')</script>";
                                                    }


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
                                echo "<script>alert('minore di 18 anni ')</script>";
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
        } else {
            echo "<script>alert('email non valida')</script>";
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
    <title>JobInt lavoratore</title>
    <link href="css/regUserLavoratore2.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="navbar">
        <div class="logo-container">
            <div class="logo">
                <img class="logo-image" src="../Resource/logo.png">
            </div>
            <div class="title-container">
                <h1 class="title">Lavoratore</h1>
            </div>
        </div>
        <div class="menu">
            <nav>
                <a class="menu-a" href="help.php">Contattaci</a>
                <a class="menu-a" href="#">FAQ</a>
                <a class="menu-a" href="index.php">Accedi</a>
            </nav>
        </div>
    </div>
    <div class="content">
        <div class="form-container">
            <form class="registration-form" action="" method="POST" enctype="multipart/form-data">
                <b><p>Dati personali</p></b>
                <div class="input-group">
                    <p>Nome</p>
                    <input class="input" type="text" name="nome">
                </div>
                <div class="input-group">
                    <p>Cognome</p>
                    <input class="input" type="text" name="cognome">
                </div>
                <div class="input-group">
                    <p>Data di nascita</p>
                    <input type="date" name="dob" id="data">
                </div>
                <div>
                    <p>Sesso</p>
                    <select name="sesso" id="" >
                        <option selected></option>
                        <option value="M"> M</option>
                        <option value="F"> F</option>
                    </select>
                </div>
                <div class="input-group">
                    <p>Codice fiscale</p>
                    <input class="input" type="text" name="cf">
                    <div class="input-group">
                        <b><p>Dati di contatto</p></b>
                        <select name="qualificatore">
                            <option value="indirizzo" disabled="disabled" selected>
                                Via/Piazza
                            </option>
                            <option value="via">
                                Via
                            </option>
                            <option value="piazza">
                                Piazza
                            </option>
                        </select>
                        <br>
                        <input class="input" type="text" name="indirizzo">
                    </div>
                    <div class="input-group">
                        <p>Numero civico</p>
                        <input class="input" type="text" name="numeroCivico">
                    </div>
                    <div class="input-group">
                        <p>Comune</p>
                        <input class="input" type="text" name="Comune">
                    </div>
                    <div class="input-group">
                        <p>Provincia</p>
                        <input class="input" type="text" name="provincia" maxlength="2">
                    </div>
                    <div class="input-group">
                        <p>CAP</p>
                        <input class="input" type="text" name="CAP" maxlength="5">
                    </div>
                    <div class="input-group">
                        <p>
                            Città
                        </p>
                        <input class="input" type="text" name="Citta">
                    </div>
                    <div class="input-group">
                        <p>Numero di cellulare</p>
                        <input class="input" type="text" name="numeroCellulare" maxlength="10"
                    </div>
                    <div class="input-group">
                        <b>
                            <p>
                                Professioni d'interesse
                            </p>
                        </b>
                        <?php

                        $area = '';
                        $query = "SELECT area FROM categoriaprofessionale GROUP BY area ORDER BY area ASC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            $area .= '<option value="'.$row["area"].'">'.$row["area"].'</option>';
                        }
                        ?>
                        <div class="input-group">
                            <p>Area professionale</p>
                            <select name="Area_professionale" id="Area_professionale"  class="form-control action" required >
                                <option selected disabled>Area Professionale</option>
                                <?php echo $area; ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <p>Sotto-area professionale</p>
                            <select name="Sotto_area_professionale" id="Sotto_area_professionale" class="form-control action" required>
                                <option selected disabled>Sotto Area professionale</option>

                            </select>
                        </div>
                        <div class="input-group">
                            <p>Categoria Professionale</p>
                            <select name="Categoria_professionale" id="Categoria_professionale" class="form-control" required>
                                <option selected disabled>Categoria professionale</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <p>Allegato PDF curriculum</p>
                        <input class="aggiungi"  type="file" id="myfile" name="curriculum" accept="application/pdf" required>
                    </div>
                    <br>
                    <div class="input-group">
                        <p>Immagine profilo</p>
                        <input class="aggiungi"   type="file" name="my_image" placeholder="user image" required >

                    </div>
                    <br>
                    <div class="input-group" id="datipersonali">
                        <p style="width: 60%"> Autorizzo il trattamento dei miei dati personali ai sensi del D. Lgs. 196/2003, come modificato dal D. Lgs. 101/2018 e ai sensi del Regolamento UE 2016/679 (GDPR)</p>
                        <input type="checkbox" name="gdpr" required>Accetto
                    </div>
                    <br>
                    <br>
                    <div class="input-group" id="bottone">
                        <button type="submit" name="submit"><a class="button-a">Registrati</a></button>
                    </div>

            </form>
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
