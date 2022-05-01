<?php
require 'groupfunctions.php';

function getUserId($name, $db){
    $sql = "SELECT id_user FROM tbl_user WHERE name = '$name'";
    $result = mysqli_query ($db,$sql);

    if($result){
        $data = mysqli_fetch_array ($result,MYSQLI_ASSOC);
        return $data["id_user"];
    }
    return null;
}

function userIsInGroup($userName, $groupName, $db){
    $userId = getUserId($userName, $db);
    $groupId = getGroupId($groupName, $db);

    $sql = "SELECT * FROM tbl_groupuser WHERE fk_user = $userId
    AND fk_group = $groupId";

    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows ($result) > 0){
        return true;
    }
    return false;
}

function receivedInvitation($userName, $groupName, $db){
    $userId = getUserId($userName, $db);
    $groupId = getGroupId($groupName, $db);

    $sql = "SELECT * FROM tbl_invitation WHERE fk_receiver = $userId
    AND fk_group = $groupId";    

    $result = mysqli_query ($db, $sql);
    if(mysqli_num_rows ($result) > 0){
        return true;
    }
    return false;
}

function userExists($userName, $db){
    $sql = "SELECT * FROM tbl_user WHERE name = '$userName'";
    
    $result = mysqli_query ($db, $sql);
    if(mysqli_num_rows ($result) > 0){
        return true;
    }
    return false;
}

?>