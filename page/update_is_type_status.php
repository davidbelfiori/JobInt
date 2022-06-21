<?php

include('../db/config.php');

session_start();

$query = "
UPDATE login_details 
SET is_type = '".$_POST["is_type"]."' 
WHERE iduser1 = '".$_SESSION["user_id"]."'
";

$statement = $conn->prepare($query);

$statement->execute();
