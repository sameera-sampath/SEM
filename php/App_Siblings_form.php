<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
$app=intval(@$_SESSION['SESS_Appication']);
$cat=intval(@$_SESSION['SESS_Category']);
if($app>0 AND $cat==3){

require('Validate.php');
//Connect to the database
require_once('connection.php');

if(isset($_POST['submit']))
{
    $Elec_reg = intval(getVal(@$_POST['Elec_reg']));
    $Elec_reg2 = intval(getVal(@$_POST['Elec_reg2']));
    $ownership = getVal(@$_POST['ownership']);
    $proof = intval(getVal(@$_POST['proof']));
    $other_sch = intval(getVal(@$_POST['other_sch']));
    $ownerDuration = intval(getVal(@$_POST['ownerDuration']));
    $marks1=electorial_marks(@$Elec_reg,@$Elec_reg2);
    $marks2 = ownership(@$ownership,@$ownerDuration);
    $marks3 = extra_doc(@$proof);
    $marks4 = near($marks1,$other_sch);
    $markst=$marks1+$marks2+$marks3+$marks4;
    if($_POST['submit']=="Submit")
    {
        $sql="INSERT INTO Siblings_Marks ".
            "(Application_ID, Category_ID, Electoral_Years, Electoral_only_One_Years, Ownership, Ownership_Years, Proofs_Count, School_Count, Marks_Electoral, Marks_Ownership, Marks_Proofs, Marks_School, Marks_Total)".
            "VALUES ('$app', '$cat', '$Elec_reg', '$Elec_reg2', '$ownership', '$ownerDuration', '$proof', '$other_sch', '$marks1', '$marks2', '$marks3', '$marks4', '$markst') ".
            "ON DUPLICATE KEY UPDATE Electoral_Years = VALUES (Electoral_Years),Electoral_only_One_Years = VALUES (Electoral_only_One_Years),Ownership = VALUES (Ownership),Ownership_Years = VALUES (Ownership_Years),".
            "Proofs_Count = VALUES (Proofs_Count),School_Count = VALUES (School_Count),Marks_Electoral = VALUES (Marks_Electoral),Marks_Ownership = VALUES (Marks_Ownership),Marks_Proofs = VALUES (Marks_Proofs),Marks_School = VALUES (Marks_School),Marks_Total = VALUES (Marks_Total);";
        $retval = mysql_query( $sql);
        if(! $retval )
        {
            die('Could not enter data: ' . mysql_error());
        }
        else{
            header("location: UnsetSession_SelectionPanel.php");
        }
    }
    elseif($_POST['calc']=="Calculate")
    {  }
}
else
{
    //Retriev data from DataBase

    $sql="SELECT * FROM Siblings_Marks WHERE Application_ID='$app'";
    $resultses = mysql_query ($sql);
    while($resultSet = mysql_fetch_array($resultses))
    {
        if($resultSet['Application_ID']==$app)
        {
            $Elec_reg=$resultSet['Electoral_Years'];
            $Elec_reg2=$resultSet['Electoral_only_One_Years'];
            $ownership=$resultSet['Ownership'];
            $proof=$resultSet['Proofs_Count'];
            $other_sch=$resultSet['School_Count'];
            $ownerDuration=$resultSet['Ownership_Years'];
            $marks1=$resultSet['Marks_Electoral'];
            $marks2=$resultSet['Marks_Ownership'];
            $marks3=$resultSet['Marks_Proofs'];
            $marks4=$resultSet['Marks_School'];
            $markst=$resultSet['Marks_Total'];
        }
    }
}
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

                <!-- Residential form-->

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
                        <tr><th width="70%" ></th>
                            <th width="15%" align="center">Marks</th>
                            <th width="15%"></th>
                        </tr>
                        <tr>
                            <td align="left">
                                <label id="Elec-reg_label" class="app_label">Number of years applicant and spouse included in the electoral register</label>
                                <input name="Elec_reg" type="text" class="app_input" id="Elec_reg_label" <?php echo("value='".@$Elec_reg."'"); ?>/><br />


                                <label id=" Elec-reg2_label">
                                    Number of years if applicant or spouse is included in electoral register</label>
                                <input name="Elec_reg2" type="text" class="app_input" id="Elec-reg2_input" <?php echo("value='".@$Elec_reg2."'"); ?>/><br />
                            </td>
                            <td align="left"><input name="marks1" type="text" class="app_input" id="marks1_input" <?php echo("value='".@$marks1."' disabled"); ?>/></td>

                            <td align="left"><label id="marks1" class="app_label"> Out of 35</label></td>
                        </tr>
                        <tr>
                            <td align="left">

                                <label id="ownership_label" class="app_label">Ownership of resident place</label>
                                <p>
                                    <label>
                                        <input type="radio" name="ownership" value="Title deed for Applicant" id="ownership_0" <?php if (@$ownership=="Title deed for Applicant") echo "checked";?> />
                                        Title deed for Applicant (or spouse)</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="ownership" value="Title deed for Applicant's Parent" id="ownership_0" <?php if (@$ownership=="Title deed for Applicant's Parent") echo "checked";?> />
                                        Title deed for Applicant's (or spouse's)Parent</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="ownership" value="Registered lease deed" id="ownership_1" <?php if (@$ownership=="Registered lease deed") echo "checked";?>/>
                                        Registered lease deed or Other legally Acceptable documents</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="ownership" value="Official resident" id="ownership_2" <?php if (@$ownership=="Official resident") echo "checked";?>/>
                                        Official resident</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="ownership" value="Unregistered lease deed" id="ownership_2" <?php if (@$ownership=="Unregistered lease deed") echo "checked";?>/>
                                        Unregistered lease deed</label>
                                    <br />
                                    <label>
                                        <input type="radio" name="ownership" value="Other" id="ownership_2" <?php if (@$ownership=="Other") echo "checked";?>/>
                                        Other</label>
                                    <br />
                                    <label id="ownerDuration_label" class="app_label">Duration of the Ownership (Years)</label>
                                    <input name="ownerDuration" type="text" class="app_input" id="ownerDuration_label" <?php echo("value='".@$ownerDuration."'"); ?>/><br />

                                </p><br />
                            </td>
                            <td align="left"><input name="marks2" type="text" class="app_input" id="marks2_input" <?php echo("value='".@$marks2."' disabled"); ?>/></td>
                            <td align="left"><label id="marks2" class="app_label"> Out of 10</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="proof_label" class="app_label">Number of extra documents to verify the residant place</label><br />
                                <input name="proof" type="text" class="app_input" id="proof_input" <?php echo("value='".@$proof."'"); ?>/> <br />

                            </td>
                            <td align="left"><input name="marks3" type="text" class="app_input" id="marks3_input" <?php echo("value='".@$marks3."' disabled"); ?>/></td>
                            <td align="left"><label id="marks3" class="app_label"> Out of 5</label></td>

                        </tr>


                        <tr>
                            <td align="left">
                                <label id="other-sch_label" class="app_label">Number of schools near than the Applied School</label><br />
                                <input name="other_sch" type="text" class="app_input" id="other-sch_input" <?php echo("value='".@$other_sch."'"); ?>/>
                            </td>
                            <td align="left"><input name="marks4" type="text" class="app_input" id="marks4_input" <?php echo("value='".@$marks4."' disabled"); ?> /></td>
                            <td align="left"><label id="marks4" class="app_label"> Out of 50</label></td>
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
                        <input id="submit" name="calc" type="submit" value="Calculate" class="submit_button">
                    </div></td><td></td>
                    </tr>
                    </table>
                </form>

                <!-- Residential form ends-->

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