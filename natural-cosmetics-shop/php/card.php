<?php
    include_once 'Category.php';
    include_once 'db.php';
    include_once '../model/ProductsModel.php';
    
    $rsCategories = getAllMainCatsWithChildren();
    $cat_tree = mapTree($rsCategories);
    $cat_menu = showCat($cat_tree, '');
    $prod_inf = getInfo ($_GET['prod_id']);
    $prod_show = showCard($prod_inf , '');
?>

<!DOCKTYPE HTML>
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
                    <li> <a href="index.html" class="menu ">Главная</a></li>
                    <li> <a href="lk.php" class="menu ">Личный кабинет</a></li>
                    <li> <a href="catalog.php" class="menu ">Каталог</a></li>
                    <li> <a href="../html/contact.html" class="menu ">Контакты</a></li>
                    <li> <a href="" ><form action="../html/basket.html"><button class="button-korz">КОРЗИНА</button></form></a></li>
                </ul>
            </nav>
        <!-- Конец Меню -->
        
        <?php echo '<div class = "cat"> <ul class="no">'. $cat_menu .'</ul> </div>'; ?> 
        <?php echo '<div class = "card"> '. $prod_show .'</div>'; ?> 
        <script src="../js/basket.js"></script>
        
    </body>
    </html>