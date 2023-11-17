<?php

include "../db/config.php";
include "../db/database_connection.php";


session_start();


$res1 =  mysqli_query($conn, "select * from user where iduser='".$_SESSION['user_id']."'");
$row = mysqli_fetch_assoc($res1);
if($row['typeuser'] == 'azienda') {
    $query = "
SELECT * FROM `like`,lavoratore,user 
WHERE  lavoratore.idlavoratore=`like`.idLavoratore and iduser = lavoratore.idUser1 and `like`.idAzienda = '".$_SESSION['idAzienda']."' 
";
} else {

    $query = "
    select *
    from `like`,azienda,user
where `like`.idAzienda=azienda.idAzienda and iduser=azienda.idUser1 and idLavoratore='".$_SESSION['idlavoratore']."' ;";
}


$result = mysqli_query($conn, $query);


$output = '
<table class="table table-bordered table-striped">
	<tr>
		<th width="70%">Username</td>
		<th width="20%">Status</td>
		<th width="10%">Action</td>
	</tr>
';



while($row = mysqli_fetch_assoc($result)) {


    $status = '';
    $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
    $user_last_activity = fetch_user_last_activity($row['iduser'], $conn);
    if($user_last_activity > $current_timestamp) {
        $status = '<span class="label label-success">Online</span>';
    } else {
        $status = '<span class="label label-danger">Offline</span>';
    }

    $output .= '
	<tr>
	
		<td> '.$row['nome'].' '.count_unseen_message($row['iduser'], $_SESSION['user_id'], $conn).'  '.fetch_is_type_status($row['iduser'], $conn).'</td>
		<td>'.$status.'</td>
		<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['iduser'].'" data-tousername="'.$row['nome'].'">Start Chat</button></td>
	</tr>
	';

}

$output .= '</table>';
echo $output;
