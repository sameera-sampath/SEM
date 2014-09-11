<!DOCTYPE html>
<!-- To disallow the user to go back when the user still logged in. -->
<?php
    //Start session
    session_start();
    //Unset the variables stored in session
    unset($_SESSION['SESS_USER_ID']);
    unset($_SESSION['SESS_FIRST_NAME']);
    unset($_SESSION['SESS_LAST_NAME']);
    unset($_SESSION['SESS_USER_TYPE']);
    ?>

<html>
<head>
    <title>EMIS Sign In</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body id="body-sign">

<div id="Sign-In">
    <form method="POST" action="login_validate.php">
        <table >
            <tr>
                <td colspan="4"><strong id="EMIS">E-MIS </strong>Sign in Form</td>
            </tr>
            <tr>
                <td id="error" colspan="2">
                    <!--To display error messages-->
                    <?php
                    if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
                        echo '<ul class="err">';
                        foreach($_SESSION['ERRMSG_ARR'] as $msg) {
                            echo '<li>',$msg,'</li>';
                        }
                        echo '</ul>';
                        unset($_SESSION['ERRMSG_ARR']);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td id="User">User Name <b style="text-align: right">:</b> </td>
                <td><input id="username" type="text" name="username"/></td>
            </tr>
            <tr>
                <td id="Pass">Password <b style="text-align: right">:</b> </td>
                <td><input id="password" type="password" name="password" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input id="button" type="submit" name="button" value="LogIn" /></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>