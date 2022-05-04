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

    //insert task
    $sqlInsertTask = "INSERT INTO tbl_task (task) VALUES ('$task')";
    $insertTaskResult = mysqli_query ($db,$sqlInsertTask);
    if(!$insertTaskResult){
        return http_response_code(422);
    }

    //get taskid
    $sqlGetTaskId = "SELECT id_task FROM tbl_task WHERE task = '$task'";
    $getTaskIdResult = mysqli_query ($db,$sqlGetTaskId);
    if(!$getTaskIdResult){
        return http_response_code(500);
    }
    $data = mysqli_fetch_array ($getTaskIdResult,MYSQLI_ASSOC);
    $taskId = $data["id_task"];

    $groupId = getGroupId($group, $db);
    $userId = getUserId($user, $db);

    //insert plan
    $sqlInsertPlan = "INSERT INTO tbl_plan (date, onetime_task, fk_user, fk_group, fk_task) 
    VALUES ('$date', null, $userId, $groupId, $taskId)";

    $insertPlanResult = mysqli_query ($db,$sqlInsertPlan);
    if($insertPlanResult){
        http_response_code(201);
    }
    else{
        http_response_code(422);
    }
}


?>