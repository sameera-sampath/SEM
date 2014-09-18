<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');
//Connect to the database
require_once('connection.php');
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
            <div class="content_title">Student Enrolment - Finalize</div>
            <div class="content_middle">
                <?php

                ///////// Getting the data from Mysql table for District list box//////////
                $quer2="SELECT DISTINCT District_ID,District_Name FROM district order by District_ID";
                ///////////// End of query for District list box////////////

                ///////// Getting the data from Mysql table for Category list box//////////
                $queryC="SELECT DISTINCT Category_ID,Category_Name FROM Category order by Category_ID";
                ///////////// End of query for Category list box////////////

                ///////// Getting the data from Mysql table for Division list box//////////
                if(isset($_GET['cat']))
                {
                    $cat=$_GET['cat']; // This line is added to take care if your global variable is off

                }
                if(isset($cat) and strlen($cat) > 0){
                    $quer="SELECT DISTINCT Division_ID,Division_Name FROM Division join Zone on Division.Zone_ID=Zone.Zone_ID where District_ID='".$cat."' order by Division_ID";
                }else{$quer="SELECT DISTINCT Division_ID,Division_Name FROM Division";}
                ///////////// End of query for Division list box////////////

                ///////// Getting the data from Mysql table for School list box//////////
                if(isset($_GET['cat3']))
                {
                    $cat3=$_GET['cat3']; // This line is added to take care if your global variable is off
                }
                if(isset($cat3) and strlen($cat3) > 0){
                    $quer3="SELECT DISTINCT School_ID,School_Name FROM School where Division_ID =$cat3 order by School_ID";
                }
                else{$quer3="SELECT DISTINCT School_ID,School_Name FROM School where Division_ID =null order by School_ID";}
                ///////////// End of query for School list box////////////

                ///////// Getting the data from Mysql table for Application list box//////////
                if(isset($_GET['scl']))
                {
                    $scl=$_GET['scl']; // This line is added to take care if your global variable is off
                }
                if(isset($_GET['cate']))
                {
                    $cate=$_GET['cate']; // This line is added to take care if your global variable is off
                }
                ?>

                <form id="stage1" name="f1" action="<?php $_PHP_SELF ?>" method="post">
                    <table class="resident" id="resident_table">
                        <tr><th width="60%" align="right">Select School or Enter School ID</th>
                            <th width="40%" align="left"></th>
                        </tr>
                    <tr><td colspan="2" align="center"><legend><strong id="SchoolLabel">Select School :</strong></legend>
                        </td></tr>
                        <label id="district-label" class="app_label">
                            <tr><td align="right"><strong>Select District</strong>
                            </td><td align="left"><div id="district-select" class="app_select" >
                            <?php
                            //////////        Starting of District drop downlist /////////
                            $result2 = mysql_query ($quer2);
                            echo "<select name='cat' onchange=\"reload4(this.form)\"><option value=''>Select District</option>";
                            while($noticia2 = mysql_fetch_array($result2)) {
                                if($noticia2['District_ID']==@$cat){echo "<option selected value='$noticia2[District_ID]'>$noticia2[District_Name]</option>"."<BR>";}
                                else{echo  "<option value='$noticia2[District_ID]'>$noticia2[District_Name]</option>";}
                            }
                            echo "</select>";
                            //////////////////  This will end the District drop down list ///////////
                            ?>

                        </div></td></tr>
                    </label>
                    <label id="division-label" class="app_label">
                        <tr><td align="right"><strong>Select Division</strong>
                            </td><td align="left"><div id="division-select" class="app_select" >

                            <?php
                            //////////        Starting of Division drop downlist /////////
                            $result = mysql_query ($quer);
                            if(isset($cat) and strlen($cat) > 0){
                                echo "<select name='subcat' onchange=\"reload4(this.form)\"><option value=''>Select Division</option>";
                            }
                            else{echo "<select name='subcat' onchange=\"reload4(this.form)\"><option value=''>First Select District</option>";}
                            while($noticia = mysql_fetch_array($result)) {
                                if($noticia['Division_ID']==@$cat3){echo "<option selected value='$noticia[Division_ID]'>$noticia[Division_Name]</option>"."<BR>";}
                                else{echo  "<option value='$noticia[Division_ID]'>$noticia[Division_Name]</option>";}
                            }
                            echo "</select>";
                            //////////////////  This will end the Division drop down list ///////////
                            ?>

                        </div></td></tr>
                    </label>
                    <label id="school-label" class="app_label">
                        <tr><td align="right"><strong>Select School</strong>
                            </td><td align="left"><div id="school-select" class="app_select" >

                            <?php
                            //////////        Starting of School drop downlist /////////
                            $result3 = mysql_query ($quer3);
                            if(isset($cat3) and strlen($cat3) > 0){
                                echo "<select name='subcat3' onchange=\"reload4(this.form)\"><option value=''>Select School</option>";
                            }
                            else{echo "<select name='subcat3' onchange=\"reload4(this.form)\"><option value=''>First Select Division</option>";}
                            while($noticia3 = mysql_fetch_array($result3)) {
                                if($noticia3['School_ID']==@$scl){echo "<option selected value='$noticia3[School_ID]'>$noticia3[School_Name]</option>"."<BR>";}
                                else{echo  "<option value='$noticia3[School_ID]'>$noticia3[School_Name]</option>";}
                            }
                            echo "</select>";
                            //////////////////  This will end the School drop down list ///////////
                            ?>
                        </div></td></tr>
                    </label>
                        <tr><td colspan="2" align="center">OR</td></tr>
                        <tr>
                            <td align="right">
                                <label id="marks3" class="app_label">Enter School ID</label></td>
                            <td align="left">
                                <input name="marks3" type="text" class="app_input" id="marks3_input" <?php echo("value='".@$marks3."'"); ?>/></td>

                        </tr>
                        <tr><td colspan="2" align="center">
                    <div class="button">
                        <input id="proceed" name="proceed" type="submit" value="Proceed" class="submit_button">
                    </div></td></tr>
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
