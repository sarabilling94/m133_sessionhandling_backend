<?php
session_start();
require '../utils/accesscontrol.php';

echo session_id();
echo $_SESSION["name"];
 
if(!isset($_SESSION['name'])) {
   http_response_code(401);
   session_unset();
   session_destroy();
 }
 else{
    http_response_code(200);
    echo 'Eingeloggt als: ', $_SESSION["name"];
 }

?> 