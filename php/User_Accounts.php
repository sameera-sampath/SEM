<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('Authorize.php');
?>

<html>
<head>
    <title>EMIS Home Page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/template.css">
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
                       <span><a href="Logout.php" class="link1" style="cursor:pointer;color: #5779ff">&nbsp;&nbsp;&nbsp;Logout</a></span>
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
            <div class="content_title">Main Modules</div>
            <div class="content_middle">
                <div class="content_block"><a href="http://103.29.60.41:8080/EMIS/schoolnet/" class="content_link">
                        <span class="content_link_text">Reports&nbsp;</span></a><!--<div class="alert1"></div>--></div>
                <div class="content_block"><a href="http://103.29.60.41:8080/EMIS/timetable/" class="content_link">
                        <span class="content_link_text">Timetable<br>&nbsp;</span></a></div>
                <div class="content_block"><a href="http://103.29.60.41:8080/EMIS/retirement/" class="content_link">
                        <span class="content_link_text">Retirement<br>&nbsp;</span></a></div>
                <div class="content_block"><a href="http://103.29.60.41:8080/EMIS/administrator/" class="content_link">
                        <span class="content_link_text">Administrator<br>&nbsp;</span></a></div>

                <!--<div class="content_block"><a href="http://103.29.60.41:8080/EMIS/approvel/" class="mcibm_block_link"><img src="EMIS_files/settings.png" alt="dashboard" height="35" width="48">Approve<br>
                        <span class="mcibm_block_link_text">&nbsp;</span></a></div>-->
            </div>
            <div class="content_bottom">
            </div>
    </div>
</div>
<!--content end-->

</body>
</html>
