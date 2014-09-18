<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('Authorize.php');
?>

<html>
<head>
    <title>Student Enrolment Module</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/template.css">
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
            <div class="content_title">Student Enrolment</div>
            <div class="content_middle">
                <?php
                //Print the message from previous operation
                if(isset($_GET['insert']))
                {
                    if($_GET['insert']=="Success")
                    {
                        echo("Data Entered Successfully !");
                    }
                }
                ?>
                <div class="content_block"><a href="UnsetSession.php" class="content_link">
                        <span class="content_link_text">New Application&nbsp;</span></a><!--<div class="alert1"></div>--></div>
                <div class="content_block"><a href="Panel.php" class="content_link">
                        <span class="content_link_text">Selection Panel<br>&nbsp;</span></a></div>
                <div class="content_block"><a href="Panel.php" class="content_link">
                        <span class="content_link_text">Appeal<br>&nbsp;</span></a></div>
                <div class="content_block"><a href="Confirm_Student.php" class="content_link">
                        <span class="content_link_text">Confirm Enrolments<br>&nbsp;</span></a></div>

            </div>
            <div class="content_bottom">
            </div>
    </div>
</div>
<!--content end-->

</body>
</html>
