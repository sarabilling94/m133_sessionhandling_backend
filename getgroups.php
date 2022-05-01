<?php
session_start();
require 'connect.php';
require 'accesscontrol.php';

$iduser = $_SESSION["id_user"];

$sqlGetGroupIds = "SELECT * FROM tbl_groupuser WHERE fk_user = $iduser";

$groupIdsResult =  mysqli_query ($db,$sqlGetGroupIds);

if(mysqli_num_rows($groupIdsResult) > 0){
    $groupIdList = array();
    while($array = mysqli_fetch_array($groupIdsResult)){
        //echo "fk_group = ", $array['fk_group'], "\n";
        array_push($groupIdList,$array['fk_group']);
        //echo count($groupIdList);
    }

    $firstGroup = array_values($groupIdList)[0];
    $sqlGetGroupsById = "SELECT * FROM tbl_group WHERE id_group = $firstGroup";

    for ($i = 1; $i < count($groupIdList); $i++){
        $nextGroup = array_values($groupIdList)[$i];
        $sqlGetGroupsById .= " OR id_group = $nextGroup";
    }

    $groupsResult = mysqli_query ($db,$sqlGetGroupsById);
    if(mysqli_num_rows($groupsResult) > 0){

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
    else{
        http_response_code(404);
    }

}
