<?php

class mysql {
	public $pdo;
		var $error = "";
		var $result = false;


   public function __construct($db = NULL, $username = NULL, $password = NULL, $host = '127.0.0.1', $port = 3306, $options = [])
	{
   	$default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        	];
       $options = array_replace($default_options, $options);
	global $dsn;
	$host = $dsn['hostspec'];
	$database = $dsn['database'];
	$username = $dsn['username'];
	$password = $dsn['password'];
	$ds = "mysql:host=$host; dbname=$database; port=$port";
        
		try {
			$this->pdo = new \PDO($ds, $username, $password, $options);
			//echo "Connection to server was successful";
			} 
		catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
      	}
		}	
		
	public function query($sql, $args = NULL) {
		if (!$args) {
			return $this->pdo->query($sql);			
			}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($args);
		return $stmt;
		}


	function escape ($q_string) {	
		// replace deprecated mysql_real_escape_string ($string);
		// Quotes a string for use in a query by placing quotes around the input string (if required) 
		// and escapes special characters within the input string
// not using 		
        	return $q_string;
        }

	}		


?>
