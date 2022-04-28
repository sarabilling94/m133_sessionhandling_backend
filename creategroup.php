<?php
session_start();
require 'connect.php';
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
     
    $name = $request->name;

    $sqlCreateGroup = "INSERT INTO tbl_group (name) VALUES ('$name')";

    $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname=$name";
    $idgroup = $db->query($sqlGetGroupId);
    $iduser = $_SESSION["userid"];

    $sqlCreateGroupUser = 
    "INSERT INTO tbl_groupuser (fk_group, fk_user, owner, coowner) VALUES ('$idgroup', '$iduser', true, false)";
    //userid needs to be save as sessionvariable in login!

    if(mysqli_query($db,$sqlGroup)){
        http_response_code(201);
    }
    else{
         http_response_code(422); 
    }
         
}
?>