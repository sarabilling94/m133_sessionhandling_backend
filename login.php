<?php
session_start();

require 'connect.php';
require("functions.php");
require 'accesscontrol.php';

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
      $auth = false;

      // Benutzerdaten in ein Array auslesen.
      $data = mysqli_fetch_array ($result,MYSQLI_ASSOC);

      $auth = password_verify($formPassword, $data['password']);

      if ($auth) {
        //echo 'Correct password!';

            // Sessionvariablen erstellen und registrieren
          $_SESSION["name"] = $data["name"];

          echo $_SESSION["name"];

          http_response_code(200);
      
      } else {
          http_response_code(403);
      }
      
    }
    else {
          http_response_code(403);
      }
  }
  else
  {
    http_response_code(403);
  }
}
