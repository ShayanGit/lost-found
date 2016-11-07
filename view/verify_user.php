<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php
		if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || empty($_SESSION['username']))
		{
		    header("Location: http://localhost:81/");
		    exit();
		}
	?>
	<meta charset="utf-8">
	<script src="jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="http://localhost:81/javascript/script.js">
	</script>
</head>
<body>
<form role="form" id="verification_code">
	عبارت فعال سازی: <input type="text" id="VerificationCode" name="VerificationCode">
	نام کاربری: <?php echo "<input type='text' id='user_id' name='user_id' value='".$_SESSION['username']."'disabled>" ?>
	<button type="submit">تأیید</button>
</form>
</body>
</html>