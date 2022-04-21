<?php

function check_login($db){
	
	if(isset($_SESSION['id_user'])){
		$id = $_SESSION['id_user'];
		$query = "SELECT * FROM tbl_users WHERE id_user = '$id' limit 1";
		
		$result = mysqli_query($db, $query);
		if($result && mysqli_num_rows($result) > 0){
			
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}
	
	//redirect to Login
	header("Location: login.php");
	die;
}

function randomNumber($length) {
    $result = '';
    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}


