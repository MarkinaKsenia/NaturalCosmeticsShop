<?php
    function getLastProducts ($limit = null){
        global $sql, $db, $rs;
        $sql = "SELECT *
                FROM `products`
                WHERE status = 1
                ORDER BY id DESC";

        if ($limit) {
            $sql  = $sql.  " LIMIT {$limit} " ;
        }

        $rs = $db->query($sql);

        $mas = array();
        while ($row = $rs->fetch_assoc()) {
            $mas [$row['id']] = $row;
        //  echo  $row['category_name'] . "<br />";
        }
  
        return $mas;
    }

    function tplProd($products,$str)
     {   
            $prod = '<li class = "prod-elem"> <a href="card.php?prod_id=' .$products['id'].'"class = "prod-elem__name" >' .$products['name'].'</a>';
            $prod .= '<img class = "prod-elem__img" src = "../images/' .$products['image']. '" >';
            $prod .= '<span class = "prod-elem__price" >' .$products['price'].' руб. </span>';
            $prod .= '<button class = "prod-elem__btn" data-id = "'.$products['id'].'">Добавить в корзину </button> </li> ';
         return $prod;
     }
     


    /**
    * Рекурсивно считываем наш шаблон
    **/

    function showProd($data, $str){
        $string = '';
        $str = $str;
        foreach($data as $item){
            $string .= tplProd($item, $str);
        }
        return $string;
    }

function getInfo ($id){
    global $sql, $db, $rs;
    $sql = "SELECT * FROM products WHERE id =  " .$id;
    $rs = $db->query($sql);

    $mas = array();
    while ($row = $rs->fetch_assoc()) {
        $mas [$row['id']] = $row;
    //  echo  $row['category_name'] . "<br />";
    }

    return $mas;
}


function getAllProd (){
    global $sql, $db, $rs;
    $sql = "SELECT * FROM products";
    $rs = $db->query($sql);

    $mas = array();
    while ($row = $rs->fetch_assoc()) {
        $mas [$row['id']] = $row;
    }

    file_put_contents('data.json', json_encode($mas, JSON_UNESCAPED_UNICODE));
}


function tplCard($products,$str)
{   
       $card = '<li class = "prod-card"> <h1 class="name_prod">' .$products['name'].'</h1>';
       $card .= '<img class = "prod-card__img" src = "../images/' .$products['image']. '" >';
       $card.= '<span class = "prod-card__price1" > Цена: </span>';
       $card.= '<span class = "prod-card__price" >' .$products['price'].' руб. </span>';
       $card .= '<button class = "prod-card__btn" data-id="' .$products['id'].'" >Добавить в корзину </button> </li> ';
       $card.= '<div class = "desc"><span class = "prod-card__desc" > Описание: <br> ' .$products['description'].'<br> </span> </div>';
       $card.= '<div class = "compos"> <span class = "prod-card__comp" > Состав: <br>' .$products['compos'].' </span> </div>';
       $card.= '<div class = "man"> <span class = "prod-card__man" > Производитель: <br> ' .$products['manufact'].' </span> </div> ';
       
    return $card;
}

function showCard($data, $str){
    $string = '';
    $str = $str;
    foreach($data as $item){
        $string .= tplCard($item, $str);
    }
    return $string;
}

function getProdFromArray($itemIds){
    global $sql, $db, $rs;
    $strIds = implode(', ', $itemIds);
    $sql = "SELECT * FROM products WHERE id in ({$strIds})";
    $rs = $db->query($sql);

    $mas = array();
    while ($row = $rs->fetch_assoc()) {
        $mas [$row['id']] = $row;
    }

    return $mas;
    
}


