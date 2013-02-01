<?php
	session_start();
	require_once('connection/connector.php');
	require_once('config.php');
	require_once('anketa_header.php');
	require_once('functions.php');
	$connect = new DbConnector();
	$connect->install();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2009 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
<head>
	<?php
		include('scripts/head_tags.php');
	?>
	<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script> 
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
					<td class="left_content" valign="top" align="left">
						<div id="ocenki"></div>
						<img src="images/title_info.jpg" alt="За дневника"/>
						<?php
						
						$query_informaciq = $connect->query("SELECT * FROM ".$TABLES['informaciq']." WHERE place = 'index_informaciq' ");
						if($connect->numRows($query_informaciq) < 1 && $_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director'))
						{
							if(isset($_POST['submit']) && isset($_POST['description']))
							{
								$description = htmlspecialchars($_POST['description']);
								if(strlen($description) > 0)
								{
									$query = $connect->query("INSERT INTO ".$TABLES['informaciq']." (informaciq, place) VALUES('".$description."', 'index_informaciq')");
									if($query)
									{
						?>
									<div id="success" onclick="hide('success');document.location.href='index.php'" >
										The information is updated!
									</div>	
									<?php	
									}
									else
									{
									?>
									<div id="error" onclick="hide('error')" >
										Error with the database!
									</div>	
								<?php
									}
								}
								else
								{
								?>
										<div id="error" onclick="hide('error')" >
											Please add description!
										</div>	
								<?php
								}
							}
						?>
							
							<div align="center" style="margin-top:10px" >
								<form action="" method="post">	
									<textarea id="description1" name="description" >Add description of the school</textarea>
										<script language="JavaScript">
										generate_wysiwyg('description1');
										</script> 
									<br />
									<input type="submit" value="Save" id="submit" name="submit" class="yellow_button" />
								</form>
							</div>
						<?php
						}
						else
						{
							$query = $connect->query("SELECT * FROM ".$TABLES['informaciq']." WHERE place = 'index_informaciq'");
							$information = $connect->fetchObject($query);
							echo htmlspecialchars_decode($information->informaciq);
							if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director'))
							{
						?>
								<div align="right" style="display:inline">
									<a href="?edit=informaciq" title="header=[<font style='font-size:12px'>Edit</font>] body=[<font style='font-size:12px'>Edit the front page of the school</font>]" >
										<img src="images/edit.gif" title="Edit" alt="Edit" border="0" />
									</a>
								</div>
						<?php
							}
						}
						if(isset($_GET['edit']) && $_GET['edit'] == 'informaciq' && $_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director'))
						{
							$query = $connect->query("SELECT * FROM ".$TABLES['informaciq']." WHERE place = 'index_informaciq'");
							$information = $connect->fetchObject($query);
							if(isset($_POST['submit'], $_POST['description']) && strlen($_POST['description']) > 0)
							{
								if(strlen($_POST['description']) > 0)
								{
									$description = htmlspecialchars($_POST['description']);
									$query = $connect->query("UPDATE ".$TABLES['informaciq']." SET informaciq = '".$description."' WHERE place = 'index_informaciq' ");
									if($query)
									{
									?>
									<div id="success" onclick="hide('success');document.location.href='index.php'" >
										The information is updated!
									</div>	
									<?php	
									}
									else
									{
									?>
									<div id="error" onclick="hide('error')" >
										Error with the database!
									</div>	
								<?php
									}
								}
								else
								{
								?>
								<div id="error" onclick="hide('error')" >
									Please add description!
								</div>	
								<?php
								}
							}
								?>
								<div align="center" style="margin-top:10px" >
									<form action="" method="post">	
										<textarea id="description1" name="description" ><?php echo $information->informaciq; ?></textarea>
											<script language="JavaScript">
											generate_wysiwyg('description1');
											</script> 
										<br />
										<input type="submit" value="Save" id="submit" name="submit" class="yellow_button" />
									</form>
								</div>
						<?php
							
						}
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
				
				// излиза грешка ако са написани грешно username и password
				if($_SESSION!='loggedin')
				{
					main::getLoging();
				}
			?>
		</div>
	</div>
</body>
</html>