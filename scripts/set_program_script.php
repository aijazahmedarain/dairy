<?php	
	session_start();
	if($_SESSION['loggedin'])
	{
		require_once('../connection/connector.php');
		require_once('../functions.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$connect = new DbConnector();
		
		$method = htmlspecialchars($_GET['method']);
		$day = htmlspecialchars($_GET['day']);
		$chas = htmlspecialchars($_GET['chas']);
		if(($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
		{
			if($method == 'get_program')
			{
				$query = $connect->query("SELECT * FROM ".$TABLES['programa']." WHERE den = '".mysql_real_escape_string($day)."' && chas = 'school_starts'");
				$row = $connect->fetchObject($query);
				$time = $row->vreme;
				$time = explode(':', $time);
				$timeh = $time[0];
				$timem = $time[1];
				?>
					<table align="center" cellpadding="0" cellspacing="0" border="0" >
						<tr valign="top" >
							<td align="right"  style="padding:5px 5px 0px 0px" >
								<b>The classes start at:</b>
							</td>
							<td align="center" style="padding:5px 0px 0px 5px"  >
								<select name="timeh_from_<?php echo $day; ?>" id="timeh_from_<?php echo $day; ?>">
									<option value="<?php echo $timeh; ?>" ><?php echo $timeh; ?></option>
									<option value="1" >1</option>
									<option value="2" >2</option>
									<option value="3" >3</option>
									<option value="4" >4</option>
									<option value="5" >5</option>
									<option value="6" >6</option>
									<option value="7" >7</option>
									<option value="8" >8</option>
									<option value="9" >9</option>
									<option value="10" >10</option>
									<option value="11" >11</option>
									<option value="12" >12</option>
									<option value="13" >13</option>
									<option value="14" >14</option>
									<option value="15" >15</option>
									<option value="16" >16</option>
									<option value="17" >17</option>
									<option value="18" >18</option>
									<option value="19" >19</option>
									<option value="20" >20</option>
									<option value="21" >21</option>
									<option value="22" >22</option>
									<option value="23" >23</option>
									<option value="00" >00</option>
								</select>h. and
								<select name="timem_from_<?php echo $day; ?>" id="timem_from_<?php echo $day; ?>">
									<option value="<?php echo $timem; ?>" ><?php echo $timem; ?></option>
									<option value="00" >00</option>
									<option value="05" >05</option>
									<option value="10" >10</option>
									<option value="15" >15</option>
									<option value="20" >20</option>
									<option value="25" >25</option>
									<option value="30" >30</option>
									<option value="35" >35</option>
									<option value="40" >40</option>
									<option value="45" >45</option>
									<option value="50" >50</option>
									<option value="55" >55</option>
								</select>min.
								<br />
								<a href="Javascript:;" onclick="school_starts('<?php echo $day; ?>', 'timem_from_<?php echo $day; ?>', 'timeh_from_<?php echo $day; ?>', 'result_time_from', 'time_starts')" >Set</a>
								<div id="result_time_from" ></div>
							</td>
						</tr>
						<tr>
							<td align="center" class="list_td" >
								<b>Hour</b>
							</td>
							<td align="center"  class="list_td">
								<b>Time</b>
							</td>
						</tr>
						<?php
						for($i = 1 ; $i <= 10; $i++)
						{
							$query1 = $connect->query("SELECT * FROM ".$TABLES['programa']." WHERE den = '".$day."' && chas = '".$i."_chas' ");
							$row_chas = $connect->fetchObject($query1);
							$query = $connect->query("SELECT * FROM ".$TABLES['programa']." WHERE den = '".$day."' && chas = '".$i."_mejduchasie' ");
							$row_mejduchasie = $connect->fetchObject($query);
						?>
							<tr>
								<td width="100" height="25" >
									<b><?php echo $i.' hour'; ?></b>
								</td>
								<td width="200" align="center" id="<?php echo $i.'_chas'; ?>" >
									<?php
									if($row_chas->vreme)
									{
										echo $row_chas->vreme;
									?>
										<a href="Javascript:;" onclick="set_time1('<?php echo $i; ?>_chas', 'time_<?php echo $i; ?>_chas', '<?php echo $day; ?>', 'delete_time');"><img src="images/delete.gif" alt="delete" title="delete" border="0"  /></a>
									<?php
									}
									else
									{
										echo '<a href="Javascript:;" onclick="set_time(\''.$i.'_chas\', \''.$day.'\', \'set_time\');" title="Set time in minutes" >Set time <img src="images/write.png" alt="" border="0" /></a>';
									}
									?>
								</td>
							</tr>
							<?php
							if($i == 10)
							{
								break;
							}
							?>
							<tr>
								<td width="100" height="25" >
									<i><?php echo $i.' break'; ?></i>
								</td>
								<td width="200" align="center" id="<?php echo $i.'_mejduchasie'; ?>" >
									<?php
									if($row_mejduchasie->vreme)
									{
										echo $row_mejduchasie->vreme;
									?>
										<a href="Javascript:;" onclick="set_time1('<?php echo $i; ?>_mejduchasie', 'time_<?php echo $i; ?>_mejduchasie', '<?php echo $day; ?>', 'delete_time');"><img src="images/delete.gif" alt="delete" title="delete" border="0"  /></a>
									<?php
									}
									else
									{
										echo '<a href="Javascript:;" onclick="set_time(\''.$i.'_mejduchasie\', \''.$day.'\', \'set_time\');"  title="Set time in minutes" >Set time <img src="images/write.png" alt="" border="0" /></a>';
									}
									?>
								</td>
							</tr>
						<?php
						}
						?>
					</table>
	<?php
			}
			if($method == 'time_starts')
			{
				$timeh = $_GET['timeh'];
				$timem = $_GET['timem'];
				$day = $_GET['day'];
				$time = $timeh.':'.$timem;
				$query = $connect->query("DELETE FROM ".$TABLES['programa']." WHERE den = '".$day."' && chas= 'school_starts'")or die(MYSQL_ERROR);
				$query = $connect->query("INSERT INTO ".$TABLES['programa']." (chas, den, vreme) VALUES ('school_starts', '".$day."', '".$time."')")or die(MYSQL_ERROR);
				echo 'The classes start at '.$day.', '.$time;
			}
			if($method == 'set_time')
			{
	?>
			<input type="text" name="time_<?php echo $chas; ?>" id="time_<?php echo $chas; ?>"  style="height:15px;width:25px;" /> 
			<a href="Javascript:;" onclick="set_time1('<?php echo $chas; ?>', 'time_<?php echo $chas; ?>', '<?php echo $day; ?>', 'set_time1')" >Set</a>
	<?php
			}
			if($method == 'set_time1')
			{
				$vreme = htmlspecialchars($_GET['vreme']);
				if($vreme != '' && is_numeric($vreme))
				{
					$day = htmlspecialchars($_GET['day']);
					$chas = htmlspecialchars($_GET['chas']);
					$vreme = htmlspecialchars($_GET['vreme']);
					
					$query = $connect->query("INSERT INTO ".$TABLES['programa']." (den, chas, vreme) VALUES('".$day."', '".$chas."', '".$vreme." minutes')")or die(MYSQL_ERROR);	
					
					echo $vreme.' minutes';
		?>
					<a href="#" onclick="set_time1('<?php echo $chas; ?>', 'time_<?php echo $chas; ?>', '<?php echo $day; ?>', 'delete_time');"><img src="images/delete.gif" alt="delete" title="delete" border="0"  /></a>
<?php
				}
				else
				{
?>
				<input type="text" name="time_<?php echo $chas; ?>" id="time_<?php echo $chas; ?>"  style="height:15px;width:25px;" /> 
				<a href="Javascript:;" onclick="set_time1('<?php echo $chas; ?>', 'time_<?php echo $chas; ?>', '<?php echo $day; ?>', 'set_time1')" >Set</a>
<?php
				}
			}
			if($method == 'delete_time')
			{
				$day = htmlspecialchars($_GET['day']);
				$chas = htmlspecialchars($_GET['chas']);
				
				$query = $connect->query("DELETE FROM ".$TABLES['programa']." WHERE den = '".$day."' && chas = '".$chas."'  ")or die(MYSQL_ERROR);
				$query = $connect->query("DELETE FROM ".$TABLES['programa_predmeti']." WHERE chas = '".$chas."' && day = '".$day."'")or die(MYSQL_ERROR);
				echo '<a href="Javascript:;" onclick="set_time(\''.$chas.'\', \''.$day.'\', \'set_time\');"  title="Set time in minutes" >Set time</a>';
			}
		}
		if(($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'teacher'))
		{
			if($method == 'view_program')
			{
				$day = htmlspecialchars($_GET['day']);
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
						<b>Hour</b>
					</td>
					<td align="center" class="list_td">
						<b>Subject - class</b>
					</td>
				</tr>
				
	<?php	
				if($num < 1)
				{
				?>
				<tr>
					<td colspan="2" >
						<div id="error"> <font color="black">There are no classes on this day! </font> </div>
					</td>
				</tr>
				<?php
				}
				for($i = 1; $i<=10; $i++)
				{
					$query = $connect->query("SELECT * FROM ".$TABLES['programa']." WHERE den = '".$day."' && chas = '".$i."_chas' ") or die(MYSQL_ERROR);
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
							$oMain = new main;
							$teacherid = $oMain->get_teacherid($_SESSION['username']);
							$query = $connect->query("SELECT * FROM ".$TABLES['programa_predmeti']." WHERE day = '".$day."' && chas = '".$i."'  && teacherid = '".$teacherid."'") or die(MYSQL_ERROR);
							if($connect->numRows($query))
							{
								$row = $connect->fetchObject($query);
								$classid = $row->classid;
								$query = $connect->query("SELECT * FROM ".$TABLES['paralelki']." WHERE classid = '".$classid."' ")or die(MYSQL_ERROR);
								$row_class = $connect->fetchObject($query);
								echo $row->predmet." - <a href='list_students.php?classid=".$classid."'>".$row_class->klas.'"'.$row_class->class_name.'"</a>';
							}
							else
							{
								echo 'You have a free hour!';
							}
							?>
						</td>
					</tr>
	<?php			
					}
				}
	?>
				</table>
<?php
			}
		}
	}
	else 
	{
		header('Location: index.php');
	}
?>