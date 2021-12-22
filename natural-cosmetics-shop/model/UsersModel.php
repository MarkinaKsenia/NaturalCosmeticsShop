<?php

include_once 'OrderModel.php';
include_once 'InformModel.php';

session_start(); 

function registerNewUser ($email, $password, $name, $phone, $adress)
{
    session_start();
    $dblocation = "127.0.0.1";
    $dbname = "beauty_formula";
    $dbuser = "root";
    $dbpassword ="root";

    $db = new mysqli($dblocation, $dbuser, $dbpassword, $dbname);
    
    if ($db->connect_errno){
        echo "Ошибка доступа к MySQL";
        exit();

    }

    $email = htmlspecialchars($db->real_escape_string($email)); 
    $name  = htmlspecialchars($db->real_escape_string($name)); 
    $phone = htmlspecialchars($db->real_escape_string($phone));
    $adress= htmlspecialchars($db->real_escape_string($adress));

    $sql = "INSERT INTO users (`email`, `password`, `name`, `phone`, `adress`) 
            VALUES ('{$email}', '{$password}', '{$name}', '{$phone}', '{$adress}') ";
   
    $rs = $db->query($sql);


  if($rs){
        $sql = "SELECT * FROM users WHERE (`email` = '{$email}' and `password` = '{$password}')  LIMIT 1";

        $rs = $db->query($sql);

        $mas = array();
        while ($row = $rs->fetch_assoc()) {
            $mas = $row;
        }
        if (isset ($mas['id'])){
                $mas['success'] = 1;
        }
        else {
           $mas['success'] = 0;
        }
    }
    else {
        $mas['success'] = 0;
    }
    return $mas;
}

function checkRegisterParams ( $email, $password,  $password2 ) {
    $res = null;

    if (! $email){
        $res['success'] = 0;
        $res['message'] = 'Введите email';
    }

    if (! $password){
        $res['success'] = 0;
        $res['message'] = 'Введите пароль';
    }

    if (! $password2){
        $res['success'] = 0;
        $res['message'] = 'Повторите пароль';
    }
    
    if ($password != $password2){
        $res['success'] = 0;
        $res['message'] = "Пароли не совпадают ('{$password}') и ('{$password2}') ";
    }
    return $res;
}

function checkUserEmail ($email) {

    global $sql, $db, $rs;

    $email = $db->real_escape_string($email);
    $sql = "SELECT id FROM users WHERE email = '{$email}'";

    $rs = $db->query($sql);

    $mas = array();
        while ($row = $rs->fetch_assoc()) {
            $mas= $row;
        }
    
    return $mas;
}

function loginUser($email, $password)
{
    global $sql, $db, $rs;

    $email   = htmlspecialchars($db->real_escape_string($email)); 
    $password    = md5($password);
    
    $sql = "SELECT * FROM users  
            WHERE (`email` = '{$email}' and `password` = '{$password}')
            LIMIT 1";

    $rs = $db->query($sql);

    $mas = array();
        while ($row = $rs->fetch_assoc()) {
            $mas= $row;
    }

    if (isset ($mas['id'])){
        $mas['success'] = 1;
    }
    else {
        $mas['success'] = 0;
    }
    
   return $mas;
}

function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwd){

    global $sql, $db, $rs;

    $email = htmlspecialchars($db->real_escape_string($_SESSION['user']['email'])); 
    $name  = htmlspecialchars($db->real_escape_string($name)); 
    $phone = htmlspecialchars($db->real_escape_string($phone));
    $adress= htmlspecialchars($db->real_escape_string($adress));

    $pwd1 = trim($pwd1);
    $pwd2 = trim($pwd2);
    
    $newPwd = null;
    if($pwd1 && ($pwd1 == $pwd2)){
        $newPwd = md5 ($pwd1);
    }

    $sql = "UPDATE users SET ";

    if($newPwd) {
        $sql .=" `password` = '{$newPwd}', "; 
    }

    $sql .= "`name` = '{$name}', `phone` = '{$phone}', `adress`= '{$adress}' WHERE `email` ='{$email}' AND `password`= '{$curPwd}' LIMIT 1";

    $rs = $db->query($sql);

    return $rs;
}

function getCurUserOrders()
{
    $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
	$rs = getOrdersWithProductsByUser($userId);
   
	return $rs;
}

?>