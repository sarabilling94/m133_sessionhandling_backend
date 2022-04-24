<?php
require 'accesscontrol.php';

session_start();
session_unset();
session_destroy();
echo "Logout erfolgreich";
?>