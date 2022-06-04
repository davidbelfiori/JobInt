<?php

include('../db/database_connection.php');
include('../db/config.php');
session_start();

echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $conn);
