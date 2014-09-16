<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
require('Validate.php');
if(isset($_POST['submit'])and ($_POST['submit']=="Submit"))
{
    $val="submit";
}elseif(isset($_POST['calc'])and ($_POST['calc']=="Calculate"))
{
    $Elec_reg = getVal(@$_POST['Elec_reg']);
    $Elec_reg2 = getVal(@$_POST['Elec_reg2']);
    $marks1 = getVal(@$_POST['marks1']);
    $marks2 = getVal(@$_POST['marks2']);
    $marks3 = getVal(@$_POST['marks3']);
    $marks4 = getVal(@$_POST['marks4']);
    $ownership = getVal(@$_POST['ownership']);
    $proof = getVal(@$_POST['proof']);
    $other_sch = getVal(@$_POST['other_sch']);
    $ownerDuration = getVal(@$_POST['ownerDuration']);
}
$val=removeNull(@$val);
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

                <!-- Residential form-->

                <form id="stage1" action="<?php $_PHP_SELF ?>" method="post">
                    <table class="resident" id="resident_table">																       <tr>
                            <th width="70%" ></th>
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
                            <td align="left"><input name="marks1" type="text" class="app_input" id="marks1_input" <?php echo("value='".@$marks1."'"); ?>/></td>

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
                                        Registered lease deed</label>
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
                                        <input type="radio" name="ownership" value="Othere" id="ownership_2" <?php if (@$ownership=="Othere") echo "checked";?>/>
                                        Othere</label>
                                    <br />
                                    <label id="ownerDuration_label" class="app_label">Duration of the Ownership (Years)</label>
                                    <input name="ownerDuration" type="text" class="app_input" id="ownerDuration_label" <?php echo("value='".@$ownerDuration."'"); ?>/><br />

                                </p><br />
                            </td>
                            <td align="left"><input name="marks2" type="text" class="app_input" id="marks2_input" <?php echo("value='".@$marks2."'"); ?>/></td>
                            <td align="left"><label id="marks2" class="app_label"> Out of 10</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="proof_label" class="app_label">Number of extra documents to verify the residant place</label><br />
                                <input name="proof" type="text" class="app_input" id="proof_input" <?php echo("value='".@$proof."'"); ?>/> <br />

                            </td>
                            <td align="left"><input name="marks3" type="text" class="app_input" id="marks3_input" <?php echo("value='".@$marks3."'"); ?>/></td>
                            <td align="left"><label id="marks3" class="app_label"> Out of 5</label></td>

                        </tr>


                        <tr>
                            <td align="left">
                                <label id="other-sch_label" class="app_label">Number of schools near than this</label><br />
                                <input name="other_sch" type="text" class="app_input" id="other-sch_input" <?php echo("value='".@$other_sch."'"); ?>/>
                            </td>
                            <td align="left"><input name="marks4" type="text" class="app_input" id="marks4_input" <?php echo("value='".@$marks4."'"); ?> /></td>
                            <td align="left"><label id="marks4" class="app_label"> Out of 50</label></td>
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
