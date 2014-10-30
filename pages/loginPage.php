<?php
/*
 * Author : A.Saunders
 * Desc:  Project 4 - Login and Menu Development
 * Date: 10/10/2014  
 */
$modNo = "1";

$pageNumber = 1;

$cookieValue = "";

setCookie("loggedIn", $cookieValue, time()-3600);
?>

<html>
    <head>
        <link href="../css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" type="image/png" href="favicon.ico"/>
        <script type='text/javascript' src='../jquery/jquery.min.js'></script>
        <script type='text/javascript' src='../jquery/jquery.ui.min.js'></script>
        <link href='../jquery/css/smoothness/jquery-ui.css' rel='stylesheet'/>
        <meta name='viewport' content ='width=device-width, initial-scale=1.0'/>
        <title>Project 4</title>
        <script type="text/javascript">
            $(document).ready(function()
            {
                //alert(window.screen.width);
                //alert(window.screen.height);
            });
            
            function doLogin()
            {
                var username = $('#username').val();
                var password = $('#password').val();
                 $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'chkUser','username': username,'password': password},
                  dataType: 'json',
                  success: function(data)
                  {
                    $('#errMsg').html(data.errMsg);
                    var userValid = data.userValid;
                    if (userValid == false)
                    {
                        alert("Invalid Username or Password");
                    }
                    else
                    {
                        document.location.href="homePage.php";
                    }
                  
                  }
                });               
            }
                                 
        </script>        
</head>
    <body>
        
        <div id="background-wrap">
            <?php include_once '../includes/cloudsBackground.php'; ?>
            <center>
                <div id="loginBox">
                    <br>
                    <center> <img src="../images/blissPic.png" height="150px" width="241px"> </center>
                    <br>
                    <table>
                        <tr> <td> Username </td> </tr>
                        <tr> <td> <input id="username" name="username" type="text" placeholder="Username" class="loginInputBox"> </td> </tr>
                        <tr> <td> Password </td> </tr>
                        <tr> <td> <input id="password" name="password" type="password" placeholder="Password" class="loginInputBox"> </td> </tr>
                    </table>
                    <br><br><br>
                    <center> <div id="loginBtn" class="divBtns" onClick='doLogin();'>Login</div>
                    </form>
                </div>
            </center>
            
        </div>
        
    
    </body>
</html>