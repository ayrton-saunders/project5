<?php


//$USERNAME = $_COOKIE['USERNAME'];
$request = $_REQUEST['request'];
$info = new stdClass(); //class to hold data
$info->errmsg = '';

$sqlHost = "127.0.0.1";
$sqlUser = "bliss";
$sqlPass = "monkey";
$sqlDbase = "erp";

//echo $request;
if (trim($request) == 'chkUser')
{
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];
  $userValid = false;
  
 $con=mysqli_connect($sqlHost,$sqlUser,$sqlPass,$sqlDbase);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL" . mysqli_connect_error();
}
else
    {
        //Insert the order data
        $sql="SELECT * FROM users where (username = '$username' and password = '$password')";
        $result = mysqli_query($con, $sql);
        if ($result==null)
          {
            //die('Error: ' . mysqli_error($con));
            $errFlg =1;
            $errMsg = "Sorry, this is an invalid user";
          }
        else
        {
            //check how many records are returned
            $row_cnt = mysqli_num_rows($result);
            
            //if zero thenm invalid username or password
            if ($row_cnt == 0)
            {
                $userValid = false;
            }
            
            //if greater than 0 then valid user
            if ($row_cnt > 0)
            {
                $userIp = $_SERVER['REMOTE_ADDR'];
                //updat into user table
                $sql = "UPDATE users
                SET iPaddress = '$userIp'
                WHERE username = '$username'";
                $result = mysqli_query($con, $sql);
                
                $userValid = true;
                $cookieValue = $username;
                
                setCookie("loggedIn", $cookieValue, time()+3600);
            }
            
            //
            
        }
    }
    
  mysqli_close($con);
  $info->userValid = $userValid;
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'insertEmployee')
{
        $firstName = $_REQUEST['firstName'];
        $lastName = $_REQUEST['lastName'];
        $email = $_REQUEST['email'];
        $dateOfBirth = $_REQUEST['dateOfBirth'];
        $mobileNumber = $_REQUEST['mobileNumber'];
        $NInumber = $_REQUEST['NInumber'];
        $employeeId = $_REQUEST['employeeId'];


        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the employee data
            $sql = "INSERT INTO employee (firstName, lastName, email, dateOfBirth, mobileNumber, NInumber)
                VALUES
                ('$firstName','$lastName','$email','$dateOfBirth','$mobileNumber','$NInumber')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'updateEmployee')
{
        $firstName = $_REQUEST['firstName'];
        $lastName = $_REQUEST['lastName'];
        $email = $_REQUEST['email'];
        $dateOfBirth = $_REQUEST['dateOfBirth'];
        $mobileNumber = $_REQUEST['mobileNumber'];
        $NInumber = $_REQUEST['NInumber'];
        $employeeId = $_REQUEST['employeeId'];


        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the employee data
            $sql = "UPDATE employee 
                    SET firstName='$firstName', lastName='$lastName', email='$email', dateOfBirth='$dateOfBirth', mobileNumber='$mobileNumber', NInumber='$NInumber'
                    WHERE employeeId='$employeeId'";    
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if(trim($request) == 'getEmployeeData')
{
  $employeeId = $_REQUEST['employeeId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT firstName, lastName, email, dateOfBirth, mobileNumber, NInumber FROM employee WHERE employeeId = $employeeId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $firstName = $row['firstName'];
                          $lastName = $row['lastName'];
                          $email = $row['email'];
                          $dateOfBirth = $row['dateOfBirth'];
                          $mobileNumber = $row['mobileNumber'];
                          $NInumber = $row['NInumber'];
                    }
                }
      mysqli_close($con);
      $info ->firstName = $firstName;
      $info ->lastName = $lastName;
      $info ->email = $email;
      $info ->dateOfBirth = $dateOfBirth;
      $info ->mobileNumber = $mobileNumber;
      $info ->NInumber = $NInumber;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'showEmployees')
{
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    $sql = "SELECT * FROM employee";

    $result = mysqli_query($con, $sql);

    $row_cnt = mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        $rowData['employeeId'] = $row['employeeId'];
        $rowData['firstName'] = $row['firstName'];
        $rowData['lastName'] = $row['lastName'];
        $rowData['email'] = $row['email'];
        $rowData['dateOfBirth'] = $row['dateOfBirth'];
        $rowData['mobileNumber'] = $row['mobileNumber'];
        $rowData['NInumber'] = $row['NInumber'];
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if (trim($request) == 'insertJobRole')
{
        $jobRoleTitle = $_REQUEST['jobRoleTitle'];
        $jobRoleDesc = $_REQUEST['jobRoleDesc'];
        $jobRoleId = $_REQUEST['jobRoleId'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the job role data
            $sql = "INSERT INTO jobRoles (jobRoleTitle, jobRoleDesc)
                VALUES
                ('$jobRoleTitle','$jobRoleDesc')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
            //echo "New Job Role Added";
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}


if (trim($request) == 'updateJobRole')
{
        $jobRoleTitle = $_REQUEST['jobRoleTitle'];
        $jobRoleDesc = $_REQUEST['jobRoleDesc'];
        $jobRoleId = $_REQUEST['jobRoleId'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the job role data
            $sql = "UPDATE jobRoles 
                    SET jobRoleTitle='$jobRoleTitle', jobRoleDesc='$jobRoleDesc'
                    WHERE jobRoleId='$jobRoleId'";
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}


if(trim($request) == 'getJobData')
{
  $jobRoleId = $_REQUEST['jobRoleId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT jobRoleTitle, jobRoleDesc FROM jobroles WHERE jobRoleId=$jobRoleId";
                    //echo $Str;
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $jobRoleTitle = $row['jobRoleTitle'];
                          $jobRoleDesc = $row['jobRoleDesc'];
                    }
                }
      mysqli_close($con);
      $info ->jobRoleTitle = $jobRoleTitle;
      $info ->jobRoleDesc = $jobRoleDesc;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'showProducts')
{
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    $sql = "SELECT prodcategories.`catDesc`, products.* 
            FROM products 
            INNER JOIN prodcategories 
            ON (products.catId = prodcategories.catId)";

    $result = mysqli_query($con, $sql);

    $row_cnt = mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        $rowData['prodId'] = $row['prodId'];
        $rowData['weight'] = $row['weight'];
        $rowData['prodDesc'] = $row['prodDesc'];
        $rowData['eanCode'] = $row['eanCode'];
        $rowData['catId'] = $row['catId'];
        $rowData['catDesc'] = $row['catDesc'];
 
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if(trim($request) == 'getProductData')
{
  $prodId = $_REQUEST['prodId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT weight, prodDesc, eanCode, catId FROM products WHERE prodId = $prodId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $weight = $row['weight'];
                          $prodDesc = $row['prodDesc'];
                          $eanCode = $row['eanCode'];
                          $catId = $row['catId'];
                    }
                }
      mysqli_close($con);
      $info ->weight = $weight;
      $info ->prodDesc = $prodDesc;
      $info ->eanCode = $eanCode;
      $info ->catId = $catId;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'insertProduct')
{
        $prodId = $_REQUEST['prodId'];
        $weight = $_REQUEST['weight'];
        if (trim($weight) == "")
            $weight = "0.00";
        $prodDesc = $_REQUEST['prodDesc'];
        $eanCode = $_REQUEST['eanCode'];
        if (trim($eanCode) == "")
            $eanCode = "0";
        $catId = $_REQUEST['catId'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the product data
            $sql = "INSERT INTO products (weight, prodDesc, eanCode, catId)
                VALUES
                ('$weight','$prodDesc','$eanCode','$catId')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}


if (trim($request) == 'updateProduct')
{
        $prodId = $_REQUEST['prodId'];
        $weight = $_REQUEST['weight'];
        if (trim($weight) == "")
            $weight = "0.00";
        $prodDesc = $_REQUEST['prodDesc'];
        $eanCode = $_REQUEST['eanCode'];
        if (trim($eanCode) == "")
            $eanCode = "0";
        $catId = $_REQUEST['catId'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Update the Product data
            $sql = "UPDATE products 
                    SET weight='$weight', prodDesc='$prodDesc', eanCode='$eanCode', catId='$catId'
                    WHERE prodId='$prodId'";
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'showCategories')
{
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    $sql = "SELECT * FROM prodCategories";

    $result = mysqli_query($con, $sql);

    $row_cnt = mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        $rowData['catId'] = $row['catId'];
        $rowData['catDesc'] = $row['catDesc'];
 
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if(trim($request) == 'getCategoryData')
{
  $catId = $_REQUEST['catId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT catDesc FROM prodCategories WHERE catId = $catId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $catDesc = $row['catDesc'];
                    }
                }
      mysqli_close($con);
      $info ->catDesc = $catDesc;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'insertCategory')
{
        $catId = $_REQUEST['catId'];
        $catDesc = $_REQUEST['catDesc'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the product data
            $sql = "INSERT INTO prodCategories (catDesc)
                VALUES
                ('$catDesc')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}


if (trim($request) == 'updateCategory')
{
        $catId = $_REQUEST['catId'];
        $catDesc = $_REQUEST['catDesc'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Update the Product data
            $sql = "UPDATE prodCategories 
                    SET catDesc='$catDesc'
                    WHERE catId='$catId'";
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'insertRecipe')
{
        $recipeId = $_REQUEST['recipeId'];
        $recipeDesc = $_REQUEST['recipeDesc'];
        $instructions = $_REQUEST['instructions'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the recipe data
            $sql = "INSERT INTO recipeHeader (recipeDesc, instructions)
                VALUES
                ('$recipeDesc','$instructions')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'updateRecipe')
{
        $recipeId = $_REQUEST['recipeId'];
        $recipeDesc = $_REQUEST['recipeDesc'];
        $instructions = $_REQUEST['instructions'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Update the Product data
            $sql = "UPDATE recipeHeader 
                    SET recipeDesc='$recipeDesc', instructions='$instructions'
                    WHERE recipeId='$recipeId'";
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'showRecipes')
{
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    $sql = "SELECT * FROM recipeHeader";

    $result = mysqli_query($con, $sql);

    $row_cnt = mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        $rowData['recipeId'] = $row['recipeId'];
        $rowData['recipeDesc'] = $row['recipeDesc'];
        $rowData['instructions'] = $row['instructions'];
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if(trim($request) == 'getRecipeData')
{
  $recipeId = $_REQUEST['recipeId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT recipeDesc, instructions FROM recipeHeader WHERE recipeId = $recipeId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $recipeDesc = $row['recipeDesc'];
                          $instructions = $row['instructions'];
                    }
                }
      mysqli_close($con);
      $info ->recipeDesc = $recipeDesc;
      $info ->instructions = $instructions;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if(trim($request) == 'getWholeRecipe')
{
  $recipeId = $_REQUEST['recipeId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT recipeingredients.weight, 
                                   recipeingredients.quantity, 
                                   recipeingredients.volume, 
                                   products.prodId, 
                                   products.prodDesc, 
                                   recipeheader.recipeId, 
                                   recipeheader.instructions, 
                                   recipeheader.recipeDesc, 
                                   recipeheader.recipeImg 
                              FROM (erp.recipeingredients recipeingredients 
                                    LEFT OUTER JOIN erp.products products 
                                       ON (recipeingredients.prodId = products.prodId)) 
                                   RIGHT OUTER JOIN erp.recipeheader recipeheader 
                                      ON (recipeheader.recipeId = recipeingredients.recipeId) 
                                    WHERE recipeheader.recipeId = $recipeId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                        $rowData = array();
                        
                        $rowData['instructions'] = $row['instructions'];
                        $rowData['recipeDesc'] = $row['recipeDesc'];
                        $rowData['recipeImg'] = $row['recipeImg'];
                        $rowData['weight'] = $row['weight'];
                        $rowData['quantity'] = $row['quantity'];
                        $rowData['volume'] = $row['volume'];
                        $rowData['prodId'] = $row['prodId'];
                        $rowData['prodDesc'] = $row['prodDesc'];
                        
                        $dataArray[] = $rowData;
                    }
                }
      mysqli_close($con);
      $info->resultData = $dataArray;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'insertIngredient')
{
        $recipeId = $_REQUEST['recipeId'];
        $prodId = $_REQUEST['prodId'];
        $weight = $_REQUEST['weight'];
        if (trim($weight) == "")
            {
                $weight = 0;
            }
        $quantity = $_REQUEST['quantity'];
        if (trim($quantity) == "")
            {
                $quantity = 0;
            }
        $volume = $_REQUEST['volume'];
        if (trim($volume) == "")
            {
                $volume = 0;
            }

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the recipe data
            $sql = "INSERT INTO recipeIngredients (recipeId, prodId, weight, quantity, volume)
                VALUES
                ('$recipeId','$prodId','$weight','$quantity','$volume')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'updateIngredient')
{
        $recipeId = $_REQUEST['recipeId'];
        $prodId = $_REQUEST['prodId'];
        $weight = $_REQUEST['weight'];
        $quantity = $_REQUEST['quantity'];
        $volume = $_REQUEST['volume'];

        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Update the Product data
            $sql = "UPDATE recipeIngredients 
                    SET weight='$weight', quantity='$quantity', volume='$volume'
                    WHERE (recipeId='$recipeId' AND prodId='$prodId')";
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if(trim($request) == 'getIngredientData')
{
  $recipeId = $_REQUEST['recipeId'];
  $prodId = $_REQUEST['prodId'];
  $weight = $_REQUEST['weight'];
  $quantity = $_REQUEST['quantity'];
  $volume = $_REQUEST['volume'];
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT weight, quantity, volume FROM recipeIngredients WHERE (recipeId = $recipeId AND prodId = $prodId)";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                        $weight = $row['weight'];
                        $quantity = $row['quantity'];
                        $volume = $row['volume'];
                    }
                }
      mysqli_close($con);
      $info ->prodId = $prodId;
      $info ->weight = $weight;
      $info ->quantity = $quantity;
      $info ->volume = $volume;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'insertUser')
{
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $userId = $_REQUEST['userId'];


        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the employee data
            $sql = "INSERT INTO users (username, password)
                VALUES
                ('$username','$password')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'updateUser')
{
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $userId = $_REQUEST['userId'];


        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the employee data
            $sql = "UPDATE users 
                    SET username='$username', password='$password'
                    WHERE userId='$userId'";    
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if(trim($request) == 'getUserData')
{
  $userId = $_REQUEST['userId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT username, password FROM users WHERE userId = $userId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $username = $row['username'];
                          $password = $row['password'];
                    }
                }
      mysqli_close($con);
      $info ->username = $username;
      $info ->password = $password;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'showUsers')
{
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    $sql = "SELECT userId, username, password FROM users";

    $result = mysqli_query($con, $sql);

    $row_cnt = mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        $rowData['userId'] = $row['userId'];
        $rowData['username'] = $row['username'];
        $rowData['password'] = $row['password'];
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if (trim($request) == 'insertProgram')
{
        $programId = $_REQUEST['programId'];


        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the employee data
            $sql = "INSERT INTO programs (categoryId, programName, programDesc)
                VALUES
                ('$categoryId','$programName','$programDesc')";
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if (trim($request) == 'updateProgram')
{
        $programId = $_REQUEST['programId'];


        $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
        //check connection to mySQL
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL" . mysqli_connect_error();
        } 
        else {       
            //Insert the employee data
            $sql = "UPDATE programs 
                    SET categoryId='$categoryId', programName='$programName', programDesc='$programDesc'
                    WHERE programId='$programId'";    
            
            if (!mysqli_query($con, $sql)) {
                die('Error: ' . mysqli_error($con));
            }
        }
  mysqli_close($con);
  $info->errMsg = $errMsg;
  echo json_encode($info);
}

if(trim($request) == 'getProgramData')
{
  $userId = $_REQUEST['programId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT categoryId, programName, programDesc FROM programs WHERE programId = $programId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $categoryId = $row['categoryId'];
                          $programName = $row['programName'];
                          $programDesc = $row['programDesc'];
                    }
                }
      mysqli_close($con);
      $info ->categoryId = $categoryId;
      $info ->programName = $programName;
      $info ->programDesc = $programDesc;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}

if (trim($request) == 'showPrograms')
{
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    $sql = "SELECT programId, categoryId, programName, programDesc FROM programs";

    $result = mysqli_query($con, $sql);

    $row_cnt = mysqli_num_rows($result);
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        $rowData['programId'] = $row['programId'];
        $rowData['categoryId'] = $row['categoryId'];
        $rowData['programName'] = $row['programName'];
        $rowData['programDesc'] = $row['programDesc'];
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if (trim($request) == 'showSearchResults')
{
    $searchTxt = $_REQUEST['searchTxt'];  
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
    
    $sql = "SELECT * FROM products WHERE prodDesc LIKE '%$searchTxt%'";
    //echo $sql;
    $result = mysqli_query($con, $sql);
    
    $row_cnt = mysqli_num_rows($result); 
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        
        $rowData['prodId'] = $row['prodId'];
        $rowData['prodDesc'] = $row['prodDesc'];
        
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if (trim($request) == 'showContacts')
{ 
    $contact = $_REQUEST['contact'];
    $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");
    
    $sql = "SELECT contacts.*, company.* 
            FROM erp.contacts contacts 
            INNER JOIN erp.company company 
                ON (contacts.companyId = company.companyId) 
            WHERE firstName LIKE '%$contact%'";
    //echo $sql;
    $result = mysqli_query($con, $sql);
    
    $row_cnt = mysqli_num_rows($result); 
    
    while ($row = mysqli_fetch_array($result))
    {
        $rowData = array();
        
        $rowData['contactId'] = $row['contactId'];
        $rowData['firstName'] = $row['firstName'];
        $rowData['lastName'] = $row['lastName'];
        $rowData['age'] = $row['age'];
        $rowData['address'] = $row['address'];
        $rowData['postCode'] = $row['postCode'];
        $rowData['phoneNumber'] = $row['phoneNumber'];
        $rowData['companyId'] = $row['companyId'];
        $rowData['cName'] = $row['cName'];
        $rowData['cAddress'] = $row['cAddress'];
        $rowData['cPostCode'] = $row['cPostCode'];
        
        $dataArray[] = $rowData;
    }

    mysqli_close($con);
    $info->resultData = $dataArray;
    $info->errMsg = $errMsg;
    echo json_encode($info);
}

if(trim($request) == 'getContactData')
{
  $contactId = $_REQUEST['contactId'];  
  $errMsg = '';
  $con = mysqli_connect("127.0.0.1", "bliss", "monkey", "erp");

    if (mysqli_connect_errno($con))
            {
                echo 'Could not connect to Database.' . mysqli_connect_error();
            }
            else
                {
                    $Str = "SELECT firstName, lastName, age, address, postCode, phoneNumber FROM contacts WHERE contactId = $contactId";
                    $result = mysqli_query($con,$Str) or die ('error=' . mysqli_error($con));

                    while ($row = mysqli_fetch_array($result))
                    {
                          $firstName = $row['firstName'];
                          $lastName = $row['lastName'];
                          $age = $row['age'];
                          $address = $row['address'];
                          $postCode = $row['postCode'];
                          $phoneNumber = $row['phoneNumber'];
                    }
                }
      mysqli_close($con);
      $info ->firstName = $firstName;
      $info ->lastName = $lastName;
      $info ->age = $age;
      $info ->address = $address;
      $info ->postCode = $postCode;
      $info ->phoneNumber = $phoneNumber;
      $info ->errMsg = $errMsg;
      echo json_encode($info);
}



