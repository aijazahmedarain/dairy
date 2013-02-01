<?php
	function ocenkaColor($ocenka)
	{
		switch($ocenka)
		{
			case 2 : return "red"; break;
			case 3 : return "#d9621a"; break;
			case 4 : return "#fea509"; break;
			case 5 : return "#a4c218"; break;
			case 6 : return "green"; break;
		}
	}
	function ocenkaWord($ocenka)
	{
		switch($ocenka)
		{
			case 2 : return "Poor"; break;
			case 3 : return "Medium"; break;
			case 4 : return "Good"; break;
			case 5 : return "Very Good"; break;
			case 6 : return "Excellent"; break;
		}
	}
	function loginForm()
	{
		echo '<div id="login_form" style="">
				<form action="login.php" method="post" name="login" onsubmit="return validate()">
					<label for="uname">
						<img src="images/username.png" alt="user" /> Username : 
					</label>
					<input type="text" name="uname" id="uname" class="form_field" style="width : 120px;"  />
					<label for="password">
						<img src="images/password.gif" alt="pass" /> Password : 
					</label>
					<input type="password" name="password" id="password" class="form_field" style="width : 120px;"  />
					<input type="submit" value="Sign in >" class="login_button" /> 
					<input type="hidden" name="goback" value="'.$_SERVER['PHP_SELF'].'" />';
				echo '| <a href="#" onclick="hide(\'login_form\')" title="Close the sign in form">
							Close
					</a>';						
			echo '</form>
		</div>';
	}
?>