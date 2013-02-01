					<?php
						echo '<h1 align="left">
								<img src="images/student.gif" alt="" /> List of students - 
								<font color="green">
									<u>'.$row2->klas.''.$row2->class_name.'</u>
								</font>
							</h1>';
					?>
						<table align="center" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" width="5%" class="list_td">
									No.
								</td>
								<td align="center" width="20%" class="list_td">
									Name
								</td>
								<td align="center" width="20%" class="list_td">
									Surname
								</td>
								<td align="center" width="20%" class="list_td">
									Last name
								</td>
								<td align="center" width="25%" class="list_td">
									UCC
								</td>
								<td align="center" width="5%" class="list_td">
									Edit
								</td>
								<td align="center" width="5%" class="list_td">
									Del
								</td>
							</tr>
						</table>
						<div>
							<table align="center" width="100%" cellpadding="0" cellspacing="0" >
									<?php
										$select = $connect->query("SELECT * FROM ".$TABLES['uchenici']." where classid = '".mysql_real_escape_string($classid)."' order by number asc") or die(MYSQL_ERROR);
										
										if($connect->numRows($select))
										{
											while($row = $connect->fetchObject($select))
											{
												echo '<tr id="'.$row->studentsid.'">
														<td align="center" width="5%" class="list_td_info">
															'.$row->number.'
														</td>
														<td align="center" width="20%" class="list_td_info">
															'.$row->ime.'
														</td>';
												echo '<td align="center" width="20%" class="list_td_info">
															'.$row->prezime.'
														</td>';
												echo '<td align="center" width="20%" class="list_td_info">
															'.$row->familiq.'
														</td>';
												echo '<td align="center" width="25%" class="list_td_info">
															'.$row->egn.'	
														</td>';
												echo '<td align="center" width="5%" class="list_td_info">
															<a href="edit_student.php?studentsid='.$row->studentsid.'">
																<img src="images/edit.gif" alt="" border="0" />
															</a>
														</td>';
												echo '<td align="center" width="5%" class="list_td_info">
															<a href="#" title="Delete this student" >
																<img src="images/delete.gif" alt="" border="0" onclick="delete_student('.$row->studentsid.', \'delete_student.php\')" />
															</a>
														</td>';
												echo '</tr>';
											}
										}
										else {
											echo '<div align="center"><div><br /></div><b>There are no students in this class!</b><div><br /></div></div>';
										}
									?>
							</table>
						<hr size="1" />