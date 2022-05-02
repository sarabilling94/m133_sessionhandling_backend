<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require 'groupfunctions.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
          
    $groupName = mysqli_real_escape_string($db,$request->groupName);

    $groupId = getGroupId($groupName, $db);

    $group = getAllUsersOfGroup($groupId, $db);

    if(count($group->list_groupusers) > 0){
        echo $group;
    }
    else{
        http_response_code(404);
    }
}
