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
            document.getElementById('ShowReports').click();
        }
    });
}

function DelReport(ObjectId){
	// Initiate Variables With Form Content
    alert("آیا از حذف این گزارش مطمئن هستید؟");
	var id= ObjectId;
    $.ajax({
        type: "POST",
        url: "http://localhost:81/app/server.php",
        data: "DeleteReport=DeleteReport" + "&ReportId=" + id,
        success : function(text){
            alert(text);
            document.getElementById('reports').style.display = "none";
        }
    });
}



$(document).ready(function(){
	$("#new_property").hide();
	$("#NewReport").hide();
	$("#reports").hide();
	$("#new_category").hide();
	$('#exit').click(function(){
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "exit=exit",
	        success : function(text){
    			window.location.href = "http://localhost:81/";
	        }
		});
	});

	$('#ShowReports').click(function(){
		$("#new_property").hide(300);
		$("#NewReport").hide(300);
		$("#new_category").hide(300);
		$("#reports").show(300);
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "ShowReports=ShowReports",
	        success : function(text){
				var content = "";
				if($.parseJSON(text).length == 0){
					alert("گزارشی موجود نمی باشد.");
				}
    			$.each($.parseJSON(text), function(key,value){
				    content += "<div><img width='150px' height='150px' src='../files/images/" + value.Image_address + "'>";
				    content += "<p>عنوان: " + value.Title;
				    content += "<br>دسته: " + value.CategoryName;
				    content += "<br>جزئیات: " + value.Description;
				    content += "<br>تاریخ: " + value.Date;
				    content += "<br>وضعیت: " + value.Status;
				    content += "<br>نام کاربری گزارش دهنده: " + value.User_id;
				    // $.ajax({
				    //     type: "POST",
				    //     url: "http://localhost:81/app/server.php",
				    //     data: "get_property=get_property&category=" + value.Category,
				    //     success : function(text){
				    //     	$.each($.parseJSON(text), function(k,v){
				    //     		content += "<br>" + v + ": " + value[k];
				    //     	});
				    //     }
				    // });
				    content += "<br><button class='delete_report' type='button' onclick=DelReport(" + value.Object_id + ")>حذف گزارش</button>";
				    content += "</p></div>";
				    content += "----------------------------------------";
				});

				$('#reports').html(content);
	        }
	    });
	});

	$('#NotConfirmedItems').click(function(){
		$("#new_property").hide(300);
		$("#NewReport").hide(300);
		$("#new_category").hide(300);
		$("#reports").show(300);
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "NotConfirmedReports=NotConfirmedReports",
	        success : function(text){
				var content = "";
				if($.parseJSON(text).length == 0){
					alert("گزارشی موجود نمی باشد.");
				}
    			$.each($.parseJSON(text), function(key,value){
				    content += "<div><img width='150px' height='150px' src='../files/images/" + value.Image_address + "'>";
				    content += "<p>عنوان: " + value.Title;
				    content += "<br>دسته: " + value.CategoryName;
				    content += "<br>جزئیات: " + value.Description;
				    content += "<br>تاریخ: " + value.Date;
				    content += "<br>وضعیت: " + value.Status;
				    content += "<br>نام کاربری گزارش دهنده: " + value.User_id;
				    content += "<br><button class='confirm' type='button' onclick=Confirm(" + value.Object_id + ")>تأیید گزارش</button>";
				    // $.ajax({
				    //     type: "POST",
				    //     url: "http://localhost:81/app/server.php",
				    //     data: "get_property=get_property&category=" + value.Category,
				    //     success : function(text){
				    //     	$.each($.parseJSON(text), function(k,v){
				    //     		content += "<br>" + v + ": " + value[k];
				    //     	});
				    //     }
				    // });
				    content += "<br><button class='delete_report' type='button' onclick=DelReport(" + value.Object_id + ")>حذف گزارش</button>";
				    content += "</p></div>";
				    content += "----------------------------------------";
				});
				$('#reports').html(content);
	        }
	    });
	});

	$("#reportNewItem").click(function(){
		$("#new_property").hide(300);
		$("#reports").hide(300);
		$("#new_category").hide(300);
		$("#NewReport").show(300);
		$("#Category").nextAll().remove();
		$("#Category").find('option').remove();
		$("#properties").empty();
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "get_category=get_category",

	        success : function(text){
	        	if(text.length != 0){
	        		$("#properties").empty();
	        		$("#Category").nextAll().remove();
					$("#Category").find('option').remove();
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
	});

	

	$(document).on('change',"[id=Category],[class=sub_categories]", function() {
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
	        	if(text == 'success')
	        	{
	        		alert("گزارش با موفقیت ثبت شد، لطفاً منتظر تأیید آن بمانید.");
	        		$("#NewReport").hide(300);
	        	}else
	        	{
	        		alert(text);
	        	}
	        }
	    });
	}

	$("#newCategory").click(function(){
		$("#new_property").hide(300);
		$("#reports").hide(300);
		$("#NewReport").hide(300);
		$("#new_category").show(300);
		$("#Category_2").nextAll().remove();
		$("#Category_2").find('option').remove();
		$("#properties_2").empty();
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "get_category=get_category",
	        success : function(text){
	        	if(text.length != 0){
	        		$("#Category_2").nextAll().remove();
					$("#Category_2").find('option').remove();
	        		$.each($.parseJSON(text), function(key,value){
        				$('#Category_2').append($('<option>', {
						    value: key ,
						    text: value
						}));
    				});
    				$("#Category_2").prepend("<option value='' selected='selected'></option>");
	        	}
	        }
		});
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: {"getAllProperties":"getAllProperties","info":null},
	        success : function(text){
	        	if(text.length > 0)
	        	{
	        		$("#properties_2").empty();
					$.each($.parseJSON(text), function(key,value){
						var tmp = $('<form class="property" name="'+key+'">').appendTo('#properties_2');
						tmp.append($('<span>', {
							text: "ضروری"
						}));
						tmp.append($('<input>', {
						    type: "radio",
						    value: "1",
						    name: "Need"
						}));
						tmp.append($('<span>' , {
							text: "غیر ضروری"
						}));
						tmp.append($('<input>', {
						    type: "radio",
						    value: "0",
						    name: "Need"
						}));
						tmp.append($('<span>', {
							text: "هیچکدام"
						}));
						tmp.append($('<input>', {
						    type: "radio",
						    value: "3",
						    name: "Need",
						    checked: "checked"
						}));
						tmp.before($('<span>', {
						    text: "    " + value + ""
						}));
					});
	        	}
	        }
		});
	});

	$(document).on('change', "[id=Category_2],[class=sub_categories]", function() {
		var category = $(this).val();
		$(this).nextAll().remove();
		$("#properties_2").empty();
		var info = [];
		$('#categories_2').children().each(function () {
			info.push($(this).val());
		});
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "get_sub_category=get_sub_category&category=" + category,
	        success : function(text){
	        	if(text.length != 0){
	        		var sel = $('<select class="sub_categories">').appendTo('#categories_2');
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
	        data: {"getAllProperties":"getAllProperties","info":info},
	        success : function(text){
	        	if(text.length > 0)
	        	{
	        		$("#properties_2").empty();
	        		$.each($.parseJSON(text), function(key,value){
	        			var tmp = $('<form class="property" name="'+key+'">').appendTo('#properties_2');
						tmp.append($('<span>', {
							text: "ضروری"
						}));
						tmp.append($('<input>', {
						    type: "radio",
						    value: "1",
						    name: "Need"
						}));
						tmp.append($('<span>' , {
							text: "غیر ضروری"
						}));
						tmp.append($('<input>', {
						    type: "radio",
						    value: "0",
						    name: "Need"
						}));
						tmp.append($('<span>', {
							text: "هیچکدام"
						}));
						tmp.append($('<input>', {
						    type: "radio",
						    value: "3",
						    name: "Need",
						    checked: "checked"
						}));
						tmp.before($('<span>', {
						    text: "    " + value + ""
						}));
					});
	        	}	
	        }
		});
	});

	$("#new_category").submit(function(event){
		event.preventDefault();
		submitCategory();
	});

	function submitCategory(){
		var name = $('#categoryName').val();
		var parentCategory = $('#categories_2').children().eq(-2).val();
		// age ye category bishtar nabashe chi???????? injuri eq(-2) nadarim
		var properties = [];
		var categories = [];
		$('#properties_2').children('form').each(function () {
			properties[$(this).attr('name')] = $(this).children('input:radio[name=Need]:checked').val();
		});
		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: {"NewCategory":"NewCategory","CategoryName":name,"properties":properties, "parent":parentCategory},
	        success : function(text){
	        	if(text == 'success')
	        	{
	        		alert("ثبت دسته با موفقیت انجام شد.");
	        		$("#new_category").hide(300);
	        	}else
	        	{
	        		alert(text);
	        	}
	        }
	    });
	}

	$("#newProperty").click(function(){
		$("#reports").hide(300);
		$("#NewReport").hide(300);
		$("#new_category").hide(300);
		$("#new_property").show(300);
	});

	$("#new_property").submit(function(event){
		event.preventDefault();
		submitProperty();
	});

	function submitProperty(){
		var name = $("#propertyName").val();

		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "NewProperty=NewProperty&PropertyName=" + name,
	        success : function(text){
	        	if(text == 'success')
	        	{
	        		alert("ثبت مشخصه با موفقیت انجام شد.");
	        		$("#new_property").hide(300);
	        	}else
	        	{
	        		alert(text);
	        	}
	        }
	    });
	}

	$("#verify_user").submit(function(event){
		event.preventDefault();
		VerifyUser();
	});

	function VerifyUser(){
		var code = $("#VerificationCode").val();
		var User_id = $('#user_id').val();

		$.ajax({
	        type: "POST",
	        url: "http://localhost:81/app/server.php",
	        data: "VerifyUser=VerifyUser&user_id=" + user_id + "&VerificationCode=" + code,
	        success : function(text){
	        	if(text == 'success')
	        	{
	        		alert("ثبت مشخصه با موفقیت انجام شد.");
	        		$("#new_property").hide(300);
	        	}else
	        	{
	        		alert(text);
	        	}
	        }
	    });
	}
});