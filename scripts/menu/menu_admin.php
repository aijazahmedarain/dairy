<?php	
	echo '<h1 align="left"><img src="images/administration.gif" border="0" alt="" align="top" /> Options connected with the administration ';
			if($_SESSION['user_rank'] == 'admin') echo 'and the diary';
	echo '</h1>';
									if($_SESSION['user_rank'] == 'admin')
									{
										echo '<a href="srok.php" title="header=[<font style=\'font-size:12px\' >Set terms </font>] body=[<font style=\'font-size:12px\' >Set school terms. </font>]">
												<img src="images/term.png" border="0" alt="" /> School terms
											</a><br />';	
										echo '<a href="classes.php" title="header=[<font style=\'font-size:12px\' >Add / delete classes and sub-classes</font>] body=[<font style=\'font-size:12px\' >Add and delete classes and sub-classes. </font>]">
												<img src="images/klas.png" border="0" alt="" /> Add / delete classes and sub-classes
											</a><br />';
										echo '<a href="subject.php" title="header=[<font style=\'font-size:12px\' >Add / Delete school subject</font>] body=[<font style=\'font-size:12px\' >Gives you the opportunity to add and delete school subjects.</font>]">
					<img src="images/predmet.png" border="0" alt="" width="17" height="17" /> Add / delete subject
				</a><br />';
										echo '<a href="set_subject.php" title="header=[<font style=\'font-size:12px\' >Subjects for the classes</font>] body=[<font style=\'font-size:12px\' >Add the subjects that the classes are going to study. </font>]">
						<img src="images/book_next.png" border="0" alt="" /> Subjects for the classes
				</a><br />';	
										echo '<a href="set_program.php" title="header=[<font style=\'font-size:12px\' >Set your school schedule</font>] body=[<font style=\'font-size:12px\' >Set your school programme. </font>]">
					<img src="images/program.png" border="0" alt="" /> Set the school schedule
				</a><br />';
										echo '<a href="register.php" title="header=[<font style=\'font-size:12px\' >Register new teacher </font>] body=[<font style=\'font-size:12px\' >Register new teacher. </font>]">
												<img src="images/new_teacher.gif" border="0" alt="" /> Register new teacher
											</a><br />';
										echo '<a href="classes.php?method=list" title="header=[<font style=\'font-size:12px\' >List of the students </font>] body=[<font style=\'font-size:12px\' >See the list of students of a certain class. </font>]">
												<img src="images/student.gif" border="0" alt="" /> List of the students
											</a><div><br /></div>';	
									}
									if($_SESSION['user_rank'] == 'director') 
									{
										echo '<a href="register_admin.php" title="header=[<font style=\'font-size:12px\' >Register new administrator</font>] body=[<font style=\'font-size:12px\' >Register an administrator who will help you administrate the system </font>]">
													<img src="images/admin.png" border="0" alt="" /> Register new administrator
												</a><br />
												<a href="list.php?list=admin" title="header=[<font style=\'font-size:12px\' >List of administrators </font>] body=[<font style=\'font-size:12px\' >Manage the administrators, edit their profiles, delete them. </font>]">
													<img src="images/admin.gif" border="0" alt="" width="18" height="16"/> List of administrators
												</a><br />';
									}
										echo '<a href="create_anketa.php" title="header=[<font style=\'font-size:12px\' >Create new poll </font>] body=[<font style=\'font-size:12px\' >Helps you create a voting poll. </font>]">
												<img src="images/poll.gif" border="0" alt="" width="18" height="16"/> Create new poll
											</a><br />
											<a href="add_message.php" title="header=[<font style=\'font-size:12px\' >Add message </font>] body=[<font style=\'font-size:12px\' >Helps you add a new message. </font>]">
												<img src="images/message_new.gif" alt="" border="0" /> Add message
											</a><br />
											<a href="messages_list.php" title="header=[<font style=\'font-size:12px\' >Edit messages </font>] body=[<font style=\'font-size:12px\' >Gives you the opportunity to edit the messages. </font>]">
												<img src="images/message_edit.gif" alt="" border="0" /> Edit messages
											</a>
											<div><br /></div>';
?>