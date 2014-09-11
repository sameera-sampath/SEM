<?php
//Start session
session_start();

//Connect to the database
require_once('connection.php');

//Initialize array to store error massages
$error_msg_array = array();

//Initialize error flag
$error_flag = false;

//Function to safely retrieve values received from the form. Prevents SQL injection
function clean($str) {
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysql_real_escape_string($str);
}

//Get the POST values to variables and clear the post values
$username = clean($_POST['username']);
$password = clean($_POST['password']);

//Input Validations
if($username == '') {
    $error_msg_array[] = 'Username missing';
    $error_flag = true;
}
if($password == '') {
    $error_msg_array[] = 'Password missing';
    $error_flag = true;
}

//If there are input validations, redirect back to the login form
if($error_flag) {
    $_SESSION['ERRMSG_ARR'] = $error_msg_array;
    session_write_close();
    header("location: signin.php");
    exit();
}

//Retrieve mysql query
$qry="SELECT * FROM users WHERE username='$username' AND password='$password'";
$result=mysql_query($qry);

//Check whether the query was successful or not

if($result) {
    // Mysql_num_row is counting table row
    $count=mysql_num_rows($result);

    // If result matched, table row must be 1 row
    if($count==1){
        //Login Successful
        session_regenerate_id();
        $user = mysql_fetch_assoc($result);
        $_SESSION['SESS_USER_ID'] = $user['USER_ID'];
        $_SESSION['SESS_FIRST_NAME'] = $user['fname'];
        $_SESSION['SESS_LAST_NAME'] = $user['lname'];
        $_SESSION['SESS_USER_TYPE'] = $user['User_Type'];
        session_write_close();
        header("location: index.php");
        exit();
    }else {
        //Login failed
        $error_msg_array[] = 'user name and password not found';
        $error_flag = true;
        if($error_flag) {
            $_SESSION['ERRMSG_ARR'] = $error_msg_array;
            session_write_close();
            header("location: signin.php");
            exit();
        }
    }
}else {
    die("Query failed");
}
?>