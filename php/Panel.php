<!DOCTYPE html>
    <!--Check whether the user is logged in.-->
<?php
require_once('authorize.php');

//Connect to the database
require_once('connection.php');
if(isset($_POST['application'])and strlen($_POST['application']) > 0)
{
    $selection;
    $app=$_POST['application'];
    $_SESSION['SESS_Appication'] = $app;
    $_SESSION['SESS_School'] = $_POST['subcat3'];
    if(isset($_POST['category']) and strlen($_POST['category']) > 0)
    {
        $selection= $_POST['category'];

        $sql="SELECT Application_ID,School_Name,Birth_Day,Gender,Religion,Education_Medium,Address,Distance_To_School_KM,Telephone,Full_Name,Applicant_Initials,Applicant_LastName,Applicant_Type,NIC FROM Application, School WHERE Application_ID=$app AND Application.School_ID = School.School_ID";
        $resultses = mysql_query ($sql);
        while($resultSet = mysql_fetch_array($resultses))
        {
            if($resultSet['Application_ID']==$app)
            {
                $_SESSION['SESS_School_Name'] = $resultSet['School_Name'];
                $_SESSION['SESS_Full_Name']=$resultSet['Full_Name'];
                $_SESSION['SESS_NIC']=$resultSet['NIC'];
                $_SESSION['SESS_Applicant_Name']=$resultSet['Applicant_Type']." :     ".$resultSet['Applicant_Initials']." ".$resultSet['Applicant_LastName'];
                $_SESSION['SESS_BD']="Birth Day       : ".$resultSet['Birth_Day'];
                $_SESSION['SESS_Gender']="Gender          : ".$resultSet['Gender'];
                $_SESSION['SESS_Medium']="Language Medium : ".$resultSet['Education_Medium'];
                $_SESSION['SESS_Religion']="Religion        : ".$resultSet['Religion'];
                $_SESSION['SESS_Address']="Address   : ".$resultSet['Address'];
                $_SESSION['SESS_Distance']="Distance To School: ".$resultSet['Distance_To_School_KM']."Km";
                $_SESSION['SESS_Telephone']="Telephone : ".$resultSet['Telephone'];
            }
        }
    }
    else{
        $sql="SELECT Application_ID,Category_ID,School_Name,Birth_Day,Gender,Religion,Education_Medium,Address,Distance_To_School_KM,Telephone,Full_Name,Applicant_Initials,Applicant_LastName,Applicant_Type,NIC FROM Application, School WHERE Application_ID=$app AND Application.School_ID = School.School_ID";
        $resultses = mysql_query ($sql);
        while($resultSet = mysql_fetch_array($resultses))
        {
            if($resultSet['Application_ID']==$app)
            {
                $selection = $resultSet['Category_ID'];
                $_SESSION['SESS_School_Name'] = $resultSet['School_Name'];
                $_SESSION['SESS_Full_Name']=$resultSet['Full_Name'];
                $_SESSION['SESS_NIC']=$resultSet['NIC'];
                $_SESSION['SESS_Applicant_Name']=$resultSet['Applicant_Type']." :     ".$resultSet['Applicant_Initials']." ".$resultSet['Applicant_LastName'];
                $_SESSION['SESS_BD']="Birth Day       : ".$resultSet['Birth_Day'];
                $_SESSION['SESS_Gender']="Gender          : ".$resultSet['Gender'];
                $_SESSION['SESS_Medium']="Language Medium : ".$resultSet['Education_Medium'];
                $_SESSION['SESS_Religion']="Religion        : ".$resultSet['Religion'];
                $_SESSION['SESS_Address']="Address   : ".$resultSet['Address'];
                $_SESSION['SESS_Distance']="Distance To School: ".$resultSet['Distance_To_School_KM']."Km";
                $_SESSION['SESS_Telephone']="Telephone : ".$resultSet['Telephone'];
            }
        }
    }
    $_SESSION['SESS_Category'] = $selection;
    switch($selection)
    {
        case 1:
            $_SESSION['SESS_Category_Name']="Residential";
            header("location: App_Resident.php");
            break;
        case "2":
            $_SESSION['SESS_Category_Name']="Old Student";
            header("location: App_OldStudent.php");
            break;
        case "3":
            $_SESSION['SESS_Category_Name']="Siblings";
            header("location: App_Siblings_form.php");
            break;
        case "4":
            $_SESSION['SESS_Category_Name']="Education Official";
            header("location: App_EducationOfficial.php");
            break;
        case "5":
            $_SESSION['SESS_Category_Name']="Government Officials";
            header("location: App_GovernmentOfficials_Form.php");
            break;
        case "6":
            $_SESSION['SESS_Category_Name']="Foreign Travel";
            header("location: App_ForeignTravel.php");
            break;
        default:
            $_SESSION['SESS_Category_Name']="Residential";
            header("location: App_Resident.php?default=".$selection);
    }
    exit();
}
else{
?>

<html>
<head>
    <title>Student Enrolment Module - Selectoo Panel</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/template.css">
    <SCRIPT language=JavaScript>
        <!--
        function reload3(form)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            var val2=form.subcat.options[form.subcat.options.selectedIndex].value;
            var val4=form.subcat3.options[form.subcat3.options.selectedIndex].value;
            var val5=form.category.options[form.category.options.selectedIndex].value;

            self.location='Panel.php?cat=' + val + '&cat3=' + val2+ '&scl='+val4 +'&cate='+ val5;
        }
        function reload4(form)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            var val2=form.subcat.options[form.subcat.options.selectedIndex].value;
            var val4=form.subcat3.options[form.subcat3.options.selectedIndex].value;

            self.location='Panel.php?cat=' + val + '&cat3=' + val2+ '&scl='+val4;
        }

        //-->

    </script>
