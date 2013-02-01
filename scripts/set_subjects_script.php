<?php	
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		$classid = htmlspecialchars($_GET['classid']);
		
		$connect = new DbConnector();
		$oMain = new main;
		$oKlas = new klas;

		$teacherid = $oMain->get_teacherid($_SESSION['username']);

		if($oKlas->checkKlasen($teacherid, $classid) && is_numeric($classid))
		{
			require_once('../anketa_header.php');
			
			main::setEncoding();		
			
			$method = htmlspecialchars($_GET['method']);
			$day = $_GET['day'];
			if($method == 'get_subjects')
			{
				$num = 0;
				$query = $connect->query("SELECT * FROM ".$TABLES['programa']." WHERE den = '".$day."'") or die(MYSQL_ERROR);
				while($row = $connect->fetchObject($query))
				{
					$chas = $row->chas;
					$chas = explode('_', $chas);
					$chas_type = $chas[1];
					if($chas_type == 'chas')
					{
						$num++;
					}
				}
				?>
				<table align="center" cellspacing="0" cellpadding="5" border="0" >
				<tr>
					<td align="center" width="50" class="list_td">
						<b>Time</b>
					</td>
					<td align="center" class="list_td">
						<b>Subject - teacher</b>
					</td>
				</tr>
				
	<?php	
				if($num < 1)
				{
				?>
				<tr>
					<td colspan="2" >
						<div id="error"> <font color="black"> There are no classes on this day! </font> </div>
					</td>
				</tr>
				<?php
				}
				for($i = 1; $i<=10; $i++)
				{
					$query = $connect->query("SELECT * FROM ".$TABLES['programa']." WHERE den = '".$day."' && chas = '".$i."_chas'") or die(MYSQL_ERROR);
					if($connect->numRows($query))
					{
						$row_chas = $connect->fetchObject($query);
	?>
					<tr>
						<td>
							<?php
								$chas = $row_chas->chas;
								$chas = explode('_', $chas);
								$chas = $chas[0];
								echo '<b>'.$chas.'.</b>';
							?>
						</td>
						<td>
							<?php
							$query = $connect->query("SELECT * FROM ".$TABLES['programa_predmeti']." WHERE day = '".$day."' && chas = '".$i."' && classid='".$classid."'") or die(MYSQL_ERROR);
							$row = $connect->fetchObject($query);
							?>
								<select name="predmet_<?php echo $i; ?>" id="predmet_<?php echo $i; ?>" onchange="set_subjects('<?php echo $day; ?>', '<?php echo $classid; ?>', '<?php echo $i; ?>', 'predmet_<?php echo $i; ?>', 'set_subjects')" >
									<?php if($connect->numRows($query)){?><option value="<?php echo $row->predmet; ?>" ><?php echo $row->predmet;echo ' - '.$oMain->call_name($teacherid); ?></option> <?php }else{ echo '<option value="---" >---</option>'; }?>
									<?php
									$query = $connect->query("SELECT * FROM ".$TABLES['predmet_klas']." WHERE classid = '".$classid."' ") or die(MYSQL_ERROR);
									while($row_predmetid = $connect->fetchObject($query))
									{
										$predmetid = $row_predmetid->predmetid;
										$query1 = $connect->query("SELECT * FROM ".$TABLES['predmeti']." WHERE predmetid = '".$predmetid."'") or die(MYSQL_ERROR);
										$row_predmet = $connect->fetchObject($query1);
										$query2 = $connect->query("SELECT * FROM ".$TABLES['predmet_teacher']." WHERE predmetid = '".$predmetid."'") or die(MYSQL_ERROR);
										while($row_teacher = $connect->fetchObject($query2))
										{
											$teacherid = $row_teacher->teacherid;
											$query3 = $connect->query("SELECT * FROM ".$TABLES['users']." WHERE teacherid = '".$teacherid."'") or die(MYSQL_ERROR);
											$row_teacher1 = $connect->fetchObject($query3);
										
										
									?>
										<option value="<?php echo $row_predmet->predmet;echo '|'.$teacherid; ?>" ><?php echo $row_predmet->predmet; ?> - <?php echo $row_teacher1->ime.' '.$row_teacher1->familiq; ?></option>
									<?php
										}
									}
									?>
								</select>
							
						</td>
					</tr>
	<?php			
					}
				}
	?>
				</table>
	<?php
			}
			if($method == 'set_subjects')
			{
				$classid  = $_GET['classid'];
				$chas = $_GET['chas'];
				$subject = $_GET['subject'];
				$subject1 = explode('|', $subject);
				$subject = $subject1[0];
				$teacherid = $subject1[1];
				$query = $connect->query("DELETE FROM ".$TABLES['programa_predmeti']." WHERE classid = '".$classid."' && chas = '".$chas."' && day = '".$day."'")or die(MYSQL_ERROR);
				$query = $connect->query("INSERT INTO ".$TABLES['programa_predmeti']." (classid, chas, predmet, day, teacherid) VALUES('".$classid."', '".$chas."', '".$subject."', '".$day."', '".$teacherid."') ") or die(MYSQL_ERROR);
				if($query)
				{
					echo 'At '.$day.' '.$chas.' the class has '.$subject.' with '.$oMain->call_name($teacherid);
				}
			}
		}
		else 
		{
			header('Location: menu_functions.php');
		}
	}
	else 
	{
		header('Location: menu_functions.php');
	}
?>