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
		
		// взимаме studentsid
		$studentsid = htmlspecialchars($_GET['studentsid']);
		
		if($oKlas->checkKlasen($teacherid, $classid))
		{
			$oStudents = new students;
			
			$oOtsastviq = new otsastviq;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2009 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript" src="js/ajax.js"></script>
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
							<img src="images/student.gif" alt="" /> Absence - 
							<font color="green">
								<u><?php echo $oStudents->printStudent($studentsid); ?></u> 
							</font> from <font color="green"><u><?php echo $oKlas->printKlas($classid); ?></u></font> class 
						</h1>
						<div id="success" align="center">
							<?php
								$otsastviq = explode("-", $oOtsastviq->countOtsastviq($studentsid));
								$izvineni = $otsastviq[0];
								$neizvineni = $otsastviq[1];
							?>
							<font color="#006F9A" >
								<b>Excused :</b>
							</font> 
							<font color="green">
								<?php echo $izvineni; ?>
							</font>
							<font color="#006F9A" >
								<b>Unexcused :</b>
							</font> 
							<font color="red">
								<?php echo $neizvineni; ?>
							</font>
						</div>
						<input type="hidden" value="<?php echo $classid; ?>" id="klas" name="klas" />
						<div align="left" id="sort">
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?classid=<?php echo $classid; ?>&action=3&studentsid=<?php echo $studentsid; ?>" method="post">
								<label for="sort">
									<img src="images/sort.png" alt="" /> Sort by :
								</label>
								<select name="sort" id="sort">
									<option value="izvineni">
										Excused
									</option>
									<option value="neizvineni">
										Unexcused
									</option>
								</select>
								<input type="submit" name="sort_button" value="Sort >>" class="yellow_button"/>
							</form>
						</div>
						<table align="center" width="100%" cellpadding="0" cellspacing="0" >
							<tr>
								<td align="center" width="18%" class="list_td">
									Absence
								</td>
								<td align="center" width="40%" class="list_td">
									Subject
								</td>
								<td align="center" width="25%" class="list_td">
									Date
								</td>
								<td align="center" width="17%" class="list_td">
									Excuse
								</td>
							</tr>
						</table>
						<?php
							$select_rows =  $connect->query("SELECT id FROM ".$TABLES['otsastviq']." where studentsid = '".mysql_real_escape_string($studentsid)."'")or die(MYSQL_ERROR);
								
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
								$ot = ($page-1)*RESULT_OTSASTVIQ;
							}
							if($action == 3 && isset($_POST['sort_button']))
							{
								$sort = $_POST['sort'];
								if($sort == 'izvineni')
								{
									$select =  $connect->query("SELECT * FROM ".$TABLES['otsastviq']." where studentsid = '".mysql_real_escape_string($studentsid)."' && izvineno = 'true' order by id desc limit ".$ot.", ".RESULT_OTSASTVIQ."")or die(MYSQL_ERROR);
								}
								if($sort == 'neizvineni')
								{
									$select =  $connect->query("SELECT * FROM ".$TABLES['otsastviq']." where studentsid = '".mysql_real_escape_string($studentsid)."' && izvineno = 'false' order by id desc limit ".$ot.", ".RESULT_OTSASTVIQ."")or die(MYSQL_ERROR);
								}
							}
							else {
								$select =  $connect->query("SELECT * FROM ".$TABLES['otsastviq']." where studentsid = '".mysql_real_escape_string($studentsid)."' order by id desc limit ".$ot.", ".RESULT_OTSASTVIQ."")or die(MYSQL_ERROR);
							}
							if($connect->numRows($select))
							{
								$oPredmet = new predmet;
								
								$pages = $connect->numRows($select_rows)/RESULT_OTSASTVIQ;
								$pages_floored = floor($pages);
								
								echo '<table align="center" width="100%" cellspacing="0" cellspacing="0">';
								
									while($row = $connect->fetchObject($select))
									{
										$oPredmet->predmetid = $row->predmetid;
										
										echo '<tr>
												<td height="3"></td>
											</tr>
											<tr>
												<td align="center" width="18%">
													'.$oOtsastviq->returnOtsastvie($row->otsastvie, 'unreal').'
												</td>
												<td align="center" width="40%">
													'.$oPredmet->callPredmet().'
												</td>
												<td align="center" width="25%">
													'.$row->date.'
												</td>
												<td align="center" width="17%" id="'.$row->id.'c">
													'.$oOtsastviq->checkOtsastvie($row->otsastvie, $row->izvineno, $row->id).'
												</td>
											</tr>';
									}
									
								echo'</table>';
							}
							else {
								echo '<div align="center"><div id="success">This student has no absences!</div></div>';
							}
						?>
						<div id="message"></div>
						<div><br /></div>
						<?php
							if($pages > 1)
							{
						?>
							<div align="right">
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>?classid=<?php echo $classid; ?>&action=2&studentsid=<?php echo $studentsid; ?>" method="post">
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
						<hr width="100%" color="#c3c3c3" size="1" />
							<a href="otsastviq.php?classid=<?php echo $classid; ?>&page=1"><b>. : Go back : .</b></a>
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