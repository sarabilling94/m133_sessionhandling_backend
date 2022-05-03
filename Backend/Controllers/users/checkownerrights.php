<?php

function checkOwnerRights($groupName, $db){

    $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname = '$groupName'";

    $groupIdResult =  mysqli_query ($db,$sqlGetGroupId);
    if(!$groupIdResult){
        return false;
    }
    if(mysqli_num_rows($groupIdResult) < 1){
        return false;
    }

    $groupIdData = mysqli_fetch_array ($groupIdResult,MYSQLI_ASSOC);
    $groupId = $groupIdData["id_group"];
    $iduser = $_SESSION["id_user"];

    $sqlGetOwner = "SELECT owner FROM tbl_groupuser WHERE fk_group = $groupId AND fk_user = $iduser";

    $getOwnerResult = mysqli_query ($db,$sqlGetOwner);
    if(!$getOwnerResult){
        return false;
    }
    if(mysqli_num_rows($getOwnerResult) < 1){
        return false;
    }

    $ownerData = mysqli_fetch_array ($getOwnerResult,MYSQLI_ASSOC);
    $owner = $ownerData["owner"];

    if($owner){
        return true;
    }
}

//checks if user is at least coowner
function checkCoOwnerRights($groupName, $db){

    $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname = '$groupName'";
    
    $groupIdResult =  mysqli_query ($db,$sqlGetGroupId);
    if(!$groupIdResult){
        return false;
    }
    if(mysqli_num_rows($groupIdResult) < 1){
        return false;
    }

    $groupIdData = mysqli_fetch_array ($groupIdResult,MYSQLI_ASSOC);
    $groupId = $groupIdData["id_group"];
    $iduser = $_SESSION["id_user"];
    $sqlGetOwner = "SELECT owner, coowner FROM tbl_groupuser WHERE fk_group = $groupId AND fk_user = $iduser";

    $getOwnerResult = mysqli_query ($db,$sqlGetOwner);
    if(!$getOwnerResult){
        return false;
    }
    if(mysqli_num_rows($getOwnerResult) < 1){
        return false;
    }

    $ownerData = mysqli_fetch_array ($getOwnerResult,MYSQLI_ASSOC);
    $owner = $ownerData["owner"];
    $coowner = $ownerData["coowner"];

    if($owner || $coowner){
        return true;
    }
}

?> 