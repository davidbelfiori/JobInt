
<?php
//richiamo del file con la conf. del db
/*include '../db/config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    //inserimento delle variabili
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    //confronto delle password(pw,cpw)
    if ($password == $cpassword) {
        //selezione delle email presenti nel database
        $sql = "SELECT * FROM jobint.user WHERE email='$email' and username='$username'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            //insrimento valori nel db
            $sql = "INSERT INTO jobint.user (username, email, password,typeuser)
                    VALUES ('$username', '$email', '$password','lavoratore')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Registrazione Completata')</script>";
                header('location: index.php');
                exit;

            } else {
                echo "<script>alert('Qualcosa è andato storto.')</script>";
            }
        } else {
            echo "<script>alert('Email o username non disponibile.')</script>";
        }

    } else {
        echo "<script>alert('Le password non corrispondono.')</script>";
    }




}*/


session_start();

if (isset($_POST['submit'])) {
    foreach ($_POST as $key =>$value) {
        $_SESSION['info'][$key]=$value;
    }

    $keys= array_keys($_SESSION['info']);

    if (in_array('submit', $keys)) {
        unset($_SESSION['info']['submit']);
    }
    header("Location:regUserLavoratore2.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link href="css/reg2azienda.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <div class="nav">
        <div class="logo-container">
            <img class="logo" src="../Resource/logo.png">
        </div>
        <div class="title-container">
            <h1 class="title">Lavoratore</h1>
        </div>
    </div>
    <div class="content">
        <div class="image-container">
            <img class="content-image" src="../Resource/registrazione-azienda-1.png">
        </div>
        <div class="form-container">
            <form class="form" action="" method="POST" >
                <div class="input-group">
                    <input type="text" placeholder="Nome Utente" name="username" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email personale" name="email" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Conferma Password" name="cpassword" required>
                </div>
                <div class="button-container">
                    <button class="button" type="submit" name="submit"><a class="button-a" >Avanti</a></button>
                </div>
                <div class="form-text">
                    <p class="text"> Hai un account JobInt? <a class="text-a" href="index.php">Accedi ora!</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
