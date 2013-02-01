<?php
	class students 
	{
		private $table 	= 'uchenici';
		private $tableUsers = 'users';
		private $pool 	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; 
		public $classid;
		public $number;
		public $egn;
		
		public function checkNumber() 
		{
			if(isset($this->table, $this->number, $this->classid))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE classid = '".mysql_real_escape_string($this->classid)."' and number = '".mysql_real_escape_string($this->number)."'") or die(MYSQL_ERROR);

				$num_rows = $connect->numRows($query);

				if($num_rows == 0) {
				
				return false;
					
				} else {
				
				return true;
					
				}
			}
		}
		public function printStudent($studentsid)
		{
			if(isset($this->table, $studentsid))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT ime, prezime, familiq FROM ".$this->table." WHERE studentsid = '".mysql_real_escape_string($studentsid)."'");
				if($connect->numRows($select))
				{
					$row = $connect->fetchObject($select);
					$name = $row->ime.' '.$row->prezime.' '.$row->familiq;
					/*if(strlen($name) > 30)
					{
						$name = substr($name, 0, 26).'...';
					}*/
					return $name;
				}
				else {
					echo '<div id="error">There is no such student!</div>';
				}
			}
		}
		public function checkEGN()
		{
			if(isset($this->table, $this->egn))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE egn = '".mysql_real_escape_string($this->egn)."'") or die(MYSQL_ERROR);

				$num_rows = $connect->numRows($query);

				if($num_rows == 0) {
				
				return false;
					
				} else {
				
				return true;
					
				}
			}
		}
		public function studentsId()
		{
			if(isset($this->table))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT studentsid FROM ".$this->table." order by studentsid desc") or die(MYSQL_ERROR);
				$row = $connect->fetchObject($select);
				$max = $row->studentsid + 1;			
				if($row)
				{
					$studentsid = $max;
				}
				else {
					$studentsid = 1;
				}
				return $studentsid;
			}
		}
		public function checkConfirm($studentsid)
		{
			if(isset($this->table))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT checked FROM ".$this->table." WHERE studentsid = '".mysql_real_escape_string($studentsid)."'")or die(MYSQL_ERROR);
				$row = $connect->fetchObject($select);
				
				if($row->checked == "true")
				{
					return true;
				}
				else {
					return false;
				}
			}
		}
		public function generateCode()
		{
			if(isset($this->pool))
			{
				$numletters = 5; 
							
				for ($i=0;$i<=$numletters;$i++) 
				{
					$kod = $kod.substr($this->pool, rand(0, strlen($this->pool)), 1);
				}
				return substr(md5($kod.time()), 0, $numletters);
			}
		}
		public function printUsername()
		{
			if(isset($this->studentsid, $this->table))
			{
				$connect = new DbConnector();
				
				$select = $connect->query("SELECT u_key FROM ".$this->table." WHERE studentsid = '".mysql_real_escape_string($this->studentsid)."'")or die(MYSQL_ERROR);
				
				$row = $connect->fetchObject($select);
				
				$select_username = $connect->query("SELECT username FROm ".$this->tableUsers." WHERE u_key = '".$row->u_key."'")or die(MYSQL_ERROR);
				
				if($connect->numRows($select_username))
				{
					$row_username = $connect->fetchObject($select_username);
				
					return $row_username->username;
				}
				else
				{
					return 'This student does not have a username!!!';
				}
			}
		}
		// print student's name by egn
		public function printStudentsName($egn)
		{
			if(isset($this->table, $egn))
			{
				$connect = new DbConnector();
				
				$select = $connect->query("SELECT ime, familiq FROM ".$this->table." WHERE egn = '$egn'")or die(MYSQL_ERROR);
				
				$row = $connect->fetchObject($select);
				
				$fullName = $row->ime.' '.$row->familiq;
				
				return $fullName;
			}
		}
	}
?>