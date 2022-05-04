<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require '../users/userfunctions.php';
require 'taskfunctions.php';
require '../dtos/plan.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
        
    $groupName = mysqli_real_escape_string($db,$request->groupName);
    $groupId = getGroupId($groupName, $db);

    $sqlGetPlans = "SELECT fk_user, onetime_task, fk_task FROM tbl_plan WHERE fk_group = $groupId";

    $getPlansResult =  mysqli_query ($db,$sqlGetPlans);

    if(!$getPlansResult){
        http_response_code(422);
        die();
    }

    if(mysqli_num_rows($getPlansResult) > 0){
        $planList = array();
        while($array = mysqli_fetch_array($getPlansResult)){   
            $plan = new Plan();
            $userId = $array['fk_user'];
            $user = getUserName($userId, $db);

            $taskId = $array['fk_task'];
            $onetimetask = $array['onetime_task'];

            if($onetimetask){
                $plan->plan = $onetimetask;
                $plan->username = $user;
                array_push($planList, $plan);
            }
            else if($taskId){
                $task = getTaskById($taskId, $db);
                $plan->plan = $task;
                $plan->username = $user;
                array_push($planList, $plan);
            }
        }
        echo json_encode($planList);
    }
}
