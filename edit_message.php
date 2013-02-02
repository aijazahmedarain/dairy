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
					<td class="left_content" valign="top">
						<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/message.gif" alt="" /> 
								Edit message
							</font>
							<br />
						<hr width="80%" color="#c3c3c3" size="1" />
						<div align="center">
							<div style="width:506px;">
								<?php
									if($_POST['name'] && $_POST['news'])
									$connect->query("REPLACE INTO ".$TABLES['messages']." VALUES(".intval ($_GET['tid']).",'".$_POST['name']."','".$_POST['news']."')");
									$select = $connect->query("SELECT * FROM ".$TABLES['messages']." WHERE id=".intval($_GET['tid']))or die(mysql_error());
									if ($connect->numRows($select)) $red = $connect->fetchObject($select);
								?>
								<form action="<?php echo($_SERVER['PHP_SELF']."?tid=".$_GET['tid']);?>" method="post">
									<font color="#006F9A" ><b>Title : </b></font><input type="text" name="name" value="<?php echo($red->name);?>" size="50" />
									<div><br /></div>
									<div style="border : 2px ridge #2457ca;">
										<textarea id="textarea1" name="news">
											<?php echo $red->news; ?>
										</textarea>
										<script language="JavaScript">
										  generate_wysiwyg('textarea1');
										</script> 
									</div>
									<div><br /></div>
									<input type="submit" name="submit" value="Edit" class="yellow_button"/>
								</form>
							</div>
						</div>
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
		header('Location: index.php');
	}
?>