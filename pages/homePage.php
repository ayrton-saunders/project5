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
            });
                                 
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
                vtyufctyufctyufctyufctyufctyufctyufctyufctyufctyufctyufctyufctyufc
            
            
            
            
            
            
            
                </div>       
            </center>         
        </div>   
    </body>
</html>