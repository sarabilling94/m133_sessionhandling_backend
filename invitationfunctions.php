<?php
function deleteInvitation($sender, $receiver, $group, $db){
    $sql = "DELETE FROM tbl_invitation WHERE fk_sender = $sender
    AND fk_receiver = $receiver AND fk_group = $group";
    $result = mysqli_query ($db,$sql);

    if($result){
        return true;
    }
    return false;
}

?>