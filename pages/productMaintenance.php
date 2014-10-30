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

$con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
$sql = "SELECT * FROM prodCategories";
$result = mysqli_query($con, $sql);
$row_cnt = mysqli_num_rows($result); 

//read to get list of categories
$catList = "<select id='catId' name='catId' class='inputBox'>";
for ($x = 0; $x < $row_cnt; $x++)
{
    $row = mysqli_fetch_array($result);
    $catList = $catList . "<option value='" . $row['catId'] . "'>" . $row['catDesc'];
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
                showProducts();
                $('#newProduct').hide();
                $('#weight').val("");
                $('#prodDesc').val("");
                $('#eanCode').val("");
                $('#catId').val("");
            });
            
            var gProductId = 0;
            
            function showProducts()
            {
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': 'showProducts'},
                  dataType: 'json',
                  success: function(data)
                  {
                        var dataArray = data.resultData;
                        var outputStr = "";
                        outputStr = "<br><br><table class='table'><tr><th></th><th>Description</th>";
                        outputStr = outputStr + "<th>Category</th>";    
                        outputStr = outputStr + "<th>Weight (kg) </th>";    
                        outputStr = outputStr + "<th>EAN Code</th>";      

                        for (var i = 0; i < dataArray.length; i++)
                        {
                            outputStr = outputStr + "<tr><td>";
                            outputStr = outputStr + "<input type='button' class='formBtns' value='Amend' onclick='doAmend(\"" + dataArray[i].prodId + "\");'>";
                            outputStr = outputStr + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].prodDesc + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].catDesc + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].weight + "</td>";
                            outputStr = outputStr + "<td>" + dataArray[i].eanCode + "</td>";
                        }
                        
                        outputStr = outputStr + "</tr></table>";
              
                        //alert(outputStr);
                        $('#productInfo').html(outputStr);                
                  } 
                
                });
            }
            
            function doAmend(thisId)
            {
                gProductId = thisId;
                
                $('#addBtn').val("Update");
                $('#newProduct').show();
                $('#newProductBtn').hide();
                $('#productInfo').hide();
                $('#prodDesc').focus();
                
                $.ajax ({
                    url:'project5_ajax.php',
                    cache:false,
                    data: {'request': 'getProductData', 'prodId': thisId},
                    dataType: 'json',
                    success: function(data)
                      {
                          $('#errMsg').html(data.errMsg);
                          //$('#searchresults').html(data.resultStr);
                          if (data.resultData !== null)
                          {
                              $('#weight').val(data.weight);
                              $('#prodDesc').val(data.prodDesc);
                              $('#eanCode').val(data.eanCode);
                              $('#catId').val(data.catId);
                          }
                      }
                    });
            }
            
            function addNewProduct()
            {
                $('#newProduct').show();
                $('#newProductBtn').hide();
                $('#addBtn').val("Add");
                $('#productInfo').hide();
                $('#prodDesc').focus();
            }
            
            function doCancel()
            {
                $('#productInfo').show();
                $('#newProduct').hide();
                $('#newProductBtn').show();
                $('#weight').val("");
                $('#prodDesc').val("");
                $('#eanCode').val("");
                $('#catId').val("");
            }
            
            function doUpdate()
            {
                var weight = $('#weight').val();
                var prodDesc = $('#prodDesc').val();
                var eanCode = $('#eanCode').val();
                var catId = $('#catId').val();
                
                var requestType = "insertProduct";
                if (gProductId > 0)
                {
                    requestType = "updateProduct";
                }                
                
                $.ajax({
                  url: 'project5_ajax.php',
                  cache: false,
                  data: {'request': requestType, 'prodId': gProductId, 'weight': weight, 'prodDesc': prodDesc, 'eanCode': eanCode, 'catId': catId},         
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
                    <div id="newProductBtn" class="divBtns" onclick="addNewProduct();">Add New Product</div>
                    <br><br>
                    <div id="newProduct">
                        <table class="table">
                            <tr>
                                <td> Description </td>
                                <td> <input id="prodDesc" name="prodDesc" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> Category ID </td>
                                <td> <?php echo $catList; ?> </td>
                            </tr>
                            <tr>
                                <td> Weight (kg) </td>
                                <td> <input id="weight" name="weight" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> EAN Code </td>
                                <td> <input id="eanCode" name="eanCode" type="text" class="inputBox"> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td> <input id="addBtn" type="button" class="formBtns" onclick="doUpdate();"> <input type="button" class="formBtns" value="Cancel" onclick="doCancel();"> </td>
                            </tr>
                        </table>
                        <input type="hidden" id="productId" name="productId" value="">
                    </div>
                    <div id="productInfo"></div>
            
            
            
                </div>       
            </center>
        </div>   
        
        <form name="formAmend" action="newProduct.php" method="post">
            <input id="productIdAmend" name="productIdAmend" type="hidden" value="">
        </form>
    </body>
</html>