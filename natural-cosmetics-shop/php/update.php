<?php
  include_once '../model/UsersModel.php';
    include_once 'db.php';
    include_once 'Category.php';

    session_start();

function updateAction (){

    $resData = array();
    $phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
    $adress = isset($_REQUEST['adress']) ? $_REQUEST['adress'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
    $pwd1 = isset($_REQUEST['pwd1']) ? $_REQUEST['pwd1'] : null;
    $pwd2 = isset($_REQUEST['pwd2']) ? $_REQUEST['pwd2'] : null;
    $curPwd = isset($_REQUEST['curPwd']) ? $_REQUEST['curPwd'] : null;

    $curPwdMD5 = md5 ($curPwd);
    if(! $curPwd || ($_SESSION['user']['password']!=$curPwdMD5)) 
    {
        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль не верный';
        echo json_encode($resData);
        return false;
    }

    $res = updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwdMD5);

    if($res) {
        $resData['success'] = 1;
        $resData ['message'] ='Данные сохранены';
        $resData['userName'] = $name;

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['adress'] = $adress;

        $newPwd = $_SESSION['user']['password'];
        if($pwd1 &&($pwd1 == $pwd2)){
            $newPwd = md5(trim($pwd1));
        }
        $_SESSION['user']['password'] = $newPwd;
        $_SESSION['user']['displayName'] = $name ? $name : $_SESSION['user']['email'];
    }
    else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка сохранения данных';
    }

    echo json_encode($resData);

}

updateAction();


?>