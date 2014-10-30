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
$sql = "SELECT * FROM contacts";
$result = mysqli_query($con, $sql);
$row_cnt = mysqli_num_rows($result); 

//read to get list of categories
$selectContact = "<select id='selectContact' name='selectContact' class='inputBox'>";
$selectContact = $selectContact . "<option>Please Select...</option>";
for ($x = 0; $x < $row_cnt; $x++)
{
    $row = mysqli_fetch_array($result);
    $selectContact = $selectContact . "<option value='" . $row['contactId'] . "'>" . $row['firstName'];
}
$selectContact = $selectContact . "</select>";

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
                $('#backBtn').hide();
                $('#showMore').hide();
                $('#selectContact').focus();
                $('#contacts').hide();
                doMenu();  
            });
            
            function showContacts()
            {
                var contact = $('#selectContact').val();
                if (contact !== "") {
                    $('#contacts').show();
                    $.ajax({
                        url: 'project5_ajax.php',
                        cache: false,
                        data: {'request': 'showContacts', 'contact' : contact},
                        dataType: 'json',
                        success: function(data)
                        {
                            var dataArray = data.resultData;
                            var outputStr = "";     

                            outputStr = "<br><table class='table'>";
                            outputStr = outputStr + "<tr><th></th><th>First Name</th><th>Last Name</th><th>Company</th>";
                                for (var i = 0; i < dataArray.length; i++)
                                {
                                    outputStr = outputStr + "<tr>";
                                    outputStr = outputStr + "<td><input type='button' class='formBtns' value='More..' onclick='showMore(\"" + dataArray[i].contactId + "\");'></td>";
                                    outputStr = outputStr + "<td>" + dataArray[i].firstName + "</td>";
                                    outputStr = outputStr + "<td>" + dataArray[i].lastName + "</td>";
                                    outputStr = outputStr + "<td>" + dataArray[i].cName + "</td>";
                                    outputStr = outputStr + "</tr>";
                                }

                            outputStr = outputStr + "</table>";

                            $('#contacts').html(outputStr);  
                        }
                    });
                }
                else {
                    $('#contacts').hide();
                }
            }
            
            function showMore(thisId)
            {
                $('#contacts').hide();
                $('#backBtn').show();
                $('#showMore').show();
                $('#selectContact').hide();
                var contactId = thisId;
                
                $.ajax({
                    url: 'project5_ajax.php',
                    cache: false,
                    data: {'request': 'getContactData', 'contactId' : contactId},
                    dataType: 'json',
                    success: function(data)
                    {
                        var dataArray = data.resultData;
                        var outputStr = "";     

                        outputStr = "<br><table class='table'>";
                        outputStr = outputStr + "<tr><th>First Name</th><th>Last Name</th><th>Age</th><th>Address</th><th>Post Code</th><th>Phone Number</th>";

                                outputStr = outputStr + "<tr>";
                                outputStr = outputStr + "<td>" + data.firstName + "</td>";
                                outputStr = outputStr + "<td>" + data.lastName + "</td>";
                                outputStr = outputStr + "<td>" + data.age + "</td>";
                                outputStr = outputStr + "<td>" + data.address + "</td>";
                                outputStr = outputStr + "<td>" + data.postCode + "</td>";
                                outputStr = outputStr + "<td>" + data.phoneNumber + "</td>";
                                outputStr = outputStr + "</tr>";

                        outputStr = outputStr + "</table>";

                        $('#showMore').html(outputStr);  
                    }
                });
            }
            
            function goBack()
            {
                $('#backBtn').hide();
                $('#showMore').hide();
                $('#contacts').show();
                $('#selectContact').show();
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
                    <input id="selectContact" name="selectContact" type="text" class="inputBox" onkeyup='showContacts();'>
                    <div id="backBtn" class="divBtns" onclick="goBack();">Back</div>
                    <div id="contacts"></div>
                    <div id="showMore"></div>    
                    
                </div>       
            </center>         
        </div>   
    </body>
</html>