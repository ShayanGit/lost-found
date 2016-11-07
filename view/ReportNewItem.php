<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
		    // $("button").click(function(){
		    // 	var category = $('#category').find(":selected").val();
		    // 	$.ajax({
			   //      type: "POST",
			   //      url: "http://localhost:81/app/server.php",
			   //      data: "get_sub_category=get_sub_category" + "&category=" + category,
			   //      success : function(text){
			   //      	alert(text);
			   //          var sub_categories = text.split(",");
			   //          $('#sub_category').empty();
			   //          for (i = 0; i < sub_categories.length; i++) {
			   //          	var res = sub_categories[i].split(":"); 
						//     $('#sub_category').append($('<option>', {
						// 	    value: res[0],
						// 	    text: res[1]
						// 	}));
						// }
			   //      }
			   //  });

		    	// $('#category').change(function(){
		    	// 	var sub_category = $('#sub_category').find(":selected").val();
				   //  $.ajax({
				   //      type: "POST",
				   //      url: "http://localhost:81/app/server.php",
				   //      data: "get_property=get_property" + "&sub_category=" + sub_category,
				   //      success : function(text){
				   //      	alert(text);
				   //          var properties = text.split(",");
				   //          str = "<div id='properties' name='properties'>";
				   //          for (i = 0; i < properties.length; i++) {
				   //          	var res = properties[i].split(":"); 
							//     str += res[1] + ": <input name='" + res[0] + "'>";
							// }
							// str += "</div>";
							// $("#properties").html(str)

				   //      }
				   //  });
		    	// });

		    	$("#NewReport").submit(function(event){
    				// cancels the form submission
    				event.preventDefault();
    				submitForm();
				});
				function submitForm(){
				    // Initiate Variables With Form Content
					var title= $('#title').val();
					var category= $('#category').val();
					var sub_category= $('#sub_category').val();
					var description= $('#description').val();
					var date= $('#date').val();
					var image_address= $("#image_address").val().split('\\').pop();
					var status= $('#status').val();
					// var properties = {};
					var d = "NewReport=NewReport&title=" + title + "&category=" + category + "&sub_category=" + sub_category + "&description=" + description + "&date=" + date + "&image_address=" + image_address +  "&status=" + status;
					$('#properties').children().each(function(){
						// properties[$(this).attr('name')] = this.value;
						d += "&" + $(this).attr('name') + "=" + this.value;
					});

				    $.ajax({
				        type: "POST",
				        url: "http://localhost:81/app/server.php",
				        data: d,
				        success : function(text){
				            alert(text);
				        }
				    });
				}
		    });
	</script>
</head>
<body dir="rtl">
<?php
	session_start();
	if($_SESSION['username'] == "" || !isset($_SESSION['username']) || empty($_SESSION['username']))
	{
	    header("Location: http://localhost:81/");
	}
?>

<form role="form" id="NewReport" >
	عنوان: <input id="title" type="text" name="title"> 
	<?php 
		$category = "دسته: <select>";
		$connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
	    if ($connection->connect_error)
	    {
	    	die("Connection failed: " . $connection->connect_error);
	    }
	    $sql = "CALL GetCategories()";
	    $result= $connection->query($sql);
	    if($connection->errno !== 0)
	    {
	        die($connection->error);
	    }
	    $connection->close();
	    for($i = 0; $i < $result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();
			$category .= "<option value=" . $row['Id'] . ">" . $row['Name'] . "</option>";
		}
		echo $category;
    ?>
	زیر دسته: <select id="sub_category" name="sub_category"></select>
	مشخصات: <div id="properties" name="properties"></div>
	جزئیات: <textarea rows="5" id="description" name="description"></textarea>
	تاریخ: <input id="date" type="date" name="date">
	تصویر: <input id="image_address" type="file" name="image_address" accept="image/*">
	وضعیت: <select id="status" name="status">
				<option value="1">پیدا شده</option>
				<option value="0">گم شده</option>
			</select>
	<button type="submit" name="registerMe">ثبت</button>
</form>
</body>
</html>