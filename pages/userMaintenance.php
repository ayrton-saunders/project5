<?php
/*
 * Author : A.Saunders
 * Desc:  Project 3
 * Date:   06/10/2014
 * 
 * 
 */
$modNo = "1";

$pageNumber = 1;

$pageTitle = "User Maintenance";

$username = $_COOKIE['loggedIn'];

if (trim($username) == null)
{
    header('location:loginPage.php');
}
?>

<html>
    <head>
        <link href="../css/style.css" rel="stylesheet" type="text/css"/>
        <script type='text/javascript' src='../includes/javascript.js'></script>
        <link rel="icon" type="image/png" href="favicon.ico"/>
        <script type='text/javascript' src='../jquery/jquery.min.js'></script>
        <script type='text/javascript' src='../jquery/jquery.ui.min.js'></script>
        <link href='../jquery/css/smoothness/jquery-ui.css' rel='stylesheet'/>
        <meta name='viewport' content ='width=device-width, initial-scale=1.0'/>
        <script type="text/javascript" src="../navgoco/src/jquery.navgoco.js"></script>
        <link rel="stylesheet" href="../navgoco/src/jquery.navgoco.css" type="text/css" media="screen" />
        <title></title>
        <script type="text/javascript">
            $(document).ready(function()
            {
                //alert(window.screen.width);
                //alert(window.screen.height);
                doMenu();
                showUsers();
                $('#newUser').hide();
                $('#username').val("");
                $('#password').val("");
                $('#confirmPassword').val("");
            });
            
            var gUserId = 0;
                       
            function doAmend(thisId)
            {
                gUserId = thisId;
                
                $('#addBtn').val('Update');
                $('#userInfo').hide();
                $('#newUser').show();
                $('#newUserBtn').hide();
                $('#username').focus();
                
                $.ajax({
                   url: 'project5_ajax.php',
                   cache: false,
                   data: {'request': 'getUserData', userId: gUserId},
                   dataType: 'json',
                   success: function(data)
                   {
                       $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#username').val(data.username);
                              $('#password').val(data.password);
                          }
                   }
                });
                
            }
            
            function showUsers()
            {
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'showUsers'},
                  dataType: 'json',
                  success: function(data)
                  {
                        var dataArray = data.resultData;
                        var outputStr = "";
                        outputStr = "<br><br><table class='table'><tr><th></th><th>Username</th>";
                        outputStr = outputStr + "<th>Password</th>";       

                        for (var i = 0; i < dataArray.length; i++)
                        {
                            outputStr = outputStr + "<tr><td>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + dataArray[i].userId + "\");'>";
                            outputStr = outputStr + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].username + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].password + "</td>";                            
                        }
                        outputStr = outputStr + "</tr></table>";
              
                        //alert(outputStr);
                        $('#userInfo').html(outputStr);                
                  } 
                
                });
            }
            
            function addNewUser()
            {
                $('#userInfo').hide();
                $('#newUser').show();
                $('#addBtn').val('Add');
                $('#newUserBtn').hide();
                $('#username').focus();
            }
            
            function doCancel()
            {
                $('#userInfo').show();
                $('#newUser').hide();
                $('#newUserBtn').show();
                $('#username').val("");
                $('#password').val("");
                $('#confirmPassword').val("");
            }
            
            function doUpdate()
            {
                var username = $('#username').val();
                var password = $('#confirmPassword').val();
                
                var requestType = "insertUser";
                if (gUserId > 0)
                {
                    requestType = "updateUser";
                    
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'userId': gUserId, 'username': username, 'password': password},
                  dataType: 'json',
                  success: function(data)
                  {
                    alert("Successful");
                    location.reload();
                  }
                });    
            }
            
            function checkPassword()
            {
                var password = $('#password').val();
                var cPassword = $('#confirmPassword').val();
        
                if (cPassword !== password)
                {
                    alert("Passwords Do Not Match.  Please Re-enter");
                    $('#password').val("");
                    $('#confirmPassword').val("");
                }
            }
           
                                 
        </script>        
    </head>
    <body>
        <div id="menuBar">
            
        </div>   
            
        
        <div id="background-wrap">
            <?php include_once '../includes/cloudsBackground.php'; ?>
            <center>
                <div id="header" class="divDesign">
                    <?php include_once '../includes/header.php'; ?>
                </div>
                <div id="content" class="divDesign">
                    <br><br>
                    <div id="newUserBtn" class="divBtns" onclick="addNewUser();">Add New User</div>
                    <br><div id="newUser">
                        <br><br>
                        <table class="table">
                            <tr>
                                <td> Username </td>
                                <td> <input id="username" name="username" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Password </td>
                                <td> <input id="password" name="password" type="password" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Confirm Password </td>
                                <td> <input id="confirmPassword" name="confirmPassword" type="password" class="inputBox" onchange="checkPassword();"> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> <input id="addBtn" type="button" class="formBtns" onclick="doUpdate();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();"> </td>
                            </tr>
                        </table>
                        <input type="hidden" id="userId" name="userId">
                    </div>
                    
                    <div id="userInfo"></div>
                </div>       
            </center>         
        </div>     

    </body>
</html>