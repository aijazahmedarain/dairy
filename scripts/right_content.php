<?php
	echo '<ul id="right_content" style="list-style-type: none; margin: 0; padding: 0;">';
	echo '<li id="right_content_1">';
		// кой е онлайн
		$oWhoIs = new main;
		$oWhoIs->session = loggedin;
		$oWhoIs->who_is_online();
	echo '</li><li id="right_content_2">';
		// анкета
		echo '<div class="title_right_content" style="cursor : move;">
				Poll
			</div>';
		echo '<div class="info_right_content">';
				include('anketa.php');
		echo '</div>';
	echo '</li><li id="right_content_3">';
		// новини
		echo '<div class="title_right_content" style="cursor : move;">
				Messages
			</div>';
		echo '<div class="info_right_content">';
				$query = $connect->query("SELECT * FROM ".$TABLES['messages']." order by id desc") or die(mysql_error);
				if($connect->numRows($query))
				{
					while($row = $connect->fetchObject($query))
					{
						echo $row->news;
						echo '<hr />';
					}
				}
				else {
					echo '<b>There is no news.</b>';
				}
		echo '</div>';
	echo '</li><li id="right_content_4">';
		// реклама
		echo '<div class="title_right_content" style="cursor : move;">
				Advertisement
			</div>';
		echo '<div class="info_right_content"><br />';
				echo '<b>Your advertise here!</b><br />';
		echo '<br /></div>';
	echo '</li>
	<ul>';
?>