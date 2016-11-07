<!DOCTYPE html>
<html>
<head>
	<title>ورود</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<meta charset="utf-8">
	<script>
		$(document).ready(function(){
		    	$("#LoginForm").submit(function(event){
    				event.preventDefault();
    				submitForm();
				});
				function submitForm(){
				    var login = "login";
					var username= $('#username').val();
					var password= $('#password').val();
				    $.ajax({
				        type: "POST",
				        url: "http://localhost:81/app/server.php",
				        data: "login=" + login + "&username=" + username + "&password=" + password,
				        success : function(text){
				        	if(text == 'success_a')
				        	{
				        		window.location.href = "http://localhost:81/view/admin_panel.php";	
				        	}else
				        	{
				        		if(text == 'success_u')
				        		{
				        			window.location.href = "http://localhost:81/view/user_profile.php";
				        		}else
				        		{
				        			if(text == 'NotVerified')
				        			{
				        				alert("نام کاربری شما فعال سازی نشده است.");
				        				window.location.href = "http://localhost:81/view/verify_user.php";
				        			}else
				        			{
				        				alert(text);
				        			}
				        		}
				        	}
				            
				        }
				    });
				}
		    });
	</script>
</head>
<body dir="rtl">
<form role="form" id="LoginForm">
	نام کاربری: <input id="username" type="text" name="username">&nbsp&nbsp&nbsp&nbsp
	رمز عبور: <input id="password" type="password" name="password">
	<button type="submit" name="login">ورود</button>
</form>
</body>
</html>