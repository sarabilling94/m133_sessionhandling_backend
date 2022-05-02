<?php
session_start();
require '../../connect.php';
require '../../utils/accesscontrol.php';
require '../users/userfunctions.php';
require '../users/checkownerrights.php';
require 'invitationfunctions.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
     
    $receiverName = mysqli_real_escape_string($db,$request->receiverName);
    $groupName = mysqli_real_escape_string($db,$request->groupName);
    $senderId = $_SESSION["id_user"];

    $allowed = checkCoOwnerRights($groupName, $db);
    $userAlreadyInGroup = userIsInGroup($receiverName, $groupName, $db);
    $alreadyInvited = receivedInvitation($receiverName, $groupName, $db);

    if(($allowed == http_response_code(200)) && !$userAlreadyInGroup && !$alreadyInvited){
        $receiverId = getUserId($receiverName, $db);
        $groupId = getGroupId($groupName, $db);

        if($receiverId && $groupId){
            $sqlInsert = "INSERT INTO tbl_invitation (fk_sender,fk_receiver,fk_group) 
            VALUES ($senderId,$receiverId,$groupId)";

            $insertResult = mysqli_query ($db,$sqlInsert);
            if($insertResult){
                http_response_code(201);
                echo "Invitation sent";
            }
        }
        else{
            http_response_code(404);
            echo "User not found.";

        } 
    }
    else{
        http_response_code(401);
        echo "Unauthorized, person is already in group or person has already received invitation.";
    }
}
?> 