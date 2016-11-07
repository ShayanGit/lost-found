<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>پروفایل شخصی</title>
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<?php
		if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || empty($_SESSION['username']))
		{
		    header("Location: http://localhost:81/");
		    exit();
		}
	?>
	<script type="text/javascript" src="http://localhost:81/javascript/script.js"></script>
</head>
<body dir="rtl">
<div>
	<button id="reportNewItem">گزارش جدید</button>
	<button id="ShowReports">نمایش گزارشات تأیید شده</button>
	<button id="exit">خروج</button>
</div>
<br>
<div id="reports">
</div>

<form role="form" id="NewReport">
	عنوان: <input id="title" type="text" name="title"><br>

	دسته:<div id="categories" name="categories">
			<select id="Category" name="category">
			</select>
		</div>
	مشخصات: <div id="properties" name="properties"></div>
	جزئیات:<br><textarea rows="5" id="description" name="description"></textarea><br>
	تاریخ: <input type="date" name="date" id="date">&nbsp&nbsp&nbsp&nbsp
	<!-- تصویر: <input id="image_address" type="file" name="image_address" accept="image/*">&nbsp&nbsp -->
	وضعیت:	<select id="status" name="status">
				<option value="1">پیدا شده</option>
				<option value="0">گم شده</option>
			</select><br>
	<button type="submit">ثبت</button>
</form>
</body>
</html>
