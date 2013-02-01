<?php
	class srok 
	{
		private $table 	= 'srok';
		
		public function get_srok()
		{
			if(isset($this->table))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT * FROM ".$this->table." where srok = '1'");
				$row = $connect->fetchObject($select);
				$select2 = $connect->query("SELECT * FROM ".$this->table." where srok = '2'");
				$row2= $connect->fetchObject($select2);
				$date = date("m/d/Y"); 
				if($date >= date($row->date_from) && $date <= date($row->date_to))
				{
					return "1";
				}
				else if($date >= date($row2->date_from) && $date <= date($row2->date_to))
				{
					return "2";
				}
				else {
					return "0";
				}
			}
		}
		public function check()
		{
			if(isset($this->table))
			{
				$connect = new DbConnector();
				$select = $connect->query("SELECT * FROM ".$this->table."");
				$row = $connect->fetchObject($select);
				if(!$row)
				{
					echo '<div align="center"><div id="error">In order the school diary to functionate correctly,<br />first you must set the school terms!</div></div><div style="height:10px;"></div>';
				}
			}
		}
		public function callCurrentSrok()
		{
			if(isset($this->table))
			{
				$currentSrok = self::get_srok();
				
				if($currentSrok == '1' || $currentSrok == '2')
				{
					self::callSrok($currentSrok);
				}
				else {
					return 'out of the given ';
				}
			}
		}
		public function callSrok($srok)
		{
			if(isset($srok))
			{
				if($srok == "1" || $srok == 1)
				{
					return "I-";
				}
				if($srok == "2" || $srok == 2)
				{
					return "II-";
				}
			}
		}
	}
?>