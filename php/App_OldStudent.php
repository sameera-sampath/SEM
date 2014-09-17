<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
$app=intval(@$_SESSION['SESS_Appication']);
$cat=intval(@$_SESSION['SESS_Category']);
if($app>0 AND $cat==2){
require('Validate.php');
//Connect to the database
require_once('connection.php');

// For the Application part
$School_Name=@$_SESSION['SESS_School_Name'];
$Category_Name=@$_SESSION['SESS_Category_Name'];
$Full_Name=@$_SESSION['SESS_Full_Name'];
$Medium=@$_SESSION['SESS_Medium'];
$BD=@$_SESSION['SESS_BD'];
$Gender=@$_SESSION['SESS_Gender'];
$Religion=@$_SESSION['SESS_Religion'];
$Applicant=@$_SESSION['SESS_Applicant_Name'];
$Address=@$_SESSION['SESS_Address'];
$NIC=@$_SESSION['SESS_NIC'];
$Telephone=@$_SESSION['SESS_Telephone'];
$Distance=@$_SESSION['SESS_Distance'];
if(isset($_POST['submit']))
{
    $no_grade = intval(getVal(@$_POST['no_grade']));
    $achievementsin = getVal(@$_POST['achievementsin']);
    $extra = getVal(@$_POST['extra']);
    $achievementsout = getVal(@$_POST['achievementsout']);
    $donation = getVal(@$_POST['donation']);
    $marks21= grades(@$no_grade);
    $marks22 = intval(getVal(@$_POST['marks22']));
    $marks23 = intval(getVal(@$_POST['marks23']));
    $marks24 = intval(getVal(@$_POST['marks24']));
    $marks25 = intval(getVal(@$_POST['marks25']));
    $markst=$marks21+$marks22+$marks23+$marks24+$marks25;
    if($_POST['submit']=="Submit")
    {
        $sql="INSERT INTO OldStudent_Marks ".
            "(Application_ID, Category_ID, NumberOf_grades, Educational, ExtraCurricular, Educational_After, Donation, Marks_Grades, Marks_Edu, Marks_Extra, Marks_After, Marks_Donation, Marks_Total)".
            "VALUES ('$app', '$cat', '$no_grade', '$achievementsin', '$extra', '$achievementsout', '$donation', '$marks21', '$marks22', '$marks23', '$marks24', '$marks25', '$markst') ".
            "ON DUPLICATE KEY UPDATE NumberOf_grades = VALUES (NumberOf_grades),Educational = VALUES (Educational),ExtraCurricular = VALUES (ExtraCurricular),Educational_After = VALUES (Educational_After),".
            "Donation = VALUES (Donation),Marks_Grades = VALUES (Marks_Grades),Marks_Edu = VALUES (Marks_Edu),Marks_Extra = VALUES (Marks_Extra),Marks_After = VALUES (Marks_After),Marks_Donation = VALUES (Marks_Donation),Marks_Total = VALUES (Marks_Total);";
        $retval = mysql_query( $sql);
        if(! $retval )
        {
            die('Could not enter data: ' . mysql_error());
        }
        else{
            $sql2="UPDATE Application SET Marks = $markst WHERE Application_ID =$app;";
            $set = mysql_query( $sql2);
            if(! $set )
            {
                die('Could not enter data: ' . mysql_error());
            }
            header("location: UnsetSession_SelectionPanel.php");
        }
    }
    elseif($_POST['submit']=="Calculate")
    {  }
}
else
{
    //Retriev data from DataBase
    $sql="SELECT * FROM OldStudent_Marks WHERE Application_ID='$app'";
    $resultses = mysql_query ($sql);
    while($resultSet = mysql_fetch_array($resultses))
    {
        if($resultSet['Application_ID']==$app)
        {
            $no_grade=$resultSet['NumberOf_grades'];
            $achievementsin=@$resultSet['Educational'];
            $extra=@$resultSet['ExtraCurricular'];
            $achievementsout=@$resultSet['Educational_After'];
            $donation=@$resultSet['Donation'];
            $marks21=$resultSet['Marks_Grades'];
            $marks22=$resultSet['Marks_Edu'];
            $marks23=$resultSet['Marks_Extra'];
            $marks24=$resultSet['Marks_After'];
            $marks25=$resultSet['Marks_Donation'];
            $markst=$resultSet['Marks_Total'];
        }
    }
}

?>

<html>
<head>
    <title>Student Enrolment Module</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/template.css">
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
    <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
    <style>
        table {width:100%;}
        #content_outer #content_inner .content_allication .content_middle #stage1 #resident_table tr td #Elec-reg_label {
            font-size: 18px;
        }
        label {
            font-size: 18px;
        }
        input {font-size:18px;}
        table {border:#999; border-style:solid; border-width:3px; border-bottom:hidden;}
        tr,td { border-bottom-color:#999; border-bottom-style:solid; border-bottom-width:3px;}
    </style>
</head>
<body>

<!--header start-->
<div id="header_outer">
	<div id="header_inner">
      <div id="header_top">
          <div class="header_top_left">&nbsp;&nbsp; </div>
            <div class="header_top_right">
           		<div id="admin_button" style="cursor:default;">
                    <a href="#" style="cursor:default;">
                        <span style="cursor:default;color: #ffed6f">
                            <?php
                            $user = $_SESSION['SESS_USER_TYPE'];
                            echo $user;
                            ?>
                        </span>
                    </a>
                </div>
                <div id="user_welcome">
                       <?php
                       $fname = $_SESSION['SESS_FIRST_NAME'];
                       $lname = $_SESSION['SESS_LAST_NAME'];
                       echo "Welcome, " . $fname . " " . $lname . ", ";
                       ?>
                       <span><a href="logout.php" class="link1" style="cursor:pointer;color: #5779ff">&nbsp;&nbsp;&nbsp;Logout</a></span>
                </div>
            </div>
      </div>
        <div id="header_logo" style="margin-top:0px;">
            <img src="../img/header2.png" height="150" width="960">
        </div>
	</div>
</div>

<!--header end-->

<!--content start-->
<div id="content_outer">
    <div id="content_inner">
            <div class="content_title">Student Enrolment Module - Application Selection Panel</div>
            <div class="content_middle">

                <!-- Old Student form-->

                <form id="stage1" action="<?php $_PHP_SELF ?>" method="post">

                    <!-- Application Header -->
                    <table class="resident" id="app_table">
                        <tr><th align="left" style="font-size: 18px">School :<?php echo @$School_Name; ?></th>
                            <th colspan="2" align="center" style="font-size: 18px">Application Category:  <?php echo @$Category_Name; ?></th>
                        </tr>
                        <tr><td align="left" style="font-size: 14px">
                                <label class="app_label">Student Name : <?php echo @$Full_Name; ?></label><br/>
                                <label class="app_label"><?php echo @$Medium; ?></label><br/>
                                <label class="app_label"><?php echo @$BD; ?></label><br/>
                                <label class="app_label"><?php echo @$Gender; ?></label><br/>
                                <label class="app_label"><?php echo @$Religion; ?></label><br/>
                            </td>
                            <td colspan="2" align="center" style="font-size: 14px">
                                <label class="app_label"><?php echo @$Applicant; ?></label><br/>
                                <label class="app_label"><?php echo @$Address; ?></label><br/>
                                <label class="app_label"><?php echo @$NIC; ?></label><br/>
                                <label class="app_label"><?php echo @$Telephone; ?></label><br/>
                                <label class="app_label"><?php echo @$Distance; ?></label><br/>
                            </td>
                        </tr>
                    </table>
                    <!-- Application Header End -->
                    <!-- Custom decision support by Application category -->
                    <table class="resident" id="resident_table">
                        <tr>
                            <th width="70%" ></th>
                            <th width="15%" align="center">Marks</th>
                            <th width="15%"></th>
                        </tr>
                        <tr>
                            <td align="left">
                                <label id="no-grade_label" class="app_label">Number of grades studied in the school</label> <br />
                                <input name="no_grade" type="text" class="app_input" id="no-grade_input" <?php echo("value='".@$no_grade."'"); ?>/><br />

                            </td>
                            <td align="left"><input name="marks21" type="text" class="app_input" id="marks21_input" <?php echo("value='".@$marks21."' disabled"); ?> /></td>

                            <td align="left"><label id="marks21_lable" class="app_label"> Out of 26</label></td>
                        </tr>
                        <tr>
                            <td align="left">

                                <label id="achivmentsin_label" class="app_label">Educational Achievements in the school</label><br />
                                <input name="achievementsin" type="text" class="app_input" id="achivmentsin_input" <?php echo("value='".@$achievementsin."'"); ?> />
                            </td>
                            <td align="left"><label class="error">Manually Enter Marks</label>
                                <input name="marks22" type="text" class="app_input" id="marks22_input" <?php echo("value='".@$marks22."'"); ?>/></td>
                            <td align="left"><label id="marks22_label" class="app_label"> Out of 25</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="extra_label" class="app_label">Achievements in extra-curricular activities</label><br />
                                <input name="extra" type="text" class="app_input" id="extra_input" <?php echo("value='".@$extra."'"); ?>/> <br />

                            </td>
                            <td align="left"><label class="error">Manually Enter Marks</label>
                                <input name="marks23" type="text" class="app_input" id="marks23_input" <?php echo("value='".@$marks23."'"); ?>/></td>
                            <td align="left"><label id="marks23" class="app_label"> Out of 25</label></td>

                        </tr>


                        <tr>
                            <td align="left">
                                <label id="achievementsout_label" class="app_label">Educational Achievements after leaving school</label><br />
                                <input name="achievementsout" type="text" class="app_input" id="achivmentsout_input" <?php echo("value='".@$achievementsout."'"); ?>/>
                            </td>
                            <td align="left"><label class="error">Manually Enter Marks</label>
                                <input name="marks24" type="text" class="app_input" id="marks24_input" <?php echo("value='".@$marks24."'"); ?>/></td>
                            <td align="left"><label id="marks24" class="app_label"> Out of 18</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="donation_label" class="app_label">Donations for school development</label><br />
                                <input name="donation" type="text" class="app_input" id="donation_input" <?php echo("value='".@$donation."'"); ?>/>
                            </td>
                            <td align="left"><label class="error">Manually Enter Marks</label>
                                <input name="marks25" type="text" class="app_input" id="marks25_input" <?php echo("value='".@$marks25."'"); ?>/></td>
                            <td align="left"><label id="marks25" class="app_label"> Out of 6</label></td>
                        </tr>

                        <tr>
                            <td align="right">
                                <label id=" Total_label">Total</label><br />
                            </td>
                            <td align="left"><input name="markst" type="text" class="app_input" id="markst_input" <?php echo("value='".@$markst."' disabled"); ?> /></td>
                            <td align="left"><label id="markst" class="app_label"> Out of 100</label></td>
                        </tr>

                        <tr><td>
                                <div class="button" align="center">
                                    <input id="submit" name="submit" type="submit" value="Submit" class="submit_button">
                                </div></td>
                            <td>
                                <div class="button" align="center">
                                    <input id="submit" name="submit" type="submit" value="Calculate" class="submit_button">
                                </div></td><td></td>
                        </tr>
                    </table>
                </form>

                <!-- Old Student form ends-->

            </div>
            <div class="content_bottom">
            </div>
    </div>
</div>
<!--content end-->

</body>
</html>
<?php }
else{
    header("location: Panel.php?select_application=false");
    exit();
}?>