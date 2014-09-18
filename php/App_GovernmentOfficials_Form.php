<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
$app=intval(@$_SESSION['SESS_Appication']);
$cat=intval(@$_SESSION['SESS_Category']);
if($app>0 AND $cat==5){
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
    $service = intval(getVal(@$_POST['service']));
    $distance = intval(getVal(@$_POST['distance']));
    $remoteCurrent = intval(getVal(@$_POST['remoteCurrent']));
    $remote = intval(getVal(@$_POST['remote']));
    $y2013 = intval(getVal(@$_POST['y2013']));
    $y2012 = intval(getVal(@$_POST['y2012']));
    $y2011 = intval(getVal(@$_POST['y2012']));
    $y2010 = intval(getVal(@$_POST['y2010']));
    $y2009 = intval(getVal(@$_POST['y2009']));
    $schservice = intval(getVal(@$_POST['schservice']));
    $marks31= service(@$service);
    $marks32 = distance(@$distance);
    $marks33 = remote($remoteCurrent,$remote);
    $marks34 = leave($y2013,$y2012,$y2011,$y2010,$y2009);
    $marks35 = same_School_service($schservice);
    $markst=$marks31+$marks32+$marks33+$marks34+$marks35;
    if($_POST['submit']=="Submit")
    {
        $sql="INSERT INTO governmentwork_child_marks ".
            "(Application_ID, Category_ID, Service, Distance, RemotePresent, RemoteService, LeaveY1,LeaveY2,LeaveY3,LeaveY4,LeaveY5, ServiceSameSchool,Marks_Service, Marks_Distance, Marks_Remote, Marks_Leave, Marks_SameSchool, Marks_Total)".
            "VALUES ('$app', '$cat', '$service', '$distance', '$remoteCurrent', '$remote', '$y2013', '$y2012', '$y2011', '$y2010', '$y2009','$schservice', '$marks31', '$marks32', '$marks33', '$marks34', '$marks35', '$markst') ".
            "ON DUPLICATE KEY UPDATE Service = VALUES (Service),Distance = VALUES (Distance),RemotePresent = VALUES (RemotePresent),RemoteService = VALUES (RemoteService),LeaveY1 = VALUES (LeaveY1),LeaveY2 = VALUES (LeaveY2),LeaveY3 = VALUES (LeaveY3),LeaveY4 = VALUES (LeaveY4),LeaveY5 = VALUES (LeaveY5),ServiceSameSchool = VALUES (ServiceSameSchool),".
            "Marks_Service = VALUES (Marks_Service),Marks_Distance = VALUES (Marks_Distance),Marks_Remote = VALUES (Marks_Remote),Marks_Leave = VALUES (Marks_Leave),Marks_SameSchool = VALUES (Marks_SameSchool),Marks_Total = VALUES (Marks_Total);";
        $retval = mysql_query( $sql);
        if(! $retval )
        {
            die('Could not enter data: ' . mysql_error());
        }
        else{
            $sql2="UPDATE application SET Marks = $markst WHERE Application_ID =$app;";
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
    $sql="SELECT * FROM governmentwork_child_marks WHERE Application_ID='$app'";
    $resultses = mysql_query ($sql);
    while($resultSet = mysql_fetch_array($resultses))
    {
        if($resultSet['Application_ID']==$app)
        {
            $service=$resultSet['Service'];
            $distance=@$resultSet['Distance'];
            $remoteCurrent=@$resultSet['RemotePresent'];
            $remote=@$resultSet['RemoteService'];
            $y2013=@$resultSet['LeaveY1'];
            $y2012=@$resultSet['LeaveY2'];
            $y2011=@$resultSet['LeaveY3'];
            $y2010=@$resultSet['LeaveY4'];
            $y2009=@$resultSet['LeaveY5'];
            $schservice=@$resultSet['ServiceSameSchool'];
            $marks31=$resultSet['Marks_Service'];
            $marks32=$resultSet['Marks_Distance'];
            $marks33=$resultSet['Marks_Remote'];
            $marks34=$resultSet['Marks_Leave'];
            $marks35=$resultSet['Marks_SameSchool'];
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
          <div class="header_top_left"><span><a href="Index.php" class="link1" style="cursor:pointer;color: #d2a5ff">&nbsp;&nbsp;&nbsp;Home</a></span></div>
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
            <div class="content_title">Student Enrolment</div>
            <div class="content_middle">

                <!-- Education Officials' Children form-->

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
                    <table class="resident" id="resident_table">																       <tr>
                            <th width="70%" ></th>
                            <th width="15%" align="center">Marks</th>
                            <th width="15%"></th>
                        </tr>
                        <tr>
                            <td align="left">
                                <label id="service_label" class="app_label">Years of service as a Permanent employee</label> <br />
                                <input name="service" type="text" class="app_input" id="service_input" <?php echo("value='".@$service."'"); ?>/><br />

                            </td>
                            <td align="left"><input name="marks31" type="text" class="app_input" id="marks31_input" <?php echo("value='".@$marks31."' disabled"); ?>/></td>

                            <td align="left"><label id="marks31_lable" class="app_label"> Out of 20</label></td>
                        </tr>
                        <tr>
                            <td align="left">

                                <label id="distance_label" class="app_label">Distance between resident and work place</label><br />
                                <input name="distance" type="text" class="app_input" id="distance_input" <?php echo("value='".@$distance."'"); ?>/>
                            </td>
                            <td align="left"><input name="marks32" type="text" class="app_input" id="marks32_input" <?php echo("value='".@$marks32."' disabled"); ?>/></td>
                            <td align="left"><label id="marks32_label" class="app_label"> Out of 35</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="remoteCurrent_label" class="app_label">years of service if currently engaging remote service in a School</label><br />
                                <input name="remoteCurrent" type="text" class="app_input" id="remoteCurrent_input" <?php echo("value='".@$remoteCurrent."'"); ?>/> <br />
                                <label id="remote_label" class="app_label">Years of service if engaged in remote service</label><br />
                                <input name="remote" type="text" class="app_input" id="remote_input" <?php echo("value='".@$remote."'"); ?>/><br />

                            </td>
                            <td align="left"><input name="marks33" type="text" class="app_input" id="marks33_input" <?php echo("value='".@$marks33."' disabled"); ?>/></td>
                            <td align="left"><label id="marks33" class="app_label"> Out of 25</label>

                            </td>


                        </tr>
                        <tr>
                            <td align="left">

                                <label id="holiday_label" class="app_label">Number of holidays not claimed :</label>
                                <br /><label id="year">Past 1st year </label>
                                <input name="y2013" type="text" class="app_input" id="2013_input" <?php echo("value='".@$y2013."'"); ?>/>
                                <br /><label id="year">Past 2nd year</label>
                                <input name="y2012" type="text" class="app_input" id="2012_input" <?php echo("value='".@$y2012."'"); ?>/>
                                <br /><label id="year">Past 3rd year </label>
                                <input name="y2011" type="text" class="app_input" id="2011_input" <?php echo("value='".@$y2011."'"); ?>/>
                                <br /><label id="year">Past 4th year </label>
                                <input name="y2010" type="text" class="app_input" id="2010_input" <?php echo("value='".@$y2010."'"); ?>/>
                                <br /><label id="year">Past 5th year </label>
                                <input name="y2009" type="text" class="app_input" id="2009_input" <?php echo("value='".@$y2009."'"); ?>/>
                            </td>
                            <td align="left"><input name="marks34" type="text" class="app_input" id="marks34_input" <?php echo("value='".@$marks34."' disabled"); ?>/></td>
                            <td align="left"><label id="marks34_label" class="app_label"> Out of 10</label></td>
                        </tr>


                        <tr>
                            <td align="left">

                                <label id="schservice_label" class="app_label">Years of service in applied school if working in applied school</label><br />
                                <input name="schservice" type="text" class="app_input" id="schservice_input" <?php echo("value='".@$schservice."'"); ?>/>
                            </td>
                            <td align="left"><input name="marks35" type="text" class="app_input" id="marks35_input" <?php echo("value='".@$marks35."' disabled"); ?>/></td>
                            <td align="left"><label id="marks35_label" class="app_label"> Out of 10</label></td>
                        </tr>

                        <!-- Common End of The Form-->
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

                <!-- Education Officials' Children form ends-->

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
