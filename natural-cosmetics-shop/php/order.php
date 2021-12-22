<?php
    include_once '../model/UsersModel.php';
    include_once '../model/OrderModel.php';
    include_once '../model/InformModel.php';
    include_once 'db.php';
    include_once 'Category.php';

    session_start();

function saveorderAction()
 {
	$cart = isset($_SESSION['saleCart']) ? $_SESSION['saleCart'] : null;

	if(! $cart){
		$resData['success'] = 0; 
        $resData['message'] = 'Нет товаров для заказа'; 
		echo json_encode($resData);
		return;
	}
	
	$name	= $_SESSION['user']['name'];
	$phone	=  $_SESSION['user']['phone'];
	$adress =  $_SESSION['user']['adress'];
	
	$orderId = makeNewOrder($name, $phone, $adress);
	
	if(! $orderId){
		$resData['success'] = 0; 
       $resData['message'] = 'Ошибка создания заказа'; 
		echo json_encode($resData);
		return;
	} 

	foreach ($orderId as $key=>$value){
		$orderId  = $key;
	}

	// сохраняем товары для созданного заказа
	$res = setInformForOrder($orderId, $cart);

	
	// если успешно, то формируем ответ, удаляем переменные корзины
	if($res){
		$resData['success'] = 1; 
        $resData['message'] = 'Заказ сохранен';
		unset($_SESSION['saleCart']);
	} else {
        $resData['success'] = 0; 
        $resData['message'] = 'Ошибка внесения данных для заказа № ' . $orderId; 
	}
	
	echo json_encode($resData);
 }

    saveorderAction();

 ?>