<?php
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		require_once('../functions.php');
		
		main::setEncoding();

		$connect = new DbConnector();
		
		$oStudents = new students;
		
		$classid = addslashes($_GET['classid']);
		$predmetid = addslashes($_GET['predmetid']);
		$srok = addslashes($_GET['srok']);
		
		$oSrok = new srok;
		
		$oMain = new main;
		$teacherid = $oMain->get_teacherid($_SESSION['username']);
		
		$oKlas = new klas;
		
		if($srok == 1 || $srok == 2)
		{
			if(is_numeric($classid) && is_numeric($predmetid))
			{
				$select = $connect->query("SELECT ime, prezime, familiq, studentsid FROM ".$TABLES['uchenici']." WHERE classid = '".mysql_real_escape_string($classid)."' order by number ASC")or die(MYSQL_ERROR);
				
				if($connect->numRows($select))
				{
					echo '<table align="center" width="100%">
							<tr>
								<td width="17%" align="center" class="list_td">
									Name
								</td>
								<td width="20%" align="ceter" class="list_td">
									Marks '.$oSrok->callSrok($srok).' term
								</td>
								<td align="center" width="21%" class="list_td">
									I - term
								</td>
								<td align="center" width="21%" class="list_td">
									II - term
								</td>
								<td align="center" width="21%" class="list_td">
									Final mark
								</td>
							</tr>
						</table>';
					echo '<table align="center" width="100%" height="auto">';
						while($row = $connect->fetchObject($select))
						{
							if($oStudents->checkConfirm($row->studentsid))
							{
								$ime = $row->ime;
								$ime = substr($ime, 0, 1).'.'.$row->familiq;
								
								if(strlen($ime) > 16)
								{
									$ime = substr($ime, 0, 13).'...';
								}
								
								echo '<tr>
										<td width="17%" align="center">
											<i><b><span title="'.$row->ime.' '.$row->familiq.'">'.$ime.'</span></b></i>
										</td>
										<td width="20%" align="center">';
											
										$select2 = $connect->query("SELECT ocenka FROM ".$TABLES['ocenki']." WHERE studentsid = '".mysql_real_escape_string($row->studentsid)."' && predmetid = '".mysql_real_escape_string($predmetid)."' && srok = '".mysql_real_escape_string($srok)."'") or die(MYSQL_ERROR);
										
										if($connect->numRows($select2))
										{
											while($row2 = $connect->fetchObject($select2))
											{
												echo $row2->ocenka.', ';
											}
										}
										else {
											echo '<font color="red">No marks!</font>';
										}
											
								echo '</td>
										<td align="center" width="21%">';
										
											$select3 = $connect->query("SELECT ocenka FROM ".$TABLES['srochni']." WHERE srok = '1' && studentsid = '".mysql_real_escape_string($row->studentsid)."' && predmetid = '".mysql_real_escape_string($predmetid)."'")or die(MYSQL_ERROR);
											$row3 = $connect->fetchObject($select3);
											
											if($connect->numRows($select3))
											{
												echo '<b><font color="'.ocenkaColor($row3->ocenka).'">'.ocenkaWord($row3->ocenka).' - '.$row3->ocenka.'</font></b>';
											}
											else if($oSrok->get_srok() == '1' && $oKlas->teacherAccess($teacherid, $classid) && $oKlas->checkTeacher($predmetid, $teacherid) && $oKlas->checkKlas($predmetid, $classid))
											{
												echo '<div id="parvi_srok'.$row->studentsid.'r">
													<select name="ocenka" id="parvi_srok'.$row->studentsid.'o">
														<option value="2">Poor 2</option>
														<option value="3">Medium 3</option>
														<option value="4">Good 4</option>
														<option value="5">Very good 5</option>
														<option value="6">Excellent 6</option>
													</select> -
													<a href="#" onclick="write_srochna_godishna_ocenka('.$row->studentsid.', \'parvi\')">
														<img src="images/write.png" alt="Grade" border="0" />
													</a>
												</div>';
											}
											else {
												echo '<font color="red">No mark!</font>';
											}
											
								echo '</td>
										<td align="center" width="21%">';
											$select4 = $connect->query("SELECT ocenka FROM ".$TABLES['srochni']." WHERE srok = '2' && studentsid = '".mysql_real_escape_string($row->studentsid)."' && predmetid = '".mysql_real_escape_string($predmetid)."'")or die(MYSQL_ERROR);
											$row4 = $connect->fetchObject($select4);
										
											if($connect->numRows($select4))
											{
												echo '<b><font color="'.ocenkaColor($row4->ocenka).'">'.ocenkaWord($row4->ocenka).' - '.$row4->ocenka.'</font></b>';
											}
											else if(($oSrok->get_srok() == '2' || $oSrok->get_srok() == '1') && $oKlas->teacherAccess($teacherid, $classid) && $oKlas->checkTeacher($predmetid, $teacherid) && $oKlas->checkKlas($predmetid, $classid))
											{
												echo '<div id="vtori_srok'.$row->studentsid.'r">
													<select name="ocenka" id="vtori_srok'.$row->studentsid.'o">
														<option value="2">Poor 2</option>
														<option value="3">Medium 3</option>
														<option value="4">Good 4</option>
														<option value="5">Very good 5</option>
														<option value="6">Excellent 6</option>
													</select> -
													<a href="#" onclick="write_srochna_godishna_ocenka('.$row->studentsid.', \'vtori\')">
														<img src="images/write.png" alt="ќцени" border="0" />
													</a>
												</div>';
											}
											else {
												echo '<font color="red">No mark!</font>';
											}
								echo '</td>
										<td align="center" width="21%">';
											$select5 = $connect->query("SELECT ocenka FROM ".$TABLES['godishni']." WHERE studentsid = '".mysql_real_escape_string($row->studentsid)."' && predmetid = '".mysql_real_escape_string($predmetid)."'")or die(MYSQL_ERROR);
											$row5 = $connect->fetchObject($select5);
										
											if($connect->numRows($select5))
											{
												echo '<b><font color="'.ocenkaColor($row5->ocenka).'">'.ocenkaWord($row5->ocenka).' - '.$row5->ocenka.'</font></b>';
											}
											else if($oSrok->get_srok() != '0' && $oKlas->teacherAccess($teacherid, $classid) && $oKlas->checkTeacher($predmetid, $teacherid) && $oKlas->checkKlas($predmetid, $classid))
											{
												echo '<div id="godishna'.$row->studentsid.'r">
													<select name="ocenka" id="godishna'.$row->studentsid.'o">
														<option value="2">Poor 2</option>
														<option value="3">Medium 3</option>
														<option value="4">Good 4</option>
														<option value="5">Very good 5</option>
														<option value="6">Excellent 6</option>
													</select> -
													<a href="#" onclick="write_srochna_godishna_ocenka('.$row->studentsid.', \'godishna\')">
														<img src="images/write.png" alt="Grade" border="0" />
													</a>
												</div>';
											}
											else {
												echo '<font color="red">No mark!</font>';
											}
											
									echo '</td>
									</tr>';
							}
						}
					echo '</table><div id="srochna_godishna_ocenka"></div>';
				}
			}
			else {
				echo '<b><font color="red">Invalid information!</font><b>';
			}
		}
		else {
			echo '<b><font color="red">Invalid term!!!</font></b>';
		}
	}
	else {
		header('Location :index.php');
	}
?>