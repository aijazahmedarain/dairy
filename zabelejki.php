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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
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
							<img src="images/student.gif" alt="" /> Notices - 
							<font color="green">
								<u><?php echo $oKlas->printKlas($classid); ?></u> 
							</font> class
						</h1>
						<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
								<td	align="center" width="28%" class="list_td">
									Full name
								</td>
								<td	align="center" width="23%" class="list_td">
									Teacher
								</td>
								<td	align="center" width="37%" class="list_td">
									Notice
								</td>
								<td	align="center" width="12%" class="list_td">
									Date
								</td>
							</tr>
						</table>
						<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<?php
								$select_rows =  $connect->query("SELECT id FROM ".$TABLES['zabelejki']." where classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
								
								$action = $_GET['action'];

								$page = $_GET['page'];
								
								if($action==2)
								{
									$page = $_POST['page'];
								}
									
								if($page == 1 || $page == null)
								{
									$ot = 0;
								}
								if($page > 1)
								{
									$ot = ($page-1)*RESULTS;
								}
								
								$select =  $connect->query("SELECT * FROM ".$TABLES['zabelejki']." where classid = '".mysql_real_escape_string($classid)."' order by id desc limit ".$ot.", ".RESULTS."")or die(MYSQL_ERROR);
								
								if($connect->numRows($select))
								{
									$oStudents = new students;
									$pages = $connect->numRows($select_rows)/RESULTS;
									$pages_floored = floor($pages);
									
									while($row = $connect->fetchObject($select))
									{
										if($oStudents->checkConfirm($row->studentsid))
										{
											echo '<tr>
													<td height="4"></td>
												</tr>
												<tr>
													<td	align="center" width="28%">
													<b>'.$oStudents->printStudent($row->studentsid).'</b>
												</td>
												<td	align="center" width="23%">
													<b>'.$oMain->callName($oMain->callUsername($row->teacherid)).'</b>
												</td>
												<td	align="center" width="37%">
													<u>'.$row->zabelejka.'</u>
												</td>
												<td	align="center" width="12%">
													<i>'.$row->date.'</i>
												</td>
											</tr>';
										}
									}
								}
								else {
									echo '<div align="center"><div id="error">There are still no notices!</div></div>';
								}
							?>
						</table>
						<?php
							if($pages > 1)
							{
						?>	
							<br />
							<div align="right">
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>?classid=<?php echo $classid; ?>&action=2" method="post">
									<font color="#006F9A" ><b>Page : </b></font>
									<select name="page" id="page">
										<?php
											if(isset($_POST['page']))
											{
												echo '<option value="'.$_POST['page'].'">'.$_POST['page'].'</a>';
											}
											if($pages > $pages_floored)
											{
												$pages1 = $pages_floored+1;
											}
											else {
												$pages1 = $pages_floored;
											}
											for($i=1;$i<=$pages1;$i++)
											{
												if($i != $_POST['page'])
												{
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
											}
										?>
									</select>
									<input type="submit" value="Go >" class="yellow_button" />
								</form>
							</div>
						<?php
							}
						?>
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
		header('Location: index.php');
	}
?>