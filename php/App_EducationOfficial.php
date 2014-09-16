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

                <!-- Education Officials' Children form-->

                <form id="stage1" action="<?php $_PHP_SELF ?>" method="post">
                    <table class="resident" id="resident_table">																       <tr>
                            <th width="70%" ></th>
                            <th width="15%" align="center">Marks</th>
                            <th width="15%"></th>
                        </tr>
                        <tr>
                            <td align="left">
                                <label id="post-service_label" class="app_label">Years of service as a permenent emploee in the perticular organisation</label> <br /><input name="post-service" type="text" class="app_input" id="post-service_input" /><br />

                            </td>
                            <td align="left"><input name="marks31" type="text" class="app_input" id="marks31_input" /></td>

                            <td align="left"><label id="marks31_lable" class="app_label"> Out of 20</label></td>
                        </tr>
                        <tr>
                            <td align="left">

                                <label id="distance_label" class="app_label">Distance between resident place and work place</label><br /><input name="distance" type="text" class="app_input" id="distance_input" />
                            </td>
                            <td align="left"><input name="marks32" type="text" class="app_input" id="marks32_input" /></td>
                            <td align="left"><label id="marks32_label" class="app_label"> Out of 35</label></td>
                        </tr>

                        <tr>
                            <td align="left">
                                <label id="remote-servicename_label" class="app_label">years of if engaging remote sevice in a School</label><br /><input name="remote-servicename" type="text" class="app_input" id="remote-servicename_input" /> <br />
                                <label id="remote-sevicetime_label" class="app_label">Years of service if engaged in remote service</label><br /> <input name="remote-sevicetime" type="text" class="app_input" id="remote-sevicetime_input" /><br />

                            </td>
                            <td align="left"><input name="marks33" type="text" class="app_input" id="marks33_input" /></td>
                            <td align="left"><label id="marks33" class="app_label"> Out of 25</label>

                            </td>


                        </tr>
                        <tr>
                            <td align="left">

                                <label id="holiday_label" class="app_label">Number of holidays not claimed</label>
                                <br /><label>Past 1st year</label><input name="2013" type="text" class="app_input" id="2013_input" />
                                <br /><label>Past 2nd year</label><input name="2012" type="text" class="app_input" id="2012_input" />
                                <br /><label>Past 3rd year</label><input name="2011" type="text" class="app_input" id="2011_input" />
                                <br /><label>Past 4th year</label><input name="2010" type="text" class="app_input" id="2010_input" />
                                <br /><label>Past 5th year</label><input name="2009" type="text" class="app_input" id="2009_input" />
                            </td>
                            <td align="left"><input name="marks34" type="text" class="app_input" id="marks34_input" /></td>
                            <td align="left"><label id="marks34_label" class="app_label"> Out of 10</label></td>
                        </tr>


                        <tr>
                            <td align="left">

                                <label id="schname_label" class="app_label">Years of service in applied school if working in applied school</label><br /><input name="schname" type="text" class="app_input" id="schname_input" />
                            </td>
                            <td align="left"><input name="marks35" type="text" class="app_input" id="marks35_input" /></td>
                            <td align="left"><label id="marks35_label" class="app_label"> Out of 10</label></td>
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

                <!-- Education Officials' Children form ends-->

            </div>
            <div class="content_bottom">
            </div>
    </div>
</div>
<!--content end-->

</body>
</html>
