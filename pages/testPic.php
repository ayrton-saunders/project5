<?php

//call sql to get blob with recipe picture then output the binary data
$recipeId = $_REQUEST['recipeId'];

$errMsg = '';
$con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
            {
                $Str = "SELECT recipeImg FROM recipeHeader WHERE recipeId = $recipeId";
                $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                while ($row = mysqli_fetch_array($result))
                {
                    $recipeImg = $row['recipeImg'];
                }
                $row_cnt = mysqli_num_rows($result);
            }
      header("Content-type:image/jpeg");
      echo $recipeImg;

?>
