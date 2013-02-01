<?php
	class klas
	{
		private $tableTeacherKlas 		= 'teacher_klas';
		private $tablePredmetTeacher	= 'predmet_teacher';
		private $tablePredmetKlas		= 'predmet_klas';
		private $tableParalelki 		= 'paralelki';
		private $tableUchenici			= 'uchenici';
		private $tableKlasen			= 'klasen';
		public $teacherid;
		public $classid;
		public $predmetid;
		public $srudentsid;
		
		public function printKlas($classid)
		{
			if(isset($this->tableParalelki, $classid))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT * FROM ".$this->tableParalelki." WHERE classid = '".mysql_real_escape_string($classid)."' order by classid desc");
				if($connect->numRows($select))
				{
					$row = $connect->fetchObject($select);
					$klas = $row->klas.$row->class_name;
					return $klas;
				}
			}
		}
		public function teacherAccess($teacherid, $classid)
		{
			if(isset($this->tableTeacherKlas, $teacherid, $classid))
			{
				if($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin')
				{
					return true;
				}
				else {
					$connect = new  DbConnector();
					$con = 1;
					$select = $connect->query("SELECT teacherid FROM ".$this->tableTeacherKlas." where classid = '".mysql_real_escape_string($classid)."'");
					while($row = $connect->fetchObject($select))
					{
						if($row->teacherid == $teacherid)
						{
							$con = 0;
						}
					}
					if($con == 0)
					{
						return true;
					}
					else {
						return false;
					}
				}
			}
		}
		public function checkStudent($classid, $studentsid)
		{
			if(isset($classid, $studentsid, $this->tableUchenici))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT classid FROM ".$this->tableUchenici." WHERE studentsid = '".mysql_real_escape_string($studentsid)."'") or die(MYSQL_ERROR);
				$row = $connect->fetchObject($select);
				if($row->classid == $classid)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		public function checkTeacher($predmetid, $teacherid)
		{
			if(isset($predmetid, $teacherid, $this->tablePredmetTeacher))
			{
				$connect = new DbConnector();
				$result = 0;
				$select = $connect->query("SELECT predmetid FROM ".$this->tablePredmetTeacher." WHERE teacherid = '".mysql_real_escape_string($teacherid)."'") or die(MYSQL_ERROR);
				if($connect->numRows($select))
				{
					while($row = $connect->fetchObject($select))
					{
						if($row->predmetid == $predmetid)
						{
							$result = 1;
						}
					}
				}
				if($result == 1)
				{
					return true;
				}
				else 
				{
					return false;
				}
			}
		}
		public function checkKlas($predmetid, $classid)
		{
			if(isset($predmetid, $classid, $this->tablePredmetKlas))
			{
				$connect = new DbConnector();
				$result = 0;
				$select = $connect->query("SELECT predmetid FROM ".$this->tablePredmetKlas." WHERE classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);
				if($connect->numRows($select))
				{
					while($row = $connect->fetchObject($select))
					{
						if($row->predmetid == $predmetid)
						{
							$result = 1;
						}
					}
				}
				if($result == 1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		public function writeTeacherAccess()
		{
			if(isset($this->classid, $this->studentsid, $this->teacherid, $this->predmetid))
			{
				$oCheckStudent 	= self::checkStudent($this->classid, $this->studentsid);
				$oTeacherAccess = self::teacherAccess($this->teacherid, $this->classid);
				$oCheckTeacher 	= self::checkTeacher($this->predmetid, $this->teacherid);
				$oCheckKlas		= self::checkKlas($this->predmetid, $this->classid);
				
				if($oCheckStudent && $oTeacherAccess && $oCheckTeacher && $oCheckKlas)
				{
					return true;
				}
				else 
				{
					return false;
				}
			}
		}
		public function teacherClasses()
		{
			if(isset($this->tableTeacherKlas, $this->tableParalelki))
			{
				$connect = new DbConnector();
				
				if($_SESSION['user_rank'] == 'director' || $_SESSION['user_rank'] == 'admin')
				{
					$select = $connect->query("SELECT classid FROM ".$this->tableParalelki."");
				}
				else 
				{
					if(!$_SESSION['loggedin'])
					{
						$select = $connect->query("SELECT classid FROM ".$this->tableParalelki."");
					}
					else
					{
						$select = $connect->query("SELECT classid FROM ".$this->tableKlasen." WHERE teacherid = '".mysql_real_escape_string($this->teacherid)."'");
					}
				}
				if($connect->numRows($select))
				{
					while($row = $connect->fetchObject($select))
					{
						echo '<option value="'.$row->classid.'">'.self::printKlas($row->classid).'</option>';
					}
				}
			}
		}
		public function checkKlasen($teacherid, $classid)
		{
			if(isset($this->tableKlasen, $teacherid, $classid))
			{
				if($_SESSION['loggedin'] == true && $_SESSION['user_rank'] == 'director')
				{
					return true;
				}
				else {
					$connect = new DbConnector();
					$select = $connect->query("SELECT teacherid FROM ".$this->tableKlasen." WHERE classid = '".mysql_real_escape_string($classid)."'")or die(MYSQL_ERROR);

					$row = $connect->fetchObject($select);
						
					if($row->teacherid == $teacherid)
					{
						return true;
					}
					else {
						return false;
					}
				}
			}
		}
	}
?>