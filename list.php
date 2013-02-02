<?php
	session_start();
	if($_SESSION['loggedin'] && $_SESSION['user_rank'] == 'director')
	{
		require_once('connection/connector.php');
		require_once('config.php');
		
		$connect = new DbConnector();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Copyright 2013 School diary All rights reserved. Designed and developed by Azuneca -->
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
				
				$list = $_GET['list'];
				
				if($list == 'admin') {
					echo '<h1 align="left"><img src="images/admin.gif" alt="" /> List of administrators</h1>';
				}
				if($list == 'teacher') {
					echo '<h1 align="left"><img src="images/teacher.gif" alt="" /> List of teachers</h1>';
				}
			?>
			<table cellpadding="0" cellspacing="0" width="99%" border="0">
				<tr>
					<td class="left_content">
						<table align="center" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" width="15%" class="list_td">
									Username
								</td>
								<td align="center" width="15%" class="list_td">
									Name
								</td>
								<td align="center" width="15%" class="list_td">
									Surname
								</td>
								<td align="center" width="35%" class="list_td">
									Subject
								</td>
								<td align="center" width="10%" class="list_td">
									R.H.
								</td>
								<td align="center" width="5%" class="list_td">
									Edit
								</td>
								<td align="center" width="5%" class="list_td">
									Del
								</td>
							</tr>
						</table>
						<div>
							<div align="center" style="overflow:auto;height:500px;width:100%">
								<table align="center" width="100%" cellpadding="0" cellspacing="0">
									<?php
										$rank = addslashes($_GET['list']);
										
										if($rank == 'admin' || $rank =='teacher')
										{
											$select = $connect->query("SELECT * FROM ".$TABLES['users']." where rank = '".mysql_real_escape_string($rank)."' order by id desc") or die(MYSQL_ERROR);

											if($connect->numRows($select)) 
											{
												while($row = $connect->fetchObject($select))
												{
													echo '<tr id="'.$row->id.'">
															<td align="center" width="15%" class="list_td_info"> 
																'.$row->username.'
															</td>
															<td align="center" width="15%" class="list_td_info">
																'.$row->ime.'
															</td>
															<td align="center" width="15%" class="list_td_info">
																'.$row->familiq.'
															</td>
															<td align="center" width="35%" class="list_td_info">';
															
																if($rank == "teacher")
																{
																	$teacherid = $row->teacherid;
																	$select2 = $connect->query("SELECT * FROM ".$TABLES['predmet_teacher']." where teacherid = '$teacherid'") or die(MYSQL_ERROR);
																	if($connect->numRows($select2))
																	{
																		while($row_r = $connect->fetchObject($select2))
																		{
																			$predmetid = $row_r->predmetid;
																			
																			$select3 = $connect->query("SELECT * FROM ".$TABLES['predmeti']." where predmetid = '$predmetid'") or die(MYSQL_ERROR);
																			$row_r2 = $connect->fetchObject($select3);
																			
																			echo $row_r2->predmet.', ';
																		}
																	}
																}
																else {
																	echo 'None';
																}
																
														echo '</td>
															<td align="center" width="10%" class="list_td_info">';
															
																if($rank == "teacher") 
																{
																	echo $row->znpz;
																}
																else {
																	echo 'None';
																}
																
														echo '</td>
															<td align="center" width="5%" class="list_td_info">';
															
																if($rank == 'teacher') 
																{
																	echo '<a href="edit_teacher.php?username='.$row->username.'" title="Edit this user">
																			<img src="images/edit.gif" alt="" border="0" />
																		</a>';
																}
																if($rank == 'admin') 
																{
																	echo '<a href="edit_admin.php?username='.$row->username.'" title="Edit this user">
																			<img src="images/edit.gif" alt="" border="0" />
																		</a>';
																}
																		
														echo '</td>
															<td align="center" width="5%" class="list_td_info">
																<a href="#" title="Delete this user" onclick="delete_user('.$row->id.')">
																	<img src="images/delete.gif" alt="" border="0" />
																	<input type="hidden" id="username" name="username" value="'.$row->username.'">
																</a>
															</td>
														</tr>';
												}
											}
											else {
												echo '<br /><div align="center"><div id="error">There are no registered users with the rank : <b><u>'.$rank.'</u></b></div></div>';
											}
										}
										else {
											header('Location: index.php');
										}
									?>
								</table>
								<div><br /></div>
								<div id="message"></div>
							</div>
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