<?php

$formName = $_POST['name'];
$formPassword = $_POST['password'];

session_start ();

include("connect.php");

$sql = "SELECT * FROM tbl_user WHERE name = '$formName' LIMIT 1";
$result = mysqli_query ($db,$sql);

if($result){
  if (mysqli_num_rows ($result) > 0)
  {
    // Benutzerdaten in ein Array auslesen.
    $data = mysqli_fetch_array ($result,MYSQLI_ASSOC);

    $auth = password_verify($formPassword, $data['password']);

    if ($auth) {
      echo 'Correct password!';

          // Sessionvariablen erstellen und registrieren
        $_SESSION["user_id"] = $data["user_id"];
        $_SESSION["name"] = $data["name"];

    header ("Location: intern.php");
    } else {
        header ("Location: formular.php?fehler=1");
    }
  }
}
else
{
  header ("Location: formular.php?fehler=1");
}
?> 