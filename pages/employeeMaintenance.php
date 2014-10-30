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

$pageTitle = "Employee Maintenance";

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
                showEmployees();
                $('#newEmployee').hide();
                $('#firstName').val("");
                $('#lastName').val("");
                $('#email').val("");
                $('#dateOfBirth').val("");
                $('#mobileNumber').val("");
                $('#NInumber').val("");
                $('#dateOfBirth').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'
                });
            });
            
            var gEmployeeId = 0;
                       
            function doAmend(thisId)
            {
                gEmployeeId = thisId;
                
                $('#addBtn').val('Update');
                $('#employeeInfo').hide();
                $('#newEmployee').show();
                $('#newEmployeeBtn').hide();
                $('#firstName').focus();
                
                $.ajax({
                   url: 'project5_ajax.php',
                   cache: false,
                   data: {'request': 'getEmployeeData', employeeId: thisId},
                   dataType: 'json',
                   success: function(data)
                   {
                       $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#firstName').val(data.firstName);
                              $('#lastName').val(data.lastName);
                              $('#email').val(data.email);
                              $('#dateOfBirth').val(data.dateOfBirth);
                              $('#mobileNumber').val(data.mobileNumber);
                              $('#NInumber').val(data.NInumber);
                          }
                   }
                });
                
            }
            
            function showEmployees()
            {
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'showEmployees'},
                  dataType: 'json',
                  success: function(data)
                  {
                        var dataArray = data.resultData;
                        var outputStr = "";
                        outputStr = "<br><br><table class='table'><tr><th></th><th>First Name</th>";
                        outputStr = outputStr + "<th>Last Name</th>";    
                        outputStr = outputStr + "<th>Email Address</th>";    
                        outputStr = outputStr + "<th>Date Of Birth</th>";    
                        outputStr = outputStr + "<th>Mobile Number</th>";    
                        outputStr = outputStr + "<th>National Insurance No.</th>";    

                        for (var i = 0; i < dataArray.length; i++)
                        {
                            outputStr = outputStr + "<tr><td>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + dataArray[i].employeeId + "\");'>";
                            outputStr = outputStr + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].firstName + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].lastName + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].email + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].dateOfBirth + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].mobileNumber + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].NInumber + "</td>";
                            
                        }
                        outputStr = outputStr + "</tr></table>";
              
                        //alert(outputStr);
                        $('#employeeInfo').html(outputStr);                
                  } 
                
                });
            }
            
            function addNewEmployee()
            {
                $('#employeeInfo').hide();
                $('#newEmployee').show();
                $('#addBtn').val('Add');
                $('#newEmployeeBtn').hide();
                $('#firstName').focus();
            }
            
            function doCancel()
            {
                $('#employeeInfo').show();
                $('#newEmployee').hide();
                $('#newEmployeeBtn').show();
                $('#firstName').val("");
                $('#lastName').val("");
                $('#email').val("");
                $('#dateOfBirth').val("");
                $('#mobileNumber').val("");
                $('#NInumber').val("");
            }
            
            function doUpdate()
            {
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var email = $('#email').val();
                var dateOfBirth = $('#dateOfBirth').val();
                var mobileNumber = $('#mobileNumber').val();
                var NInumber = $('#NInumber').val();
                
                var requestType = "insertEmployee";
                if (gEmployeeId > 0)
                {
                    requestType = "updateEmployee";
                    
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'employeeId': gEmployeeId, 'firstName': firstName, 'lastName': lastName, 'email': email, 'dateOfBirth': dateOfBirth, 'mobileNumber': mobileNumber, 'NInumber': NInumber},
                  dataType: 'json',
                  success: function(data)
                  {
                    alert("Successful");
                    location.reload();
                  }
                });    
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
                    <div id="newEmployeeBtn" class="divBtns" onclick="addNewEmployee();">Add New Employee</div>
                    <br><div id="newEmployee">
                        <br><br>
                        <table class="table">
                            <tr>
                                <td> First Name </td>
                                <td> <input id="firstName" name="firstName" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Last Name </td>
                                <td> <input id="lastName" name="lastName" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Email Address </td>
                                <td> <input id="email" name="email" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Date Of Birth </td>
                                <td> <input id="dateOfBirth" name="dateOfBirth" type="date" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Mobile Number </td>
                                <td> <input id="mobileNumber" name="mobileNumber" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> National Insurance No. </td>
                                <td> <input id="NInumber" name="NInumber" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> <input id="addBtn" type="button" class="formBtns" onclick="doUpdate();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();"> </td>
                            </tr>
                        </table>
                        <input type="hidden" id="employeeId" name="employeeId">
                    </div>
                    
                    <div id="employeeInfo"></div>
                </div>       
            </center>         
        </div>     

    </body>
</html>