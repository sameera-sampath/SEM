<?php
/**
 * Created by PhpStorm.
 * User: Sameera
 * Date: 9/12/14
 * Time: 7:25 AM
 */

namespace SEM;


class Application_Handler {

    private $databaseUsersTable;
    private $cryptMethod;
    private $showMessage;
    public $school="";
    public $category="";
    public $schoolID="";
    public $categoryID="";
    public $fullName="";
    public $name_initials="";
    public $surName="";
    public $gender="";
    public $religion="";
    public $medium="";
    public $birthYear="";
    public $birthMonth="";
    public $birthDate="";
    public $address="";
    public $applicant="";
    public $app_fullName="";
    public $app_initials="";
    public $app_lastName="";
    public $app_NIC="";
    public $app_Srilankan="";
    public $app_religion="";
    public $app_address="";
    public $tel="";
    public $district="";
    public $division="";
    public $GND="";
    public $GNDno="";
    public $distance="";
public $error_msg_array = array();
public $error_flag = false;

    function __construct()
    {
    }
    /**
     * Sets the database users table
     */
    public function setDatabaseUserTable($database_user_table)
    {
        $this->databaseUsersTable=$database_user_table;
    }

    /**
     * Sets the crypting method
     *
     * @param string $crypt_method - You can set it as 'md5' or 'sha1' to choose the crypting method for the user password.
     */
    public function setCryptMethod($crypt_method)
    {
        $this->cryptMethod=$crypt_method;
    }

    /**
     * Crypts a string
     *
     * @param string $text_to_crypt -  crypt a string if $this->cryptMethod was defined.
     * If not, the string will be returned uncrypted.
     */
    public function setCrypt($text_to_crypt)
    {
        switch($this->cryptMethod)
        {
            case 'md5': $text_to_crypt=trim(md5($text_to_crypt)); break;
            case 'sha1': $text_to_crypt=trim(sha1($text_to_crypt)); break;
        }
        return $text_to_crypt;
    }

    /**
     * Anti-Mysql-Injection method, escapes a string.
     *
     * @param string $text_to_escape
     */
    static public function setEscape($str)
    {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }

    static public function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validate_st1()
    {
        $error_msg_array = array();
        $error_flag = false;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {

            $fullName = clean($_POST["name"]);
            $name = clean($_POST["name"]);
            $email = clean($_POST["email"]);
            $website = clean($_POST["website"]);

            $gender = clean($_POST["gender"]);
            header("location: Application.php?stage=2");
        }


    }


    public function getMessage($message_text, $message_html_tag_open=null, $message_html_tag_close=null, $message_die=false)
    {
        if($this->showMessage)
        {
            if($message_die) die($message_text);
            else echo $message_html_tag_open . $message_text . $message_html_tag_close;
        }
    }

    /**
     * Register user in the database
     *
     * The user form data needed is: user_name, user_pass, user_confirm_pass, user_mail, user_confirm_mail
     */
    public function setUserRegistration()
    {
        $user_name=$this->setEscape($_POST['user_name']);
        $user_pass=$_POST['user_pass'];
        $user_confirm_pass=$_POST['user_confirm_pass'];
        $user_mail=$_POST['user_mail'];
        $user_confirm_mail=$_POST['user_confirm_mail'];
        $user_crypted_pass=$this->setCrypt($user_pass);
        $result_user_name=mysql_query("SELECT * FROM"." ".$this->databaseUsersTable." "."WHERE user_name='$user_name'");
        $result_user_mail=mysql_query("SELECT * FROM"." ".$this->databaseUsersTable." "."WHERE user_mail='$user_mail'");
        if((strlen($user_name)<6) or (strlen($user_name)>16)) $this->getMessage('Entered username length must be of 6 to 16 characters.');
        elseif(mysql_num_rows($result_user_name)) $this->getMessage('Entered username already exists in the database.');
        elseif((strlen($user_pass)<8) or (strlen($user_pass)>16)) $this->getMessage('Entered password length must be of 8 to 16 characters.');
        elseif($user_pass!=$user_confirm_pass) $this->getMessage('Passwords entered do not match.');
        elseif(mysql_num_rows($result_user_mail)) $this->getMessage('Entered email already exists in the database.');
        elseif($user_mail!=$user_confirm_mail) $this->getMessage('Email addresses entered do not match.');
        elseif(!preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{4,})+\.)+([a-zA-Z0-9]{2,})+$/", $user_mail)) $this->getMessage('Email address entered is not valid.');
        else
        {
            if(mysql_query("INSERT INTO"." ".$this->databaseUsersTable." "."(user_name, user_pass, user_mail) VALUES ('$user_name', '$user_crypted_pass', '$user_mail')")) $this->getMessage('Registration was successful.');
        }
    }

}
?>