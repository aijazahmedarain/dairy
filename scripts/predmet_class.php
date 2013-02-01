<?php	
	session_start();
	if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
	{
		require_once('../connection/connector.php');
		require_once('../config.php');
		
		main::setEncoding();
		
		$connect = new DbConnector();
		
		$classid = addslashes($_GET['classid']);
		
		if($classid!="----------" && is_numeric($classid))
		{
			$select = $connect->query("SELECT * FROM ".$TABLES['predmeti']."");
			if($connect->numRows($select)) 
			{
				while($red = $connect->fetchObject($select))
				{
					$teacherid = $row->teacherid;
					$select2 = $connect->query("SELECT * FROM ".$TABLES['predmet_klas']." where classid = '$classid'");
															
	?>
					<input type="checkbox" name="predmet[]" 
					<?php while($red2 = $connect->fetchObject($select2))
					{
						if($red2->predmetid == $red->predmetid) 
						{
							echo'checked="checked"';
						}
					} ?> value="<?php echo $red->predmetid; ?>" onblur="checkPredmet()" id="predmet" /> <?php echo $red->predmet.' '; ?><br />
	<?php										
				}
			}
			else {
				echo '<div id="error">There are still no added subjects!</div>';
			}
		}
		else {
			echo '<div><br /></div>
				<b>Please, select a class!</b>
					<div><br /></div>';
		}
	}
	else {
		header('Location: index.php');
	}
?>