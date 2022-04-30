<?php
session_start();
require 'connect.php';
require 'accesscontrol.php';

//echo $_SESSION["name"];
 
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
    $groupName = $request->groupName;
    echo "groupName ", $groupName;

    $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname = '$groupName'";
    $groupIdResult =  mysqli_query ($db,$sqlGetGroupId);

    if($groupIdResult){
        $groupIdData = mysqli_fetch_array ($groupIdResult,MYSQLI_ASSOC);
        $groupId = $groupIdData["id_group"];
        $sqlGetOwner = "SELECT owner FROM tbl_groupuser WHERE fk_group = $groupId";

        $getOwnerResult = mysqli_query ($db,$sqlGetOwner);
        if($getOwnerResult){
            $ownerData = mysqli_fetch_array ($getOwnerResult,MYSQLI_ASSOC);
            $owner = $ownerData["owner"];

            if($owner){
                http_response_code(200);
            }
            else{
                http_response_code(401);
            }
        }
        else{
            http_response_code(401);
        }
    }
    else{
        http_response_code(401);
    }
}

?> 