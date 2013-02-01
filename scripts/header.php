<div id="student_info" style="display:none;">
				<div id="student_info2">
				
				</div>
				<div align="right">
					<b>
						<a href="#" onclick="hide('student_info')">Close</a>
					</b>
				</div>
			</div>
			<table cellpadding="0" cellspacing="0" id="header" border="0" align="center" >
				<tr>
					<td id="header_title" >
						<a href="index.php" ><img src="images/title.png" alt="School diary" border="0"  /></a>
					</td>
					<td id="school_title"  >
						<div id="school_title_div">
						<?php 
							$query = $connect->query("SELECT * FROM ".$TABLES['informaciq']." WHERE place = 'school_title'");
							if(!$connect->numRows($query))
							{
								echo 'Enter the name of the school!';
							}
							$school_title =	$connect->fetchObject($query);
							echo htmlspecialchars_decode($school_title->informaciq);
							
						?>
						
						</div> 
						<?php  
					if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
					{				
					?>
						<a href="Javascript:;" onclick="edit_title()"  title="header=[<font style='font-size:12px'>Edit</font>] body=[<font style='font-size:12px'>Edit the name of the school</font>]" >
							<img src="images/edit.gif" alt="Edit" title="Edit" border="0" id="edit_school_title" />
						</a>
					<?php
					}
					?>
					</td>
					<?php  
					if($_SESSION['loggedin'] && ($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin'))
					{				
					?>
					<td id="school_title_edit"  >
						<textarea class="school_title_textarea" id="school_title_textarea"  ><?php echo $school_title->informaciq; ?></textarea>
						<a href="#" title="header=[<font style='font-size:12px'>Save</font>] body=[]" onclick="edit_title1();"><img src="images/edit.gif" alt="Edit" title="Edit" border="0" id="edit_school_title1" /></a>
					</td>
					<?php 
					}
					?>
				</tr>		
			</table>
			<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" >
				<tr>
					<td class="sess_login_top_menu" width="" valign="top">
						<?php
							if($_SESSION['loggedin'] == false && $_SESSION['loggedin_student'] == false)
							{
								loginForm();
							}
							if($_SESSION['loggedin'] == true  || $_SESSION['loggedin_student'] == true)
							{
								echo '<div style="padding-left:28px;">
										<b> Hello, '.$_SESSION['username'].' </b> ';

									echo ' - <a href="menu_functions.php" title="Options"> 
												<img src="images/menu_functions.png" border="0" alt="" /> Options
											</a>&nbsp
											<a href="manage_profile.php" title="Edit your profile">
												<img src="images/profile.png" border="0" alt="" /> Profile
											</a>';
											
								echo '</div>
									<div style="height:10px;"></div>';
								if($_SESSION['user_rank'] == 'teacher' || $_SESSION['user_rank'] == 'director')
								{
									$oChasove = new chasove;
									$oMain = new main;
									$day_of_week = date('l');
									$day;
									switch($day_of_week)
									{
										case "Monday": $day = 'Monday';
										break;
										case "Tuesday": $day = 'Tuesday';
										break;
										case "Wednesday": $day = 'Wednesday';
										break;
										case "Thursday": $day = 'Thursday';
										break;
										case "Friday": $day = 'Friday';
										break;
										case "Saturday": $day = 'Saturday';
										break;
										case "Sunday": $day = 'Sunday';
										break;
										
									}
									echo '<div style="padding-left:28px;">';
									$oChasove->teacherid = $oMain->get_teacherid($_SESSION['username']);
									echo $oChasove->return_curr_chas($day);
									echo '</div>';
								}
							}
							else {
								echo '<div id="seperator"></div>';
							}
							//echo $_SESSION['username'].' '.$_SESSION['password'].' '.$_SESSION['user_rank'];
						?>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" width="100%" class="horizontal_up">
				<tr>
					<td>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" id="menu" align="center" >
				<tr>
					<td onmouseover="eventOver_roll(this)" onmouseout="eventOut_noRoll(this)" width="187">
						<a href="<?php echo INDEX; ?>" title="">Home</a>
					</td>
					<td onmouseover="eventOver_roll(this)" onmouseout="eventOut_noRoll(this)" width="187">
						<a href="#" title="" onclick="show('search_student')">Search for a student</a>
					</td>
					<td onmouseover="eventOver_roll(this)" onmouseout="eventOut_noRoll(this)" width="187">
						<a href="register_student.php" title="Registration" >Registration</a>
					</td>
					<td onmouseover="eventOver_roll(this)" onmouseout="eventOut_noRoll(this)" width="187">
						<?php
							if($_SESSION['loggedin'] || $_SESSION['loggedin_student']) {
								echo '<a href="logout.php?goback='.$_SERVER['PHP_SELF'].'">Logout</à>';
							}
							else {
								echo '<a href="#" onclick="show(\'login_form\')" title="Sign in">Sign in</a>';
							}
						?>
					</td>
					<td onmouseover="eventOver_roll(this)" onmouseout="this.style.background = ''" width="187">
						<a href="contacts.php" title="">Contacts</a>
					</td>
				</tr>
			</table>
			<div id="search_student" style="">
				<img src="images/search.png" alt="sea" />  
				<label for="egn">
					UCC : 
				</label>
				<input type="text" name="egn" id="egn" class="form_field" style="width : 120px;" />
				<input type="submit" value="Search>" class="login_button" onclick="student_info(1)" />
				| <a href="#" onclick="hide('search_student')" title="Close the search form"> 
					Close
				</a>
			</div>
			<table cellpadding="0" cellspacing="0" width="100%" class="horizontal_down">
				<tr>
					<td class="horizontal_down">
					</td>
				</tr>
			</table>