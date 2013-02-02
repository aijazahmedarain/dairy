<?php
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('connection/connector.php');
		require_once('config.php');
		require_once('anketa_header.php');
	
		$connect = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
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
						<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/icon_rangs.gif" alt="" /> 
								Manage classes - <font color="green"><u>Add sub-classes</u></font>
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							$klas = addslashes($_POST['klas']);
							$class = addslashes($_GET['class']);
							$do = addslashes($_POST['do']);
							$action = $_GET['action'];
							
							$oParalelki = new paralelki;
							$oParalelki->classes = $class;
							
							$select = $connect->query("SELECT * FROM ".$TABLES['paralelki']." order by classid desc") or die(MYSQL_ERROR);
							$row = $connect->fetchObject($select);
							$max = $row->classid+1;
							
							if($action == 2)
							{
								if(isset($do) && !$oParalelki->checkKlas())
								{
									for($i=1;$i<=$do;$i++)
									{	
										switch($i) {
											case 1:
												$class_name = "a";
											break;
											case 2:
												$class_name = "b";
											break;
											case 3:
												$class_name = "c";
											break;
											case 4: 
												$class_name = "d";
											break;
											case 5:
												$class_name = "e";
											break;
											case 6:
												$class_name = "f";
											break;
											case 7:
												$class_name = "g";
											break;
											case 8:
												$class_name = "h";
											break;
										}
										if($row) $classid = $max++;
										else $classid++;
										
										$query = $connect->query("INSERT INTO ".$TABLES['paralelki']." (klas, class_name, classid) VALUES('$class', '$class_name', '$classid')") or die(MYSQL_ERROR);						
									}
									if($query) {
										//echo '<meta http-equiv="refresh" content="2;url=create_par.php?class='.$class.'" />';
										echo '<div align="center"><div id="success">Successfully added sub-classes!</div></div>';
									}
								}
							}
							echo '<font color="#006F9A" ><b>'.$class.' class</b></font><br /><br />';
						
							
							if(!$oParalelki->checkKlas())
							{
								echo '<form action="'.$_SERVER['PHP_SELF'].'?class='.$class.'&action=2" method="post">
										<table align="center" cellspacing="0" cellpadding="0" width="15%">
											<tr>
												<td align="left" valign="top">
													<font color="#006F9A" ><b>To : </b></font>
												</td>
												<td align="left" valign="top">
													<input type="radio" name="do" value="1" /> a <br />
													<input type="radio" name="do" value="2" /> b <br />
													<input type="radio" name="do" value="3" /> c <br />
													<input type="radio" name="do" value="4" /> d <br />
													<input type="radio" name="do" value="5" /> e <br />
													<input type="radio" name="do" value="6" /> f <br />
													<input type="radio" name="do" value="7" /> g <br />
													<input type="radio" name="do" value="8" /> h 
												</td>
											</tr>
										</table>
										<input name="id" type="hidden" value="'.$classid.'">
										<br /><input type="submit" value="Add >>" class="yellow_button" />';
											
								echo '</form><br />
								<hr width="80%" color="#c3c3c3" size="1" />';
							}
							echo '<font color="#006F9A" ><b>Add other sub-class : </b></font><div><br /></div>
								<input type="text" name="paralelka" id="paralelka" style="width:20px;" />
								<input type="submit" value="Add >>" onclick="add_par('.$class.')" class="yellow_button" name="submit" /><div><br /></div>
							<div id="message"><br /></div>';	
							echo '<hr width="80%" color="#c3c3c3" size="1" />';
							echo '<div><br /></div>
								<a href="classes.php"><b>. : Go back : .</b></a>';
						?>
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
		header('Location: index.php');
	}
?>