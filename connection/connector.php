<?php
	error_reporting(0);
	
	require_once('commponents.php');
	
	class DbConnector extends SystemComponent 
	{
		public $table = 'users';
		public $theQuery;
		private $link;
		
		public function __construct() 
		{
			$options = parent::getSettings();
			
			$host = $options['dbhost'];
			$db = $options['dbname'];
			$userdb = $options['dbusername'];
			$passdb = $options['dbpassword'];
			
			$this->link = mysqli_connect($host, $userdb, $passdb);
			
			mysqli_select_db($this->link, $db);
		}
		public function query($query)
		{
			$this->theQuery = $query;
			
			return mysqli_query($this->link, $query);
		}
		public function fetchObject($result)
		{
			return mysqli_fetch_object($result);
		}
		public function numRows($result)
		{
			return mysqli_num_rows($result);
		}
		public function install()
		{
			$director = 'director';
			if(!$this->link || !$this->numRows($this->query("SELECT * FROM ".$this->table." WHERE rank = '".$director."'")))
			{
				header("Location: install/index.php");
			}
		}
	}
	
	
?>