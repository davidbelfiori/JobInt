<?php
//richiamo del file con la conf. del db
include '../db/config.php';

//avvio della sessione
session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
    $sql="select * from user where username='$username'";
    $res = mysqli_query($conn,$sql);
    if($res->num_rows >0){
        $row1=mysqli_fetch_assoc($res);
        if($row1['typeuser']=='lavoratore'){
            header("Location: welcomeLavoratoreHome.php");
        }else{header("Location: welcomeAzienda.php");}
    }

}

//controllo delle credenziali email e password
if (isset($_POST['submit'])) {



    $email = $_POST['email'];
    $password = md5($_POST['password']);


    $sql1="select  * from user where email='$email' AND password='$password'";
    $result1=mysqli_query($conn,$sql1);
    if($result1->num_rows>0){
        $row= mysqli_fetch_assoc($result1);
        $code=$row['code'];
        if($code!=0) {
            $_SESSION['email']=$row['email'];
            header("location: verificationcode.php");
            exit;
        }
        //ricerca nel database delle credenziali con il confronto tra email e password inserite con quelle presenti nel db
        $_SESSION['username'] = $row['username'];
        $_SESSION['email']=$row['email'];
        if($row['typeuser']=='lavoratore'){
            header("location: welcomeLavoratoreHome.php");

        }else{
            header("Location: welcomeAzienda.php");
        }

    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
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
                <a href="help.php">Help</a>
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
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>

                </div>
                <div class="input-group">
                    <button name="submit" class="btn"><a id="button-text">Accedi</a></button>
                </div>
            </form>
            <p>Non hai un account JobInt? <a href="regUserLavoratore.php">Lavoratore</a> <a href="reg1UA.php">Azienda</a></p>
            <p>Hai dimenticato la password? <a href="forgot-password.php">Recupera</a></p>
        </div>
    </div>
</div>

</body>
</html>