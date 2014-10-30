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

$pageTitle = "Recipe Maintenance";

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
                showRecipes();
                $('#newRecipe').hide();
                $('#recipeDesc').val("");
                $('#instructions').val("");
            });
            
            var gRecipeId = 0; 
            
            function addNewRecipe()
            {
                $('#newRecipe').show();
                $('#addBtn').val("Add");
                $('#newRecipeBtn').hide();
                $('#recipeInfo').hide();
                $('#recipeDesc').focus();
            }
            
            function doCancel()
            {
                $('#newRecipe').hide();
                $('#newRecipeBtn').show();
                $('#recipeDesc').val("");
                $('#instructions').val("");
                $('#recipeInfo').show();
            }
            
            function doAdd()
            {
                var recipeDesc = $('#recipeDesc').val();
                var instructions = $('#instructions').val();
                
                var requestType = "insertRecipe";
                if (gRecipeId > 0)
                {
                    requestType = "updateRecipe";
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'recipeId': gRecipeId, 'recipeDesc': recipeDesc, 'instructions': instructions},         
                  dataType: 'json',
                  success: function(data)
                  {
                    alert("Successful");
                    location.reload();
                  }
                });    
            } 
            
            function showRecipes()
            {
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'showRecipes'},
                  dataType: 'json',
                  success: function(data)
                  {
                        var dataArray = data.resultData;
                        var outputStr = "";
                        outputStr = "<br><br><table class='table'><tr><th></th><th>Description</th>";        

                        for (var i = 0; i < dataArray.length; i++)
                        {
                            outputStr = outputStr + "<tr><td>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + dataArray[i].recipeId + "\");'>";
                            outputStr = outputStr + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].recipeDesc + "</td>";
                            outputStr = outputStr + "<td><input type='button' class='formBtns' value='Ingredients' onclick='showIngredients(\"" + dataArray[i].recipeId + "\");'></td>";
                        }
                        outputStr = outputStr + "</tr></table>";
              
                        $('#recipeInfo').html(outputStr);                
                  } 
                
                });
            }
            
            function doAmend(thisId)
            {
                gRecipeId = thisId;
                
                $('#newRecipe').show();
                $('#addBtn').val("Update");
                $('#newRecipeBtn').hide();
                $('#recipeInfo').hide();
                $('#recipeDesc').focus();
                $.ajax({
                   url: 'project5_ajax.php',
                   cache: false,
                   data: {'request': 'getRecipeData', recipeId: thisId},
                   dataType: 'json',
                   success: function(data)
                   {
                       $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#recipeDesc').val(data.recipeDesc);
                              $('#instructions').val(data.instructions);
                          }
                   }
                });
            }
            
            function showIngredients(thisId)
            {
                $('#recipeId').val(thisId);
                document.forms['recipeId'].submit();
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
                    <div id="newRecipeBtn" class="divBtns" onclick="addNewRecipe();">Add New Recipe</div>
                    <br>
                    <div id="newRecipe">
                        <br><br>
                        <table class='table'>
                            <tr>
                                <th> Description </th>
                                <th> Instructions </th>
                            </tr>
                            <tr>
                                <td> <input id="recipeDesc" name="recipeDesc" type="text" class="inputBox"> </td>
                                <td> <textarea id='instructions' rows="10" cols="50" class='textArea'></textarea> </td>
                            </tr>
                        </table>
                        <br>
                        <input id="addBtn" type="button" class="formBtns" onclick="doAdd();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();">
                        <form name="recipeId" action="ingredientsMaintenance.php" methos="post">
                            <input type="hidden" id="recipeId" name="recipeId">
                        </form>    
                    </div>
                    <div id="recipeInfo"></div>
                </div>       
            </center>         
        </div>     

    </body>
</html>