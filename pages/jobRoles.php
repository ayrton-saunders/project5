<?php
/*
 * Author : A.Saunders
 * Desc:  Project 3
 * Date:   06/10/2014
 * 
 * 
 */
$modNo = "1";

$pageNumber = 3;

$pageTitle = "Job Roles";
$btnText = "Insert";

$username = $_COOKIE['loggedIn'];

if (trim($username) == null)
{
    header('location:loginPage.php');
}

if(trim($jobRoleId) !== "")
{
    $requestType = "updateJobRole";
}
else
{
    $requestType = "insertJobRole";
}

$actionDone = "New Job Role Added";

$amend = false;



$con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL" . mysqli_connect_error();
    } 
    else {       
        //Select corresponding job role
        $sql2 = "SELECT * FROM jobRoles";

        $result2 = mysqli_query($con, $sql2);

        $row_cnt2 = mysqli_num_rows($result2);
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
                //$('#inputData').hide();
                //$('#amendBtn').hide();
                $('#amendBtn').html("Insert");
                $('#inputData').hide();
                $('#jobRoleTitleInput').val("");
                $('#jobRoleDescInput').val("");
                doMenu();
            });
            
            var gJobRoleId = 0;
            
            function doUpdate()
            {
                var jobRoleTitle = $('#jobRoleTitleInput').val();
                var jobRoleDesc = $('#jobRoleDescInput').val();
                //var jobRoleId = $('#jobRoleId').val();
                
                var requestType = "insertJobRole";
                if (gJobRoleId > 0)
                {
                    requestType = "updateJobRole";
                    
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'jobRoleId': gJobRoleId, 'jobRoleTitle': jobRoleTitle, 'jobRoleDesc': jobRoleDesc},
                  
                  //fix the ajax call for inserting and updating the sql table
            
                  dataType: 'json',
                  success: function(data)
                  {
                    alert("Successful");
                    location.reload();
                  }
                });    
            }
            
            function doAmend(thisId)
            {
                //performs a read on selected job role
                gJobRoleId = thisId;
                $('#amendBtn').html("Update");
                $('#clickToInsert').hide();
                $('#inputData').show();
                $('#viewData').hide();
                
                $.ajax ({
                    url:'project5_ajax.php',
                    cache:false,
                    data: {'request': 'getJobData', 'jobRoleId': thisId},
                    dataType: 'json',
                    success: function(data)
                      {

                          $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#jobRoleTitleInput').val(data.jobRoleTitle);
                              $('#jobRoleDescInput').val(data.jobRoleDesc);
                          }
                      }
                    });
                            
                $('#inputData').show();
                $('#amendBtn').show();
                $('#viewData').hide();
                $('#jobRoleTitleInput').focus();
            }
            
            function doCancel()
            {
                $('#viewData').show();
                $('#jobRoleTitleInput').val("");
                $('#jobRoleDescInput').val("");
                $('#amendBtn').html("Insert");
                $('#inputData').hide();
                $('#clickToInsert').show();
                $('#viewData').show();
            }
            
            function doInsertNew()
            {
                $('#clickToInsert').hide();
                $('#inputData').show();
                $('#viewData').hide();
                $('#jobRoleTitleInput').focus();
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
                    <br><br><br>    
                        <div id="clickToInsert" class="divBtns" onclick="doInsertNew();">Insert New Job Role</div>
                        <div id="inputData">
                            <table class="table" id="insertNew">
                                <tr>
                                <td>Job Title</td> <td><input type="text" class="inputBox" id="jobRoleTitleInput"></td>
                                </tr>
                                <tr>
                                    <td>Job Description</td> <td><input type="text" class="inputBox" id="jobRoleDescInput"></td>
                                </tr>
                            </table>
                            <div class="divBtns" id="amendBtn" onclick='doUpdate();'></div>
                            <div class="divBtns" id="cancelBtn" onclick="doCancel();">Cancel</div>
                        </div>
                    <br><br><br>

                    <div id="viewData">  
                        <table>
                            <tr>
                                <td>  </td>
                                <td> Job Title </td>
                                <td> Job Description </td>
                            </tr>
                            <?php
                            for ($x = 0; $x < $row_cnt2; $x++)
                            {
                                $row2 = mysqli_fetch_array($result2);

                                $jobRoleId = $row2['jobRoleId'];

                                echo "<tr><td><input type='button' class='formBtns' value='Amend' onclick='doAmend(\"$jobRoleId\");'</td><td>"
                                . $row2['jobRoleTitle'] . "</td><td>"
                                . $row2['jobRoleDesc'] . "</td></tr>";       
                            }

                            mysqli_close($con);

                            ?>

                        </table>
                    </div>
                </div>
            </center>    
        </div>
    </body>
</html>