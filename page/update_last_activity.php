<?php

include "../db/config.php";
include "../db/database_connection.php";


session_start();

$query = "
UPDATE login_details 
SET last_activity = now() 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";

$statement = $conn->prepare($query);

$statement->execute();
