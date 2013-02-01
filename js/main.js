 function eventOver_roll(element) 
 {
	element.style.backgroundImage = 'url(images/menubg.gif)';
 }
 function eventOut_noRoll(element) 
 {
	element.style.backgroundImage = '';
 }
 function validate() 
 {
	var password = document.login.password.value;
	var username = document.login.uname.value;
	
	if(password.length < 1 || username.length < 1)
	{
		alert('Fill the forms!');
		return false;
	}
	else {
		return true;
	}
 }
 function show(div)
 {
	$(function() {
		$("#" + div).fadeIn();
	});
 }
 function hide(div)
 {
	$(function() {
		$("#" + div).fadeOut();
	});
 }
 function set_border(thing)
 {
	thing.style.border = '2px solid #edd42e';
 }
 function unset_border(thing)
 {
 	thing.style.border = '2px solid #c3c3c3';
 }
 $(function() {
		$("#right_content").sortable({ revert: true }, { cursor: 'move' }, { opacity: 0.85 })
 });
 function delete_student(thing)
 {
	if(confirm("Are you sure you want to delete this student?"))
	{
		delete_thing(thing, 'delete_student.php');
		return true;
	}
	else {
		return false;
	}
 }
 function delete_user(thing)
 {
	if(confirm("Are you sure you want to delete this user?"))
	{
		delete_thing(thing, 'delete_user.php');
		return true;
	}
	else
	{
		return false;
	}
 }
 function delete_message(thing)
 {
	if(confirm("Are you sure you want to delete this message?"))
	{
		delete_thing(thing, 'delete_message.php');
		return true;
	}
	else 
	{
		return false;
	}
 }
 function confirm_delete_class(thing)
 {
	if(confirm("Are you sure you want to delete this class?"))
	{
		delete_class(thing);
		return true;
	}
	else 
	{
		return false;
	}
 }
 function load_all_subjects()
 {
	$("#message2").load("scripts/subjects.php");
 }
 $(document).ready(function() {
	$("#zabelejka").draggable({ cursor: 'move' });
  });
  $(document).ready(function() {
	$("#ocenki").draggable({ cursor: 'move' });
  });
   $(document).ready(function() {
	$("#student_info").draggable({ cursor: 'move' });
  });
 function GetXmlHttpObject()
 {
	if (window.XMLHttpRequest)
	{
		// IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		//IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
 }
 function student_info(page)
 {
	show('student_info');
	$("#student_info2").html('<div><br /></div><img src="images/loader.gif"> <b>Loading...</b><div><br /></div>');
	xmlhttp = GetXmlHttpObject();
	if(xmlhttp == null)
	{
		alert("Your browser doesnt support AJAX");
		return;
	}
	var page;
	var egn = document.getElementById("egn").value;
	url = 'scripts/student_info.php?egn=' + egn + '&page=' + page;
	
	xmlhttp.open("GET", url, true);
	xmlhttp.onreadystatechange = stateChanged;
	xmlhttp.send(null);
	
	function stateChanged()
	{
		if(xmlhttp.readyState == 4)
		{
			$("#student_info2").hide().html(xmlhttp.responseText).fadeIn();
			hide('search_student');
		}
	}
 }