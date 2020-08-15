<html><head><title>PHP Test</title></head>
<body>
<h1>Display $POST input</h1>

<?php
require_once ( "lib/lib.php");

echo '<br /><br />';

// this lists out all the values in the incoming $_POST array - for debugging
if ($_POST) {
 foreach ($_POST as $k => $v)
    { Echo "$k --> $v <br />";};
 }
 
//$v1 = set_post_title ();
//echo "<h2> set_post_title=$v1</h2>"; 
echo "<h2> set_post_title= " .set_post_title (). "</h2>"; 
 
 
?>
</body></html>