<?php

include "config.php";


function fetch_user_last_activity($user_id, $conn)
{
    $query = "
	SELECT * FROM login_details 
	WHERE iduser1 = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
    $result= mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['last_activity'];
    }
}
