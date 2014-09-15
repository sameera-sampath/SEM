<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
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

                <!-- Old Student form-->

                <form id="stage1" action="<?php $_PHP_SELF ?>" method="post">
                    <table class="resident" id="resident_table">																       <tr>
                            <th width="70%" ></th>
                            <th width="15%" align="center">Marks</th>
                            <th width="15%"></th>
                        </tr>
                        <tr>
                            <td align="left">
                                <label id="no-grade_label" class="app_label">Number of grades studied in the school</label> <br /><input name="no-grade" type="text" class="app_input" id="no-grade_input" /><br />

                            </td>
                            <td align="left"><input name="marks21" type="text" class="app_input" id="marks21_input" /></td>

                            <td align="left"><label id="marks21_lable" class="app_label"> Out of 26</label></td>
                        </tr>
                        <tr>
                            <td align="left">

                                <label id="achivmentsin_label" class="app_label">Achivments in the school</label><br /><input name="achivmentsin" type="text" class="app_input" id="achivmentsin_input" />
                            </td>
                            <td align="left"><input name="marks22" type="text" class="app_input" id="marks22_input" /></td>
                            <td align="left"><label id="marks22_label" class="app_label"> Out of 25</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="achivmentssub-related_label" class="app_label">Subject related achivments</label><br /><input name="achivmentssub-relate" type="text" class="app_input" id="achivmentssub-relate_input" /> <br />

                            </td>
                            <td align="left"><input name="marks23" type="text" class="app_input" id="marks23_input" /></td>
                            <td align="left"><label id="marks23" class="app_label"> Out of 25</label></td>

                        </tr>


                        <tr>
                            <td align="left">
                                <label id="achivmentsout_label" class="app_label">Achivments after leaving school and donations for school development</label><br /> <input name="achivmentsout" type="text" class="app_input" id="achivmentsout_input" />
                            </td>
                            <td align="left"><input name="marks24" type="text" class="app_input" id="marks24_input" /></td>
                            <td align="left"><label id="marks24" class="app_label"> Out of 24</label></td>
                        </tr>

                    </table>


                    <div class="button" align="center">
                        <input id="submit" name="submit" type="submit" value="Submit" class="submit_button">
                    </div>
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
