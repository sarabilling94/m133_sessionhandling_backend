<?php
    function getTaskById($taskId, $db){
        $sql = "SELECT task FROM tbl_task WHERE id_task = $taskId";
    
        $result = mysqli_query ($db,$sql);
        if(!$result){
            return null;
        }
        if(mysqli_num_rows ($result) > 0){
            $data = mysqli_fetch_array ($result,MYSQLI_ASSOC);
            return $data["task"];
        }
    
        return null;
    }
?>