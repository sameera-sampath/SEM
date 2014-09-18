<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('Authorize.php');
$scl=intval(@$_SESSION['SESS_School']);

if($scl>0){
require('Validate.php');

?>
<html>
<head>
    <title>Student Enrolment Module</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/template.css">
    <SCRIPT language=JavaScript>
        function reload4(form)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            var val2=form.subcat.options[form.subcat.options.selectedIndex].value;
            var val4=form.subcat3.options[form.subcat3.options.selectedIndex].value;

            self.location='Panel.php?cat=' + val + '&cat3=' + val2+ '&scl='+val4;
        }
    </script>
    <style>
        table {width:100%;}
        #content_outer #content_inner .content_allication .content_middle #stage1 #resident_table tr td #Elec-reg_label {
            font-size: 16px;
        }
        strong {
            font-size: 14px;
        }
        label {
            font-size: 16px;
        }
        input {font-size:16px;}
        table {border:#999; border-style:solid; border-width:3px; }
        }
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
        <div class="content_title">Student Enrolment - Finalize</div>
        <div class="content_middle">

            <form id="stage1" name="f1" action="<?php $_PHP_SELF ?>" method="post">
                <table class="resident" id="resident_table">
                    <tr><th width="60%" align="right">Student Name</th>
                        <th width="20%" align="left">Language Medium</th>
                        <th width="20%" align="left">Gender</th>
                        <th width="20%" align="left">Marks</th>
                    </tr>

                    <label id="district-label" class="app_label">
                        <tr><td align="right"><strong>Select Student</strong></td></tr>
                            <div id="district-select" class="std_select" >
                                    <?php
                                    //////////        Starting of Application List /////////
                                    //Connect to the database
                                    require_once('Connection.php');
                                    $sqli="SELECT Application_ID,School_ID,Category_ID,Gender,Religion,Education_Medium,Full_Name,Marks FROM application WHERE School_ID=$scl order by Marks";
                                    $resultset = mysql_query ($sqli);

                                    while($query = mysql_fetch_array($resultset)) {
                                        if($query['School_ID']==$scl){
                                            echo("<tr><td><a href='UnsetSession.php?cat=$query[Category_ID]&app=$query[Application_ID]' class='Student'><span>$query[Category_ID]&nbsp;$query[Full_Name]</span></td><td>$query[Education_Medium]</td><td>$query[Gender]</td><td>$query[Marks]</td></a></tr>");
                                        }
                                    }
                                    //////////////////  This will end the Application list ///////////
                                    ?>

                                </div>
                    </label>

                </table>
            </form>
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
    header("location: Confirm_Student.php?select_school=false");
    exit();
}?>