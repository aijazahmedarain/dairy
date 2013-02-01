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
<!-- Copyright 2009 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script type="text/javascript">
		function validate_anketa() {
			var question = document.anketa.q.value;
				
			if(question.length < 3) {
				alert("Fill the question field!");
				return false;
			}
			else {
				return true;
			}
		}
	</script>
</head>
<body>
	<div align="center">
		<div id="main">
			<?php
				include('scripts/top_menu.php');
				include('scripts/header.php');
			?>
			<table cellpadding="0" cellspacing="0" width="99%" border="0">
				<tr>
					<td class="left_content" valign="top">
						<div>
							<hr width="80%" color="#c3c3c3" size="1" />
								<font color="#006F9A" size="5">
									<img src="images/anketa.gif" alt="" /> 
									Create new poll
								</font>
								<br />
							<hr width="80%" color="#c3c3c3" size="1" />
							<div align="center">
								<?php	
									if(isset($_GET['step']) && $_GET['step'] == 1 && isset($_POST['q']) && $_POST['q'] != '' && isset($_POST['num_q']) && $_POST['num_q'] >= 2 && $_POST['num_q'] <= MAX_NUM_Q)
										{
								?>
											<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="anketa">
												<font color="#006F9A" ><b>Question:</b></font><input type="text" name="q" value="<?php echo $_POST['q']; ?>" size="30" />
												<br />
													<?php
														for($i=1; $i <= $_POST['num_q']; $i++)
															{
																echo '<br /><br /><font color="#006F9A" ><b>Answer #'.$i.' :</b></font> <input name="options['.($i-1).']" value="" />';
															}
													?>
												<br /><br />
												<input type="submit" name="submit" value="Next >>" class="yellow_button" />
											</form>
									<?php
									}
										else if(isset($_GET['step']) && $_GET['step'] == 2 
											&& isset($_POST['q']) && $_POST['q'] != '' && isset($_POST['options']) )
											{
												$connect->query("DELETE FROM ".$TABLES['anketa']); //iztrivame vaprosa ot starata anketa
												$query = "INSERT INTO ".$TABLES['anketa']." VALUES('".mysql_real_escape_string($_POST['q'])."')";	//zapisvame noviq vapros
												if($connect->query($query))
													{
														echo '<br /><font color="#006F9A" ><b>Successfully added question!</b></font>';
													}
												else
													{
														die(MYSQL_ERROR);
													}
										
												$connect->query("DELETE FROM ".$TABLES['anketa_q']); //iztrivame opciite ot starata anketa

												$successes=0;
												for($i=0; $i < sizeof($_POST['options']); $i++)
													{
														if($_POST['options'][$i] != '')
															{
																if
																	(
																		$connect->query("INSERT INTO ".$TABLES['anketa_q']." 
																		VALUES('',
																		'".mysql_real_escape_string($_POST['options'][$i])."',
																		0
																		)"
																	)
															)
															{
																$successes++;
															}
														else
															{
																die(MYSQL_ERROR);
															}
													}
											}
										echo '<br /><font color="#006F9A" ><b><u>'.$successes.'</u> successfully added options!</b></font>';
										echo '<br /><br /><a href="'.$_SERVER['PHP_SELF'].'">Go back</a>';
										
									}
										else
											{
									?>
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=1" method="post" name="anketa" onsubmit="return validate_anketa();">
											<font color="#006F9A" ><b>Question : </b></font><input type="text" name="q" value="" size="30" />
											<br />	<br />
											<font color="#006F9A" ><b>Number - answers : </b></font><select name="num_q">
												<?php
												for($i=2; $i <= MAX_NUM_Q; $i++)
												{
													echo "<option value=".$i.">".$i." answers</option>";
												}
												?>
											</select>
											<br /><br />
											<input type="submit" name="submit" value="Next >>" class="yellow_button" />
										</form>
								<?php
											}
								?>
								<br />
							</div>
						</div>
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