<?php
namespace SEM;
include "Application_Handler.php";
require_once('authorize.php');
$stage=1;
$handle=new Application_Handler();
if(isset($_GET['tex']))
{
    $tex=$_GET['tex']; // This line is added to take care if your global variable is off
}
if(isset($_GET['cate']))
{
    $cate=$_GET['cate']; // This line is added to take care if your global variable is off
}
if(isset($_GET['religion']))
{
    $religion=$_GET['religion']; // This line is added to take care if your global variable is off
}
if(isset($_GET['gender']))
{
    $gender=$_GET['gender']; // This line is added to take care if your global variable is off
}
if(isset($_GET['medium']))
{
    $medium=$_GET['medium']; // This line is added to take care if your global variable is off
}

//stage2
$fullname="";
$greligion="";
$nic="";
$address="";
$tel="";
$GND="";
$GNDNO="";
if(isset($_GET['tel']))
{
    $tel=$_GET['tel']; // This line is added to take care if your global variable is off
}
if(isset($_GET['GND']))
{
    $GND=$_GET['GND']; // This line is added to take care if your global variable is off
}
if(isset($_GET['GNDNO']))
{
    $GNDNO=$_GET['GNDNO']; // This line is added to take care if your global variable is off
}
if(isset($_GET['fullname']))
{
    $fullname=$_GET['fullname']; // This line is added to take care if your global variable is off
}
if(isset($_GET['greligion']))
{
    $greligion=$_GET['greligion']; // This line is added to take care if your global variable is off
}
if(isset($_GET['nic']))
{
    $nic=$_GET['nic']; // This line is added to take care if your global variable is off
}
if(isset($_GET['address']))
{
    $address=$_GET['address']; // This line is added to take care if your global variable is off
}
if(isset($_GET['Nationalty']))
{
    $Nationalty=$_GET['Nationalty']; // This line is added to take care if your global variable is off
}

