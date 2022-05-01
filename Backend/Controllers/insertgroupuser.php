<?php
session_start();
require '../connect.php';
require '../utils/accesscontrol.php';
require '../utils/userfunctions.php';
require '../utils/invitationfunctions.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
          
    $groupName = mysqli_real_escape_string($db,$request->groupName);
    $groupId = getGroupId($groupName, $db);
    $senderName = mysqli_real_escape_string($db,$request->sender);
    $senderId = getUserId($senderName, $db);
    $iduser = $_SESSION["id_user"];

    $sqlInsert = "INSERT INTO tbl_groupuser (fk_group, fk_user, owner, coowner) 
    VALUES ($groupId,$iduser, 0, 0)";

    $insertResult = mysqli_query ($db,$sqlInsert);
    if($insertResult){
        deleteInvitation($senderId, $iduser, $groupId, $db);
        http_response_code(201);
    }
    else{
        http_response_code(500);
    }
}
?> 