<?php

$request = $_REQUEST['request'];
$info = new stdClass(); //class to hold data
$info->errmsg = '';

$sqlHost = "127.0.0.1";
$sqlUser = "bliss";
$sqlPass = "monkey";
$sqlDbase = "erp";

if (trim($request) == 'readPrograms')
{
    //read the menu and return list of programs and descriptions
    
    $categoryId = $_REQUEST['categoryId'];
  $programDesc = $_REQUEST['programDesc'];
  $categoryDesc = $_REQUEST['categoryDesc'];
  
 $con=mysqli_connect($sqlHost,$sqlUser,$sqlPass,$sqlDbase);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL" . mysqli_connect_error();
}
else
    {
        $sql="SELECT programs.programId, programs.programName, programs.programDesc, programs.categoryId, categories.categoryId, categories.categoryDesc "
            . "FROM programs "
            . "LEFT OUTER JOIN categories "
            . "ON (programs.categoryId=categories.categoryId) "
            . "ORDER BY categories.categoryId ASC";
        //echo ($sql);
        $result = mysqli_query($con, $sql);
        if ($result == null)
          {
            //die('Error: ' . mysqli_error($con));
            $errFlg = 1;
            $errMsg = "Unable to read menu files";
          }
        else
        {
            //check how many records are returned
            $row_cnt = mysqli_num_rows($result);
            
            //if zero thenm invalid username or password
            if ($row_cnt == 0)
            {
                $errMsg = "There is no menu available";
            }
            
            //if greater than 0 then valid user
            if ($row_cnt > 0)
            {
                //loop around results - create an array to read data
                
                while ($row = mysqli_fetch_array($result))
                {
                    $rowData = array();
                    $rowData['categoryId'] = $row['categoryId'];
                    $rowData['categoryDesc'] = $row['categoryDesc'];
                    $rowData['programDesc'] = $row['programDesc'];
                    $rowData['programName'] = $row['programName'];
                    $dataArray[] = $rowData;
                }

            }
        }
    }
    
  mysqli_close($con);
  $info->resultData = $dataArray;
  $info->errMsg = $errMsg;
  echo json_encode($info);
}
