<?php

include '../db/config.php';
include "validate_email.php";
session_start();
error_reporting(0);

if(empty($_SESSION['info'])){
    header("Location: reg1UA.php");
}

if(isset($_SESSION['info'])){
    extract($_SESSION['info']);



if (isset($_POST['submit'])) {
    //inserimento delle variabili

    $pw=md5($password);
    $cpw=md5($cpassword);
    $nomeAzienda=$_POST['nomeAzienda'];
    $nsedi=$_POST['nsedi'];
    $settore=$_POST['settore'];
    $ndipendenti=$_POST['ndipendenti'];
    $luogosedi=$_POST['luogosedi'];
    $codiceAteco=$_POST['codiceAteco'];

    //confronto delle password(pw,cpw)


    if(ValidateEmail($email)==='valid'){
    if($password == $cpassword){

        $sql = "SELECT * FROM jobint.user WHERE email='$email' and username='$username'" ;
        $result = mysqli_query($conn, $sql);
        if(!$result->num_rows > 0){
            $code=rand(999999,111111);
            $sql = "
            insert into jobint.user (email, password, typeuser, username,code) values ('$email','$pw','azienda','$username','$code');";
            $result = mysqli_query($conn, $sql);

            $sql= "select * from jobint.azienda where nome='$nomeAzienda'";
            $result= mysqli_query($conn,$sql);
            if(!$result->num_rows >0){


            $sql2 = "insert into jobint.azienda (nome, numeroSedi, numeroDipendenti, luogoSedi, idUser1)
            values ('$nomeAzienda', '$nsedi' , '$ndipendenti' ,'$luogosedi',(select iduser from user where email='$email'));";
            $sql3 = "insert into jobint.ateco (idCodiceATECO,codiceATECO, settore)
            values ((select idAzienda from azienda where nome='$nomeAzienda'),'$codiceAteco','$settore');";

            $result2 = mysqli_query($conn, $sql2);
            $result3 = mysqli_query($conn, $sql3);
            if ($result and $result2 and $result3) {

                $subject = "Profile Verification Code";
                $message = "Here is the verification code .$code.";
                $sender = "From: noreply.jobint@gmail.com ";
                if(mail($email, $subject, $message, $sender)){
                    echo"<script>alert('We have sent a passwrod reset otp to your email - $email')</script>";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: verificationcode.php');
                    exit();
                }else{
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
            echo "<script>alert('Email o username non disponibile.')</script>";}

        }else{  echo "<script>alert('Email o username non disponibile.')</script>"; }
            }else{
            echo"<script> alert('le password non corrispondono')</script>";}
    }else{
        echo "<script> alert('email non valida'); </script>";
        //header("Location: help.php");
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
    <title>Inserimento dati</title>
    <link href="css/reg1azienda.css" rel="stylesheet" type="text/css">
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
            <div class="title">
                <h1>Azienda</h1>
            </div>
        </div>
        <div class="menu">
            <nav>
                <a href="#">Contattaci</a>
                <a href="#">FAQ</a>
                <a href="index.php">Accedi</a>
            </nav>
        </div>
    </div>
    <div class="content">
        <div class="image-container">
            <img class="content-image" src="../Resource/registrazione-azienda-2.png">
        </div>
        <div class="form-container">
            <form action="" method="POST" required>
                <div class="input-group">
                    <p>Nome  dell'azienda</p>
                    <input type="text" name="nomeAzienda" required>
                </div>
                <div class="input-group">
                    <p>Numero di sedi</p>
                    <input type="number" name="nsedi" required>
                </div>
                <div class="input-group">
                    <p>Settore</p>
                    <input type="text" name="settore" required>
                </div>
                <div class="input-group">
                    <p>Numero di dipendenti</p>
                    <input type="number" name="ndipendenti" required>
                </div>
                <div class="input-group">
                    <p>Luogo delle sedi</p>
                    <input type="text" name="luogosedi" required>
                </div>
                <div class="input-group">
                    <p>Codice ATECO</p>
                    <input type="text" name="codiceATECO">


                </div>

                <div class="button">
                    <button type="submit" name="submit">Registrati</button>
                </div>


            </form>
        </div>
    </div>
</div>
</body>
</html>
