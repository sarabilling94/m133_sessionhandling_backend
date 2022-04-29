<?php
session_start();
require 'connect.php';
require 'accesscontrol.php';

$iduser = $_SESSION["id_user"];

$sqlGetGroupIds = "SELECT * FROM tbl_groupuser WHERE fk_user = $iduser";

$groupsOfUserResult =  mysqli_query ($db,$sqlGetGroupIds);

if($groupsOfUserResult){
    $groupIdList = array();
    while($array = mysqli_fetch_array($groupsOfUserResult)){
        //echo "fk_group = ", $array['fk_group'], "\n";
        array_push($groupIdList,$array['fk_group']);
        echo count($groupIdList);
    }

    $firstGroup = array_values($groupIdList)[0];
    $sqlGetGroupsById = "SELECT * FROM tbl_group WHERE id_group = $firstGroup";

    for ($i = 1; $i < count($groupIdList); $i++){
        $nextGroup = array_values($groupIdList)[$i];
        $sqlGetGroupsById .= " OR id_group = $nextGroup";
    }

    echo $sqlGetGroupsById;

}
