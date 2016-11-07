<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<meta charset="utf-8">
	<script>
		$(document).ready(function(){

			$('#NewReport').click(function(){
				var d = "NewReport=NewReport&title=ساعت دیجیتال&category=1&sub_category=1&description=ساعت مچی دیجیتال&date=2016-7-6&image_address=phosphor-eink-digital-watch-2.jpg&status=1&1=مشکی";
			    $.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: d,
			        success : function(text){
	        			alert(text);
			        }
			    });	
			});

			$('#get_sub_category').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "get_sub_category=get_sub_category&category=1",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#get_property').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "get_property=get_property&sub_category=1",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#NewCategory').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "NewCategory=NewCategory&CategoryName=اتوموبیل",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#NewSubCategory').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "NewSubCategory=NewSubCategory&CategoryId=2&SubCategoryName=کامیون",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#NewProperty').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "NewProperty=NewProperty&PropertyName=مدل",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#ShowReports').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "ShowReports=ShowReports",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#RegisterMe').click(function(){
				var registerMe= "registerMe";
				var name= "امین";
				var family= "عباسی";
				var username= "امین";
				var password= "1";
				var confirmPassword= "1";
				var email= "amin@yahoo.com";
				var telephone= "239749";
			    $.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "registerMe=" + registerMe + "&name=" + name + "&family=" + family + "&username=" + username + "&password=" + password + "&confirmPassword=" + confirmPassword +  "&email=" + email + "&telephone=" + telephone,
			        success : function(text){
			            alert(text);
			        }
			    });
			});

			$('#AssignProperty').click(function(){
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "AssignProperty=AssignProperty&SubCategoryId=2&PropertyId=2",
			        success : function(text){
	        			alert(text);
			        }
			    });
			});

			$('#Login').click(function(){
				var login = "login";
				var username= "امین";
				var password= "1";
			    $.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "login=" + login + "&username=" + username + "&password=" + password,
			        success : function(text){
			        	if(text == 'success')
			        	{
			        		alert("خوش آمدید.");	
			        	}else
			        	{
			        		alert("ورود ناموفق");
			        	}
			            
			        }
			    });
			});

			$('#Confirm').click(function(){
			    var Confirm = "Confirm";
				var id= 31;
			    $.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "Confirm=" + Confirm + "&id=" + id,
			        success : function(text){
			            alert(text);
			        }
			    });
			});
		});
	</script>
</head>
<body dir="rtl">

<button id="NewReport">گزارش جدید</button>
<button id="get_sub_category">دریافت زیر دسته ها</button>
<button id="get_property">دریافت مشخصات دسته</button>
<button id="NewCategory">دسته جدید</button>
<button id="NewSubCategory">زیر دسته جدید</button>
<button id="NewProperty">مشخصه جدید</button>
<button id="ShowReports">نمایش گزارش ها</button>
<button id="RegisterMe">کاربر جدید</button>
<button id="AssignProperty">اختصاص دادن مشخصه</button>
<button id="Login">ورود</button>
<button id="Confirm">تأیید گزارش</button>

</body>
</html>