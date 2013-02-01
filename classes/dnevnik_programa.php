<?php
	class chasove
	{
		public $table_programa = 'programa';
		public $programa_predmeti = 'programa_predmeti';
		public $teacherid;
		
		public function curr_chas($day)
		{
			$connect = new DbConnector();
			$query = $connect->query("SELECT * FROM ".$this->table_programa." WHERE den = '".$day."' && chas = 'school_starts'");
			$row = $connect->fetchObject($query);		
			$school_starts = $row->vreme;
			$school_starts = explode(':', $school_starts);
			$school_starts_h = $school_starts[0];
			$school_starts_m = $school_starts[1];
			$school_starts = $school_starts_h * 60 + $school_starts_m;
			$h = (date("H") * 60) + date("i");
			if($h > $school_starts)
			{
				$query = $connect->query("SELECT * FROM ".$this->table_programa." WHERE den = '".$day."' && chas != 'school_starts'");
				$chasove = $connect->numRows($query);
				$time_passed = $h - $school_starts;
				$sum_time;
				$times = 0;
				for($i = 0; $i < $chasove; $i++)
				{
					$query = $connect->query("SELECT * FROM ".$this->table_programa." WHERE den = '".$day."' && chas = '".$i."_chas'");
					$row = $connect->fetchObject($query);
					$vreme = $row->vreme;
					$vreme1 = explode(' ', $vreme);
					$vreme = $vreme1[0];
					$sum_time += $vreme;
					if($sum_time < $time_passed)
					{
						$times++;
					}
					else
					{
						$arr = array();
						$arr[0] = $i;
						$arr[1] = 'chas';
						return $arr;
						break;
					}
					$query = $connect->query("SELECT * FROM ".$this->table_programa." WHERE den = '".$day."' && chas = '".$i."_mejduchasie'");
					$row = $connect->fetchObject($query);
					$vreme = $row->vreme;
					$vreme1 = explode(' ', $vreme);
					$vreme = $vreme1[0];
					$sum_time += $vreme;
					if($sum_time < $time_passed)
					{
						$times++;
					}
					else
					{
						$arr = array();
						$arr[0] = $i;
						$arr[1] = 'mejduchasie';
						return $arr;
						break;
					}
				}
				if($times > $chasove + 1)
				{
					return 'error1';
				}
			}
			else
			{
				return 'error2';
			}
		}
		public function check_teacher_chas($day, $val)
		{
			$connect = new DbConnector();
			$query = $connect->query("SELECT * FROM programa_predmeti WHERE chas = '".$val."' && day = '".$day."' && teacherid = '".$this->teacherid."'")or die(MYSQL_ERROR);
			if($connect->numRows($query))
			{
				$row = $connect->fetchObject($query);
				$classid = $row->classid;
				$query = $connect->query("SELECT * FROM paralelki WHERE classid = '".$classid."' ")or die(MYSQL_ERROR);
				$row_class = $connect->fetchObject($query);
				return 'and you have: '.$row->predmet.' with <a href="list_students.php?classid='.$classid.'">'.$row_class->klas.'"'.$row_class->class_name.'"</a> class.';
			}
			else
			{
				return 'and you have free class.';
			}
		}
		public function return_curr_chas($day)
		{
			$val = $this->curr_chas($day);
			
			switch($val[0])
			{
				case 1:
					$hour = 'first';
				break;
				case 2: 
					$hour = 'second';
				break;
				case 3:
					$hour = 'third';
				break;
				case 4:
					$hour = 'fourth';
				break;
				case 5:
					$hour = 'fifth';
				break;
				case 6:
					$hour = 'sixth';
				break;
				case 7:
					$hour = 'seventh';
				break;
				case 8:
					$hour = 'eighth';
				break;
				case 9:
					$hour = 'ninth';
				break;
				case 10:
					$hour = 'tenth';
				break;
			}
			
			if($val == 'error1')
			{
				return 'The study classes for today have already ended.';
			}
			if($val == 'error2')
			{
				return 'The study classes have not started yet.';
			}
			if($val[1] == 'chas')
			{
				$oMain = new main;
				return '<b>Now</b> is the '.$hour.' hour '.$this->check_teacher_chas($day, $val[0]);
				
			}
			if($val[1] == 'mejduchasie')
			{
				return '<b>Now</b> is the '.$hour.' break';
			}
		}
		
	}
?>