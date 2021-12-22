<?php
  include_once '../model/UsersModel.php';
  include_once 'db.php';
  include_once 'Category.php';
  include_once '../model/OrderModel.php';
  include_once '../model/InformModel.php';

session_start(); 

?>
<!DOCKTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Beauty Formula</title>
        <link rel="icon" href="../images/logo1.png">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/auth.css">	
        <link rel="stylesheet" href="../css/lk.css">	
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>

    <body>
        <!-- Меню -->
			<nav>           
                <ul>
                    <li> <a href=""><img src="../images/logo.png" alt="logo.png" width="236" height="41"></a></li>
                    <li> <a href="../index.html" class="menu ">Главная</a></li>
                    <li> <a href="lk.php" class="menu ">Личный кабинет</a></li>
                    <li> <a href="catalog.php" class="menu ">Каталог</a></li>
                    <li> <a href="../html/contact.html" class="menu ">Контакты</a></li>
                    <li> <form action="../html/basket.html"><button class="button-korz">КОРЗИНА</button></form></li>
                </ul>
            </nav>
        <!-- Конец Меню -->
       
       <h2 id="zag" class="hidden" <?php session_start(); if($_SESSION['user']!=NULL){echo "style='display:inline;'";}?>> Ваши регистрационные данные: </h2>
     
       <div id="userBox" class="hidden" <?php session_start(); if($_SESSION['user']!=NULL){echo "style='display:inline;'";}?>>
            <h2 id="user"><?php session_start(); if($_SESSION['user']!=NULL){echo $_SESSION['user']['email'];}?></h2>
            <button class="btn_logout" type="button" onclick="logout();"> Выход </button>
        </div>
        <div id="regTable" class="hidden"  <?php session_start(); if($_SESSION['user']!=NULL){echo "style='display:inline;'";}?>>
       <table border="0">
       <tr>
        <td> Имя </td>
        <td><input class="up" type="text" id="newName" value="<?php session_start(); if($_SESSION['user']!=NULL){echo $_SESSION['user']['name'];}?>" /> </td>
       </tr>
       <tr>
        <td> Телефон </td>
        <td><input class="up" type="text" id="newPhone" value="<?php session_start(); if($_SESSION['user']!=NULL){echo $_SESSION['user']['phone'];}?>" /> </td>
       </tr>
       <tr>
        <td> Адрес </td>
        <td><textarea class="up" id="newAdress" value="" > <?php session_start(); if($_SESSION['user']!=NULL){echo $_SESSION['user']['adress'];}?> </textarea></td>
       </tr>
       <tr>
        <td> Новый пароль </td>
        <td><input class="up" type="password" id="newPwd1" value=""  /> </td>
       </tr>
       <tr>
        <td> Повтор пароля </td>
        <td><input class="up"  type="password" id="newPwd2" value="" /> </td>
       </tr>
       <tr>
        <td> Для того, чтобы сохранить данные, введите текущий пароль </td>
        <td><input  class="up" type="password" id="curPwd" value="" /> </td>
       </tr>
       <tr>
        <td>  </td>
        <td><input class="btn_save" type="button" id="curPwd" value="Сохранить изменения" onclick="updateUserData();"/> </td>
       </tr>
       </table>
        </div>
        
        
        <div class="login-box" id="login-box" <?php session_start(); if($_SESSION['user']!=NULL){echo "style='display:none;'";}?>> 
        
            <h2>Вход</h2>
            <form>
              <div class="user-box">
                <input type="text" id="loginEmail">
                <label>Пользователь</label>
              </div>
              <div class="user-box">
                <input type="password" id="loginPassword">
                <label>Пароль</label>
              </div>
              <button type="button" onclick="login();">
                <span> </span>
                <span> </span>
                <span> </span>
                <span> </span>
                Войти
              </button>
              
            </form>
          </div>
          <div class="reg-box" id="reg-box" <?php session_start(); if($_SESSION['user']!=NULL){echo "style='display:none;'";}?>>
            <h2>Регистрация</h2>
            <form>
              <div class="user-box" id="registerBox">
                <input type="text"  id="email">
                <label>Логин</label>
              </div>
              <div class="user-box">
                <input type="password"  id="password">
                <label>Пароль</label>
              </div>
              <div class="user-box">
                <input type="password"  id="password2">
                <label>Повторите пароль</label>
              </div>
              <button type="button" onclick="registerNewUser();">
                <span> </span>
                <span> </span>
                <span> </span>
                <span> </span>
                Зарегистрироваться
</button>
              
            </form>
          </div>
    
    <?php  
  
  $rsUserOrders = getCurUserOrders();
   if(!$rsUserOrders){
    
   }
   else {
    echo '<h2>Заказы: </h2>';
     echo '<table border ="1" cellpadding="1" cellspasing="1" class="table">';
     echo '<tr> <th>№</th> <th> Действие </th> <th> ID заказа </th> <th> Статус </th> <th> Дата создания </th> <th> Дополнительная информация </th> <th> Сумма </th></tr>';
    $i=0;
     foreach ( $rsUserOrders as $item) {
       $i++;
       echo '<tr><td>'.$i.'</td>';
       echo '<td> <a href="#" onclick="showProducts('.$item['id'].'); return false;">Показать детали заказа</a></td>';
       echo '<td>'.$item['id'].'</td>';
       echo '<td>'.$item['status'].'</td>';
       echo '<td>'.$item['date'].'</td>';
       echo '<td>'.$item['comment'].'</td>';
       echo '<td>'.$item['price'].'</td></tr>';
       if($item['children']){
        echo '<tr class="hidden" id="informForOrderId_'.$item['id'].'">';
        echo '<td colspan="7">';
         echo '<table border="1" cellpadding="1" width="100%">';
         echo '<tr> <th>№</th> <th> ID </th> <th> Название </th> <th> Цена </th> <th> Количество </th></tr>';
         $i=0;
         foreach ( $item['children'] as $itemChild) {
           $i++;
           echo '<td>'.$i.'</td>';
           echo '<td>'.$itemChild['prod_id'].'</td>';
           echo '<td> <a href="/php/card.php?prod_id='.$itemChild['prod_id'].'">'.$itemChild['name'].'</a></td>';
           echo '<td>'.$itemChild['price'].'</td>';
           echo '<td>'.$itemChild['amount'].'</td></tr>';
         } 
     
     }

       echo '</table>';
     }


     echo '</td></tr>';
    
   }?>
          <script src="../js/lk.js"></script>
          <script src="../js/order.js"></script>
    </body>
    </html>