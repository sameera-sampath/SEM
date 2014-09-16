<?php
/**
 * Created by PhpStorm.
 * User: Sameera
 * Date: 9/15/14
 * Time: 12:44 AM
 */
//Start session
session_start();
//Unset the variables stored in session
unset($_SESSION['SESS_Appication']);
unset($_SESSION['SESS_Category']);
unset($_SESSION['SESS_School_Name']);
unset($_SESSION['SESS_Category_Name']);
unset($_SESSION['SESS_Full_Name']);
unset($_SESSION['SESS_Medium']);
unset($_SESSION['SESS_BD']);
unset($_SESSION['SESS_Gender']);
unset($_SESSION['SESS_Religion']);
unset($_SESSION['SESS_Applicant_Name']);
unset($_SESSION['SESS_Address']);
unset($_SESSION['SESS_NIC']);
unset($_SESSION['SESS_Telephone']);
unset($_SESSION['SESS_Distance']);
header("location: Panel.php?insert=Success");
exit();
?>