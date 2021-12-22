<?php
session_start();


function logoutAction(){

    if($_SESSION['user']!=NULL){
        unset($_SESSION['user']);
    }

    echo json_encode($_SESSION);
    
}

logoutAction();

?>