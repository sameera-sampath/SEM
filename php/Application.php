<?php
namespace SEM;
include "Application_Handler.php";
require_once('authorize.php');
?>
<!DOCTYPE html>
<!--Check whether the user is logged in.-->
<html>
<head>
    <title>Student Enrolment Module</title>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
    <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/template.css">
    <SCRIPT language=JavaScript>
        <!--
        function reload(form,st)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            self.location='Application.php?stage='+st+'&cat=' + val ;
        }
        function reload3(form,st)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            var val2=form.subcat.options[form.subcat.options.selectedIndex].value;

            self.location='Application.php?stage='+st+'&cat=' + val + '&cat3=' + val2 ;
        }
        function disableselect()
        {
            <?Php
            if(isset($cat) and strlen($cat) > 0){
            echo "document.f1.subcat.disabled = false;";
            }
            else{echo "document.f1.subcat.disabled = true;";}
            ///////// for Division list box//////////
            if(isset($cat3) and strlen($cat3) > 0){
             echo "document.f1.subcat3.disabled = false;";
             echo "document.f1.subcat.disabled = false;";}
             else{echo "document.f1.subcat3.disabled = true;";
                if(isset($cat) and strlen($cat) > 0){
                echo "document.f1.subcat.disabled = false;";
                }
                else{echo "document.f1.subcat.disabled = true;";}
             }
            ?>
        }
        //-->

    </script>
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
        <?php
        $stage=1;
        $handle=new Application_Handler();
        if(isset($_GET['stage'])){
            $stage = $_GET['stage'];
        }
        if ($stage == '1') {
        ?>
        <div class="content_title">New Allication - Student Information</div>
        <div class="content_allication">
            <form onload="disableselect()" id="stage1" name="f1" action="<?php $handle->validate_st1() ?>" method="post">
                <span class="error">* required field.</span>
                <?Php
                //Connect to the database
                require_once('connection.php');

                ///////// Getting the data from Mysql table for District list box//////////
                $quer2="SELECT DISTINCT District_ID,District_Name FROM district order by District_ID";
                ///////////// End of query for first list box////////////

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
                ?>

                <legend><strong id="SchoolLabel">School :</strong></legend>
                <label id="district-label" class="app_label">
                    <strong>Select District</strong>
                <div id="district-select" class="app_select" >
                <?php
                //////////        Starting of District drop downlist /////////
                $result2 = mysql_query ($quer2);
                echo "<select name='cat' onchange=\"reload(this.form,1)\"><option value=''>Select District</option>";
                while($noticia2 = mysql_fetch_array($result2)) {
                    if($noticia2['District_ID']==@$cat){echo "<option selected value='$noticia2[District_ID]'>$noticia2[District_Name]</option>"."<BR>";}
                    else{echo  "<option value='$noticia2[District_ID]'>$noticia2[District_Name]</option>";}
                }
                echo "</select>";
                //////////////////  This will end the District drop down list ///////////
                ?>

                    </div>
                </label>
                <label id="division-label" class="app_label">
                    <strong>Select Division</strong>
                    <div id="division-select" class="app_select" >

                <?php
                //////////        Starting of Division drop downlist /////////
                $result = mysql_query ($quer);
                if(isset($cat) and strlen($cat) > 0){
                    echo "<select name='subcat' onchange=\"reload3(this.form,1)\"><option value=''>Select Division</option>";
                }
                else{echo "<select name='subcat' onchange=\"reload3(this.form,1)\"><option value=''>First Select District</option>";}
                while($noticia = mysql_fetch_array($result)) {
                    if($noticia['Division_ID']==@$cat3){echo "<option selected value='$noticia[Division_ID]'>$noticia[Division_Name]</option>"."<BR>";}
                    else{echo  "<option value='$noticia[Division_ID]'>$noticia[Division_Name]</option>";}
                }
                echo "</select>";
                //////////////////  This will end the Division drop down list ///////////
                ?>

                    </div>
                </label>
                <label id="school-label" class="app_label">
                    <strong>Select School</strong>
                    <div id="school-select" class="app_select" >

                <?php
                //////////        Starting of School drop downlist /////////
                $result3 = mysql_query ($quer3);
                if(isset($cat3) and strlen($cat3) > 0){
                    echo "<select name='subcat3' ><option value=''>Select School</option>";
                }
                else{echo "<select name='subcat3' ><option value=''>First Select Division</option>";}
                while($noticia3 = mysql_fetch_array($result3)) {
                    echo  "<option value='$noticia3[School_ID]'>$noticia3[School_Name]</option>";
                }
                echo "</select>";
                //////////////////  This will end the School drop down list ///////////
                ?>
                    </div>
                </label>

                <label id="name-label" class="app_label">
                    <strong>Full Name</strong>
                    <textarea name="name" id="name" rows="2" cols="50"></textarea>
                </label> <br />



                <label id="initial-label" class="app_label">
                    <strong>Initials</strong>
                    <input type="text" name="initial" id="initial" class="app_input">
                </label>&nbsp;&nbsp;&nbsp;&nbsp;


                <label id="Last_name-label" class="app_label">
                    <strong>Last Name</strong>
                    <input name="Last Name" type="text" class="app_input" id="Last_name" /> </label>
                <br/>

                <label id="Gender-label" class="app_label">
                    <strong>Gender</strong> </label> <p>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label>
                        <input type="radio" name="RadioGroup" value="radio" id="Gender_radio" />
                        Male</label>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup" value="radio" id="Gender_radio" />
                        Female</label>
                </p>

                <br />




                <label id="Religion-label" class="app_label" > <strong>Religion</strong></label>


                </br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="Religion" class="app_select" id="religion_select" role="combobox">
                    <option value="1">Buddhism</option>
                    <option value="2">Hindu</option>
                    <option value="3"> Catholic</option>
                    <option value="4"> Chritian</option>
                    <option value="5"> Islam</option>
                    <option value="6"> Othere</option>
                </select>
                <br /><br />

                <label id="Edu_medium-label" class="app_label">
                    <strong>Education Medium</strong> </label> <p>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label>
                        <input type="radio" name="RadioGroup1" value="radio" id="Edu_medium_radio" />
                        Sinhala</label>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup1" value="radio" id="Edu_medium_radio" />
                        English</label>

                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup1" value="radio" id="Edu_medium_radio" />
                        Tamil</label>

                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup1" value="radio" id="Edu_medium_radio" />
                        Bilingual</label>
                </p>


                <br />

                <div class="button">
                    <input id="nextstep" name="nextstep" type="submit" value="Next step" class="submit_button">
                </div>
            </form>
            <?php } if ($stage == '2') { ?>
            <div class="content_title">New Allication - Information about Father/Mother/Gardian</div>
            <div class="content_allication">
            <form id="stage2" action="Application_Handler.php" method="post">
                    <label id="name-label" class="app_label">
                        <strong>Initials</strong>
                        <input type="text" name="initial" id="initial" class="app_input">
                    </label><br>
                    <label id="initial-label" class="app_label">
                        <strong>Initials</strong>
                        <input type="text" name="initial" id="initial" class="app_input">
                    </label><br>

                    <div class="button">
                        <input id="submit" name="submit" type="submit" value="Proceed" class="submit_button">
                    </div>
                </form>
            <?php } ?>

        </div>
        <div class="content_bottom">
        </div>
    </div>
</div>
<!--content end-->

</body>
</html>