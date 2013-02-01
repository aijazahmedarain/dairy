<?php

if($already_voted || (isset($_POST['option']) && isset($_POST['submit'])) )
{
	if($already_voted)
	{
		echo '<b>You have already voted!</b>';
	}
	else
	{
		if($connect->query("UPDATE ".$TABLES['anketa_q']." SET votes=(votes+1) WHERE id=".mysql_real_escape_string($_POST['option'])))
		{
			echo '<b>Successful voting!</b> ';
		}
		else
		{
			die(MYSQL_ERROR);
		}
	}
	
	echo '<br /><br />';

	// printing the results
	echo '<b>Question:</b> ';
	
	$query = "SELECT question FROM ".$TABLES['anketa'];
	$result = $connect->query($query);
	if($result)
	{
		$row = $connect->fetchObject($result);
		echo htmlspecialchars($row->question);
	}
	else
	{
		die(MYSQL_ERROR);
	}
	
	// fetching all of the votes
	$all_votes=0;
	$query = "SELECT * FROM ".$TABLES['anketa_q'];
	$result = $connect->query($query);
	if($result)
	{
		while($row = $connect->fetchObject($result))
		{
			$all_votes+=$row->votes;
		}
	}
	else
	{
		die(MYSQL_ERROR);
	}
	
	echo '<br /><br />';
	
	if($all_votes == 0)
	{
		echo "Nobody has voted yet!!";
	}
	else
	{
		//showing with a chart the results
		echo '<table width="80%">';
		
		$query = "SELECT * FROM ".$TABLES['anketa_q']." ORDER BY id ASC";
		$result = $connect->query($query);
		if($result)
		{
			while($row = $connect->fetchObject($result))
			{
				$percents = (int)((100*$row->votes)/$all_votes);
				echo '<tr>';
					echo '<td width="40">';
						echo '<b>'.$percents.'%</b>';
					echo '</td>';
					echo '<td align="left">';
						echo htmlspecialchars($row->option);
					echo '</td>';
					
					echo '<td align="left" width="80%">';
						// chart with the results
						echo '<table style=" width:'.$percents.'%; heigth: 20px;" background="'.ANKETA_COLOR.'">';
							echo '<tr>';
								echo '<td >';
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					
					echo '</td>';
				echo '</tr>';
			}
		}
		
		echo '</table>';
		echo '<br />';
		echo 'Votes: <b>'.$all_votes.'</b>';
	}	
}
else
{
	echo '<form action="'.$_SERVER['PHP_SELF'].'" method = "post">
		<b>Question:</b>';

			$query = "SELECT question FROM ".$TABLES['anketa'];
			$result = $connect->query($query);
				if($result)
					{
						$row=$connect->fetchObject($result);
						echo htmlspecialchars($row->question);
					}
				else
					{
						die(MYSQL_ERROR);
					}

		echo '<br /><br />';

			$query = "SELECT * FROM ".$TABLES['anketa_q']." ORDER BY id ASC";
			$result = $connect->query($query);
				if($result)
					{
						while($row = $connect->fetchObject($result))
						{
								echo '<div style="text-align:left;padding-left:33px"><input type="radio" name="option" value="'.$row->id.'" /> '.htmlspecialchars($row->option).'<br /></div>';
						}
					}

			echo '<br />
		<input type="submit" name="submit" value="Vote!" class="yellow_button" />
	</form>';
	}
?>