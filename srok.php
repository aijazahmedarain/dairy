<?php
	session_start();
	if($_SESSION['loggedin'])
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
	<script type="text/javascript" src="js/register_check.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/epoch_styles.css" />
	<script type="text/javascript" src="js/epoch_classes.js"></script>
	<script type="text/javascript">
	/*<![CDATA[*/
		var bas_cal,dp_cal,ms_cal;      
	window.onload = function () {
		dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('date_from1'));
		dp_cal2  = new Epoch('epoch_popup','popup',document.getElementById('date_to1'));
		dp_cal3 = new Epoch('epoch_popup','popup',document.getElementById('date_from2'));
		dp_cal4  = new Epoch('epoch_popup','popup',document.getElementById('date_to2'));
	};
	/*]]>*/
	</script>
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
								<img src="images/term_big.png" alt="" /> 
								School terms
							</font>
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							// дефинираме променливите		
							$date_from1 = $_POST['date_from1'];
							
							$date_from2 = $_POST['date_from2'];
							
							$date_to1 = $_POST['date_to1'];
							
							$date_to2 = $_POST['date_to2'];
							
							$arr = split("/",$date_from1); 
							$m1 = $arr[0]; 
							$d1 = $arr[1]; 
							$y1 = $arr[2]; 
			 
							$arr2 = split("/",$date_to1); 
							$m2 = $arr2[0]; 
							$d2 = $arr2[1]; 
							$y2 = $arr2[2]; 
							
							$arr3 = split("/",$date_from2); 
							$m3 = $arr[0]; 
							$d3 = $arr[1]; 
							$y3 = $arr[2]; 
			 
							$arr4 = split("/",$date_to2); 
							$m4 = $arr2[0]; 
							$d4 = $arr2[1]; 
							$y4 = $arr2[2]; 
							
							$action = $_GET['action'];
							$srok1 = "1";
							$srok2 = "2";
							
							if($action == 2)
							{
								if(strtotime($date_to1) > strtotime($date_from1) && strtotime($date_to2) > strtotime($date_from2) && strtotime($date_from2) > strtotime($date_to1) && strtotime($date_to2) > strtotime($date_to1) && strlen($date_from1) == 10 && strlen($date_from2) == 10 && strlen($date_to1) == 10 && strlen($date_to2) == 10 && checkdate($m1,$d1,$y1) && checkdate($m2,$d2,$y2) && checkdate($m3,$d3,$y3) && checkdate($m4,$d4,$y4))
								{
									$delete = $connect->query("DELETE FROM ".$TABLES['srok']."") or die(MYSQL_ERROR);
									$query1 = $connect->query("INSERT INTO ".$TABLES['srok']." (srok, date_from, date_to) VALUES('$srok1', '$date_from1', '$date_to1')")or die(MYSQL_ERROR);
									$query2 = $connect->query("INSERT INTO ".$TABLES['srok']." (srok, date_from, date_to) VALUES('$srok2', '$date_from2', '$date_to2')")or die(MYSQL_ERROR);
									if($query1 && $query2)
									{
										echo '<div align="center"><div id="success">Successfully set terms!</div></div>';
										//echo '<meta http-equiv="refresh" content="2;url=srok.php" />';
									}
								}
								else {
									echo '<div align="center"><div id="error">Please check the dates!</div></div>';
								}
							}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post" name="register">
							<table width="auto" border="0" align="center">  
								<tr>
									<td align="right">
										<div align="center"><font color="#006F9A" ><b>I-term:</b> </font>&nbsp;</div>
										<div><br /></div>
										<b>Starts : </b><input name="date_from1" id="date_from1" size="20" type="text"/>
										<div><br /></div>
										<b>Ends : </b><input name="date_to1" id="date_to1" size="20" type="text"/>
										<div><br /></div>
									</td>
								</tr>
								<tr>
									<td align="right">
										<div align="center"><font color="#006F9A" ><b>II-term:</b> </font>&nbsp;</div>
										<div><br /></div>
										<b>Starts : </b><input name="date_from2" id="date_from2" size="20" type="text"/>
										<div><br /></div>
										<b>Ends : </b><input name="date_to2" id="date_to2" size="20" type="text"/>
										<div><br /></div>
									</td>
								</tr> 						
								<tr>
									<td align="center">
										<input type="submit" name="submit" value="Set >" class="yellow_button" />
									</td>
								</tr> 
							</table>
							<hr width="80%" color="#c3c3c3" size="1" />
						</form>
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