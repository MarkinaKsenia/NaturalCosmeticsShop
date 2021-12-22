<?php
    include_once '../model/UsersModel.php';
    include_once 'db.php';
    include_once 'Category.php';

    session_start();

function loginAction(){
	$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $email = trim($email);
    
    $password= isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
    $password = trim($password);
	
	$userData = loginUser($email, $password);
	
	if($userData['success']){
       // $userData = $userData[0];

		$_SESSION['user'] = $userData;
		$_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];
		
		$resData = $_SESSION['user'];
		$resData['success'] = 1;
        
		//$resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
        //$resData['userEmail'] = $email;
		
    } else {
        $resData['success'] = 0; 
        $resData['message'] = 'Неверный логин или пароль'; 
    }
    
   echo json_encode($resData);
	
}

loginAction();

?>