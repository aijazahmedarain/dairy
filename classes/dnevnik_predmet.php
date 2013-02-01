<?php
	class predmet
	{	
		private $table 	= 'predmeti';
		public $predmet;
		public $predmetid;

		public function checkPredmet() 
		{
			if(isset($this->table, $this->predmet))
			{
				$connect = new DbConnector();
				
				$query = $connect->query("SELECT * FROM ".$this->table." WHERE predmet = '".mysql_real_escape_string($this->predmet)."'") or die(MYSQL_ERROR);

				$num_rows = $connect->numRows($query);

				if($num_rows == 0) {
				
				return false;
					
				} else {
				
				return true;
					
				}
			}
		}
		public function predmetId()
		{
			if(isset($this->table))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT predmetid FROM ".$this->table." order by predmetid desc") or die(MYSQL_ERROR);
				$row = $connect->fetchObject($select);
				$max = $row->predmetid + 1;			
				if($row)
				{
					$predmetid = $max;
				}
				else {
					$predmetid = 1;
				}
				return $predmetid;
			}
		}
		public function callPredmet()
		{
			if(isset($this->table, $this->predmetid))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT predmet FROM ".$this->table." WHERE predmetid = '".mysql_real_escape_string($this->predmetid)."'");
				if($connect->numRows($select))
				{
					$row = $connect->fetchObject($select);
					return $row->predmet;
				}
			}
		}
	}
?>