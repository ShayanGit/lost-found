<?php
session_start();


if(isset($_POST['registerMe']))
{
	$connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
	if ($connection->connect_error) {
	    die("Connection failed: " . $connection->connect_error);
	}

	if (empty($_POST["name"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
    	$name = $_POST['name'];	
    }
	
	if (empty($_POST["family"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
    	$family = $_POST['family'];	
    }

    if (empty($_POST["username"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
		$username = $_POST['username'];
    }

    if (empty($_POST["password"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
    	$pass = $_POST['password'];
    }

    if (empty($_POST["confirmPassword"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
    	$confirmPass = $_POST['confirmPassword'];
    }

    if (empty($_POST["email"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
    	$email = $_POST["email"];
    }

    if (empty($_POST["telephone"]))
    {
    	die("لطفاً تمام فیلد ها را پر کنید.");
    }else
    {
    	$tel = $_POST["telephone"];
    }
    $sql = "CALL UserExist('$username')";
    $result= $connection->query($sql);
    $connection->close();

    if($result->num_rows > 0)
    {
    	die("این نام کاربری قبلاً استفاده شده است.");
    }else
    {
    	if(strcmp($confirmPass, $pass) == 0)
    	{
    		$connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
			if ($connection->connect_error) {
		    	die("Connection failed: " . $connection->connect_error);
			}

    		$options = [
  				'cost' => 11
			];
    		$pass = password_hash($pass, PASSWORD_BCRYPT, $options);
    		$sql = "CALL NewUser('$name', '$family', '$username', '$pass', '$email', '$tel')";
    		$result = $connection->query($sql);
    		if($connection->errno !== 0)
   				die($connection->error);
  			$connection->close();
    		if($result === TRUE)
    		{
                $VerificationCode = md5( rand(0,1000) );
                $time = date( 'Y-m-d H:i:s' );
                $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }
                $sql = "CALL NewVerificationCode('$VerificationCode',$time,'$username')";
                $result = $connection->query($sql);
                if($connection->errno !== 0)
                    die($connection->error);
                $connection->close();
                mail($email, "کد فعال سازی", "" , "From: shayan5420@yahoo.com");
    			$_SESSION['username']=$username;
                echo "اطلاعات شما با موفقیت ثبت شد.\n";
                echo "لطفاً به امیل خود مراجعه کرده و حساب کاربریتان را فعال سازید.";
                die();
    		}else
    		{
    			die("ثبت نام با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    		}
    		
    	}else
    	{
    		die("رمزهای عبور وارد شده با یکدیگر مطابقت ندارند.");
    	}
    }
}


if(isset($_POST['login']))
{
	$connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
	if ($connection->connect_error) {
	    die("Connection failed: " . $connection->connect_error);
	}

	if (empty($_POST["username"]))
    {
    	die("لطفاً تمام فیلد ها را پرد کنید");   
    }else
    {
		$username = $_POST['username'];
    }

    if (empty($_POST["password"]))
    {
        die("لطفاً تمام فیلد ها را پرد کنید");
    }else
    {
    	$pass = $_POST['password'];
    }
    $sql = "CALL Login('$username')";
    $result= $connection->query($sql);
    if($connection->errno !== 0)
    {
		die($connection->error);
    }
    $connection->close();
    if($result->num_rows > 0)
    {
    	$row = $result->fetch_assoc();
        if($row['Verified'] == 1)
        {
            if(password_verify($pass,$row['Password']))
            {
                $_SESSION['username'] = $username;
                if(strtolower($row['Role']) === 'admin')
                {
                    die('success_a');
                }else
                {
                    die('success_u');    
                }
            }else
            {
                die("نام کاربری یا رمز عبور اشتباه است.");
            }    
        }else
        {
            $_SESSION['username'] = $username;
            die("NotVerified");
        }
    	
    }else
    {
    	die("نام کاربری یا رمز عبور اشتباه است.");
    }
    
}

if(isset($_POST['Confirm']))
{
	$connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
	if ($connection->connect_error) {
	    die("Connection failed: " . $connection->connect_error);
	}
	if (empty($_POST["id"]))
    {
		die("لطفاً دوباره سعی کنید.");
    }else
    {
    	$id = intval($_POST['id']);
    }
    $sql = "CALL ConfirmReport($id)";
    $result= $connection->query($sql);
    if($connection->errno !== 0)
    {
		die($connection->error);
    }
    $connection->close();
    if($result === TRUE)
    {
    	die("گزارش مورد نظر با موفقیت تأیید شد.");
    }else
    {
    	die("لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['NewReport']))
{
    if($_SESSION['username'] == "" || !isset($_SESSION['username']) || empty($_SESSION['username']))
    {
        header("Location: http://localhost:81/");
        die();
    }
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    if(!isset($_POST["status"]))
    {
        die("وضعیت شیء گزارش شده را مشخص کنید.");
    }else
    {
        if($_POST["status"] == 0 || $_POST["status"] == 1)
        {
            $status = intval($_POST['status']);
        }else
        {
            die("وضعیت گزارش به درستی وارد نشده است.");
        }
    }

    if(empty($_POST["title"]))
    {
        die("عنوان شیء گزارش شده را مشخص کنید.");
    }else
    {
        $title = $_POST['title'];
    }

    if(empty($_POST["category"]))
    {
        die("دسته بندی شیء گزارش شده را مشخص کنید.");
    }else
    {
        $category = intval($_POST['category']);
    }

    if(empty($_POST["description"]))
    {
        die("جزئیات شیء گزارش شده را ذکر کنید.");
    }else
    {
        $description = $_POST['description'];
    }

    if(empty($_POST["date"]))
    {
        die("تاریخ گم شدن/پیدا شدن شیء گزارش شده را ذکر کنید.");
    }else
    {
        $date = $_POST['date'];
    }

    if(empty($_POST["image_address"]))
    {
        $image_address = null;
    }else
    {
        $image_address = $_POST['image_address'];
    }

    if(empty($_POST["properties"]))
    {
        die("لطفاً مشخصات ضروری را وارد کنید.");
    }else
    {
        if(empty($_POST["categories"]))
        {
            die();
        }else
        {
            $categories = $_POST['categories'];
            $properties = $_POST['properties'];
            $property_value = [];
            $property = '';
            foreach($categories as $value)
            {
                if($value != ''){
                    $v = intval($value);
                    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                    if($connection->connect_error)
                    {
                        die();
                    }
                    $sql = "CALL GetProperties($v)";
                    $result= $connection->query($sql);
                    if($connection->errno !== 0)
                    {
                        die();
                    }
                    $connection->close();
                    for($i = 0; $i < $result->num_rows; $i++)
                    {
                        $row = $result->fetch_assoc();
                        if($row['Necessary'] == 1)
                        {
                            if(array_key_exists(strval($row['Id']), $properties))
                            {
                                $property = $properties[strval($row['Id'])];
                                if($property == null || $property == '')
                                {
                                    die("لطفاً مشخصات ضروری را وارد کنید.");
                                }else
                                {
                                    $property_value[strval($row['Id'])] = $property;
                                }
                            }else
                            {
                                die();
                            }
                        }else
                        {
                            $property_value[strval($row['Id'])] = $properties[strval($row['Id'])];
                        }
                    }
                }
            }
        }
    }
    $user_id = $_SESSION['username'];
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    $last_id = 0;
    if($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $sql = "CALL ReportNewItem('$title', $category, '$description', '$date', '$image_address', $status, '$user_id')";
    if($connection->query($sql) == TRUE)
    {
        $connection->close();
        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $res = $connection->query("SELECT MAX(Object_id) FROM item");
        $row = $res->fetch_assoc();
        $last_id = $row['MAX(Object_id)'];
        if($connection->errno !== 0)
        {
            die($connection->error);
        }
    }else
    {
        die($connection->error);
    }
    $connection->close();

    foreach($property_value as $key => $value)
    {
        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $key = intval($key);
        $sql = "CALL SetProperty($last_id,$key,'$value')";
        $res = $connection->query($sql);
        if($connection->errno !== 0)
        {
            die($connection->error);
        }
        $connection->close();
    }
    die('success');
}


if(isset($_POST['get_sub_category']))
{
    $response = "";
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if($connection->connect_error)
    {
        die();
    }

    if(empty($_POST["category"]))
    {
        die();
    }else
    {
        if($_POST["category"] != '')
        {
            $category = $_POST['category'];
        }else
        {
            die();
        }
    }

    $sql = "CALL GetSubCategories($category)";
    $result= $connection->query($sql);
    if($connection->errno !== 0)
    {
        die();
    }
    $connection->close();
    for($i = 0; $i < $result->num_rows; $i++)
    {
        $row = $result->fetch_assoc();
        $response[$row['Id']] = $row['Name'];
    }
    die(json_encode($response, JSON_UNESCAPED_UNICODE));
}

if(isset($_POST['get_category']))
{
    $response = "";
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if($connection->connect_error){
        die();
    }
    $sql = "CALL GetCategories()";
    $result= $connection->query($sql);
    if($connection->errno !== 0)
    {
        die();
    }
    $connection->close();
    for($i = 0; $i < $result->num_rows; $i++)
    {
        $row = $result->fetch_assoc();
        $response[$row['Id']] = $row['Name'];
    }
    die(json_encode($response, JSON_UNESCAPED_UNICODE));
}

if(isset($_POST['get_property']))
{
    $necessary = array();
    $unnecessary = array();
    $HasResult = FALSE;
    if (empty($_POST["info"]))
    {
        die();
    }else
    {
        $temp = [];
        $categories = $_POST['info'];
        foreach ($categories as $value) {
            if($value != ''){
                $v = intval($value);
                $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                if ($connection->connect_error) {
                    die();
                }
                $sql = "CALL GetProperties($v)";
                $result= $connection->query($sql);
                if($connection->errno !== 0)
                {
                    die();
                }
                $connection->close();
                for($i = 0; $i < $result->num_rows; $i++)
                {
                    $HasResult = TRUE;
                    $row = $result->fetch_assoc();
                    if($row['Necessary'] == 1)
                    {
                        $necessary[$row['Id']] = $row["Name"];
                    }else
                    {
                        $unnecessary[$row['Id']] = $row["Name"];
                    }
                    
                }
            }
        }
        $response = array('necessary' => $necessary , 'unnecessary' => $unnecessary );
    }
    if($HasResult)
    {
        die(json_encode($response, JSON_UNESCAPED_UNICODE));
    }else
    {
        die();
    }
}

if(isset($_POST['NewCategory']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["CategoryName"]))
    {
        die("لطفاً نام دسته را مشخص کنید");
    }else
    {
        $CategoryName = $_POST['CategoryName'];
    }
    if (empty($_POST["parent"]) || $_POST["parent"] == '' || $_POST["parent"] == NULL)
    {
        $sql = "CALL NewCategory('$CategoryName')";
    }else
    {
        $parentId = intval($_POST['parent']);
        $sql = "CALL NewSubCategory('$CategoryName',$parentId)";
    }
    if (!isset($_POST["properties"]))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $properties = $_POST['properties'];
    }
    $result= $connection->query($sql);
    if($connection->errno !== 0)
    {
        die($connection->errno);
    }
    $connection->close();
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $res = $connection->query("SELECT MAX(Id) FROM category");
    if($connection->errno !== 0)
    {
        die($connection->errno);
    }
    $row = $res->fetch_assoc();
    $newCategory = $row['MAX(Id)'];
    $connection->close();
    if($result == TRUE)
    {
        foreach ($properties as $key => $value) {
            $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            if($value == '1' || $value == '0')
            {
                $pid = intval($key);
                $need = intval($value);
                $sql = "CALL AssignProperty($newCategory,$pid,$need)";
                $result= $connection->query($sql);
                $connection->close();
            }
        }
        die("success");
    }else{
        die("ثبت دسته با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    }
}

// if(isset($_POST['NewSubCategory']))
// {
//     $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
//     if ($connection->connect_error) {
//         die("Connection failed: " . $connection->connect_error);
//     }

//     if (empty($_POST["CategoryId"]))
//     {
//         die("لطفاً نام دسته را مشخص کنید");
//     }else
//     {
//         $CategoryId = $_POST['CategoryId'];
//     }

//     if (empty($_POST["SubCategoryName"]))
//     {
//         die("لطفاً نام زیر دسته را مشخص کنید");
//     }else
//     {
//         $SubCategoryName = $_POST['SubCategoryName'];
//     }

//     $sql = "CALL NewSubCategory('$SubCategoryName',$CategoryId)";
//     $result= $connection->query($sql);
//     if($result == TRUE)
//     {
//         $connection->close();
//         die("زیر دسته جدید با موفقیت ثبت شد.");
//     }else{
//         $connection->close();
//         die("ثبت زیر دسته با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
//     }
// }

if(isset($_POST['NewProperty']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["PropertyName"]))
    {
        die("لطفاً نام مشخصه را مشخص کنید");
    }else
    {
        $PropertyName = $_POST['PropertyName'];
    }
    $sql = "CALL NewProperty('$PropertyName')";
    $result= $connection->query($sql);
    if($result == TRUE)
    {
        $connection->close();
        die("success");
    }else{
        $connection->close();
        die("ثبت ویژگی با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['DeleteCategory']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["CategoryId"]))
    {
        die("لطفاً نام دسته را مشخص کنید");
    }else
    {
        $CategoryId = $_POST['CategoryId'];
    }
    $sql = "CALL DeleteCategory($CategoryId)";
    $result= $connection->query($sql);
    if($result == TRUE)
    {
        $connection->close();
        die("دسته مورد نظر با موفقیت حذف شد.");
    }else{
        $connection->close();
        die("حذف دسته با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['DeleteSubCategory']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["SubCategoryId"]))
    {
        die("لطفاً نام زیر دسته را مشخص کنید");
    }else
    {
        $SubCategoryId = $_POST['SubCategoryId'];
    }
    $sql = "CALL DeleteSubCategory($SubCategoryId)";
    $result= $connection->query($sql);
    if($result == TRUE)
    {
        $connection->close();
        die("زیر دسته مورد نظر با موفقیت حذف شد.");
    }else{
        $connection->close();
        die("حذف زیر دسته با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['DeleteProperty']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["PropertyId"]))
    {
        die("لطفاً نام مشخصه را مشخص کنید");
    }else
    {
        $PropertyId = $_POST['PropertyId'];
    }
    $sql = "CALL DeleteProperty($PropertyId)";
    $result= $connection->query($sql);
    if($result == TRUE)
    {
        $connection->close();
        die("مشخصه مورد نظر با موفقیت حذف شد.");
    }else{
        $connection->close();
        die("حذف مشخصه با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['DeleteReport']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["ReportId"]))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $ReportId = $_POST['ReportId'];
    }
    $sql = "CALL DeleteItem($ReportId)";
    $result= $connection->query($sql);
    if($result == TRUE)
    {
        $connection->close();
        die("گزارش مورد نظر با موفقیت حذف شد.");
    }else{
        $connection->close();
        die("حذف گزارش با موفقیت انجام نشد، لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['ShowReports']))
{
    if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || empty($_SESSION['username']))
    {
        header("Location: http://localhost:81/");
        exit();
    }
    $reports = array();
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    if (!isset($_SESSION['username']))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $UserId = $_SESSION['username'];
    }
    $sql = "CALL FindAdmin('$UserId')";
    $result= $connection->query($sql);
    $connection->close();
    if($result->num_rows > 0)
    {
        $sql = "SELECT * FROM item,category WHERE item.Category = category.Id AND item.Confirmed = 1";
    }else{
        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $sql = "CALL FindUser('$UserId')";
        $result= $connection->query($sql);
        if($result->num_rows > 0)
        {
            $sql = "CALL GetReports('$UserId')";
        }else
        {
            die("لطفاً دوباره سعی کنید.");
        }
        $connection->close();
    }
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $result= $connection->query($sql);
    for($i = 0; $i < $result->num_rows; $i++)
    {
        $row = $result->fetch_assoc();
        $features = array();
        $features['Object_id'] = $row['Object_id'];
        $features['Title'] = $row['Title'];
        $features['Category'] = $row['Category'];
        $features['Description'] = $row['Description'];
        $features['Date'] = $row['Date'];
        $features['Image_address'] = $row['Image_address'];
        if($row['Status'] == 1)
        {
            $features['Status'] = "پیدا شده";
        }else
        {
            $features['Status'] = "گم شده";
        }
        $features['User_id'] = $row['User_id'];
        $features['CategoryName'] = $row['Name'];
        $connection->close();
        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        // $obj_id = $row['Object_id'];
        // $sql = "SELECT * FROM item_property WHERE Item_id = $obj_id";
        // $res= $connection->query($sql);
        // for($i = 0; $i < $res->num_rows; $i++)
        // {
        //     $row = $res->fetch_assoc(); 
        //     $features[$row['Property_id']] = $row['Value'];
        // }
        // $connection->close();
        array_push($reports, $features);
    }
    die(json_encode($reports, JSON_UNESCAPED_UNICODE));
}


if(isset($_POST['AssignProperty']))
{
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (empty($_POST["SubCategoryId"]))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $SubCategoryId = $_POST['SubCategoryId'];
    }

    if (empty($_POST["PropertyId"]))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $PropertyId = $_POST['PropertyId'];
    }

    $sql = "CALL AssignProperty($SubCategoryId,$PropertyId)";
    $result= $connection->query($sql);
    $connection->close();
    if($result == TRUE)
    {
        die("مشخصه مورد نظر با موفقیت به زیر دسته مشخص شده اضافه گردید.");
    }else
    {
        die("لطفاً دوباره سعی کنید.");
    }
}

if(isset($_POST['exit']))
{
    unset($_SESSION['username']);
    die();
}

if(isset($_POST['NotConfirmedReports']))
{
    if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || empty($_SESSION['username']))
    {
        header("Location: http://localhost:81/");
        exit();
    }
    $reports = array();
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    if (!isset($_SESSION['username']))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $UserId = $_SESSION['username'];
    }
    $sql = "CALL FindAdmin('$UserId')";
    $result= $connection->query($sql);
    $connection->close();
    if($result->num_rows > 0)
    {
        $sql = "SELECT * FROM item,category WHERE item.Category = category.Id AND item.Confirmed = 0";
        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $result= $connection->query($sql);
        if($connection->errno !== 0)
        {
            die($connection->errno);
        }
        for($i = 0; $i < $result->num_rows; $i++)
        {
            $row = $result->fetch_assoc();
            $features = array();
            $features['Object_id'] = $row['Object_id'];
            $features['Title'] = $row['Title'];
            $features['Category'] = $row['Category'];
            $features['Description'] = $row['Description'];
            $features['Date'] = $row['Date'];
            $features['Image_address'] = $row['Image_address'];
            if($row['Status'] == 1)
            {
                $features['Status'] = "پیدا شده";
            }else
            {
                $features['Status'] = "گم شده";
            }
            $features['User_id'] = $row['User_id'];
            $features['CategoryName'] = $row['Name'];
            $connection->close();
            $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            array_push($reports, $features);
        }
        die(json_encode($reports, JSON_UNESCAPED_UNICODE));
    }else
    {
        die();
    }
}

if(isset($_POST["getAllProperties"]))
{
    if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || empty($_SESSION['username']))
    {
        header("Location: http://localhost:81/");
        exit();
    }
    $properties = array();
    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    if (!isset($_SESSION['username']))
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $UserId = $_SESSION['username'];
    }
    if ($_POST['info'] == Null || !is_array($_POST['info']))
    {
        $categories = array();
    }else
    {
        $categories = $_POST['info']; 
    }
    $sql = "CALL FindAdmin('$UserId')";
    $result= $connection->query($sql);
    $connection->close();
    if($result->num_rows > 0)
    {
        $alreadyExist = array();
        foreach ($categories as $value) {
            if($value != ''){
                $v = intval($value);
                $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                if ($connection->connect_error) {
                    die();
                }
                $sql = "CALL GetProperties($v)";
                $result= $connection->query($sql);
                if($connection->errno !== 0)
                {
                    die();
                }
                $connection->close();
                for($i = 0; $i < $result->num_rows; $i++)
                {
                    $row = $result->fetch_assoc();
                    $alreadyExist[$row["Id"]] = 1;
                }
            }
        }

        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $sql = "SELECT * FROM property";
        $res= $connection->query($sql);
        if($connection->errno !== 0)
        {
            die($connection->errno);
        }
        $connection->close();
        if($res->num_rows > 0)
        {
            for($i = 0; $i < $res->num_rows; $i++)
            {
                $row = $res->fetch_assoc();
                if(!array_key_exists($row["Id"], $alreadyExist)){
                    $properties[$row["Id"]] = $row["Name"];
                }
            }
            die(json_encode($properties, JSON_UNESCAPED_UNICODE));
        }
    }
}

if (isset($_POST["VerifyUser"]))
{
    if (!isset($_POST['VerificationCode']) || empty($_POST['VerificationCode']) || $_POST['VerificationCode'] == null || $_POST['VerificationCode'] = '')
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $VerificationCode = $_POST['VerificationCode'];
    }

    if (!isset($_POST['user_id']) || empty($_POST['user_id']) || $_POST['user_id'] == null || $_POST['user_id'] = '')
    {
        die("لطفاً دوباره سعی کنید.");
    }else
    {
        $UserId = $_POST['user_id'];
    }

    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $sql = "CALL UserExist('$UserId')";
    $result= $connection->query($sql);
    $connection->close();
    if($result->num_rows > 0)
    {
        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $sql = "CALL GetVerificationCode('$UserId')";
        $result = $connection->query($sql);
        $connection->close();
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $date_time = $row["SentTime"];
            $current_time = time();
            if($current_time - $date_time->getTimestamp() <= $row["ExpiryTime"])
            {
                if($row["WrongNum"] <= 3)
                {
                    if($VerificationCode === $row["Code"])
                    {
                        $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                        if ($connection->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }
                        $sql = "CALL VerifyUser('$UserId')";
                        $result = $connection->query($sql);
                        $connection->close();
                        die('success');
                    }else
                    {
                        
                    }
                }else
                {
                    $VerificationCode = md5( rand(0,1000) );
                    $time = date( 'Y-m-d H:i:s' );
                    $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }
                    $sql = "CALL NewVerificationCode('$VerificationCode',$time,'$username')";
                    $result = $connection->query($sql);
                    if($connection->errno !== 0)
                        die($connection->error);
                    $connection->close();
                }
            }else
            {
                $VerificationCode = md5( rand(0,1000) );
                $time = date( 'Y-m-d H:i:s' );
                $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }
                $sql = "CALL NewVerificationCode('$VerificationCode',$time,'$username')";
                $result = $connection->query($sql);
                if($connection->errno !== 0)
                    die($connection->error);
                $connection->close();
            }
        }
    }else
    {
        die("لفاً دوباره سعی کنید.");
    }
}

?>
