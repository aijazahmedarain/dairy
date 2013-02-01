<?php
	session_start();
	error_reporting(0);
	if($_SESSION['loggedin'] || $_SESSION['loggedin_student'])
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
								<img src="images/profile_edit.png" alt="" /> 
								Edit your profile
							</font>
							<br />
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							// дефинираме променливите	
							$password1 = $_POST['password1'];
							
							$password2 = $_POST['password2'];
							
							$ime = addslashes($_POST['ime']);
							
							$prezime = addslashes($_POST['prezime']);
							
							$familiq = addslashes($_POST['familiq']);
							
							$znpz = addslashes($_POST['znpz']);
							
							$email = addslashes($_POST['email']);
							
							$predmet = $_POST['predmet'];
							
							$klas = $_POST['klas'];
							
							$username2 = $_SESSION['username'];
							
							$rank = $_SESSION['user_rank'];

							$action = $_GET['action'];

							$select = $connect->query("SELECT * FROM ".$TABLES['users']." where username='".mysql_real_escape_string($username2)."'") or die(MYSQL_ERROR);
							$select2 = $connect->query("SELECT id FROM ".$TABLES['predmeti']."") or die(MYSQL_ERROR);
							$select3 = $connect->query("SELECT id FROM ".$TABLES['paralelki']."") or die(MYSQL_ERROR);
							
							if($connect->numRows($select))
							{
								while($row = $connect->fetchObject($select))
								{
									if($action == 2)
									{
										if(!ctype_alpha($ime) || !ctype_alpha($familiq) || !ctype_alpha($prezime))
										{
											
										} 
										else {
											if(is_string($ime) && strlen($ime) > 3 && $ime != $row->ime)
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET ime = '".$ime."' where username = '$username2'") or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=manage_profile.php" />';
											}
											if(is_string($familiq) && strlen($familiq) > 3 && $familiq != $row->familiq)
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET familiq = '".$familiq."' where username = '$username2'") or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=manage_profile.php" />';
											}
											if(is_string($prezime) && strlen($prezime) > 3 && $prezime != $row->prezime)
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET prezime = '".$prezime."' where username = '$username2'") or die(MYSQL_ERROR);						
												echo '<meta http-equiv="refresh" content="0;url=manage_profile.php" />';
											}
											if($_SESSION['password'] == $password2 && strlen($password1) > 3 && $password1 != $_SESSION['password'] )
											{
												$oRegister = new register;
												$oRegister->password = $password1;
												$md5_password = $oRegister->hashPassword();
												
												$query = $connect->query("UPDATE ".$TABLES['users']." SET password = '".$md5_password."' where username = '$username2'") or die(MYSQL_ERROR);
												if($query) {
													echo '<div align="center"><div id="success">Successfully changed <b>password</b>!</div></div>';
													//echo '<meta http-equiv="refresh" content="2;url=manage_profile.php" />';
												}
											}
											if(is_numeric($znpz) && strlen($znpz) > 2 && $znpz != $row->znpz && $_SESSION['user_rank'] == 'director')
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET znpz = '".$znpz."' where username = '$username2'") or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=manage_profile.php" />';
											}
											if($email != $row->email && preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
											{
												$query = $connect->query("UPDATE ".$TABLES['users']." SET email = '".$email."' where username = '$username2'") or die(MYSQL_ERROR);
												echo '<meta http-equiv="refresh" content="0;url=manage_profile.php" />';
											}
											if(isset($predmet) && $_SESSION['user_rank'] == 'director')
											{
												$teacherid = $row->teacherid;
												$delete = $connect->query("DELETE FROM ".$TABLES['predmet_teacher']." where teacherid = '$teacherid'") or die(MYSQL_ERROR);
												if($delete)
												{
													$count2 = $connect->numRows($select2);
													for($i = 0; $i<$count2; $i++)
													{
														$predmetid = $predmet[$i];
														if($predmetid != 0)
														{
															$query = $connect->query("INSERT INTO ".$TABLES['predmet_teacher']." (teacherid, predmetid) VALUES('$teacherid', $predmetid)");
														}
													}	
												}
											}
											if(isset($predmet) && $_SESSION['user_rank'] == 'director')
											{
												$teacherid = $row->teacherid;
												$delete = $connect->query("DELETE FROM ".$TABLES['teacher_klas']." where teacherid = '$teacherid'") or die(MYSQL_ERROR);
												if($delete)
												{
													$count3 = $connect->numRows($select3);
													for($i = 0; $i<$count3; $i++)
													{
														$klasove = $klas[$i];
														if($klasove != 0)
														{
															$query = $connect->query("INSERT INTO ".$TABLES['teacher_klas']." (teacherid, classid) VALUES('$teacherid', '$klasove')");
														}
													}											
												}
											}
										}
									}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2" method="post" name="register">
							<table width="auto" border="0" align="center"> 
								<?php
									if($_SESSION["loggedin_student"] == false)
									{
								?>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Name:</b> </font>&nbsp;</div>
										<input name="ime" id="ime" size="20" type="text" onblur="checkIme()" value="<?php echo $row->ime; ?>" />
										<div id="imeMsg"><br /></div>
									</td>
								</tr>
								<?php
									}
								if(($rank == 'teacher' or $rank == 'director') && $_SESSION['loggedin_student'] == false) {
									echo '<tr>
											<td>
												<div align="center"><font color="#006F9A" ><b>Surname:</b></font>&nbsp;</div>
												<input name="prezime" id="prezime" size="20" type="text" onblur="checkPrezime()" value="'.$row->prezime.'"';
													if($rank=='teacher'){echo '';} echo '/>
												<div id="prezimeMsg"><br /></div>
											</td>
										</tr>';
								}
								?>
								<?php
									if($_SESSION["loggedin_student"] == false)
									{
								?>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Last name:</b></font>&nbsp;</div>
										<input name="familiq" id="familiq" size="20" type="text" onblur="checkFamiliq()" value="<?php echo $row->familiq; ?>" />
										<div id="familiqMsg"><br /></div>
									</td>
								</tr> 
								<?php
									}
								?>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>E-mail:</b></font>&nbsp;</div>
										<input name="email" id="email" size="20" type="text" onblur="checkEmail()" value="<?php echo $row->email; ?>" />
										<div id="emailMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Old password:</b></font>&nbsp;</div>
										<input name="password2" id="password2" size="20" type="password"/>
										<div id="passwords"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>New password:</b></font>&nbsp;</div>
										<input name="password1" id="password1" size="20" type="password" onblur="checkPassword()"/>
										<div id="passwordMsg"><br /></div>
									</td>
								</tr>
								<?php
									if($rank == 'director') {
										echo '<tr>
											<td>
												<div align="center"><font color="#006F9A" ><b>Required hours:</b></font>&nbsp;</div>
												<input name="znpz" id="znpz" size="20" type="text" onblur="checkZnpz()" value="'.$row->znpz.'"/>
												<div id="znpzMsg"><br /></div>
											</td>';
								?>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Subjects:</b></font>&nbsp;</div>
											<?php
												echo '<div style="width:540px;">';
												$select = $connect->query("SELECT * FROM ".$TABLES['predmeti']."");
												if($connect->numRows($select)) 
												{
													while($red = $connect->fetchObject($select))
													{
														$teacherid = $row->teacherid;
														$select2 = $connect->query("SELECT * FROM ".$TABLES['predmet_teacher']." where teacherid = '".mysql_real_escape_string($teacherid)."'");	
													?>
														<input type="checkbox" name="predmet[]" 
														<?php while($red2 = $connect->fetchObject($select2))
														{
															if($red2->predmetid == $red->predmetid) 
															{
																echo'checked="checked"';
															}
														} ?> value="<?php echo $red->predmetid; ?>" onblur="checkPredmet()" id="predmet" /> <?php echo $red->predmet.' '; ?>
													<?php	
														
													}
												}
												else {
													echo '<div id="error">There are still no added subject!</div>';
												}
												echo '</div>';
														
												echo '<div id="predmetMsg"><br /></div>';
											?>
									</td>
								</tr>
								<tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Teaches <u>on</u>:</b></font>&nbsp;</div>
											<?php
												echo '<div style="width:540px;">';
												$select = $connect->query("SELECT * FROM ".$TABLES['paralelki']."");
												if($connect->numRows($select)) 
												{
													while($red = $connect->fetchObject($select))
													{
														$teacherid = $row->teacherid;
														$select4 = $connect->query("SELECT * FROM ".$TABLES['teacher_klas']." where teacherid = '".mysql_real_escape_string($teacherid)."'");
													?>
														<input type="checkbox" name="klas[]" 
														<?php while($red2 = $connect->fetchObject($select4))
														{
															if($red2->classid == $red->classid) 
															{
																echo'checked="checked"';
															}
														} ?> value="<?php echo $red->classid; ?>" onblur="checkKlasove()" id="klas" /> <?php echo $red->klas.' '.$red->class_name; ?>
													<?php		
													}
												}
												else {
													echo '<div id="error">There are still no added classes!</div>';
												}
												echo '</div>';
														
												echo '<div id="klasoveMsg"><br /></div>';
										}
											?>
									</td>
								</tr>
									<td align="center">
										<input type="submit" name="submit" value="Edit >" class="yellow_button" />
									</td>
								</tr> 
							</table>
							<hr width="80%" color="#c3c3c3" size="1" />
						</form>
						<?php
								}
							}
							echo '<br />';
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
