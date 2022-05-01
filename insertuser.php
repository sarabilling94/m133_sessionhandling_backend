<?php
require 'connect.php';
require 'userfunctions.php';
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
     
    $name = mysqli_real_escape_string($db,$request->name);
    $password = mysqli_real_escape_string($db,$request->password);
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT);

    $alreadyExists = userExists($name, $db);

    if(!$alreadyExists){
        $sql = "INSERT INTO tbl_user (name,password) VALUES ('$name','$hashedpassword')";
        if(mysqli_query($db,$sql)){
            http_response_code(201);
        }
        else{
             http_response_code(422); 
        }
    }
     else{
         http_response_code(409);
         echo "User already exists.";
     }    
}
?> 