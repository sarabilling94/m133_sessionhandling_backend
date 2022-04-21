<?php
include ("checkuser.php");
?>
<html>
<head>
  <title>Interne Seite</title>
</head>
<body>
  BenutzerId: <?php echo $_SESSION["id_user"]; ?><br>
  Nickname: <?php echo $_SESSION["name"]; ?><br>
  <hr>

  
  <a href="logout.php">Ausloggen</a>
  	  <a href="intern_artikel.php">Artikel</a> 
</body>
</html> 