<?php
    include_once '../model/UsersModel.php';
    include_once 'db.php';
    include_once 'Category.php';

    session_start();

function registerAction (){
      $email = isset ($_REQUEST['email']) ? $_REQUEST['email'] : null;
     $email = trim ($email);

      $password = isset ($_REQUEST['password']) ? $_REQUEST['password'] : null;
      $password2 = isset ($_REQUEST['password2']) ? $_REQUEST['password2'] : null;

      $phone = isset ($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
      $adress = isset ($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
      $name = isset ($_REQUEST['name']) ? $_REQUEST['name'] : null;

      $name = trim ($name);

      $resData = null;
      $resData = checkRegisterParams ( $email, $password,  $password2 );
     
      if (! $resData && checkUserEmail ($email)){
        $resData ['success'] = false;
        $resData ['message'] = "Пользователь с таким email ('{$email}') уже зарегистрирован";
      }

      if (! $resData ){
        $pwdMD5 = md5($password);
        $userData = registerNewUser ($email, $pwdMD5, $name, $phone, $adress);
        if($userData['success']){
          $resData['message'] = 'Пользователь успешно зарегистрирован';
          $resData['success'] = 1;

          $userData = $userData[0];
          $resData['userName'] = $userData['name'] ? $userData['name'] : $userData['email'];
          $resData['userEmail'] = $email;

          $_SESSION['user'] = $userData;
          $_SESSION['user']['displayName'] = $userData['name'] ? $userData['name'] : $userData['email'];

        }
        else {
          $resData['success'] = 0;
          $resData['message'] = 'Ошибка регистрации';
        }
      }
      echo  print_r($resData);
      
     // echo json_encode($resData);
    }
    
   function logoutAction(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            unset($_SESSION['cart']);
    
        }
        
        redirect('/index.html');
    }

?>