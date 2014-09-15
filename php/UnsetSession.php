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
unset($_SESSION['fullName']);
unset($_SESSION['schoolID']);
unset($_SESSION['categoryID']);
unset($_SESSION['birthDate']);
unset($_SESSION['religion']);
unset($_SESSION['gender']);
unset($_SESSION['medium']);
header("location: Application.php?stage=1");
?>