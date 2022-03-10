<?php
include "validate_email.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $subject=$_POST['subject'];
    $problema=$_POST['problema'];



    if (ValidateEmail($email)==='valid') {
        $to="jobint.help@gmail.com";

        $headers="Form:".$email;
        $message="Hai ricevuto una email da ".$username.".\n\n ".$problema;

        if (isset($username) and isset($email) and isset($subject) and isset($problema)) {
            if (mail($to, $subject, $message, $headers)) {
                $subject = "Jobint Help";
                $message = "Grazie per averci contattato" .$username.".\n\n La tua richiesta:  ".$problema."\n\n Con i tuoi feedback rendiamo JobInt migliore";
                $sender = "From: jobint.help@gmail.com ";
                if (mail($email, $subject, $message, $sender)) {
                    header("Location: index.php");
                    exit();
                }
            } else {
                echo "<script> alert('errore1')</script>";
            }
        } else {
            echo "<script> alert('si prega di compilare gli spazi vuoti')</script>";
        }
    } else {
        echo "<script> alert('email non valida'); </script>";
        //header("Location: help.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobInt Help</title>
    <link href="css/help.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="nav">
        <div class="logo-container">
            <img class="logo" src="../Resource/logo.png">
        </div>
        <div class="title-container">
            <h1 class="title">Help</h1>
        </div>
    </div>
    <div class="content">
        <div class="image-container">
            <img class="content-image" src="../Resource/undraw_Active_support_re_b7sj.png">
        </div>
        <div class="form-container">
            <form class="form" action="" method="POST" required autocomplete="off">
                <div class="input-group">
                    <input type="text" placeholder="Nome Utente" name="username" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email " name="email" required>
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Oggetto" name="subject" required>
                </div>
                <div class="input-group-1">
                    <textarea  placeholder="Descrivi il tuo problema" name="problema" required> </textarea>
                </div>
                <div class="button-container">
                    <button class="button" type="submit" name="submit"><a class="button-a" >Avanti</a></button>
                </div>
                <div class="input-group">
                    <a onclick="history.go(-1) ; return false;">Indietro</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
