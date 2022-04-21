<?php
session_start();

	include("connect.php");
	include("functions.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	//something was posted
	$name = $_POST["name"];
	$passwort = $_POST["passwort"];
	
	//read from DB
		$query = "SELECT * FROM tbl_user WHERE name = '$name' LIMIT 1";
		$result = mysqli_query($db,$query);
		if($result)
		{
			if($result && mysqli_num_rows($result) > 0){
			
				$user_data = mysqli_fetch_assoc($result);
			
				if ($user_data['passwort'] === $passwort){
					
					if(!empty($_POST['g-recaptcha-response']))
					{
					$secret = '6Le7TsgaAAAAANJeHQECCnRMdoVvOaoqCFpH6XSl';
					$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
					$responseData = json_decode($verifyResponse);
					if($responseData->success){
						$message = "g-recaptcha varified successfully";			
						$_SESSION['id_user'] = $user_data['id_user'];
						header("Location: index.php");
						die;
					}
						
					else{

						echo "<script type='text/javascript'>alert('Fehler ist aufgetreten.');</script>";

					}
					}
					else{
						echo "<script type='text/javascript'>alert('Lösen Sie bitte das Recaptcha');</script>";

					}
				}
				else{
					echo "<script type='text/javascript'>alert('User Name oder Passwort stimmt nicht.');</script>";

				}
				
			}
		}
}




?>

