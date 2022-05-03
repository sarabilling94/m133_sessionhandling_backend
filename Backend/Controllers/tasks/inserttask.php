<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require '../groups/groupfunctions.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
     
    $task = mysqli_real_escape_string($db, $request->task);
    $date = mysqli_real_escape_string($db, $request->date);
    $group = mysqli_real_escape_string($db, $request->group);

    if((strlen($task) < 1) || (strlen($task) > 100)
    || !$group || !$date){
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
    $userId = $_SESSION["id_user"];

    // get groupuserid
    $sqlGetGroupUserId = "SELECT id_groupuser FROM tbl_groupuser WHERE 
    fk_group = $groupId AND fk_user = $userId";
    $getGroupUserIdResult = mysqli_query ($db,$sqlGetGroupUserId);
    if(!$getGroupUserIdResult){
        die();
        http_response_code(404);
    }
    $groupUserData = mysqli_fetch_array ($getGroupUserIdResult,MYSQLI_ASSOC);
    $groupUserId = $groupUserData["id_groupuser"];

    echo "date: ", $date, "\nuserid: ", $userId, "\ngroupuserid: ", $groupUserId, "\ntaskid: ", $taskId;

    //insert plan
    $sqlInsertPlan = "INSERT INTO tbl_plan (date, onetime_task, fk_user, fk_groupuser, fk_task) 
    VALUES ('$date', null, $userId, $groupUserId, $taskId)";

    $insertPlanResult = mysqli_query ($db,$sqlInsertPlan);
    if($insertPlanResult){
        http_response_code(201);
    }
    else{
        http_response_code(422);
    }
}


?>