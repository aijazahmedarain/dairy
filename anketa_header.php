<?php
	$already_voted= false;

	if(isset($_COOKIE["AlreadyVoted"]) && $_COOKIE["AlreadyVoted"] == 1)
	{
		$already_voted = true;
	}
	else
	{
		if(isset($_POST['option']) && isset($_POST['submit']))
		{
			setcookie("AlreadyVoted", 1, time()+100500);
		}
	}
?>