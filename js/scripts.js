function validate_name(place, text)
{
	var username = document.getElementById(place).value;
	if(username.length < 1 || username.length > 30)
	{
		document.getElementById("message_"+place).innerHTML = '<font color="red" style="font-size:12px;">&nbsp;&nbsp;&nbsp;'+text+'!</font>';
	}
	else
	{
		document.getElementById("message_"+place).innerHTML = '';
	}
}
function validate_password1()
{
	var password = document.getElementById("password").value;
	if(password.length < 6 || password.length > 30)
	{
		document.getElementById("message_pass").innerHTML = '<font color="red" style="font-size:12px;">&nbsp;&nbsp;&nbsp;Write a valid password!</font>';
	}
	else
	{
		document.getElementById("message_pass").innerHTML = '';

	}
}
function validate_email() 
{
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.getElementById('email').value;
   if(reg.test(address) == false) 
   {
     	document.getElementById("message_email").innerHTML = '<font color="red" style="font-size:12px;">&nbsp;&nbsp;&nbsp;Write a valid e-mail!</font>';
   }
   else
   {
		document.getElementById("message_email").innerHTML = '';
   }
}
function validate_password2()
{
	var password = document.getElementById("password").value;
	var password2 = document.getElementById("password2").value;
	if(password == password2)
	{
		document.getElementById("message_pass2").innerHTML = '';
		if(password2.length < 6 || password2.length > 30)
		{
			document.getElementById("message_pass2").innerHTML = '<font color="red" style="font-size:12px;">&nbsp;&nbsp;&nbsp;Write a valid password!</font>';
		}
	}
	else
	{
		document.getElementById("message_pass2").innerHTML = '<font color="red" style="font-size:12px;">&nbsp;&nbsp;&nbsp;The passwords does not match!</font>';
	}
	
}
function pass_str()
			{	
				var pass_strength = document.getElementById('pass_str')
				var password = document.getElementById('password').value;
				if(password.length > 5)
				{
					pass_strength.innerHTML = 'Good';
					pass_strength.style.color = 'green';
					if(password.length > 9)
					{
						pass_strength.innerHTML = 'Strong';
					}
				}
				else
				{
					pass_strength.innerHTML = 'Weak';
					pass_strength.style.color = 'red';
					if(password.length == 0)
					{
						pass_strength.innerHTML = '';
					}
				}
			}

function get_program(day, method)
{
	
	if(day == '---')return 0;
	$("#program_div").html('<img src="images/loader.gif">');
	var xmlhttp = GetXmlHttpObject();
		if(xmlhttp == null)
		{
			alert("Your browser doesnt support AJAX");
			return;
		}
		var url = 'scripts/set_program_script.php?day='+day+'&method='+method;
		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange = stateChanged;
		xmlhttp.send(null);
		
		function stateChanged()
		{
			if(xmlhttp.readyState == 4)
			{
				$("#program_div").hide().html(xmlhttp.responseText).fadeIn();
			}
		}
}
function set_time(chas, day, method)
{
	var place =  $("#"+chas).val();
	var xmlhttp = GetXmlHttpObject();
		if(xmlhttp == null)
		{
			alert("Your browser doesnt support AJAX");
			return;
		}
		var url = 'scripts/set_program_script.php?day='+day+'&chas='+chas+'&method='+method;
		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange = stateChanged;
		xmlhttp.send(null);
		
		function stateChanged()
		{
			if(xmlhttp.readyState == 4)
			{
				$("#"+chas).html(xmlhttp.responseText).fadeIn();
			}
		}
}
function set_time1(chas, vreme, day, method)
{
	
	var vreme = $("#"+vreme).val();
	$("#"+chas).html('<img src="images/loader.gif">').fadeIn();
	if(vreme == '')
	{
		return 1;
	}
	var xmlhttp = GetXmlHttpObject();
		if(xmlhttp == null)
		{
			alert("Your browser doesnt support AJAX");
			return;
		}
		var url = 'scripts/set_program_script.php?day='+day+'&chas='+chas+'&method='+method+'&vreme='+vreme;
		xmlhttp.open("GET", url, true);
		xmlhttp.onreadystatechange = stateChanged;
		xmlhttp.send(null);
		
		function stateChanged()
		{
			if(xmlhttp.readyState == 4)
			{
				$("#"+chas).html(xmlhttp.responseText).fadeIn();
			}
		}
}
function school_starts(day, timem_from, timeh_from, result, method)
{
	$("#"+result).html('<img src="images/loader.gif">').fadeIn();
	var timem = $("#"+timem_from).val();
	var timeh = $("#"+timeh_from).val();
	var xmlhttp = GetXmlHttpObject();
	if(xmlhttp == null)
		{
		alert("Your browser doesnt support AJAX");
		return;
	}
	var url = 'scripts/set_program_script.php?day='+day+'&timem='+timem+'&method='+method+'&timeh='+timeh;
	xmlhttp.open("GET", url, true);
	xmlhttp.onreadystatechange = stateChanged;
	xmlhttp.send(null);
	function stateChanged()
	{
		if(xmlhttp.readyState == 4)
		{
			$("#"+result).html(xmlhttp.responseText).fadeIn();
		}
	}
}

