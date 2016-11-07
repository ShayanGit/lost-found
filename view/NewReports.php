<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		function Confirm(ObjectId){
		    // Initiate Variables With Form Content
		    alert("آیا از تأیید این گزارش مطمئن هستید؟");
		    var Confirm = "Confirm";
			var id= ObjectId;
		    $.ajax({
		        type: "POST",
		        url: "http://localhost:81/app/server.php",
		        data: "Confirm=" + Confirm + "&id=" + id,
		        success : function(text){
		            alert(text);
		        }
		    });
		}

	</script>
</head>
<body>

<?php
	$connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
	if ($connection->connect_error) {
	    die("Connection failed: " . $connection->connect_error);
	}
	$sql = "CALL NotConfirmedItem()";
	$result= $connection->query($sql);
	if($connection->errno !== 0)
    {
		die($connection->error);
    }
	if($result->num_rows > 0)
	{
		$body  = "<div>";
		for($i = 0; $i < $result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();
			$body .= "<div><img width='150px' height='150px' src='../Images/" . $row["Image_address"] . "' alt='Object Picture'>";
			$body .= "<p>عنوان: ".$row['Title'];
			$body .= "<br>دسته: ".$row['Category'];
			$body .= "<br>زیر دسته: ".$row['Sub_category'];
			$body .= "<br>جزئیات: ".$row['Description'];
			$body .= "<br>تاریخ: ".$row['Date'];
			$body .= "<br>وضعیت: ".$row['Status'];
			$body .= "<button type='button' onclick='Confirm(".$row['Object_id'].")'>Confirm</button></div>";
			$body .= "----------------------------------------------------------------------------------<br>";
		}
		echo $body . "</div>";
	}else
	{
		die('شیء گم شده جدید گزارش نشده است.');
	}
	$connection->close();
?>

</body>
</html>