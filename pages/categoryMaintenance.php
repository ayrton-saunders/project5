<?php
/*
 * Author : A.Saunders
 * Desc:  
 * Date:   
 * 
 * 
 */
$modNo = "1";

$pageNumber = 2;

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
                showCategories();
                $('#newCategory').hide();
                $('#catDesc').val("");
            });
            
            var gCatId = 0;
            
            function showCategories()
            {
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'showCategories'},
                  dataType: 'json',
                  success: function(data)
                  {
                        var dataArray = data.resultData;
                        var outputStr = "";
                        outputStr = "<br><br><table class='table'><tr><th></th>";
                        outputStr = outputStr + "<th>Description</th>";     

                        for (var i = 0; i < dataArray.length; i++)
                        {
                            outputStr = outputStr + "<tr><td>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + dataArray[i].catId + "\");'>";
                            outputStr = outputStr + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].catDesc + "</td>";
                        }
                        
                        outputStr = outputStr + "</tr></table>";
              
                        //alert(outputStr);
                        $('#categoryInfo').html(outputStr);                
                  } 
                
                });
            }
            
            function doAmend(thisId)
            {
                gCatId = thisId;
                
                $('#addBtn').val("Update");
                $('#newCategory').show();
                $('#newCatBtn').hide();
                $('#categoryInfo').hide();
                $('#catDesc').focus();
                
                $.ajax ({
                    url:'project5_ajax.php',
                    cache:false,
                    data: {'request': 'getCategoryData', 'catId': thisId},
                    dataType: 'json',
                    success: function(data)
                      {
                          $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#catDesc').val(data.catDesc);
                          }
                      }
                    });
            }
            
            function addNewCategory()
            {
                $('#newCategory').show();
                $('#newCatBtn').hide();
                $('#addBtn').val("Add");
                $('#categoryInfo').hide();
                $('#catDesc').focus();
            }
            
            function doCancel()
            {
                $('#categoryInfo').show();
                $('#newCategory').hide();
                $('#newCatBtn').show();
                $('#catDesc').val("");
            }
            
            function doUpdate()
            {
                var catDesc = $('#catDesc').val();
                
                var requestType = "insertCategory";
                if (gCatId > 0)
                {
                    requestType = "updateCategory";
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'catId': gCatId, 'catDesc': catDesc},         
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
                    <div id="newCatBtn" class="divBtns" onclick="addNewCategory();">Add New Category</div>
                    <br><br>
                    <div id="newCategory">
                        <table class="table">
                            <tr>
                                <td> Description </td>
                                <td> <input id="catDesc" name="catDesc" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> <input id="addBtn" type="button" class="formBtns" onclick="doUpdate();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();"> </td>
                            </tr>
                        </table>
                        <input type="hidden" id="catId" name="catId">
                    </div>
                    <div id="categoryInfo"></div>
            
            
            
                </div>       
            </center>
        </div>   
    </body>
</html>