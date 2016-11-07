<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>گزارش جدید</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<meta charset="utf-8">
	<?php
		if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || empty($_SESSION['username']))
		{
		    header("Location: http://localhost:81/");
		    exit();
		}
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
		        type: "POST",
		        url: "http://localhost:81/app/server.php",
		        data: "get_category=get_category",
		        success : function(text){
		        	if(text.length != 0){
		        		$.each($.parseJSON(text), function(key,value){
	        				$('#Category').append($('<option>', {
							    value: key ,
							    text: value
							}));
        				});
        				$("#Category").prepend("<option value='' selected='selected'></option>");
		        	}
		        }
			});


			$( "#Category" ).change(function() {
				var category = $(this).val();
				$(this).nextAll().remove();
				$("#properties").empty();
				var info = [];
				$('#categories').children().each(function () {
					info.push($(this).val());
				});
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "get_sub_category=get_sub_category&category=" + category,
			        success : function(text){
			        	if(text.length != 0){
			        		var sel = $('<select class="sub_categories">').appendTo('#categories');
				        	$.each($.parseJSON(text), function(key,value){
			        			sel.append($('<option>', {
								    value: key ,
								    text: value
								}));
							});
							sel.prepend("<option value='' selected='selected'></option>");
			        	}
			        }
				});

				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: {"get_property":"get_property","info":info},
			        success : function(text){
			        	if(text.length > 0)
			        	{
			        		$.each($.parseJSON(text), function(key,value){
			        			for(var i in value){
			        				$("#properties").append($('<span>', {
									    text: "    " + value[i] + ": "
									}))
			        				$("#properties").append($('<input>', {
									    name: i,
									    id: i
									}));
			        			}
							});
			        	}
			        	
			        	
			        }
				});
			});
			$(document).on('change', "[class=sub_categories]", function(){
				var category = $(this).val();
				$(this).nextAll().remove();
				$("#properties").empty();
				var info = [];
				$('#categories').children().each(function () {
					info.push($(this).val());
				});
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: "get_sub_category=get_sub_category&category=" + category,
			        success : function(text){
			        	if(text.length != 0){
			        		var sel = $('<select class="sub_categories">').appendTo('#categories');
				        	$.each($.parseJSON(text), function(key,value){
			        			sel.append($('<option>', {
								    value: key,
								    text: value
								}));
							});
							sel.prepend("<option value='' selected='selected'></option>");
			        	}
			        }
				});

				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        data: {"get_property":"get_property","info":info},
			        success : function(text){
			        	if(text.length > 0)
			        	{
			        		$.each($.parseJSON(text), function(key,value){
			        			for(var i in value){
			        				$("#properties").append($('<span>', {
									    text: "    " + value[i] + ": "
									}))
			        				$("#properties").append($('<input>', {
									    name: i,
									    id: i
									}));
			        			}
							});
			        	}
			        }
				});
			});

			$("#NewReport").submit(function(event){
				event.preventDefault();
				submitForm();
			});

			function submitForm(){
				var title = $("#title").val();
				var category = $('#categories').children().eq(-2).val();
				var properties = [];
				var categories = [];
				$('#properties').children('input').each(function () {
					properties[$(this).attr('name')] = $(this).val();
				});
				$('#categories').children('select').each(function () {
					categories.push($(this).val());
				});
				var description = $('#description').val();
				var date = $('#date').val();
				// var formData = new FormData();
				// formData.append('file', $('input[type=file]')[0].files[0]);
  				var status = $('#status').val();
				$.ajax({
			        type: "POST",
			        url: "http://localhost:81/app/server.php",
			        // contentType: false,
			        // processData: false,
			        // cache: false, 
			        data: {"NewReport":"NewReport","title":title,"category":category,"properties":properties,"description":description,"date":date,"status":status , "categories":categories},
			        success : function(text){
			        	alert(text);
			        }
			    });
			}


		});
	</script>
</head>
<body dir="rtl">

<form role="form" id="NewReport" >
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