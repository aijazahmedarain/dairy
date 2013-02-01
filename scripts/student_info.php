<?php
	session_start();
	require_once('../connection/connector.php');
	require_once('../config.php');
	require_once('../functions.php');

	main::setEncoding();
	
	$connect = new DbConnector();
	
	$egn = trim($_GET['egn']);
	$egn = htmlspecialchars($egn);
	
	if(strlen($egn) == 10 && is_numeric($egn))
	{
		$select_id = $connect->query("SELECT * FROM ".$TABLES['uchenici']." WHERE egn = '".mysql_real_escape_string($egn)."'")or die(MYSQL_ERROR);
		$row_id = $connect->fetchObject($select_id);
		
		$oStudents = new students;
		$oStudents->egn = $egn;
		$oStudents->classid = $row_id->classid;
		
		if($oStudents->checkEGN() == false)
		{
			echo '<div align="center">
				<div id="error">
					There is no student with such UCC!
				</div>
			</div>';
		}
		else 
		{
			echo '<h1 align="left"><img src="images/info_student.png" alt="Информация" /> Information about : '.$oStudents->printStudent($row_id->studentsid).'</h1>';
			
			$studentsid = $row_id->studentsid;
			
			if($oStudents->checkConfirm($studentsid))
			{
				$oKlas = new klas;
				$classid = $row_id->classid;
				$oMain = new main;
?>
		
		<b><i>Current marks</i></b>
		<table align="center" width="98%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="10%" align="center" class="list_td">
					Term	
				</td>
				<td width="25%" align="center" class="list_td">
					Subject
				</td>
				<td width="25%" align="center" class="list_td">
					Teacher
				</td>
				<td width="20%" align="center" class="list_td">
					Mark
				</td>
				<td width="20%" align="center" class="list_td">
					Date
				</td>
			</td>
		</table>
		<table align="center" width="98%" cellpadding="0" cellspacing="0">
			<?php
				$select_rows =  $connect->query("SELECT id FROM ".$TABLES['ocenki']." where studentsid = '".mysql_real_escape_string($studentsid)."'")or die(MYSQL_ERROR);
				
				$page = htmlspecialchars($_GET['page']);
								
				if($page == 1 || $page == null)
				{
					$ot = 0;
				}
				if($page > 1)
				{
					$ot = ($page-1)*RESULTS;
				}
								
				$select =  $connect->query("SELECT * FROM ".$TABLES['ocenki']." where studentsid = '".mysql_real_escape_string($studentsid)."' order by id desc limit ".$ot.", ".RESULTS."")or die(MYSQL_ERROR);
				
				if($connect->numRows($select))
				{
					$oSrok = new srok;
					$oPredmet = new predmet;
					
					$pages = $connect->numRows($select_rows)/RESULTS;
					$pages_floored = floor($pages);
					
					while($row = $connect->fetchObject($select))
					{
			?>
					<tr>
						<td width="10%" align="center">
							<?php
								echo $oSrok->callSrok($row->srok);
							?>
						</td>
						<td width="25%" align="center">
							<?php
								$oPredmet->predmetid = $row->predmetid;
								echo $oPredmet->callPredmet();
							?>							
						</td>
						<td width="25%" align="center">
							<?php
								$teacher_username = $oMain->callUsername($row->teacherid);
								echo $klasen = $oMain->callName($teacher_username);
							?>
						</td>
						<td width="20%" align="center">
							<i><?php
								echo '<font color="'.ocenkaColor($row->ocenka).'">'.ocenkaWord($row->ocenka).' - '.$row->ocenka.'</font>';
							?></i>
						</td>
						<td width="20%" align="center">
							<i><?php
								echo $row->date;
							?></i>
						</td>
					</tr>
			<?php
					}
				}
				else {
					echo '<div align="center"><div id="error">There are still no marks!</div></div>';
				}
			?>
		</table>
		<div style="height:8px;"></div>
		<?php
			if($pages > 1)
			{
		?>
			<div align="right">
				<font color="#006F9A" ><b>Страница : </b></font>
				<select name="page" id="page">
					<?php
						if(isset($_GET['page']))
						{
							echo '<option value="'.$page.'">'.$page.'</a>';
						}
						if($pages > $pages_floored)
						{
							$pages1 = $pages_floored+1;
						}
						else {
							$pages1 = $pages_floored;
						}
						for($i=1;$i<=$pages1;$i++)
						{
							if($i != $page)
							{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
						}
					?>
				</select>
				<input type="submit" value="Отиди >" class="yellow_button" onclick="student_info(document.getElementById('page').value)" />
			</div>
		<?php
			}
		?>
		<div><br /></div>
		<b><i>Term grades</i></b>
		<table align="center" width="98%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="25%" align="center" class="list_td">
					Subject
				</td>
				<td width="25%" align="center" class="list_td">
					I-term
				</td>
				<td width="25%" align="center" class="list_td">
					II-term
				</td>
				<td width="25%" align="center" class="list_td">
					Final
				</td>
			</tr>
		</table>
		<table align="center" width="98%" cellpadding="0" cellspacing="0">
			<?php
				$select2 = $connect->query("SELECT predmetid FROM ".$TABLES['predmet_klas']." WHERE classid = '$classid'")or die(MYSQL_ERROR);
				
				if($connect->numRows($select2))
				{
					while($row2 = $connect->fetchObject($select2))
					{
			?>
					<tr>
						<td width="25%" align="center">
							<?php
								$oPredmet->predmetid = $row2->predmetid;
								echo $oPredmet->callPredmet();
							?>
						</td>
						<td width="25%" align="center">
							<?php
								$select_srochni1 = $connect->query("SELECT ocenka FROM ".$TABLES['srochni']." WHERE studentsid='$studentsid' && srok = '1' && predmetid = '".mysql_real_escape_string($row2->predmetid)."'");
								
								if($connect->numRows($select_srochni1))
								{
									$row_srochni1 = $connect->fetchObject($select_srochni1);
									
									echo '<i><font color="'.ocenkaColor($row_srochni1->ocenka).'">'.ocenkaWord($row_srochni1->ocenka).' - '.$row_srochni1->ocenka.'</font></i>';
								}
								else {
									echo '<font color="red">No marks!</font>';
								}
							?>
						</td>
						<td width="25%" align="center">
							<?php
								$select_srochni2 = $connect->query("SELECT ocenka FROM ".$TABLES['srochni']." WHERE studentsid='$studentsid' && srok = '2' && predmetid = '".mysql_real_escape_string($row2->predmetid)."'");
								
								if($connect->numRows($select_srochni2))
								{
									$row_srochni2 = $connect->fetchObject($select_srochni2);
									
									echo '<i><font color="'.ocenkaColor($row_srochni2->ocenka).'">'.ocenkaWord($row_srochni2->ocenka).' - '.$row_srochni2->ocenka.'</font></i>';
								}
								else {
									echo '<font color="red">No marks!</font>';
								}
							?>
						</td>
						<td width="25%" align="center">
							<?php
								$select_godishna = $connect->query("SELECT ocenka FROM ".$TABLES['godishni']." WHERE studentsid = '$studentsid' && predmetid = '".mysql_real_escape_string($row2->predmetid)."'") or die(MYSQL_ERROR);
								
								if($connect->numRows($select_godishna))
								{
									$row_godishna = $connect->fetchObject($select_godishna);
									
									echo '<i><font color="'.ocenkaColor($row_godishna->ocenka).'">'.ocenkaWord($row_godishna->ocenka).' - '.$row_godishna->ocenka.'</font></i>';
								}
								else {
									echo '<font color="red">No marks!</font>';
								}
							?>
						</td>
					</tr>
			<?php
					}
				}
				else {
					echo '<div align="center">
						<div id="erro">
							There are still no added subject for this class
						</div>
					</div>';
				}
			?>
		</table>
		<div><br /></div>
		<b><i>Notices</i></b>
		<table align="center" width="98%" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" width="25%" class="list_td">
					Subject
				</td>
				<td align="center" width="25%" class="list_td">
					Teacher
				</td>
				<td align="center" width="35%" class="list_td">
					Notice
				</td>
				<td align="center" width="15%" class="list_td">
					Date
				</td>
			</tr>
		</table>
		<table align="center" width="98%" cellpadding="0" cellspacing="0">
			<?php
				$select_zabelejki = $connect->query("SELECT * FROM ".$TABLES['zabelejki']." WHERE studentsid = '$studentsid'")or die(MYSQL_ERROR);
				
				if($connect->numRows($select_zabelejki))
				{
					while($row_zabelejki = $connect->fetchObject($select_zabelejki))
					{
			?>
						<tr>
							<td align="center" width="25%">
								<?php
									$oPredmet->predmetid = $row_zabelejki->predmetid;
									echo $oPredmet->callPredmet();
								?>
							</td>
							<td align="center" width="25%">
								<?php
									$username1 = $oMain->callUsername($row_zabelejki->teacherid);
									echo $oMain->callName($username1);
								?>
							</td>
							<td align="center" width="35%">
								<u><?php
									echo $row_zabelejki->zabelejka;
								?></u>
							</td>
							<td align="center" width="15%">
								<i><?php
									echo $row_zabelejki->date;
								?></i>
							</td>
						</tr>
			<?php
					}
				}
				else {
					echo '<div align="center"><div id="success">No notices!</div></div>';
				}
			?>
		</table>
		<div><br /></div>
		<b><i>Absences</i></b>
		<div id="success" align="center">
			<?php
				$oOtsastviq = new otsastviq;
				$otsastviq = explode("-", $oOtsastviq->countOtsastviq($studentsid));
				$izvineni = $otsastviq[0];
				$neizvineni = $otsastviq[1];
			?>
			<font color="#006F9A" >
				<b>Excused :</b>
			</font> 
			<font color="green">
				<?php echo $izvineni; ?>
			</font>
			<font color="#006F9A" >
				<b>Non-excused :</b>
			</font> 
			<font color="red">
				<?php echo $neizvineni; ?>
			</font>
		</div>
<?php		}
			else {
				echo '<div align="center">
				<div id="error">
					This student is not confirmed!!!
				</div>
			</div>';
			}
		}
	}
	else {
		echo '<div align="center">
				<div id="error">
					You have entered an invalid UCC!
				</div>
			</div>';
	}
?>