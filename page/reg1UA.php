<?php

session_start();

if (isset($_POST['submit'])) {
    foreach ($_POST as $key =>$value) {
        $_SESSION['info'][$key]=$value;
    }

    $keys= array_keys($_SESSION['info']);

    if (in_array('submit', $keys)) {
        unset($_SESSION['info']['submit']);
    }
    header("Location: reg2Azienda.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione azienda</title>
    <link href="css/reg2azienda.css" rel="stylesheet" type="text/css">
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
            <h1 class="title">Aziende</h1>
        </div>
    </div>
    <div class="content">
        <div class="image-container">
            <img class="content-image" src="../Resource/registrazione-azienda-1.png">
        </div>
        <div class="form-container">
            <form class="form" action="" method="POST" required>
                <div class="input-group">
                    <input type="text" placeholder="Nome Utente" name="username" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email aziendale" name="email" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Conferma Password" name="cpassword" required>
                </div>
                <div class="button-container">
                    <button class="button" type="submit" name="submit"><a class="button-a" href="reg2Azienda.php">Avanti</a></button>
                </div>
                <div class="form-text">
                    <p class="text"> Hai un account JobInt? <a class="text-a" href="index.php">Accedi ora!</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
