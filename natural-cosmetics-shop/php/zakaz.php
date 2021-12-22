<?php

    include_once '../model/UsersModel.php';
    include_once 'db.php';
    include_once 'Category.php';
    include_once '../model/ProductsModel.php';

    session_start();

function orderAction (){

    $itemIds= array();

    if(isset ($_POST)){
        foreach ($_POST as $key=>$value){
            $itemIds[]  = $key;
        }
    }
    if(!$itemIds) {
        $itemIds = null;
        if(! $url) $url = '../html/basket.html';
        header("Location: {$url}"); 
        exit; 
        return;
    } 

    $itemsCnt = array();
    foreach ($itemIds as $item ){
        $postVar = $item;
        
        $itemsCnt[$item] = isset($_POST[$postVar]) ? $_POST[$postVar] : null;
    }

    $rs =  getProdFromArray($itemIds);

    $i=0;
    foreach($rs as &$item){
        $item['cnt'] = isset ($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
        if($item['cnt']){
            $item['realPrice'] = $item['cnt'] * $item['price'];
        }
        else {
            unset($rs[$i]);
        }
        $i++;
    }

    if(!$rs){
        echo "Корзина пуста";
        return;
    }

    $_SESSION['saleCart'] = $rs;

}

orderAction();

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Beauty Formula</title>
        <link rel="icon" href="../images/logo1.png">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/catalog_style.css">	
        <script src="https://code.jquery.com/jquery-2.2.4.js" charset="utf-8"></script>
        	
    </head>

    <body>
  
                <!-- Меню -->
			<nav>           
                <ul>
                    <li> <a href=""><img src="../images/logo.png" alt="logo.png" width="236" height="41"></a></li>
                    <li> <a href="../index.html" class="menu ">Главная</a></li>
                    <li> <a href="../php/lk.php" class="menu ">Личный кабинет</a></li>
                    <li> <a href="../php/catalog.php" class="menu ">Каталог</a></li>
                    <li> <a href="../php/contact.html" class="menu ">Контакты</a></li>
                    <li> <a href="" ><form action="../html/basket.html"><button class="button-korz">КОРЗИНА</button></form></a></li>
                </ul>
            </nav>
        <!-- Конец Меню -->
        

<?php  session_start(); 
 
if($_SESSION['user']){
    echo '<h2> Данные заказа </h2>';
 echo '<form id="frmOrder" action="order.php" method="POST">';
 echo ' <table><tr><td> №</td><td> Наименование</td><td> Количество</td> <td> Цена за единицу</td><td> Стоимость</td></tr>';   
    $i=0;
    $total = 0;
    foreach ( $_SESSION['saleCart'] as &$item) {
    $i++;
    echo '<tr><td> '.$i. '</td>';
    echo '<td> <a href="/php/card.php?prod_id='.$item['id'].'">'. $_SESSION['saleCart'][$item['id']]['name'].'</a></td>';
    echo '<td><span id="'.$item['id'].'"><input type="hidden" name="'.$item['id'].'" value="'.$item['cnt'].'"/>'.$item['cnt'].'</span></td>';
    echo '<td>'.$item['price'].'</td>';
    echo '<td>'.$item['realPrice'].'</td></tr>';
    $total += $item['price'] *$item['cnt'];
    
}

    echo '<tr><td></td><td></td><td></td><td> Итого:</td> <td>'.$total.'</td></tr></table>';
    $_SESSION['total']=$total;
    echo '<input type="button" id="buttonSaveOrder" value="Оплатить" onclick="saveOrder();"/>';
}
else {
    echo "<h3> ДЛЯ ОФОРМЛЕНИЯ ЗАКАЗА НЕОБХОДИМО ЗАРЕГИСТРИРОВАТЬСЯ ИЛИ АВТОРИЗОВАТЬСЯ В РАЗДЕЛЕ 'ЛИЧНЫЙ КАБИНЕТ' И ЗАПОЛНИТЬ ВСЕ ПОЛЯ ВВОДА";
}

 ?>



</form>
<script src="../js/order.js"></script>
    </body>
</html>