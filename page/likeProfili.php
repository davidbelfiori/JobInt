<?php
session_start();
include "../db/config.php";
$username = $_SESSION['username'];
$email= $_SESSION['email'];
$idAzienda= $_SESSION['idAzienda'];

?>
<html lang="it">
<header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/indexstyle.css">

    <title>JobInt</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

</header>
<body>

<a href="welcomeAzienda.php">home</a>
<?php
$sql = "select * from user,azienda,`like`,lavoratore,curriculum,professione
where `like`.idAzienda='$idAzienda' and  user.iduser=azienda.idUser1   and `like`.idAzienda=azienda.idAzienda
and `like`.idLavoratore=lavoratore.idlavoratore
and `like`.idLavoratore= curriculum.idLavoratore1
and professione.idlavoratore1=`like`.idLavoratore";

$result = mysqli_query($conn, $sql);
$queryResult = mysqli_num_rows($result);
if ($queryResult > 0) {
while ($row = mysqli_fetch_assoc($result)) {

echo "<div style='text-align: center'>
    &ensp;
    <h3>" . $row["nome"] . " " . $row["cognome"] . "</h3>

    <p>" . $row['areaprofessionale'] . "  &ensp;     " . $row['sottoarea'] . "   &ensp;      " . $row['categoria'] . "</p>
   
    <form action='' method='post'>
        <button style='border: none; background: none; padding: 0;'> <a  style='text-decoration: none' href='dettagli.php?id=".$row['idlavoratore']."'> view</a></button>
        <button style='border: none; background: none; padding: 0;' > <a  style='text-decoration: none' href='Unlike.php?id=".$row['idlavoratore']."' >Unlike</a></button>
    </form>
</div>";

}} ?>

</body>
</html>
