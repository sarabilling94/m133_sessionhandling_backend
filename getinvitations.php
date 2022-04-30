<?php
session_start();
require 'connect.php';
require 'accesscontrol.php';
require 'groupfunctions.php';

class Invitation
{
    public $sender;
    public $group;
}

$iduser = $_SESSION["id_user"];

$sqlGetInvitations = "SELECT tbl_invitation.fk_group, tbl_user.name
FROM tbl_invitation
INNER JOIN tbl_user ON tbl_invitation.fk_sender = tbl_user.id_user
WHERE tbl_invitation.fk_receiver = $iduser";

$InvitationsResult =  mysqli_query ($db,$sqlGetInvitations);

if(mysqli_num_rows($InvitationsResult) > 0){
    $invitationList = array();
    while($data = mysqli_fetch_array($InvitationsResult)){   
        $nextInvitation = new Invitation();

        $groupId = $data["fk_group"];
        $groupName = getGroupName($groupId, $db);
        
        $nextInvitation->sender = $data["name"];
        $nextInvitation->group = $groupName;

        //echo "invitations: ", $nextInvitation->sender, "\n";

        array_push($invitationList,$nextInvitation);
    }
    echo json_encode($invitationList);
}
