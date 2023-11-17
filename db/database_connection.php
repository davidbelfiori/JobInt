<?php

include "config.php";

$connect = new PDO("mysql:host=localhost;dbname=jobint;charset=utf8mb4", "root", "root");

function fetch_user_last_activity($user_id, $conn)
{
    $query = "
	SELECT * FROM login_details 
	WHERE iduser1 = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        return $row['last_activity'];
    }
}


function get_user_name($user_id, $conn)
{
    $query = "SELECT username FROM user WHERE iduser = '$user_id'";
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {
        return $row['username'];
    }
}




function fetch_user_chat_history($from_user_id, $to_user_id, $conn)
{
    $query = "
	SELECT * FROM chat_message 
	WHERE (from_user_id = '".$from_user_id."' 
	AND to_user_id = '".$to_user_id."') 
	OR (from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."') 
	ORDER BY timestamp DESC
	";
    $result = mysqli_query($conn, $query);

    $output = '<ul class="list-unstyled">';
    while($row = mysqli_fetch_assoc($result)) {
        $user_name = '';
        $dynamic_background = '';
        $chat_message = '';
        if($row["from_user_id"] == $from_user_id) {
            if($row["status"] == '2') {
                $chat_message = '<em>This message has been removed</em>';
                $user_name = '<b class="text-success">You</b>';
            } else {
                $chat_message = $row['chat_message'];
                $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
            }


            $dynamic_background = 'background-color:#ffe6e6;';
        } else {
            if($row["status"] == '2') {
                $chat_message = '<em>This message has been removed</em>';
            } else {
                $chat_message = $row["chat_message"];
            }
            $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $conn).'</b>';
            $dynamic_background = 'background-color:#ffffe6;';
        }
        $output .= '
		<li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
			<p>'.$user_name.' - '.$chat_message.'
				<div align="right">
					- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
		</li>
		';
    }
    $output .= '</ul>';
    $query = "
	UPDATE chat_message 
	SET status = '0' 
	WHERE from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."' 
	AND status = '1'
	";
    $statement = $conn->prepare($query);
    $statement->execute();
    return $output;
}



function fetch_group_chat_history($conn)
{
    $query = "
	SELECT * FROM chat_message 
	WHERE to_user_id = '0'  
	ORDER BY timestamp DESC
	";

    $statement = $conn->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $output = '<ul class="list-unstyled">';
    foreach($result as $row) {
        $user_name = '';
        $dynamic_background = '';
        $chat_message = '';
        if($row["from_user_id"] == $_SESSION["user_id"]) {
            if($row["status"] == '2') {
                $chat_message = '<em>This message has been removed</em>';
                $user_name = '<b class="text-success">You</b>';
            } else {
                $chat_message = $row["chat_message"];
                $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'">x</button>&nbsp;<b class="text-success">You</b>';
            }

            $dynamic_background = 'background-color:#ffe6e6;';
        } else {
            if($row["status"] == '2') {
                $chat_message = '<em>This message has been removed</em>';
            } else {
                $chat_message = $row["chat_message"];
            }
            $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $conn).'</b>';
            $dynamic_background = 'background-color:#ffffe6;';
        }

        $output .= '

		<li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
			<p>'.$user_name.' - '.$chat_message.' 
				<div align="right">
					- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
		</li>
		';
    }
    $output .= '</ul>';
    return $output;
}

function count_unseen_message($from_user_id, $to_user_id, $conn)
{
    $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";

    $statement = mysqli_query($conn, $query);
    $count = mysqli_num_rows($statement);
    $output = '';
    if($count > 0) {
        $output = '<span class="label label-success">'.$count.'</span>';
    }
    return $output;
}


function fetch_is_type_status($user_id, $conn)
{
    $query = "
 SELECT is_type FROM login_details 
 WHERE iduser1 = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";


    $statement = mysqli_query($conn, $query);

    $output = '';
    while($row = mysqli_fetch_assoc($statement)) {
        if($row["is_type"] == 'yes') {
            $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
        }
    }
    return $output;
}
