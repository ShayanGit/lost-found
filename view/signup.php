<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<meta charset="utf-8">
	<script>
		$(document).ready(function(){
		    	$("#RegisterForm").submit(function(event){
    				event.preventDefault();
    				submitForm();
				});
				function submitForm(){
				    var registerMe= "registerMe";
					var name= $('#name').val();
					var family= $('#family').val();
					var username= $('#username').val();
					var password= $('#password').val();
					var confirmPassword= $('#confirmPassword').val();
					var email= $('#email').val();
					var telephone= $('#telephone').val();
				    $.ajax({
				        type: "POST",
				        url: "http://localhost:81/app/server.php",
				        data: "registerMe=" + registerMe + "&name=" + name + "&family=" + family + "&username=" + username + "&password=" + password + "&confirmPassword=" + confirmPassword +  "&email=" + email + "&telephone=" + telephone,
				        success : function(text){
				        	alert(text);
				        	window.location.href = "http://localhost:81/view/verify_user.php";
				        }
				    });
				}

		   //      $.post("http://localhost:81/app/server.php",
		   //      {
		   //      	registerMe: "registerMe",
					// name: $('#name').val(),
					// family: $('#family').val(),
					// username: $('#username').val(),
					// password: $('#password').val(),
					// confirmPassword: $('#confirmPassword').val(),
					// email: $('#email').val(),
					// telephone: $('#telephone').val()
		   //      },
		   //      function(data,status){
		   //          alert("Data: " + data + "\nStatus: " + status);
		   //      });
		    });
	</script>
</head>
<body dir="rtl">
<form role="form" id="RegisterForm">
	نام کاربری: <input id="username" type="text" name="username">&nbsp&nbsp&nbsp&nbsp
	رمز عبور: <input id="password" type="password" name="password">&nbsp&nbsp&nbsp&nbsp
	تکرار رمز عبور: <input id="confirmPassword" type="password" name="confirmPassword">&nbsp&nbsp&nbsp&nbsp
	ایمیل: <input id="email" type="email" name="email">&nbsp&nbsp&nbsp&nbsp
	شماره تماس: <input id="telephone" type="text" name="telephone">&nbsp&nbsp&nbsp&nbsp
	نام: <input id="name" type="text" name="name">&nbsp&nbsp&nbsp&nbsp
	نام خوانوادگی: <input id="family" type="text" name="family">&nbsp&nbsp&nbsp&nbsp
	<button type="submit" name="registerMe">ثبت نام</button>
</form>
</body>
</html>