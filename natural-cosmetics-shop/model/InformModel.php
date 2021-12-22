<?php

session_start(); 

function setInformForOrder($orderId, $cart)
{
    global $sql, $db, $rs;
	$sql = "INSERT INTO inform
			(order_id, prod_id, price, amount) 
			VALUES ";
	
	$values = array();
	foreach ($cart as $item) {
		$values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
	}
	
	// преобразовываем массив в строку
	$sql .= implode(', ',$values );
    $rs = $db->query($sql);
   
	 return $sql; 
}


function getInformForOrder($orderId)
{
    global $sql1, $db, $rs1;
    $sql1 = "SELECT `pe`.*, `ps`.`name` 
            FROM inform as `pe`
            JOIN products as `ps` ON `pe`.prod_id = `ps`.id
            WHERE `pe`.order_id = {$orderId}";
   
   $rs1 = $db->query($sql1);

   $mas = array();
   while ($row1 = $rs1->fetch_assoc()) {
       $mas [] = $row1;
   }

    return $mas; 

}


?>