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

$pageTitle = "Menu Maintenance";

$username = $_COOKIE['loggedIn'];

if (trim($username) == null)
{
    header('location:loginPage.php');
}

$con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
$sql = "SELECT * FROM categories";
$result = mysqli_query($con, $sql);
$row_cnt = mysqli_num_rows($result); 

//read to get list of categories
$catList = "<select id='catId' name='catId' class='inputBox'>";
for ($x = 0; $x < $row_cnt; $x++)
{
    $row = mysqli_fetch_array($result);
    $catList = $catList . "<option value=" . $row['CategoryId'] . ">" . $row['CategoryDesc'];
}
$catList = $catList . "</select>";

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
                showPrograms();
                $('#newProgram').hide();
                $('#category').val("");
                $('#pageUrl').val("");
                $('#pageName').val("");
                
                $('#confirmDelete').dialog({
                    autoOpen: false,
                    title: 'Delete this Record?',
                    modal: true,
                    buttons: {
                    "Yes": function() {
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                    }
                   
                });
            });
            
            var gProgramId = 0;
                       
            function doAmend(thisId)
            {
                gProgramId = thisId;
                
                $('#addBtn').val('Update');
                $('#programInfo').hide();
                $('#newProgram').show();
                $('#newProgramBtn').hide();
                $('#category').focus();
                
                $.ajax({
                   url: 'project5_ajax.php',
                   cache: false,
                   data: {'request': 'getProgramData', programId: gProgramId},
                   dataType: 'json',
                   success: function(data)
                   {
                       $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#category').val(data.categoryId);
                              $('#pageUrl').val(data.programName);
                              $('#pageName').val(data.programDesc);
                          }
                   }
                });
                
            }
            
            function showPrograms()
            {
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'showPrograms'},
                  dataType: 'json',
                  success: function(data)
                  {
                        var dataArray = data.resultData;
                        var outputStr = "";
                        outputStr = "<br><br><table class='table'><tr><th></th><th>Category</th>";
                        outputStr = outputStr + "<th>Page URL</th>";    
                        outputStr = outputStr + "<th>Page Name</th>";      

                        for (var i = 0; i < dataArray.length; i++)
                        {
                            outputStr = outputStr + "<tr><td>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Delete' onclick='doDelete(\"" + dataArray[i].programId + "\");'>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + dataArray[i].programId + "\");'>";
                            outputStr = outputStr + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].categoryId + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].programName + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].programDesc + "</td>";                            
                        }
                        outputStr = outputStr + "</tr></table>";
              
                        //alert(outputStr);
                        $('#programInfo').html(outputStr);                
                  } 
                
                });
            }
            
            function addNewProgram()
            {
                $('#programInfo').hide();
                $('#newProgram').show();
                $('#addBtn').val('Add');
                $('#newProgramBtn').hide();
                $('#category').focus();
            }
            
            function doCancel()
            {
                $('#programInfo').show();
                $('#newProgram').hide();
                $('#newProgramBtn').show();
                $('#category').val("");
                $('#pageUrl').val("");
                $('#pageName').val("");
            }
            
            function doUpdate()
            {
                var category = $('#catId').val();
                var pageUrl = $('#pageUrl').val();
                var pageName = $('#pageName').val();
                
                var requestType = "insertProgram";
                if (gProgramId > 0)
                {
                    requestType = "updateProgram";
                    
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'programId': gProgramId, 'categoryId': category, 'programName': pageUrl, 'programDesc': pageName},
                  dataType: 'json',
                  success: function(data)
                  {
                    alert("Successful");
                    location.reload();
                  }
                });    
            }
            
            function doDelete(thisId)
            {
                gProgramId = thisId;
                
                $("#confirmDelete").dialog("open");
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
                    <div id="newProgramBtn" class="divBtns" onclick="addNewProgram();">Add New Program</div>
                    <br><div id="newProgram">
                        <br><br>
                        <table class="table">
                            <tr>
                                <td> Category </td>
                                <td> <?php echo $catList; ?> </td>
                            </tr>
                            <tr>
                                <td> Page URL </td>
                                <td> <input id="pageUrl" name="pageUrl" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Page Name </td>
                                <td> <input id="pageName" name="pageName" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> <input id="addBtn" type="button" class="formBtns" onclick="doUpdate();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();"> </td>
                            </tr>
                        </table>
                        <input type="hidden" id="programId" name="programId">
                    </div>
                    
                    <div id="programInfo"></div>
                
                    <div id='confirmDelete'>
                        This record will be permanently deleted and cannot be recovered.  Are you sure you want to continue?
                    </div> 
                </div>  
            </center>         
        </div>     
    </body>
</html>