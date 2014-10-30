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

$pageTitle = "Ingredients Maintenance";

$username = $_COOKIE['loggedIn'];

if (trim($username) == null)
{
    header('location:loginPage.php');
}

$recipeId = $_REQUEST['recipeId'];

$con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
$sql = "SELECT products.prodDesc, products.prodId, recipeheader.recipeId
        FROM (erp.products products
        INNER JOIN erp.recipeingredients recipeingredients
            ON (products.prodId = recipeingredients.prodId))
        INNER JOIN erp.recipeheader recipeheader
            ON (recipeheader.recipeId = recipeingredients.recipeId)
        WHERE (recipeheader.recipeId != $recipeId AND catId > 1)";
$result = mysqli_query($con, $sql);
$row_cnt = mysqli_num_rows($result); 

//read to get list of categories
$prodList = "<select id='prodId' name='prodId' class='inputBox'>";
for ($x = 0; $x < $row_cnt; $x++)
{
    $row = mysqli_fetch_array($result);
    $prodList = $prodList . "<option value='" . $row['prodId'] . "'>" . $row['prodDesc'];
}
$prodList = $prodList . "</select>";

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
                showWholeRecipe();
                $('#newIngredient').hide();
                $('#prodId').val("");
                $('#weight').val("");
                $('#quantity').val("");
                $('#volume').val("");
            });
            
            var gRecipeId = <?php echo $recipeId ?>;
            var amend = false;
            var gIngredientId = 0;
            
            function showWholeRecipe()
            {
                $.ajax({
                   url: 'project5_ajax.php',
                   cache: false,
                   data: {'request': 'getWholeRecipe', recipeId: gRecipeId},
                   dataType: 'json',
                   success: function(data)
                   {
                        var dataArray = data.resultData;
                        var outputIngr = "";
                        if (dataArray[0].prodDesc == null)
                        {
                            $('#recipeTitle').html("No Ingredients in this recipe");
                        }
                        else
                        {    
                            outputIngr = "<br><br><br><table class='table'><tr><th></th><th>Ingredient</th><th>Weight</th><th>Quantity</th><th>Volume</th></tr>";        

                            for (var i = 0; i < dataArray.length; i++)
                            {
                                var wgt = dataArray[i].weight;
                                if (wgt == null || wgt == 0)
                                    wgt = "n/a";
                                var prodDesc = dataArray[i].prodDesc; 
                                var qty = dataArray[i].quantity;
                                if (qty == null || qty == 0)
                                    qty = "n/a";
                                var vol = dataArray[i].volume;
                                if (vol == null || vol == 0)
                                    vol = "n/a";
                                
                                outputIngr = outputIngr + "<tr><td><input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + gRecipeId + "\",\"" + dataArray[i].prodId + "\");'></td>";
                                outputIngr = outputIngr + "<td>" + prodDesc + "</td>";
                                outputIngr = outputIngr + "<td>" + wgt + "</td>";
                                outputIngr = outputIngr + "<td>" + qty + "</td>";
                                outputIngr = outputIngr + "<td>" + vol + "</td></tr>";
                            }
                            outputIngr = outputIngr + "</table>";

                            $('#recipeIngredients').html(outputIngr);

                            var outputTitle = dataArray[0].recipeDesc;

                            $('#recipeTitle').html(outputTitle);
                        }
                   }
                });
            }
            
            function addNewIngredient()
            {
                $('#newIngredient').show();
                $('#recipeLayout').hide();
                $('#addBtn').val("Add");
                $('#prodId').focus();    
            }
            
            function doCancel()
            {
                $('#recipeLayout').show();
                $('#newIngredient').hide();
                $('#prodId').val("");
                $('#weight').val("");
                $('#quantity').val("");
                $('#volume').val("");
            }
            
            function doAmend(recipeId,prodId)
            {
                $('#newIngredient').show();
                $('#recipeLayout').hide();
                $('#addBtn').val("Update");
                $('#prodId').focus();
                amend = true;
                
                var weight = $('#weight').val();
                var quantity = $('#quantity').val();
                var volume = $('#volume').val();                
                
                $.ajax({
                   url: 'project5_ajax.php',
                   cache: false,
                   data: {'request': 'getIngredientData', recipeId: recipeId, prodId: prodId, weight: weight, quantity: quantity, volume: volume},
                   dataType: 'json',
                   success: function(data)
                   {
                       $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#prodId').val(data.prodId);
                              if (data.weight == 0)
                                  data.weight = "";
                              $('#weight').val(data.weight);                        
                              if (data.quantity == 0)
                                  data.quantity = "";
                              $('#quantity').val(data.quantity);
                              if (data.volume == 0)
                                  data.volume = "";
                              $('#volume').val(data.volume);
                          }
                   }
                });
            }
            
            function doUpdate()
            {
                var prodId = $('#prodId').val();
                var weight = $('#weight').val();
                if (weight == "")
                    weight = 0;
                var quantity = $('#quantity').val();
                if (quantity == "")
                    quantity = 0;
                var volume = $('#volume').val();
                if (volume == "")
                    volume = 0;
                
                var requestType = "insertIngredient";
                if (amend)
                {
                    requestType = "updateIngredient";
                    
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'recipeId': gRecipeId, 'prodId': prodId, 'weight': weight, 'quantity': quantity, 'volume': volume},
                  dataType: 'json',
                  success: function(data)
                  {
                    alert("Successful");
                    location.reload();
                  }
                });    
            }
            
            function goBackToRecipes()
            {
                document.location.href="recipeMaintenance.php";
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
                    <div id="recipeLayout">
                        <br><br>
                        <div id="recipeTitle"></div><br><br>
                        <div id="backBtn" class="divBtns" onclick="goBackToRecipes();">Go Back to Recipes</div>
                        <div id="addIngrBtn" class="divBtns" onclick="addNewIngredient();">Add New Ingredient</div><br>
                        <div id="recipeIngredients"></div>
                        <div id="recipeImg"><br><br><br><img src="testPic.php?recipeId=<?php echo $recipeId; ?>"></div>
                        <div id="recipeInstructions"></div>
                    </div>
                    <div id="newIngredient">
                        <br><br>
                        <table class="table">
                            <tr>
                                <td> Product </td>
                                <td> <?php echo $prodList ?> </td>
                            </tr>
                            <tr>
                                <td> Weight(KG) </td>
                                <td> <input id="weight" name="weight" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Quantity </td>
                                <td> <input id="quantity" name="quantity" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Volume(L) </td>
                                <td> <input id="volume" name="volume" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> <input id="addBtn" type="button" class="formBtns" onclick="doUpdate();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();"> </td>
                            </tr>
                        </table>
                        <input type="hidden" id="employeeId" name="employeeId">
                    </div>
                </div>       
            </center>         
        </div>     

    </body>
</html>