function get_subjects(day, classid, method)
{
	if(day == '---')return 0;
	var xmlhttp = GetXmlHttpObject();
	if(xmlhttp == null)
		{
		alert("Your browser doesnt support AJAX");
		return;
	}
	var url = 'scripts/set_subjects_script.php?day='+day+'&classid='+classid+'&method='+method;
	xmlhttp.open("GET", url, true);
	xmlhttp.onreadystatechange = stateChanged;
	xmlhttp.send(null);
	function stateChanged()
	{
		if(xmlhttp.readyState == 4)
		{
			$("#program_div").hide().html(xmlhttp.responseText).fadeIn();
		}
	}
}
function set_subjects(day, classid, chas, subject, method)
{
	var subject = $("#"+subject).val();
	if(subject == '---')
	{
		return 0;
	}
	var xmlhttp = GetXmlHttpObject();
	if(xmlhttp == null)
		{
		alert("Your browser doesnt support AJAX");
		return;
	}
	var url = 'scripts/set_subjects_script.php?day='+day+'&classid='+classid+'&method='+method+'&chas='+chas+'&subject='+subject;
	xmlhttp.open("GET", url, true);
	xmlhttp.onreadystatechange = stateChanged;
	xmlhttp.send(null);
	function stateChanged()
	{
		if(xmlhttp.readyState == 4)
		{
			alert(xmlhttp.responseText);
		}
	}
}
function edit_title()
{
	$("#school_title").hide();
	$("#school_title_edit").show();
}
function edit_title1()
{
	var value =  $("#school_title_textarea").val();
	$('#school_title_div').text(value);
	$("#school_title_edit").hide();
	$("#school_title").show();
	var xmlhttp = GetXmlHttpObject();
	if(xmlhttp == null)
	{
		alert("Your browser doesnt support AJAX");
		return;
	}
	var url = 'scripts/informaciq.php?header_informaciq='+value;
	xmlhttp.open("GET", url, true);
	xmlhttp.onreadystatechange = stateChanged;
	xmlhttp.send(null);
	function stateChanged()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.responseText != '')
		{
			alert(xmlhttp.responseText);
		}
	}
}
function get_page_program(method)
{
	var page = window.location.href;
	var result = page.split('#');
	page = result[1];
	if(!page  || page == '---')
	{
		return 0;
	}
	var day;
	switch(page)
	{
		case "Monday": day = 'Monday';
		break;
		case "Tuesday": day = 'Tuesday';
		break;
		case "Wednesday": day = 'Wednesday';
		break;
		case "Thursday": day = 'Thursday';
		break;
		case "Friday": day = 'Friday';
		break;
		case "Saturday": day = 'Saturday';
		break;
		case "Sunday": day = 'Sunday';
		break;
	}
	get_program(day, method);
}
function get_page_program2(classid)
{
	var page = window.location.href;
	var result = page.split('#');
	page = result[1];
	if(!page  || page == '---')
	{
		return 0;
	}
	var day;
	switch(page)
	{
		case "Monday": day = 'Monday';
		break;
		case "Tuesday": day = 'Tuesday';
		break;
		case "Wednesday": day = 'Wednesday';
		break;
		case "Thursday": day = 'Thursday';
		break;
		case "Friday": day = 'Friday';
		break;
		case "Saturday": day = 'Saturday';
		break;
		case "Sunday": day = 'Sunday';
		break;
	}
	get_subjects(day, classid, 'get_subjects')
}
function convert_day(day)
{
	switch(day)
	{
		case "Понеделник": day = 'Monday';
		break;
		case "Вторник": day = 'Tuesday';
		break;
		case "Сряда": day = 'Wednesday';
		break;
		case "Четвъртък": day = 'Thursday';
		break;
		case "Петък": day = 'Friday';
		break;
		case "Събота": day = 'Saturday';
		break;
		case "Неделя": day = 'Sunday';
		break;
	}
	return day;
	
}