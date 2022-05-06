<?php

include "../db/config.php";

if (isset($_GET['id'])) {
    $idLavoratore=$_GET['id'];
    $sql_query="delete from `like` where idLavoratore='$idLavoratore'";
    $result = mysqli_query($conn, $sql_query);

    header("Location: likeProfili.php");
}
