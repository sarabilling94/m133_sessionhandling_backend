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

function getGroupOfUser($iduser, $db){
    $sqlGetGroupIds = "SELECT * FROM tbl_groupuser WHERE fk_user = $iduser";

    $groupIdsResult =  mysqli_query ($db,$sqlGetGroupIds);

    if(mysqli_num_rows($groupIdsResult) > 0){
        $groupIdList = array();
        while($array = mysqli_fetch_array($groupIdsResult)){
            array_push($groupIdList,$array['fk_group']);
        }
        return $groupIdList;
    }
    return null;
}

function getGroupUserId($idgroup, $db){
    $sqlGetGroupUserId = "SELECT id_groupuser FROM tbl_groupuser WHERE fk_group = $idgroup";

    $groupUserIdResult =  mysqli_query ($db,$sqlGetGroupUserId);

    if(mysqli_num_rows($groupUserIdResult) > 0){
        $groupUserIdData = mysqli_fetch_array ($groupUserIdResult,MYSQLI_ASSOC);
        $groupUserId = $groupUserIdData["id_groupuser"];
        return $groupUserId;
    }
    return null;
}

function getAllUsersOfGroup($idgroup, $db){
    $sqlGetUsers = "SELECT tbl_groupuser.fk_user, tbl_groupuser.owner, tbl_groupuser.coowner, tbl_user.name 
    FROM tbl_groupuser
    INNER JOIN tbl_user on tbl_groupuser.fk_user = tbl_user.id_user
    WHERE fk_group = $idgroup";

    $groupUsersResult =  mysqli_query($db,$sqlGetUsers);

    if(mysqli_num_rows($groupUsersResult) > 0){
        $group = new Group();
        $groupUserList = array();
        while($array = mysqli_fetch_array($groupUsersResult)){
            $user = new GroupUser();
            $user->id_user = $array['fk_user'];
            $user->username = $array['name'];
            $user->owner = $array['owner'];
            $user->coowner = $array['coowner'];

            array_push($groupUserList,$user);
        }
        $group->groupname = getGroupName($idgroup, $db);
        $group->id_group = $idgroup;
        $group->list_groupusers = $groupUserList;

        return $group;
    }
    return null;
}

function groupAlreadyExists($groupname, $db){
    $sql = "SELECT * FROM tbl_group WHERE groupname = '$groupname'";
    $result = mysqli_query ($db,$sql);
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    return false;
}