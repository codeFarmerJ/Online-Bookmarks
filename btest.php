<?php
echo "<h1>Begin BTest</h1>";
define ("ABSOLUTE_PATH", dirname (__FILE__) . "/");
echo 'ABSOLUTE_PATH = '. ABSOLUTE_PATH;
echo "<br><br>";
require_once (ABSOLUTE_PATH . "config/config.php");
print_r($dsn);
echo "<br>";


class mysql {
	public $pdo;
		var $error = "";
		var $result = false;


   public function __construct($db = NULL, $username = NULL, $password = NULL, $host = '127.0.0.1', $port = 3306, $options = [])
		{
   	$default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        	];
		global $dsn;
		$host = $dsn['hostspec'];
		$database = $dsn['database'];
		$username = $dsn['username'];
		$password = $dsn['password'];
		$ds = "mysql:host={$host};dbname={$database}; port={$port}";
		$options = array_replace($default_options, $options);
        
		try {
			$this->pdo = new \PDO($ds, $username, $password, $options);
			echo "<p>Connection to server was successful</p>";
			echo "<p>ds= $ds</p>";
			} 
		catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
      	}
		}	
		
    public function query($sql, $args = NULL) {
        if (!$args)
        {
            return $this->pdo->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }


	function escape ($esc_string) {
		//$esc_string =  htmlspecialchars($esc_string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
			//$esc_string = $pdo->quote($esc_string);
        	return $esc_string;
        }

	}		


$mysql = new mysql();



$username="jamie";
echo "<p>u= $username </p>";
$t = $mysql->escape ($username);
echo "<p>e= $t </p>";

$query = "SELECT id, childof, name, public FROM folder WHERE user='jamie' AND deleted!='1' ORDER BY name";
//$query = sprintf ("SELECT * FROM user WHERE username='%s'",	$mysql->escape ($username));
//$query = "SELECT title, url FROM `bookmark` LIMIT 10";
//$query = "SELECT count(*) FROM `bookmark` ";

echo "<p>q= $query </p>";


//$rc = $mysql->query ($query);
$rowcount = $mysql->query ($query)->rowCount();
echo "row count = $rowcount = ".$mysql->query ($query)->rowCount();
echo "<br><br>";

//$rc = $mysql->query ($query);
//$result = $rc->fetchAll(PDO::FETCH_ASSOC);

// *******************************
//$result = $mysql->query($query)->fetchAll(PDO::FETCH_ASSOC);
//$row = $result->fetch(PDO::FETCH_ASSOC);
//$row = $mysql->query($query)->fetch(PDO::FETCH_ASSOC);

$x = $mysql->query($query);
//$result = $x->fetchAll(PDO::FETCH_ASSOC);

$folders = array ();

echo "<br><br>";

while ($row = $x->fetch(PDO::FETCH_ASSOC)) {
	//$folders[$row['id']] = $row;
	print_r($row);
	echo "<br><br>";
	}			
echo "<br><br>";



//echo "<p>column_width_bookmark:{$result['column_width_bookmark']}</p>";
//echo "<p>column_width_folder:{$result['column_width_folder']}</p>";
//echo "<p>table_height:{$result['table_height']}</p>";

//print_r($result);
var_dump($result);

echo "<br><br>";

//$result = $mysql->query ($query);
foreach ($result as $row) {
	//echo ") $row <br>";
	print_r($row);
   echo "<br>";
	
	}



?>