</head>
<body>

<!--header start-->
<div id="header_outer">
	<div id="header_inner">
      <div id="header_top">
          <div class="header_top_left"><span><a href="Index.php" class="link1" style="cursor:pointer;color: #d2a5ff">&nbsp;&nbsp;&nbsp;Home</a></span> </div>
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
            <div class="content_title">Application Selection Panel - Select Application</div>
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
                if(isset($scl) and strlen($scl) > 0){
                    if(isset($cate) and strlen($cate) > 0){
                        $queryApp="SELECT Application_ID,Full_Name,Applicant_Initials,Applicant_LastName,Applicant_Type FROM Application where School_ID =$scl AND Category_ID=$cate order by Application_ID";
                    }
                    else{$queryApp="SELECT Application_ID,Full_Name,Applicant_Initials,Applicant_LastName,Applicant_Type FROM Application where School_ID =$scl order by Application_ID";}
                }
                else{$queryApp="";}
                ///////////// End of query for Application list box////////////

                //Print the message from previous operation
                if(isset($_GET['insert']))
                {
                    if($_GET['insert']=="Success")
                    {
                        echo("Data Entered Successfully !");
                    }
                }
                ?>

                <form id="stage1" name="f1" action="<?php $_PHP_SELF ?>" method="post">

                    <legend><strong id="SchoolLabel">School :</strong></legend>
                    <label id="district-label" class="app_label">
                        <strong>Select District</strong>
                        <div id="district-select" class="app_select" >
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

                        </div>
                    </label>
                    <label id="division-label" class="app_label">
                        <strong>Select Division</strong>
                        <div id="division-select" class="app_select" >

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

                        </div>
                    </label>
                    <label id="school-label" class="app_label">
                        <strong>Select School</strong>
                        <div id="school-select" class="app_select" >

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
                            if((isset($scl) and strlen($scl) > 0) or (isset($cate) and strlen($cate) > 0)){
                            //////////////////  This will end the School drop down list ///////////
                            ?>
                        </div>
                    </label>

                    <label id="category-label" class="app_label">
                        <strong>Select Category (Optional)</strong>
                        <div id="category-select" class="app_select" >

                            <?php
                            //////////        Starting of Category drop downlist /////////
                            $resultC = mysql_query ($queryC);
                            echo "<select name='category' onchange=\"reload3(this.form)\"><option value=''>Select Application Category</option>";
                            while($query = mysql_fetch_array($resultC)) {
                                if($query['Category_ID']==@$cate){echo "<option selected value='$query[Category_ID]'>$query[Category_Name]</option>"."<BR>";}
                                else{echo  "<option value='$query[Category_ID]'>$query[Category_Name]</option>";}
                            }
                            echo "</select>";
                            //////////////////  This will end the Category drop down list ///////////
                            ?>
                        </div>
                    </label>

                    <label id="category-label" class="app_label">
                        <strong>Application</strong>
                        <div id="category-select" class="app_select" >

                            <?php
                            //////////        Starting of Application drop downlist /////////
                            $resultApp = mysql_query ($queryApp);
                            echo "<select name='application'><option value=''>Select Application</option>";
                            while($retriev = mysql_fetch_array($resultApp)) {
                            echo  "<option value='$retriev[Application_ID]'>$retriev[Full_Name] : $retriev[Applicant_Type] :- $retriev[Applicant_Initials] $retriev[Applicant_LastName]</option>";
                            }
                            echo "</select>";
                            //////////////////  This will end the Application drop down list ///////////
                            ?>
                        </div>
                    </label>
                    <?php } ?>
                    <div class="button">
                        <input id="proceed" name="proceed" type="submit" value="Proceed" class="submit_button">
                    </div>
                </form>
            </div>
            <div class="content_bottom">
            </div>
    </div>
</div>
<!--content end-->

</body>
</html>
<?php } ?>