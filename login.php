<?php
session_start();

require 'connect.php';
require 'accesscontrol.php';
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){

  $request = json_decode($postdata);
          
  $formName = $request->name;
  $formPassword = $request->password;

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
          $_SESSION["id_user"] = $data["id_user"];
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
}
