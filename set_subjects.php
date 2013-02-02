<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
		
		// ако искаме да направим някаква заявка към базата използваме тази променлива
		$connect = new DbConnector();
		
		// взимаме classid
		$classid = htmlspecialchars($_GET['classid']);
		
		// взимаме teacherid
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);
		
		// проверяваме дали учителят е класен на този клас
		$oKlas = new klas;
		
		// взимаме studentsid
		$studentsid = htmlspecialchars($_GET['studentsid']);
		
		if($oKlas->checkKlasen($teacherid, $classid))
		{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 School diary All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript" src="js/register_check.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/boxover.js"></script>
</head>
<body onload="get_page_program2('<?php echo $classid; ?>')" >
	<div align="center">
		<div id="main">
			<?php
				include('scripts/top_menu.php');
				include('scripts/header.php');
			?>
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
					<td class="left_content" valign="top">
						<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/program_big.png" alt="Програма" /> 
								Setting the school schedule and subjects
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />	
						<br /> 
						<br /> 
						<div id="sort">
							<div align="center">
								Select day:
								<select id="day" name="day" onchange="get_subjects(this.value, '<?php echo $classid; ?>', 'get_subjects');location.href='#'+convert_day(this.value)">
									<option value="---" >---</option>
									<option value="Monday" >Monday</option>
									<option value="Tuesday" >Tuesday</option>
									<option value="Wednesday" >Wednesday</option>
									<option value="Thursday" >Thursday</option>
									<option value="Friday" >Friday</option>
									<option value="Saturday" >Saturday</option>
									<option value="Sunday" >Sunday</option>	
								</select>
							</div>
						</div>
						<br /><br />
						<div id="program_div" ></div>
						<hr width="80%" color="#c3c3c3" size="1" />
					</td>
					<td class="right_content" valign="top">
						<div align="center">
							<?php
								include('scripts/right_content.php');
							?>
						</div>
					</td>
				</tr>
			</table>
			<?php
				include('scripts/footer.php');
			?>
		</div>
	</div>
</body>
</html>
<?php
		}
		else {
			header('Location: menu_functions.php');
		}
	}
	else {
		header('Location: index.php');
	}
?>