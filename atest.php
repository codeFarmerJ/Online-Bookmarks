<?php
echo "<h1>Begin " . $_SERVER['SCRIPT_NAME']. "</h1>";
define ("ABSOLUTE_PATH", dirname (__FILE__) . "/");
$abpath = ABSOLUTE_PATH;
echo "<p>ABSOLUTE_PATH =  $abpath</p>";
require_once (ABSOLUTE_PATH . "config/config.php");
require_once (ABSOLUTE_PATH . "lib/mysql.php");

$username="jamie";

$mysql = new mysql();
//$query = "SELECT * FROM user WHERE username='jamie'";
$query = "SELECT count(*) FROM user WHERE username='jamie'";
//$query = "SELECT * FROM user WHERE username=? ";
//$query = "SELECT username, admin FROM user ORDER BY username";

//$args = [$username];
//print_r($args);
//echo "<p>row count = ".$mysql->query ($query,$args)->rowCount()."</p>";
echo "<p>row count = ".$mysql->query ($query)->rowCount()."</p>";
//$result = $mysql->query ($query);

//$result = $mysql->query ($query,$args)->fetchAll(PDO::FETCH_ASSOC);
$result = $mysql->query ($query)->fetch(PDO::FETCH_ASSOC);
echo " <b>=" . $result["count(*)"] . "</b><br>\n";

//$row = $result->fetch(PDO::FETCH_ASSOC);


//echo " <b>" . $row["username"] . "</b><br>\n";
var_dump($result);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	//print_r($row);
//	echo "<p>" .$row["username"].$row["admin"]."</p>";
	}			


?>