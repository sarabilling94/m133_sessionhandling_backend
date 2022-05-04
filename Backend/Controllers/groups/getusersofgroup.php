<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require 'groupfunctions.php';
require '../dtos/group.php';
require '../dtos/groupuser.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
          
    $groupName = mysqli_real_escape_string($db,$request->groupName);

    //echo "groupname: ", $groupName, "\n";
    $groupId = getGroupId($groupName, $db);
    //echo "groupid: ", $groupId, "\n";

    $group = getAllUsersOfGroup($groupId, $db);

    if(count($group->list_groupusers) > 0){
        echo json_encode($group);
    }
    else{
        http_response_code(404);
    }
}
