<?php
define("HOST", "localhost");
// Database user
define("DBUSER", "root");
// Database password
define("PASS", "");
// Database name
define("DB", "chefensa");
$conn = mysql_connect(HOST, DBUSER, PASS) or  die(mysql_error()); 
$db = mysql_select_db(DB) or  die(mysql_error());


?>
