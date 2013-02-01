<?php
	class register 
	{
		private $table 				= 'users';
		private $usernamePattern 	= '/^[A-Za-z0-9]+$/';
		private $salt				= 'ivromo93';
		public $usernameSize 		= 3;
		public $returnTrueResult 	= false;
		public $username;
		public $password;
		
		public function checkUsername() 
		{
			if(isset($this->table, $this->username))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE username = '".mysql_real_escape_string($this->username)."'") or die(MYSQL_ERROR);

				$num_rows = $connect->numRows($query);

				if($num_rows == 0) {
				
				return false;
					
				} else {
				
				return true;
					
				}
			}
		}
		public function hashPassword()
		{
			if(isset($this->password, $this->salt))
			{
				$password = $this->password.$this->salt;
				return $password = md5($password);
			}
		}
		public function teacherId()
		{
			if(isset($this->table))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT teacherid FROM ".$this->table." order by teacherid desc") or die(MYSQL_ERROR);
				$row = $connect->fetchObject($select);
				$max = $row->teacherid + 1;			
				if($row)
				{
					$teacherid = $max;
				}
				else 
				{
					$teacherid = 1;
				}
				return $teacherid;
			}
		}
		public function usernameValidation() 
		{
			if(isset($this->usernameSize, $this->username, $this->usernamePattern)) 
			{
				if(self::checkUsername())
				{
					if($this->returnTrueResult == true)
					{
						echo '<font color="red">The username - <strong>'.$this->username.'</strong> is already in use.</font>';
					}
					else 
					{
						echo '<div align="center"><div id="error">The username - <strong>'.$this->username.'</strong> is already in use.</div></div>';
					}
					return true;
				}
				else
				{
					if(preg_match($this->usernamePattern, $this->username))
					{
						if(is_numeric($this->username))
						{
							if($this->returnTrueResult == true)
							{
								echo '<font color="red">The username should contain letters too!</font>';
							}
							else 
							{
								echo '<div align="center"><div id="error">The username should contain letters too!</div></div>';
							}
							return true;
						}
						else 
						{
							if(strlen($this->username) > $this->usernameSize)
							{
								if($this->returnTrueResult == true)
								{
									echo 'Valid username&nbsp;<img src="images/tick.gif" align="absmiddle">';
								}
								return false;
							}
							else 
							{
								if($this->returnTrueResult == true)
								{
									echo '<font color="red">The username should conatin more than <b>'.$this->usernameSize.'</b> symbols!</font>';
								}
								else 
								{
									echo '<div align="center"><div id="error">The username should conatin more than <u>'.$this->usernameSize.'</u> symbols!</div></div>';
								}
								return true;
							}
						}
					}
					else 
					{
						if($this->returnTrueResult == true)
						{
							echo '<font color="red">Invalid symbols!</font>';
						}
						else 
						{
							echo '<div align="center"><div id="error">Invalid symbols!</div></div>';
						}
						return true;
					}
				}
			}
		}
	}
?>