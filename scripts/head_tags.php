	<title>
		School diary
		<?php
			if($_SESSION['loggedin'])
			{
				echo '| '.$_SESSION['username'];
			}
		?>
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" /> 
	<meta name='Description' content="school diary" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript" src="js/boxover.js"></script>
	<link rel="stylesheet" href="styles/general_design.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/menu.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/footer.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="styles/classes.css" type="text/css" media="screen" />
	<link rel="icon" href="images/icon.png" type="image/x-icon"/>