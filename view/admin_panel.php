<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>پنل ادمین</title>
	<meta charset="utf-8">
	<script src="jquery-1.12.4.min.js"></script>
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
	<button id="NotConfirmedItems">گزارشات تأیید نشده</button>
	<button id="newCategory">افزودن دسته</button>
	<button id="newProperty">افزودن مشخصه</button>
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
<form role="form" id="new_category">
	دسته:<div id="categories_2" name="categories_2">
			<select id="Category_2" name="category_2">
			</select>
		</div>
		<br>
		نام دسته جدید: <input id="categoryName" type="text" name="categoryName"><br><br>
		<!-- مشخصات ضروری: <div id="necessary_properties" name="necessary_properties"></div>
		مشخصات غیر ضروری: <div id="unnecessary_properties" name="unnecessary_properties"></div> -->
		مشخصات: <div id="properties_2"><br></div>
		<button type="submit">ثبت</button>
</form>

<form role="form" id="new_property">
	نام مشخصه: <input type="text" id="propertyName" name="propertyName">
	<button type="submit">ثبت</button>
</form>
</body>
</html>