//Connect to the database
require_once('connection.php');

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
if(isset($_GET['scl']))
{
    $scl=$_GET['scl']; // This line is added to take care if your global variable is off
}
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
            var val=form.fullname.value;
            var val2=form.gReligion.options[form.gReligion.options.selectedIndex].value;
            var val4=form.gcat.options[form.gcat.options.selectedIndex].value;
            var val5=form.gsubcat.options[form.gsubcat.options.selectedIndex].value;
            var val6=form.nic.value;
            var val7=form.tel.value;
            var val8=form.GND.value;
            var val9=form.GNDNO.value;
            var i;
            var val10;
            var len1=form.Nationalty.length;
            for(i=0;i<len1;i++)
            {
                if(form.Nationalty[i].checked)
                {
                    val10=form.Nationalty[i].value;
                    break;
                }
            }

            self.location='Application.php?stage='+st+'&fullname=' + val + '&greligion=' + val2 + '&cat=' + val4 + '&cat3=' + val5 + '&nic=' + val6+ '&tel=' + val7+ '&GND=' + val8+ '&GNDNO=' + val9+ '&Nationalty=' + val10;
        }

        function reload4(form,st)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            var val2=form.subcat.options[form.subcat.options.selectedIndex].value;
            var val3=form.name.value;
            var val4=form.subcat3.options[form.subcat3.options.selectedIndex].value;
            var val5=form.category.options[form.category.options.selectedIndex].value;
            var val6=form.Religion.options[form.Religion.options.selectedIndex].value;
            var val7;
            var i;
            var val8;
            var len1=form.RadioGroup.length;
            var len2=form.RadioGroup1.length;
            for(i=0;i<len1;i++)
            {
                if(form.RadioGroup[i].checked)
                {
                    val7=form.RadioGroup[i].value;
                    break;
                }
            }
            for(i=0;i<len2;i++)
            {
                if(form.RadioGroup1[i].checked)
                {
                    val8=form.RadioGroup1[i].value;
                    break;
                }
            }

            self.location='Application.php?stage='+st+'&tex='+val3+'&cat=' + val + '&cat3=' + val2+ '&scl='+val4 +'&cate='+ val5 +'&religion=' + val6 +'&gender=' + val7 +'&medium=' + val8;
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

        if(isset($_GET['stage'])){
            $stage = $_GET['stage'];
        }
        if ($stage == '1') {
        ?>
        <div class="content_title">New Allication - Student Information</div>
        <div class="content_allication">
            <form id="stage1" name="f1" action="<?php $handle->validate_st1() ?>" method="post">
                <span class="error">* required field.</span>

                <legend><strong id="SchoolLabel">School :</strong></legend>
                <label id="district-label" class="app_label">
                    <strong>Select District</strong>
                <div id="district-select" class="app_select" >
                <?php
                //////////        Starting of District drop downlist /////////
                $result2 = mysql_query ($quer2);
                echo "<select name='cat' onchange=\"reload4(this.form,1)\"><option value=''>Select District</option>";
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
                    echo "<select name='subcat' onchange=\"reload4(this.form,1)\"><option value=''>Select Division</option>";
                }
                else{echo "<select name='subcat' onchange=\"reload4(this.form,1)\"><option value=''>First Select District</option>";}
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
                    if($noticia3['School_ID']==@$scl){echo "<option selected value='$noticia3[School_ID]'>$noticia3[School_Name]</option>"."<BR>";}
                    else{echo  "<option value='$noticia3[School_ID]'>$noticia3[School_Name]</option>";}
                }
                echo "</select>";
                //////////////////  This will end the School drop down list ///////////
                ?>
                    </div>
                </label>

                <label id="category-label" class="app_label">
                    <strong>Select Category</strong>
                    <div id="category-select" class="app_select" >

                        <?php
                        //////////        Starting of Category drop downlist /////////
                        $resultC = mysql_query ($queryC);
                        echo "<select name='category' ><option value=''>Select Application Category</option>";
                        while($query = mysql_fetch_array($resultC)) {
                            if($query['Category_ID']==@$cate){echo "<option selected value='$query[Category_ID]'>$query[Category_Name]</option>"."<BR>";}
                            else{echo  "<option value='$query[Category_ID]'>$query[Category_Name]</option>";}
                        }
                        echo "</select>";
                        //////////////////  This will end the Category drop down list ///////////
                        ?>
                    </div>
                </label>

                <label id="name-label" class="app_label">
                    <strong>Full Name</strong>
                    <?php
                    if(isset($tex))
                    {
                        echo("<input type='text' name='name' id='name' size='90' value='$tex' onchange=\"reload4(this.form,1)\"/>");

                    }else
                    {
                        echo("<input type='text' name='name' id='name' size='90' onchange=\"reload4(this.form,1)\"/>");
                    }
                    ?>
                </label> <br />



                <label id="initial-label" class="app_label">
                    <strong>Initials</strong>
                    <?php
                    if(isset($tex))
                    {
                        echo("<input type='text' name='initial' id='initial' value='".$handle->initial($tex)."' class='app_input' disabled />");

                    }else
                    {
                        echo("<input type='text' name='initial' id='initial' class='app_input' disabled />");
                    }
                    ?>
                </label> <br />


                <label id="Last_name-label" class="app_label">
                    <strong>Last Name</strong>
                    <?php
                    if(isset($tex))
                    {
                        echo("<input name='Last_Name' type='text' class='app_input' value='".$handle->LastName($tex)."' id='Last_name' disabled/>");

                    }else
                    {
                        echo("<input name='Last_Name' type='text' class='app_input' id='Last_name' disabled/>");
                    }
                    ?>
                </label> <br />

                <label id="Gender-label" class="app_label">
                    <strong>Gender</strong>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label>
                        <input type="radio" name="RadioGroup" value="Male" <?php if (isset($gender) && $gender=="Male") echo "checked";?> id="Gender_radio" />
                        Male</label>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup" value="Female" <?php if (isset($gender) && $gender=="Female") echo "checked";?> id="Gender_radio" />
                        Female</label>
                </label>
                <br />




                <label id="Religion-label" class="app_label" > <strong>Religion</strong>


                </br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="Religion" class="app_select" id="religion_select" role="combobox"><option value=''>Select Student's Religion</option>
                    <?php
                    for($x=1;$x<7;$x++) {
                        if($x==@$religion)
                        {
                            switch($x)
                            {
                                case 1:
                                    echo "<option selected value='$x'>Buddhism</option>"."<BR>";
                                    break;
                                case 2:
                                    echo "<option selected value='$x'>Hindu</option>"."<BR>";
                                    break;
                                case 3:
                                    echo "<option selected value='$x'>Catholic</option>"."<BR>";
                                    break;
                                case 4:
                                    echo "<option selected value='$x'>Christian</option>"."<BR>";
                                    break;
                                case 5:
                                    echo "<option selected value='$x'>Islam</option>"."<BR>";
                                    break;
                                case 6:
                                    echo "<option selected value='$x'>Other</option>"."<BR>";
                                    break;
                            }
                        }
                    }
                    ?>
                    <option value="1">Buddhism</option>
                    <option value="2">Hindu</option>
                    <option value="3"> Catholic</option>
                    <option value="4"> Christian</option>
                    <option value="5"> Islam</option>
                    <option value="6"> Other</option>
                </select>
                </label><br />

                <label id="Edu_medium-label" class="app_label">
                    <strong>Education Medium</strong> </label> <p>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label>
                        <input type="radio" name="RadioGroup1" value="Sinhala" <?php if (isset($medium) && $medium=="Sinhala") echo "checked";?> id="Edu_medium_radio" />
                        Sinhala</label>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup1" value="English" <?php if (isset($medium) && $medium=="English") echo "checked";?> id="Edu_medium_radio" />
                        English</label>

                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup1" value="Tamil" <?php if (isset($medium) && $medium=="Tamil") echo "checked";?> id="Edu_medium_radio" />
                        Tamil</label>

                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="RadioGroup1" value="Bilingual" <?php if (isset($medium) && $medium=="Bilingual") echo "checked";?> id="Edu_medium_radio" />
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
            <form id="stage2" name="f2" action="<?php $handle->validate_st1() ?>" method="post">
                <label id="fullname-label" class="app_label">
                    <strong>Full Name</strong>
                    <input type="text" name="fullname" id="fullname" class="app_input" onchange=reload3(this.form,2) value="<?php echo $fullname;?>">
                </label><br>
                <label id="ginitial-label" class="app_label">
                    <strong>Initials</strong>
                    <?php
                    if(isset($fullname))
                    {
                        echo("<input type='text' name='ginitial' id='ginitial' value='".$handle->initial($fullname)."' class='app_input' disabled />");

                    }else
                    {
                        echo("<input type='text' name='ginitial' id='ginitial' class='app_input' disabled />");
                    }
                    ?>
                </label> <br />


                <label id="gLast_name-label" class="app_label">
                    <strong>Last Name</strong>
                    <?php
                    if(isset($fullname))
                    {
                        echo("<input name='gLast_Name' type='text' class='app_input' value='".$handle->LastName($fullname)."' id='gLast_name' disabled/>");

                    }else
                    {
                        echo("<input name='gLast_Name' type='text' class='app_input' id='gLast_name' disabled/>");
                    }
                    ?>
                </label> <br />

                <legend><strong id="ResidentLabel">Resident :</strong></legend>
                <label id="gdistrict-label" class="app_label">
                    <strong>Select District</strong>
                    <div id="gdistrict-select" class="app_select" >
                        <?php
                        //////////        Starting of District drop downlist /////////
                        $gresult2 = mysql_query ($quer2);
                        echo "<select name='gcat' onchange=\"reload3(this.form,2)\"><option value=''>Select District</option>";
                        while($gnoticia2 = mysql_fetch_array($gresult2)) {
                            if($gnoticia2['District_ID']==@$cat){echo "<option selected value='$gnoticia2[District_ID]'>$gnoticia2[District_Name]</option>"."<BR>";}
                            else{echo  "<option value='$gnoticia2[District_ID]'>$gnoticia2[District_Name]</option>";}
                        }
                        echo "</select>";
                        //////////////////  This will end the District drop down list ///////////
                        ?>

                    </div>
                </label>
                <label id="gdivision-label" class="app_label">
                    <strong>Select Division</strong>
                    <div id="gdivision-select" class="app_select" >

                        <?php
                        //////////        Starting of Division drop downlist /////////
                        $gresult = mysql_query ($quer);
                        if(isset($cat) and strlen($cat) > 0){
                            echo "<select name='gsubcat' onchange=\"reload3(this.form,2)\"><option value=''>Select Division</option>";
                        }
                        else{echo "<select name='gsubcat' onchange=\"reload3(this.form,2)\"><option value=''>First Select District</option>";}
                        while($gnoticia = mysql_fetch_array($gresult)) {
                            if($gnoticia['Division_ID']==@$cat3){echo "<option selected value='$gnoticia[Division_ID]'>$gnoticia[Division_Name]</option>"."<BR>";}
                            else{echo  "<option value='$gnoticia[Division_ID]'>$gnoticia[Division_Name]</option>";}
                        }
                        echo "</select>";
                        //////////////////  This will end the Division drop down list ///////////
                        ?>
                    </div>
                </label>

                <label id="GND-label" class="app_label">
                    <strong>Grama Niladari Division</strong>
                    <input type="text" name="GND" id="GND" class="app_input"  value="<?php echo $GND;?>">
                </label><br>

                <label id="GNDNO-label" class="app_label">
                    <strong>Grama Niladari Division Number</strong>
                    <input type="text" name="GNDNO" id="GNDNO" class="app_input"  value="<?php echo $GNDNO;?>">
                </label><br>

                <label id="address-label" class="app_label">
                    <strong>Address</strong>
                    <textarea rows="4" cols="40" id="address-text"name="address" class="app_input" ><?php echo $address;?></textarea>
                </label><br>

                <label id="tel-label" class="app_label">
                    <strong>Telephone Number</strong>
                    <input type="text" name="tel" id="tel" class="app_input" maxlength="10"  value="<?php echo $tel;?>">
                </label><br>

                <label id="nic-label" class="app_label">
                    <strong>NIC Number</strong>
                    <input type="text" name="nic" id="nic" class="app_input" maxlength="10"  value="<?php echo $nic;?>">
                </label><br>

                <label id="National-label" class="app_label">
                    <strong>Nationalty</strong>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label>
                        <input type="radio" name="Nationalty" value="SriLankan" <?php if (isset($Nationalty) && $Nationalty=="SriLankan") echo "checked";?> id="Nationalty_radio" />
                        SriLankan</label>
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="Nationalty" value="Female" <?php if (isset($Nationalty) && $Nationalty=="Non-SriLankan") echo "checked";?> id="Nationalty_radio" />
                        Non-SriLankan</label>
                </label>
                <br />

                <label id="gReligion-label" class="app_label" > <strong>Religion</strong>
                <select name="gReligion" class="app_select" id="greligion_select" role="combobox"><option value=''>Select Religion</option>
                    <?php
                    for($x=1;$x<7;$x++) {
                        if($x==@$greligion)
                        {
                            switch($x)
                            {
                                case 1:
                                    echo "<option selected value='$x'>Buddhism</option>"."<BR>";
                                    break;
                                case 2:
                                    echo "<option selected value='$x'>Hindu</option>"."<BR>";
                                    break;
                                case 3:
                                    echo "<option selected value='$x'>Catholic</option>"."<BR>";
                                    break;
                                case 4:
                                    echo "<option selected value='$x'>Christian</option>"."<BR>";
                                    break;
                                case 5:
                                    echo "<option selected value='$x'>Islam</option>"."<BR>";
                                    break;
                                case 6:
                                    echo "<option selected value='$x'>Other</option>"."<BR>";
                                    break;
                            }
                        }
                    }
                    ?>
                    <option value="1">Buddhism</option>
                    <option value="2">Hindu</option>
                    <option value="3"> Catholic</option>
                    <option value="4"> Christian</option>
                    <option value="5"> Islam</option>
                    <option value="6"> Other</option>
                </select>
                </label><br />


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