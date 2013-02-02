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
<!-- Copyright 2013 Електронен Дневник All rights reserved. Designed and developed by Azuneca -->
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
				
				$studentsid = htmlspecialchars($_GET['studentsid']);
				
				$oStudents = new students;
				$oStudents->studentsid = $studentsid;
				
				$student = $oStudents->printStudent($studentsid);
			?>
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
					<td class="left_content" valign="top">
						<hr width="80%" color="#c3c3c3" size="1" />
							<font color="#006F9A" size="5">
								<img src="images/profile_edit.png" alt="" /> 
								Edit : <?php echo $student; ?>
							</font>
							<div style="height:5px"></div>
							<div align="center">
								<font size="4">
									<font color="green"><b>Username : </b></font><?php echo $oStudents->printUsername(); ?>
								</font>
							</div>
						<hr width="80%" color="#c3c3c3" size="1" />	
						<?php
							// дефинираме променливите		
							$ime = addslashes($_POST['ime']);
							
							$prezime = addslashes($_POST['prezime']);
							
							$familiq = addslashes($_POST['familiq']);
							
							$mestojiveene = $_POST['mestojiveene'];
							
							$egn = addslashes($_POST['egn']);
							
							$telefon = addslashes($_POST['telefon']);
							
							$classid = addslashes($_POST['classid']);
							
							$number = addslashes($_POST['number']);
							
							$password = addslashes($_POST['password1']);
							
							$oRegister = new register;
							$oRegister->password = $password;
							$md5_password = $oRegister->hashPassword();
							
							$action = $_GET['action'];
							
							$select = $connect->query("SELECT * FROM ".$TABLES['uchenici']." where studentsid = '".mysql_real_escape_string($studentsid)."'") or die(MYSQL_ERROR);

							$oStudents->classid = $classid;
							$oStudents->number = $number;
							$oStudents->egn = $egn;
							
								if($connect->numRows($select))
								{
									while($row = $connect->fetchObject($select))
									{
										if($action == 2)
										{
											if(!ctype_alpha($ime) || !ctype_alpha($familiq) || !ctype_alpha($prezime) || is_numeric($mestojiveene))
											{
											
											}
											else {
												if(is_string($ime) && strlen($ime) > 3 && $ime != $row->ime)
												{
													$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET ime = '".$ime."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);
													echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
												}
												if(is_string($familiq) && strlen($familiq) > 3 && $familiq != $row->familiq)
												{
													$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET familiq = '".$familiq."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);
													echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
												}
												if(is_string($prezime) && strlen($prezime) > 3 && $prezime != $row->prezime)
												{
													$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET prezime = '".$prezime."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);					
													echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
												}
												if(is_string($mestojiveene) && strlen($mestojiveene) > 4 && $mestojiveene != $row->mestojiveene)
												{
													$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET mestojiveene = '".$mestojiveene."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);
													echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
												}
												if(is_numeric($egn) && strlen($egn) == 10 && $egn != $row->egn)
												{
													if($oStudents->checkEGN())
													{
														echo '<div align="center"><div id="error">Exsisting UCC in this class!</div></div>';
													}
													else 
													{
														$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET egn = '".$egn."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);		
														echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
													}
													
												}
												if(is_numeric($telefon) && strlen($telefon) > 3 && $telefon != $row->telefon)
												{
													$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET telefon = '".$telefon."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);
													echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
												}
												if(isset($classid) && $classid != "----------" && $classid != $row->classid && is_numeric($classid))
												{
													$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET classid = '".$classid."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);
													echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
												}
												if(is_numeric($number) && strlen($number) < 3 && strlen($number) > 0 && $number != $row->number)
												{
													if($oStudents->checkNumber())
													{
														echo '<div align="center"><div id="error">Existing number in this class!</div></div>';
													}
													else 
													{
														$query = $connect->query("UPDATE ".$TABLES['uchenici']." SET number = '".$number."' where studentsid = '$studentsid'") or die(MYSQL_ERROR);				
														echo '<meta http-equiv="refresh" content="0;url=edit_student.php?studentsid='.$studentsid.'&classid='.$row->classid.'" />';
													}
												}
												if(strlen($password) > 3)
												{
													$query = $connect->query("UPDATE ".$TABLES['users']." SET password = '".$md5_password."' where username = '".$oStudents->printUsername()."'") or die(MYSQL_ERROR);
													if($query) {
														echo '<div align="center"><div id="success">Successfully changed password!</div></div>';
													}
												}
											}
										}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=2&studentsid=<?php echo $studentsid; ?>" method="post" name="register">
							<table width="auto" border="0" align="center">  
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>First name:</b> </font>&nbsp;</div>
										<input name="ime" id="ime" size="20" type="text" onblur="checkIme()" value="<?php echo $row->ime; ?>"/>
										<div id="imeMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Surname:</b></font>&nbsp;</div>
										<input name="prezime" id="prezime" size="20" type="text" onblur="checkPrezime()" value="<?php echo $row->prezime; ?>" />
										<div id="prezimeMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Last name:</b></font>&nbsp;</div>
										<input name="familiq" id="familiq" size="20" type="text" onblur="checkFamiliq()" value="<?php echo $row->familiq; ?>" />
										<div id="familiqMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>New password:</b></font>&nbsp;</div>
										<input name="password1" id="password1" size="20" type="password" onblur="checkPassword()"/>
										<div id="passwordMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>UCC:</b></font>&nbsp;</div>
										<input name="egn" id="egn" size="20" type="text" onblur="checkEgn()" value="<?php echo $row->egn; ?>" />
										<div id="egnMsg"><br /></div>
									</td>
								</tr> 	
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Telephone:</b></font>&nbsp;</div>
										<input name="telefon" id="telefon" size="20" type="text" onblur="checkTelefon()" value="<?php echo $row->telefon; ?>" />
										<div id="telefonMsg"><br /></div>
									</td>
								</tr> 	
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Adress:</b></font>&nbsp;</div>
											<textarea name="mestojiveene" id="mestojiveene" onblur="checkMestojiveene()"><?php echo $row->mestojiveene; ?></textarea>
										<div id="mestoMsg"><br /></div>
									</td>
								</tr> 
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Class:</b></font>&nbsp;</div>
										<?php
											$oMain = new main;
											$teacherid = $oMain->get_teacherid($_SESSION['username']);
											
											$oKlas = new klas;
											$oKlas->teacherid = $teacherid;
											
											echo '<select name="classid" id="classid" onblur="checkKlas()">
													<option value="'.$row->classid.'">'.$oKlas->printKlas($row->classid).'</option>
													<option value="----------">----------</option>';
													
													$oKlas->teacherClasses();	
													
											echo '</select>';
										?>
										<div id="klasMsg"><br /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><font color="#006F9A" ><b>Number in class:</b></font>&nbsp;</div>
										<input name="number" id="number" type="text" onblur="checkNumber()" value="<?php echo $row->number; ?>" style="width:30px;" />
										<div id="numberMsg"><br /></div>
									</td>
								</tr>  								
								<tr>
									<td align="center">
										<input type="submit" name="submit" value="Change >" class="yellow_button" />
									</td>
								</tr> 
							</table>
							<hr width="80%" color="#c3c3c3" size="1" />
							<div><br /></div>
								<a href="list_students.php?classid=<?php echo $_GET['classid']; ?>"><b>. : Go back : .</b></a>
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