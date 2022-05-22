<?php
//richiamo del file con la conf. del db
include '../db/config.php';

//avvio della sessione
session_start();
$email = $_SESSION['email'];
if ($email == false) {
    header('Location: index.php');
}
error_reporting(0);


//controllo delle credenziali email e password
if (isset($_POST['submit'])) {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM user WHERE code = $otp";
    $code_res = mysqli_query($conn, $check_code);
    if (mysqli_num_rows($code_res)>0) {
        $code = 0;
        $update_profile = "UPDATE user SET code = $code WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_profile);
        if ($run_query) {
            echo "<script>alert('ora puoi accedere su jobint!')</script>";
        }
        header('location: index.php');
    } else {
        echo "<script>alert('codice errato!')</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/indexstyle.css">

    <title>JobInt</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100;1,300;1,400&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="navbar">
        <nav class="nav">
            <div class="logonav">
                <h1 id="scritta-nav">JOBINT</h1>
            </div>
            <div class="menu">
                <a href="help.php">Contattaci</a>
                <a href="#">FAQ</a>
                <a href="reg1UA.php">Registrati</a>

            </div>
        </nav>
    </div>
    <div class="content">
        <div class="logo-container">
            <img class="logo" src="../Resource/logo.png">
        </div>
        <div class="form-container">
            <img class="logo-accesso" src="../Resource/accesso.png">
            <form action="" method="POST" class="login-email" >
                <h2>Code Verification</h2>
                <div class="input-group">
                    <input type="number" placeholder="Otp" name="otp"  required>
                </div>

                <div class="input-group">
                    <button name="submit" class="btn"><a id="button-text">Verifica</a></button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>