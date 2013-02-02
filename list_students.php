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
		
		// проверяваме дали учителят преподава на този клас
		$oKlas = new klas;
		
		if($oKlas->teacherAccess($teacherid, $classid))
		{
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
				
				$method = addslashes($_GET['method']);			
				$select2 = $connect->query("SELECT * FROM ".$TABLES['paralelki']." where classid='".mysql_real_escape_string($classid)."' order by id desc") or die(MYSQL_ERROR);
				$row2 = $connect->fetchObject($select2);
				
				if($_SESSION['user_rank'] == 'teacher' || $_SESSION['user_rank'] == 'director')
				{
					$oPredmet = new predmet;
					
					echo '<table align="left" width="95%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="right" valign="top" width="50%">
									<h1 align="left">
										<img src="images/student.gif" alt="" /> List of students: 
										<font color="green">
											<u>'.$row2->klas.''.$row2->class_name.'</u>
										</font>
									</h1>
								</td>
								<td align="right" width="50%">
									<font color="#006F9A" ><b>Select a subject:</b></font>
									<select id="predmet">
										<option value="Предмет...">Subject...</option>';
										$select3 = $connect->query("SELECT predmetid FROM ".$TABLES['predmet_teacher']." where teacherid = '".mysql_real_escape_string($teacherid)."'") or die(MYSQL_ERROR);
										if($connect->numRows($select3))
										{
											while($row3 = $connect->fetchObject($select3))
											{
												$predmetid_s = $row3->predmetid;
												
												$select4 = $connect->query("SELECT predmetid FROM ".$TABLES['predmet_klas']." where classid = '".mysql_real_escape_string($classid)."'") or die(MYSQL_ERROR);
												if($connect->numRows($select4))
												{
												
													while($row4 = $connect->fetchObject($select4))
													{
														if($row4->predmetid == $predmetid_s)
														{
															$oPredmet->predmetid = $row4->predmetid;
															echo '<option value="'.$row4->predmetid.'">'.$oPredmet->callPredmet().'</option>';
														}
													}
												}
											}
										}
							echo '</select>
							</td>
						</tr>
					</table>';
			?>
			<br /><br /><br />
			<table cellpadding="0" cellspacing="0" width="99%" border="0">
				<tr>
					<td class="left_content">
						<input type="hidden" value="<?php echo $classid; ?>" id="klas" name="klas" />
						<table align="center" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" width="5%" class="list_td">
									No.
								</td>
								<td align="center" width="18%" class="list_td">
									Name
								</td>
								<td align="center" width="15%" class="list_td">
									UCC
								</td>
								<td align="center" width="22%" class="list_td">
									Mark
								</td>
								<td align="center" width="22%" class="list_td">
									Absence
								</td>
								<td align="center" width="5%" class="list_td">
									Edit
								</td>
								<?php
									if($oKlas->checkKlasen($teacherid, $classid) || $_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin')
									{
										echo '<td align="center" width="5%" class="list_td">
											Del
										</td>';
										echo '<td align="center" width="7%" class="list_td">
											Conf.
										</td>';
									}
								?>
							</tr>
						</table>
						<div>
							<div align="center">
								<table align="center" width="100%" cellpadding="0" cellspacing="0" >
									<?php
										$select = $connect->query("SELECT * FROM ".$TABLES['uchenici']." where classid = '".mysql_real_escape_string($classid)."' order by number asc") or die(MYSQL_ERROR);
										
										if($connect->numRows($select))
										{
											while($row = $connect->fetchObject($select))
											{
												echo '<tr id="'.$row->studentsid.'">
														<td align="center" width="5%" class="list_td_info">
															'.$row->number.'
														</td>
														<td align="center" width="18%" class="list_td_info">';
														
														$ime = $row->ime;
														$ime = substr($ime, 0, 1).'.'.$row->familiq;
	
														if(strlen($ime) > 20)
														{
															$ime = substr($ime, 0, 17).'...';
														}
												echo 	'<span title="'.$row->ime.' '.$row->familiq.'">'.$ime.'</span>
														</td>';
												echo '<td align="center" width="15%" class="list_td_info">
															'.$row->egn.'	
														</td>';
												echo '<td align="center" width="22%" class="list_td_info">
														<div id="'.$row->studentsid.'r">
															<select name="ocenka" id="'.$row->studentsid.'o">
																<option value="2">Poor 2</option>
																<option value="3">Medium 3</option>
																<option value="4">Good 4</option>
																<option value="5">Very good 5</option>
																<option value="6">Excellent 6</option>
															</select> -';
											?>
													<a href="#" onclick="write_ocenka('<?php echo $row->studentsid; ?>')">
														<img src="images/write.png" alt="Grade" border="0" />
													</a>
											<?php
												echo '</div>
													</td>';
												echo '<td align="center" width="22%" class="list_td_info" id="'.$row->studentsid.'n">
														<a href="#" onclick="write_otsastvie('.$row->studentsid.', \'treta\')">1/3</a> |
														<a href="#" onclick="write_otsastvie('.$row->studentsid.', \'cqlo\')">Absence</a>
													</td>';
												echo '<td align="center" width="5%" class="list_td_info">
															<a href="edit_student.php?studentsid='.$row->studentsid.'&classid='.$classid.'">
																<img src="images/edit.gif" alt="" border="0" />
															</a>
														</td>';
														
											if($oKlas->checkKlasen($teacherid, $classid) || $_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin')
											{
												echo '<td align="center" width="5%" class="list_td_info">
															<a href="#" title="Delete this student" >
																<img src="images/delete.gif" alt="" border="0" onclick="delete_student('.$row->studentsid.', \'delete_student.php\')" />
															</a>
														</td>';
												echo '<td align="center" width="7%" class="list_td_info" id="'.$row->studentsid.'c">';
													if($connect->fetchObject($connect->query("SELECT checked FROM ".$TABLES['uchenici']." WHERE studentsid = '".$row->studentsid."'"))->checked == 'false')
													{
														echo '<a href="#" title="Confirm this student" >
															<img src="images/tick.gif" alt="" border="0" onclick="confirm_thing('.$row->studentsid.', \'confirm_student.php\')" />
														</a>';
													}
													else
													{
														echo '<font color="green">Yes</font>';
													}
												echo '</td>';
											}
											
												echo '</tr>';
											}
										}
										else {
											echo '<div align="center"><div><br /></div><b>There are no students in this class!</b><div><br /></div></div>';
										}
									?>
									<div id="zabelejka" style="cursor:move">	
										<b>Note for : </b>
										<?php	
											$select = $connect->query("SELECT * FROM ".$TABLES['uchenici']." where classid = '".mysql_real_escape_string($classid)."' order by number asc") or die(MYSQL_ERROR);
											
											
											echo '<select id="zabelejka_student">';
													echo '<option value="Ученик...">Student...</option>';
													if($connect->numRows($select))
													{
														$oStudents = new students;
														
														while($row_z = $connect->fetchObject($select))
														{
															if($oStudents->checkConfirm($row_z->studentsid))
															{
																echo '<option value="'.$row_z->studentsid.'">';
																		echo $ime = substr($row_z->ime, 0, 1).'.'.$row_z->familiq;
																echo'</option>';
															}
														}
													}
											echo '</select>';
										?>
										<div style="margin-top:10px;"></div>
										<div style="width:350px;">
											<textarea id="zabelejka_text" rows="4" cols="32" onclick="set_border(this)" onblur="unset_border(this)">
																
											</textarea>
											<div id="message_zabelejka">
												<br />
											</div>
											<div style="margin-bottom:5px;"></div>
											<input type="submit" class="yellow_button" value="Write >" onclick="write_zabelejka()" /> | 
											<a href="#" onclick="hide('zabelejka')"><b>Close</b></a>
										</div>
									</div>
									<div id="ocenki">
										<b><font color="#006F9A">See marks in :</font></b>
										<?php
											$select_p = $connect->query("SELECT * FROM ".$TABLES['predmet_klas']." WHERE classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
											
											if($connect->numRows($select_p))
											{
										?>
												<select id="ocenki_po" name="ocenki_po">
													<?php
														while($row_p = $connect->fetchObject($select_p))
														{
															$oPredmet->predmetid = $row_p->predmetid;
															echo '<option value="'.$row_p->predmetid.'">'.$oPredmet->callPredmet().'</option>';
														}
													?>
												</select>
												<b><font color="#006F9A">Term :</font></b>
												<select id="srok" name="srok">
													<option value="1">I - term</option>
													<option value="2">II - term</option>
												</select>
												<input type="submit" onclick="see_ocenki()" value="Load >>" class="yellow_button" />
										<?php
											}
										?>
										<div id="see_ocenki"></div>
										<div align="right"><b><a href="#" onclick="hide('ocenki')">Close</a></b></div>
									</div>
								</table>
								<div id="message_ocenka"><br /></div>
								<hr size="1" />
									<?php
										$select_klasen = $connect->query("SELECT teacherid FROM ".$TABLES['klasen']." WHERE classid = '$classid'");
										$row = $connect->fetchObject($select_klasen);
										$username_klasen = $oMain->callUsername($row->teacherid);
										
										if($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin')
										{
											$select_klasni = $connect->query("SELECT * FROM ".$TABLES['users']." WHERE rank = 'teacher'");

											echo '<b>Form-master : </b>
												<select id="klasen" name="klasen">';
												
												echo '<option value="'.$row->teacherid.'">'.$username_klasen.' - '.$oMain->callName($username_klasen).'</option>
														<option value="------">------</option>';
												
												if($connect->numRows($select_klasni))
												{
													while($row2 = $connect->fetchObject($select_klasni))
													{
														echo '<option value="'.$row2->teacherid.'">'.$oMain->callUsername($row2->teacherid).' - '.$oMain->callName($oMain->callUsername($row2->teacherid)).'</option>';
													}
												}
												
											echo '</select>
												  <input type="submit" value="Set" class="yellow_button" onclick="setKlasen()" />';
										}
										else {
												echo '<div align="center"><b><img src="images/klasen.png" alt="" /> Form-master : <i>'.$oMain->callName($username_klasen).'</i></b></div>';
										}
									?>
								<hr size="1" />
								<a href="#" onclick="show('ocenki')"><b>See marks</b></a> |
								<a href="#" onclick="show('zabelejka')"><b>Notice</b></a> |					
								<a href="zabelejki.php?classid=<?php echo $classid; ?>&page=1"><b>See notices</b></a> |
								<?php
									if($_SESSION['user_rank'] == 'director')
									{
										echo '<a href="otsastviq.php?classid='.$classid.'"><b>Absences</b></a> |';
									}
								?>
				<?php
				}
				if($_SESSION['user_rank'] == 'admin')
				{	
					include('scripts/students_list_admin.php');
				} 
				if($method == 'list') 
				{
					echo '<a href="classes.php?method=list"><b>Go back</b></a>';
				}
				if($method == 'functions') 
				{
					echo '<a href="menu_functions.php?method=list"><b>Go back</b></a>';
				}
				?>
								<div><br /></div>
								<div align="center">
									<div id="message"></div>
								</div>
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
			header('Location: menu_functions.php');
		}
	}
	else {
		header('Location: index.php');
	}
?>