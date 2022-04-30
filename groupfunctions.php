<?php
//echo $_SESSION["name"];

function getGroupId($groupName, $db){
    $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname = '$groupName'";
    $groupIdResult =  mysqli_query ($db,$sqlGetGroupId);

    if($groupIdResult){
        $groupIdData = mysqli_fetch_array ($groupIdResult,MYSQLI_ASSOC);
        $groupId = $groupIdData["id_group"];

        return $groupId;
    }
    return null;
}

function getGroupName($groupId, $db){
    $sqlGetGroupName = "SELECT groupname FROM tbl_group WHERE id_group = $groupId";
    $groupNameResult =  mysqli_query ($db,$sqlGetGroupName);

    if(mysqli_num_rows($groupNameResult) > 0){
        $groupNameData = mysqli_fetch_array ($groupNameResult,MYSQLI_ASSOC);
        $groupName = $groupNameData["groupname"];

        return $groupName;
    }
    return null;
}