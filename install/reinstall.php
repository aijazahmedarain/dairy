<?php
	unlink('connection.txt');
	unlink('../connection.txt');
	unlink('../scripts/connection.txt');
	
	header('Location: index.php');
?>