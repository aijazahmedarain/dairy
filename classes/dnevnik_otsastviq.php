<?php
	class otsastviq
	{
		private $table 			= 'otsastviq';
		public $otsastvie;
		
		public function checkOtsastvie($otsastvie, $izvineno, $id)
		{
			if(isset($otsastvie, $izvineno, $id))
			{
				if($otsastvie == 0.3)
				{
					return ' - ';
				}
				if($otsastvie == 1.0)
				{
					if($izvineno == "true")
					{
						return '<font color="green">Excused!</font>';
					}
					if($izvineno == "false")
					{
						return '<a href="#" onclick="confirm_thing('.$id.', \'izvini_otsastvie.php\')">Excuse</a>';
					}
				}
			}
		}
		public function returnOtsastvie($otsastvie, $method)
		{
			if(isset($otsastvie, $method))
			{
				if($method == 'real')
				{
					if($otsastvie == 'cqlo' || $otsastvie == 1.0) 
					{
						return 1;
					}
					if($otsastvie == 'treta' || $otsastvie == 0.3)
					{
						return 1/3;
					}
				}
				if($method == 'unreal')
				{
					if($otsastvie == 'cqlo' || $otsastvie == 1.0) 
					{
						return '1';
					}
					if($otsastvie == 'treta' || $otsastvie == 0.3)
					{
						return '1/3';
					}
				}
			}
		}
		public function countOtsastviq($studentsid)
		{
			if(isset($studentsid, $this->table))
			{
				$connect = new DbConnector();
				
				$select = $connect->query("SELECT otsastvie, izvineno FROM ".$this->table." WHERE studentsid = '".mysql_real_escape_string($studentsid)."' && izvineno = 'true'")or die(MYSQL_ERROR);
				
				$select2 = $connect->query("SELECT otsastvie, izvineno FROM ".$this->table." WHERE studentsid = '".mysql_real_escape_string($studentsid)."' && izvineno = 'false'")or die(MYSQL_ERROR);
				
				$izvineni_otsastviq = 0;
				$celi = 0;
				$broi_zakusneniq = 0;
				
				if($connect->numRows($select))
				{
					while($row = $connect->fetchObject($select))
					{
						$izvineni_otsastviq += $row->otsastvie;
					}
				}
				else {
					$izvineni_otsastviq = 0;
				}
				if($connect->numRows($select2))
				{
					while($row2 = $connect->fetchObject($select2))
					{
						if($row2->otsastvie == 0.3)
						{
							$broi_zakusneniq++;
						}
						if($row2->otsastvie == 1)
						{
							$celi++;
						}
					}
					$zakusneniq = floor($broi_zakusneniq/3);
					if($broi_zakusneniq % 3 == 1)
					{
						$zakusnenie = ' and 1/3';
					}
					if($broi_zakusneniq % 3 == 2)
					{
						$zakusnenie = ' and 2/3';
					}
					if($broi_zakusneniq % 3 == 0)
					{
						$zakusnenie = '';
					}
					$neizvineni_otsastviq = $celi+$zakusneniq.$zakusnenie;
				}
				else {
					$neizvineni_otsastviq = 0;
				}
				return $izvineni_otsastviq.'-'.$neizvineni_otsastviq.'';
			}
		}
	}
?>