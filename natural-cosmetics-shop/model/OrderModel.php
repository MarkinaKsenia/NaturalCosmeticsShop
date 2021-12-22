<?php

function makeNewOrder($name, $phone, $adress)
{
    global $sql, $db, $rs;
    $userId		=	$_SESSION['user']['id'];
    $total = $_SESSION['total'];
	$comment	=	"id пользователя: {$userId} <br/>
					Имя: {$name} <br/>
					Тел: {$phone} <br/>
					Адрес: {$adress}";
				
	$dateCreated	= date('Y.m.d H:i:s');
	
	// формирование запроса к БД
	$sql = "INSERT INTO 
            orders (`user_id`, `date`, 
					 `status`, `comment`, `price`)  
           VALUES ('{$userId}', '{$dateCreated}', 
					'0', '{$comment}', '{$total}')";
	
    $rs = $db->query($sql);
   
   // получить id созданного заказа
   if($rs){
	   $sql = "SELECT id 
				FROM orders 
				ORDER BY id DESC 
				LIMIT 1";
	    $rs = $db->query($sql);
	   // преобразование результатов запроса
	   $mas = array();
    while ($row = $rs->fetch_assoc()) {
        $mas [$row['id']] = $row;
    }

	   // возвращаем id созданного запроса
	if(isset($mas[0])){
		   return $mas[0]['id'];
	   }
   }
   
    return $mas;

}



function getOrdersWithProductsByUser($userId)
{	 global $sql, $db, $rs;
	$userId = intval($userId);
	$sql = "SELECT * FROM orders
			WHERE `user_id` = '{$userId}'
			ORDER BY id DESC";
	
    $rs = $db->query($sql);

	$newRs = array();
    while ($row = $rs->fetch_assoc()) {

       	$rsChildren = getInformForOrder($row['id']);

        if($rsChildren){
            $row['children'] = $rsChildren;
			$newRs[] = $row;
        } 
    }
   
   return $newRs;	
    
}


?>