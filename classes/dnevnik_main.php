<?php
	class main 
	{
		private $table 	= 'users';
		
		public function who_is_online()
		{
			if(isset($this->table) && isset($this->session))
			{
				$connect = new DbConnector();
				
				if($_SESSION[$this->session]) 
				{
					echo '<div class="title_right_content" style="cursor : move;">
							Who is online?
						</div>';
					echo '<div class="info_right_content">';
						$select = $connect->query("SELECT * FROM ".$this->table." where online = 'true'") or die(MYSQL_ERROR);
						if($connect->numRows($select))
						{
							while($row = $connect->fetchObject($select))
							{
								echo '<b><a href="#" title="header=[<font style=\'font-size:12px\' >'.$row->username.'</font>] body=[<font class=\'who_is_online\' >Name : '.$row->ime.'<br /> Surname : '.$row->familiq.'<br />Rank : '.self::call_rank($row->rank).'</font>]">'.$row->username."</a></b>, ";
							}
						}
						else {
							echo '<b>There are no online users at the moment.</b>';
						}
					echo '</div>';
				}
			}
		}
		public function callName($username)
		{
			if(isset($this->table, $username))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT ime, familiq FROM ".$this->table." where username = '".mysql_real_escape_string($username)."'");
				if($connect->numRows($select))
				{
					$row = $connect->fetchObject($select);
					return $row->ime.' '.$row->familiq;
				}
			}
		}
		public function setEncoding()
		{
			header('Content-type: text/html; charset=windows-1251');
		}
		public function getLoging() 
		{
			if(isset($_GET['error']))
			{
				if($_GET['error'] == 2)
				{
					echo '<script type="text/javascript">
							alert("Wrong user or password!");
					</script>';
				}
				if($_GET['error'] == 3)
				{
					echo '<script type="text/javascript">
							alert("Your registration is still not confirmed!!!");
					</script>';
				}
			}
		}
		public function get_teacherid($username) 
		{
			if(isset($this->table, $username))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT teacherid FROM ".$this->table." where username = '".mysql_real_escape_string($username)."'") or die(MYSQL_ERROR);
				$row_u = $connect->fetchObject($select);
				if($connect->numRows($select))
				{
					return $row_u->teacherid;
				}
			}
		}
		public function call_rank($rank)
		{
			if(isset($rank))
			{
				if($rank == 'admin')
				{
					return 'Administrator';
				}
				else if($rank == 'teacher')
				{
					return 'Teacher';
				}
				else {
					return 'Headmaster';
				}
			}
		}
		public function callUsername($teacherid)
		{
			if(isset($this->table, $teacherid))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT username FROM ".$this->table." WHERE teacherid = '".mysql_real_escape_string($teacherid)."'")or die(MYSQL_ERROR);
				if($connect->numRows($select))
				{
					$row = $connect->fetchObject($select);
					return $row->username;
				}
			}
		}
		public function call_name($teacherid)
		{
			$username  = $this->callUsername($teacherid);
			return $this->callName($username);
		}
		public function checkTeacherid($teacherid) 
		{
			if(isset($this->table, $teacherid))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE teacherid = '".mysql_real_escape_string($teacherid)."' and rank = 'teacher'") or die(MYSQL_ERROR);

				$num_rows = $connect->numRows($query);

				if($num_rows == 0) {
				
				return false;
					
				} else {
				
				return true;
					
				}
			}
		}
	}
?>