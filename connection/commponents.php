<?php
	class SystemComponent
	{
		public $options;
		
		public function getSettings()
		{
			$lines = file('./connection.txt');
			foreach ($lines as $line_num => $line)
			{
				$line = explode("|",$line);
				$dbhost = $line[0];
				$dbusername = $line[1];
				$dbpassword = $line[2];
				$dbname = $line[3];
			}
			$options['dbhost'] = $dbhost;
			$options['dbusername'] = $dbusername;
			$options['dbpassword'] = $dbpassword;
			$options['dbname'] = $dbname;
			
			return $options;
		}
	}
?>