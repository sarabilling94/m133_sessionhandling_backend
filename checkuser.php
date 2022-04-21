<?php
require 'accesscontrol.php';

 
if(!isset($_SESSION['name'])) {
    die("Bitte erst einloggen"); 
 }
 else{
    //echo 'Eingeloggt';
 }

?> 