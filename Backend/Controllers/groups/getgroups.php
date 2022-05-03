<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require 'groupfunctions.php';

$iduser = $_SESSION["id_user"];

$groupIdList = getGroupOfUser($iduser, $db);

if($groupIdList){
    $firstGroup = array_values($groupIdList)[0];
    $sqlGetGroupsById = "SELECT * FROM tbl_group WHERE id_group = $firstGroup";

    for ($i = 1; $i < count($groupIdList); $i++){
        $nextGroup = array_values($groupIdList)[$i];
        $sqlGetGroupsById .= " OR id_group = $nextGroup";
    }

    $groupsResult = mysqli_query ($db,$sqlGetGroupsById);
    if(!$groupsResult){
        http_response_code(500);
        die();
    }

    if(mysqli_num_rows($groupsResult) < 1){
        http_response_code(404);
        die();
    }

    $groupList = array();
    while($array = mysqli_fetch_array($groupsResult)){
        //echo "fk_group = ", $array['fk_group'], "\n";
        array_push($groupList,$array['groupname']);
        //echo "groupname: ", $array['groupname'], "\n";
    }

    if(count($groupList) > 0){
        echo json_encode($groupList);
    }
    else{
        http_response_code(404);
    }
}
