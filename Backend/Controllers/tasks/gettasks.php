<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require '../groups/groupfunctions.php';
require '../dtos/invitation.php';

$iduser = $_SESSION["id_user"];

$sqlGetPlans = "SELECT tbl_plan.fk_task, tbl_task.task FROM tbl_plan
INNER JOIN tbl_task ON tbl_plan.fk_task = tbl_task.id_task
WHERE fk_user = $iduser";

$getPlansResult =  mysqli_query ($db,$sqlGetPlans);

if(!$getPlansResult){
    http_response_code(422);
    die();
}

if(mysqli_num_rows($getPlansResult) > 0){
    $taskList = array();
    while($data = mysqli_fetch_array($getPlansResult)){   
        $task= $data["task"];
        if(!in_array($task, $taskList)){
            array_push($taskList, $task);
        }
    }
    echo json_encode($taskList);
}
