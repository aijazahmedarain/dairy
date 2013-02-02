<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('connection/connector.php');
		require_once('config.php');
		
		// ако искаме да направим някаква заявка към базата използваме тази променлива
		$connect = new DbConnector();
		
		// взимаме classid
		$classid = htmlspecialchars($_GET['classid']);
		
		// взимаме teacherid
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);
		
		// проверяваме дали учителят е класен на този клас
		$oKlas = new klas;
		
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
</head>
<body>
	<div align="center">
		<div id="main">
			<?php
				include('scripts/top_menu.php');
				include('scripts/header.php');
			?>
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
					<td class="left_content" valign="top">
						<h1 align="left">
							<img src="images/student.gif" alt="" /> Absences
							<font color="green">
								<u><?php echo $oKlas->printKlas($classid); ?></u> 
							</font> class
						</h1>
						<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
								<td align="center" width="5%" class="list_td">
									No
								</td>
								<td	align="center" width="20%" class="list_td">
									Name
								</td>
								<td	align="center" width="25%" class="list_td">
									Surname
								</td>
								<td	align="center" width="20%" class="list_td">
									Excused
								</td>
								<td	align="center" width="20%" class="list_td">
									Unexcused
								</td>
								<td align="center" width="10%" class="list_td">
									Excuse
								</td>
							</tr>
						</table>
						<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<?php
								$select = $connect->query("SELECT * FROM ".$TABLES['uchenici']." WHERE classid = '".mysql_real_escape_string($classid)."' order by number asc")or die(MYSQL_ERROR);
								
								if($connect->numRows($select))
								{
									$oOtsastviq = new otsastviq;
									$oStudents = new students;
									
									while($row = $connect->fetchObject($select))
									{
										if($oStudents->checkConfirm($row->studentsid))
										{
											$otsastviq = explode("-", $oOtsastviq->countOtsastviq($row->studentsid));
											$izvineni = $otsastviq[0];
											$neizvineni = $otsastviq[1];
											
											echo '<tr>
													<td align="center" width="5%">
														'.$row->number.'
													</td>
													<td align="center" width="20%">
														'.$row->ime.'
													</td>
													<td align="center" width="25%">
														'.$row->familiq.'
													</td>
													<td align="center" width="20%">
														<font color="green"><i>'.$izvineni.'</i></font>
													</td>
													<td align="center" width="20%">
														<font color="red"><i>'.$neizvineni.'</i></font>
													</td>
													<td align="center" width="10%" class="list_td_info">
															<a href="edit_otsastviq.php?studentsid='.$row->studentsid.'&classid='.$classid.'&page=1">
																<img src="images/edit.gif" alt="" border="0" />
															</a>
														</td>
												</tr>';
										}
									}
								}
								else {
									echo '<div align="center"><div id="error">There are still no students in this class.</div></div>';
								}
							?>
						</table>
						<div><br /></div>
						<hr width="100%" color="#c3c3c3" size="1" />
							<a href="menu_functions.php?method=list"><b>. : Go back : .</b></a>
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