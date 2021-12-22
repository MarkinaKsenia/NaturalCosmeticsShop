<?php 

function print_arr ($array){
    echo "<pre>" . print_r ($array,true) . "</pre>";
}


function mapTree ($dataset){
    $tree = array();

    foreach ($dataset as $id => &$node){
        if (! $node ['parent_id']){
            $tree[$id] = &$node;
        }
        else {
            $dataset[$node['parent_id']]['childs'][$id] = &$node;
        }
    }
    return $tree;
}

function tplMenu($category,$str)
     {   
        if($category['parent_id'] == 0 ){
            if($category['id'] == 1 )
                $menu = '<li class = "nav_item"> <a href = "#skin" class = "nav__item__link">'.$category['category_name'].'</a>'; 
            if($category['id'] == 2 )
                $menu = '<li class = "nav_item"> <a href = "#body" class = "nav__item__link">'.$category['category_name'].'</a>'; 
            if($category['id'] == 3 )
                $menu = '<li class = "nav_item"> <a href = "#make" class = "nav__item__link">'.$category['category_name'].'</a>'; 
            if($category['id'] == 4 )
                $menu = '<li class = "nav_item"> <a href = "#acsses" class = "nav__item__link">'.$category['category_name'].'</a>'; 
         }else{   
            $menu = '<a href = "categoryController.php?category_id=' .$category['id']. '" class = "nav__submenu__link">'.$category['category_name'].'</a>';
         }
 
         if(isset($category['childs'])){

            if($category['id'] == 1 )
                $menu .= '<div id="skin" class="nav_submenu">';
            if($category['id'] == 2 )
                $menu .= '<div id="body" class="nav_submenu">';
            if($category['id'] == 3 )
                $menu .= '<div id="make" class="nav_submenu">';
            if($category['id'] == 4 )
                $menu .= '<div id="acsses" class="nav_submenu">';
            $i = 1;
            for($j = 0; $j < $i; $j++){
                $str .= '_';
            }         
            $i++;

            $menu .= showCat($category['childs'], $str);
            $menu .= '</div>';
        }
         return $menu;
     }

    /**
    * Рекурсивно считываем наш шаблон
    **/
    function showCat($data, $str){
        $string = '';
        $str = $str;
        foreach($data as $item){
            $string .= tplMenu($item, $str);
        }
        return $string;
    }


function getAllMainCatsWithChildren() {
    global $sql, $db, $rs;
      $sql = "SELECT * FROM categories ";
      $rs = $db->query($sql);

      $mas = array();
      while ($row = $rs->fetch_assoc()) {
          $mas [$row['id']] = $row;
      //  echo  $row['category_name'] . "<br />";
      }

      return $mas;
}

function getProd($id) {
    global $sql, $db, $rs;
      $sql = "SELECT * FROM products WHERE status=1 and category_id = " .$id;
      $rs = $db->query($sql);

      $mas = array();
      while ($row = $rs->fetch_assoc()) {
          $mas [$row['id']] = $row;
      //  echo  $row['category_name'] . "<br />";
      }

      return $mas;
}

