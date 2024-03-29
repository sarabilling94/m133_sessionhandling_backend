<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require '../users/checkownerrights.php';
require 'groupfunctions.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
        
    $groupName = mysqli_real_escape_string($db,$request->groupName);

    $allowed = checkOwnerRights($groupName, $db);
    if(!$allowed){
       http_response_code(403);
       die();
    }

    $groupId = getGroupId($groupName, $db);

    $sqlDeleteGroup = "DELETE FROM tbl_groupuser WHERE fk_group = $groupId";
    $sqlDeleteGroup2 = "DELETE FROM tbl_group WHERE id_group = $groupId";

    $deleteGroupResult = mysqli_query ($db,$sqlDeleteGroup);
    $deleteGroupResult2 = mysqli_query ($db,$sqlDeleteGroup2);

    if($deleteGroupResult && $deleteGroupResult2){
        http_response_code(202); //"Accepted"
    }   
}
?>