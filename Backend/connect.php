<?php
// get config data
$config = parse_ini_file('config.ini', true);

// Create connection
$db = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['database']);
 
// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}
//echo "Connected successfully";
?>