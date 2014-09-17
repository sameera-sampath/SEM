<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
$app=intval(@$_SESSION['SESS_Appication']);
$cat=intval(@$_SESSION['SESS_Category']);

if($app>0 AND $cat==6){
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
    if (DateTime::createFromFormat('Y-m-j', getVal(@$_POST['timef1'])) !== FALSE) {
        $timef1=getVal(@$_POST['timef1']);
    }
    else
    {
        $timef1=null;
    }
    if (DateTime::createFromFormat('Y-m-j', getVal(@$_POST['timef2'])) !== FALSE) {
        $timef2=getVal(@$_POST['timef2']);
    }
    else
    {
        $timef2=null;
    }
    $freson = getVal(@$_POST['freson']);
    $other_sch = intval(getVal(@$_POST['other_sch']));
    $Elec_reg2 = intval(getVal(@$_POST['Elec_reg2']));
    $proof = intval(getVal(@$_POST['proof']));
    $marks1=electorial_marks(0,@$Elec_reg2);
    $marks3 = extra_doc(@$proof);
    $marks41= StayedFor($timef1,$timef2);
    $marks42 = reason(@$freson);
    $marks43 = nearforeign($marks1+$marks3,$other_sch);
    $markst=$marks41+$marks42+$marks43;
    if($_POST['submit']=="Submit")
    {
        $sql="INSERT INTO ForeignTravel_Marks ".
            "(Application_ID, Category_ID, JurneyFrom, JurneyTo, Reason, School_Count, Electoral_only_One_Years, Proofs_Count, Marks_Duration, Marks_Reason, Marks_School, Marks_Total)".
            "VALUES ('$app', '$cat', '$timef1', '$timef2', '$freson', '$other_sch', '$Elec_reg2', '$proof', '$marks41', '$marks42', '$marks43', '$markst') ".
            "ON DUPLICATE KEY UPDATE JurneyFrom = VALUES (JurneyFrom),JurneyTo = VALUES (JurneyTo),Reason = VALUES (Reason),School_Count = VALUES (School_Count),".
            "Electoral_only_One_Years = VALUES (Electoral_only_One_Years),Proofs_Count = VALUES (Proofs_Count),Marks_Duration = VALUES (Marks_Duration),Marks_Reason = VALUES (Marks_Reason),Marks_School = VALUES (Marks_School),Marks_Total = VALUES (Marks_Total);";
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
    $sql="SELECT * FROM EducationWork_Child_Marks WHERE Application_ID='$app'";
    $resultses = mysql_query ($sql);
    while($resultSet = mysql_fetch_array($resultses))
    {
        if($resultSet['Application_ID']==$app)
        {
            $timef1=$resultSet['JurneyFrom'];
            $timef2=@$resultSet['JurneyTo'];
            $freson=@$resultSet['Reason'];
            $other_sch=@$resultSet['School_Count'];
            $Elec_reg2=@$resultSet['Electoral_only_One_Years'];
            $proof=@$resultSet['Proofs_Count'];
            $marks41=$resultSet['Marks_Duration'];
            $marks42=$resultSet['Marks_Reason'];
            $marks43=$resultSet['Marks_School'];
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
            <div class="content_title">Student Enrolment</div>
            <div class="content_middle">

                <!-- Foreign Travel form-->

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
                                <label id=" Elec-reg2_label">
                                    Number of years if applicant And/Or spouse is included in electoral register</label>
                                <input name="Elec_reg2" type="text" class="app_input" id="Elec-reg2_input" <?php echo("value='".@$Elec_reg2."'"); ?>/><br />

                                <label id="proof_label" class="app_label">Number of extra documents to verify the residant place</label><br />
                                <input name="proof" type="text" class="app_input" id="proof_input" <?php echo("value='".@$proof."'"); ?>/> <br />

                            </td>
                            <td colspan="2" align="left"><label id="marks3" class="app_label"> For verifying the resident place</label></td>

                        </tr>
                        <tr>
                            <td align="left">
                                <label id="timef_label" class="app_label">Time period of foreign travel:</label><br /><br/>
                                <label>From (YYYY-MM-DD)</label><br />
                                <input name="timef1" type="text" class="app_input" id="timef1_input" <?php echo("value='".@$timef1."'"); ?> />
                                <br /><label>To (YYYY-MM-DD)</label><br />
                                <input name="timef2" type="text" class="app_input" id="timef2_input" <?php echo("value='".@$timef2."'"); ?>/>

                            </td>
                            <td align="left"><input name="marks41" type="text" class="app_input" id="marks41_input" <?php echo("value='".@$marks41."' disabled"); ?>/></td>

                            <td align="left"><label id="marks41_lable" class="app_label"> Out of 25</label></td>
                        </tr>
                        <tr>
                            <td align="left">

                                <label id="freson_label" class="app_label">Reason for foreign travel:</label>
                                <p>
                                    <label>
                                        <input type="radio" name="freson" value="Diplomatic Travels" id="freson" <?php if (@$freson=="Diplomatic Travels") echo "checked";?>/>
                                        Diplomatic Travels</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="freson" value="For Government Service" id="freson" <?php if (@$freson=="For Government Service") echo "checked";?>/>
                                        For Government Service</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="freson" value="For Scholarship" id="freson" <?php if (@$freson=="For Scholarship") echo "checked";?>/>
                                        For Scholarship</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="freson" value="Private Reason" id="freson" <?php if (@$freson=="Private Reason") echo "checked";?>/>
                                        Private Reason</label>
                                    <br />
                                </p><br />
                            </td>
                            <td align="left"><input name="marks42" type="text" class="app_input" id="marks42_input" <?php echo("value='".@$marks42."' disabled"); ?>/></td>
                            <td align="left"><label id="marks42_label" class="app_label"> Out of 40</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="other-sch_label" class="app_label">Number of schools near than the Applied School</label><br />
                                <input name="other_sch" type="text" class="app_input" id="other-sch_input" <?php echo("value='".@$other_sch."'"); ?>/>
                            </td>
                            <td align="left"><input name="marks43" type="text" class="app_input" id="marks23_input" <?php echo("value='".@$marks43."' disabled"); ?>/></td>
                            <td align="left"><label id="marks43" class="app_label"> Out of 35</label></td>

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

                <!-- Foreign Travel form ends-->

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