<?php
	class paralelki 
	{
		private $table 		= 'paralelki';
		public $paralelka;
		public $classes;
		
		public function checkParalelka() 
		{
			if(isset($this->table, $this->paralelka, $this->classes))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE klas = '".mysql_real_escape_string($this->classes)."' and class_name = '".mysql_real_escape_string($this->paralelka)."'") or die(MYSQL_ERROR);

				$num_rows = $connect->numRows($query);

				if($num_rows == 0) {
				
				return false;
					
				} else {
				
				return true;
					
				}
			}
		}
		public function checkKlas()
		{
			if(isset($this->table, $this->classes))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE klas = '".mysql_real_escape_string($this->classes)."'") or die(MYSQL_ERROR);

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