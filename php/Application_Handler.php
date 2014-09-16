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
    public $schoolID="";
    public $categoryID="";
    public $fullName="";
    public $name_initials="";
    public $Last_Name="";
    public $gender="";
    public $religion="";
    public $medium="";
    public $birthDate="";
    public $address="";
    public $applicant="";
    public $app_fullName="";
    public $app_initials="";
    public $app_lastName="";
    public $NIC="";
    public $Nationalty="";
    public $app_religion="";
    public $app_address="";
    public $tel="";
    public $districtID="";
    public $divisionID="";
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
        return mysql_real_escape_string($data);
    }

    static public function initial($name)
    {
        $array = explode(" ", $name);
        $length = count($array);
        $initials = "";
        for ($x=0; $x<$length-1; $x++) {
            $init=$array[$x];
            $initials=$initials.$init[0];
        }
        return $initials;
    }

    static public function LastName($name)
    {
        $array = explode(" ", $name);
        $length = count($array);
        return $array[$length-1];
    }

    public function initialize_st1()
    {
        global $fullName,$schoolID,$categoryID,$Last_Name,$birthDate,$religion,$gender,$Name_initials,$medium;
        $fullName = $this->clean(@$_POST["name"]);
        $schoolID=$this->clean(@$_POST["subcat3"]);
        $categoryID=$this->clean(@$_POST["category"]);
        $Last_Name = $this->LastName(@$fullName);
        $birthDate = $this->clean(@$_POST["BD"]);
        $religion = $this->clean(@$_POST["Religion"]);
        $religion=$this->religion($religion);
        $gender = $this->clean(@$_POST["RadioGroup"]);
        $Name_initials=$this->initial(@$fullName);
        $medium = $this->clean(@$_POST["RadioGroup1"]);
    }

    public function initialize_st2()
    {
        global $distance,$Nationalty,$NIC,$tel,$app_address,$app_fullName,$applicant,$districtID,$app_lastName,$divisionID,$app_religion,$GND,$app_initials,$GNDno;
        $distance = $this->clean(@$_POST["Diatance"]);
        $Nationalty = $this->clean(@$_POST["Nationalty"]);
        $NIC = $this->clean(@$_POST["nic"]);
        $tel= $this->clean(@$_POST["tel"]);
        $app_address= $this->clean(@$_POST["address"]);
        $app_fullName = $this->clean(@$_POST["fullname"]);
        $applicant=$this->clean(@$_POST["applicant"]);
        $districtID=$this->clean(@$_POST["gcat"]);
        $app_lastName = $this->LastName(@$app_fullName);
        $divisionID = $this->clean(@$_POST["gsubcat"]);
        $app_religion = $this->clean(@$_POST["gReligion"]);
        $app_religion=$this->religion($app_religion);
        $GND = $this->clean(@$_POST["GND"]);
        $app_initials=$this->initial(@$app_fullName);
        $GNDno = $this->clean(@$_POST["GNDNO"]);
    }

    public function validate_st1()
    {
        global $fullName,$schoolID,$categoryID,$Last_Name,$birthDate,$religion,$gender,$Name_initials,$medium;
        $error_msg_array = array();
        $error_flag = false;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $this->initialize_st1();
            $_SESSION['fullName'] = $fullName;
            $_SESSION['schoolID'] = $schoolID;
            $_SESSION['categoryID'] = $categoryID;
            $_SESSION['birthDate'] = $birthDate;
            $_SESSION['religion'] = $religion;
            $_SESSION['gender'] = $gender;
            $_SESSION['medium'] = $medium;

            header("location: Application.php?stage=2&religion=".$religion);
        }
    }

    public function reassignst1()
    {
        global $fullName,$schoolID,$categoryID,$Last_Name,$birthDate,$religion,$gender,$Name_initials,$medium;
        $fullName = $_SESSION['fullName'];
        $schoolID=$_SESSION['schoolID'];
        $categoryID=$_SESSION['categoryID'];
        $Last_Name = $this->LastName(@$fullName);
        $birthDate = $_SESSION['birthDate'];
        $religion = $_SESSION['religion'];
        $gender = $_SESSION['gender'];
        $Name_initials=$this->initial(@$fullName);
        $medium = $_SESSION['medium'];
        //Unset the variables stored in session
        unset($_SESSION['fullName']);
        unset($_SESSION['schoolID']);
        unset($_SESSION['categoryID']);
        unset($_SESSION['birthDate']);
        unset($_SESSION['religion']);
        unset($_SESSION['gender']);
        unset($_SESSION['medium']);
    }

    public function validate_st2()
    {
        global $fullName,$schoolID,$categoryID,$Last_Name,$birthDate,$religion,$gender,$Name_initials,$medium;
        global $distance,$Nationalty,$NIC,$tel,$app_address,$app_fullName,$applicant,$districtID,$app_lastName,$divisionID,$app_religion,$GND,$app_initials,$GNDno;
        $error_msg_array = array();
        $error_flag = false;
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $this->reassignst1();
            $this->initialize_st2();
            $message=$this->insert();

            header("location: Enrolment.php?newApp=".$message);
        }
    }

    public function insert()
    {
        //Connect to the database
        require_once('connection.php');
        global $fullName,$schoolID,$categoryID,$Last_Name,$birthDate,$religion,$gender,$Name_initials,$medium;
        global $distance,$Nationalty,$NIC,$tel,$app_address,$app_fullName,$applicant,$districtID,$app_lastName,$divisionID,$app_religion,$GND,$app_initials,$GNDno;
        $sql="INSERT INTO Application ".
            "(Full_Name, Initials, Last_Name, Category_ID, School_ID, Gender, Religion, Telephone, Education_Medium, Birth_Day, Applicant_Type, Name_Applicant, Applicant_Initials, Applicant_LastName, NIC, Nationalty, Applicant_Religion, Address, District_ID, Division_ID, GND, GND_NO, Distance_To_School_KM) ".
            "VALUES ('$fullName', '$Name_initials', '$Last_Name', '$categoryID', '$schoolID', '$gender', '$religion', '$tel', '$medium', '$birthDate', '$applicant', '$app_fullName', '$app_initials', '$app_lastName', '$NIC', '$Nationalty', '$app_religion', '$app_address', '$districtID', '$divisionID', '$GND', '$GNDno', '$distance');";
        $retval = mysql_query( $sql);
        if(! $retval )
        {
            die('Could not enter data: ' . mysql_error());
            return "Fail";
        }
        else{
            return "Succes";
        }
    }

    public function religion($reli)
    {
                switch($reli)
                {
                    case "1":
                        $data='Buddhism';
                        break;
                    case "2":
                        $data='Hindu';
                        break;
                    case "3":
                        $data='Catholic';
                        break;
                    case "4":
                        $data='Christian';
                        break;
                    case "5":
                        $data='Islam';
                        break;
                    case "6":
                        $data='Othere';
                        break;
                }
            return $data;
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