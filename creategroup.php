<?php
session_start();
require 'connect.php';
require 'accesscontrol.php';

$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)){
    $request = json_decode($postdata);
     
     
    $name = mysqli_real_escape_string($db, $request->name);
    echo "name ", $name;

    $sqlCreateGroup = "INSERT INTO tbl_group (groupname) VALUES ('$name')";
    $createGroupResult = mysqli_query($db,$sqlCreateGroup);

    if($createGroupResult){ //group created
        $sqlGetGroupId = "SELECT id_group FROM tbl_group WHERE groupname = '$name'";

        $groupResult =  mysqli_query ($db,$sqlGetGroupId);

        if($groupResult){
            $groupData = mysqli_fetch_array ($groupResult,MYSQLI_ASSOC); //gets id_group

            $idgroup = $groupData["id_group"];
            $iduser = $_SESSION["id_user"];

            echo "id_group ", $idgroup;
            echo "id_user ", $iduser;

            $sqlCreateGroupUser = 
            "INSERT INTO tbl_groupuser (fk_group, fk_user, owner, coowner) VALUES ('$idgroup', '$iduser', 1, 0)";
        
            if(mysqli_query($db,$sqlCreateGroupUser)){
                http_response_code(201);
            }
            else{
                echo "groupuser wasnt created";
                http_response_code(422); 
            }
        }
        else{
            echo "groupid wasn't found";
            http_response_code(404); 
        }
    }
    else{
        echo "group wasn't created";
        http_response_code(422); 
    }       
}
    
?>