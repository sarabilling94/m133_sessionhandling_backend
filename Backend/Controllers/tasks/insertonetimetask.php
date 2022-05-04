<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require '../users/userfunctions.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
     
    $task = mysqli_real_escape_string($db, $request->task);
    $date = mysqli_real_escape_string($db, $request->date);
    $group = mysqli_real_escape_string($db, $request->group);
    $user = mysqli_real_escape_string($db, $request->user);

    if((strlen($task) < 1) || (strlen($task) > 100)
    || !$group || !$date || !$user){
        http_response_code(422);
        die();
    }

    $groupId = getGroupId($group, $db);
    $userId = getUserId($user, $db);

    $sqlGetGroupUserId = "SELECT id_groupuser FROM tbl_groupuser WHERE 
    fk_group = $groupId AND fk_user = $userId";
    $getGroupUserIdResult = mysqli_query ($db,$sqlGetGroupUserId);
    if(!$getGroupUserIdResult){
        die();
        http_response_code(404);
    }

    $groupUserData = mysqli_fetch_array ($getGroupUserIdResult,MYSQLI_ASSOC);
    $groupUserId = $groupUserData["id_groupuser"];

    $sqlInsert = "INSERT INTO tbl_plan (date, onetime_task, fk_user, fk_groupuser, fk_task) 
    VALUES ('$date', '$task', $userId, $groupUserId, null)";

    $insertResult = mysqli_query ($db,$sqlInsert);
        if($insertResult){
        return http_response_code(201);
    }
    else{
        return http_response_code(500);
    }
}


?>