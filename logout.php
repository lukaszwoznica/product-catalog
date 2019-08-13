<?php
    require_once("session.php");
    require_once("user_class.php");
    
    $user_logout = new User();

    if(isset($_GET['logout']) && $_GET['logout'] == "true"){
        $user_logout->logOut();
        $user_logout->redirectTo('index.php');
    }
?>