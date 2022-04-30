<?php
//echo $_SESSION["name"];

function getGroupId($groupName, $db){
    // session_start();
    // require 'connect.php';
    // require 'accesscontrol.php';

    $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname = '$groupName'";
    $groupIdResult =  mysqli_query ($db,$sqlGetGroupId);

    if($groupIdResult){
        $groupIdData = mysqli_fetch_array ($groupIdResult,MYSQLI_ASSOC);
        $groupId = $groupIdData["id_group"];

        return $groupId;
    }
    return null;
}