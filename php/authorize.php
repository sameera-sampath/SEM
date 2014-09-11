<?php
//Start session
session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) {
    //Initialize array to store error massages
    $error_msg_array = array();
    $error_msg_array[] = 'Please Log in to continue';
    $_SESSION['ERRMSG_ARR'] = $error_msg_array;
    header("location: signin.php");
    exit();
}
?>