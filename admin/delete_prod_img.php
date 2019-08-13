<?php
    require_once('../user_class.php');
    $user = new User();
    $default_img = "products_img/no-image.png";

    if(isset($_GET['prod_id']) && intval($_GET['prod_id']) != 0){
        try {
            $stmt = $user->runQuery("UPDATE products SET prod_img = :img WHERE prod_id=:id");
            $stmt->bindParam(":img", $default_img);
            $stmt->bindParam(":id", $_GET['prod_id']);
            $stmt->execute();

            $file_to_delete = "../products_img/" . $_GET['prod_id'] . ".jpg";
            if(is_file($file_to_delete)){
                unlink($file_to_delete);
            }

            $user->redirectTo("../admin_products.php?prod_id=" . $_GET['prod_id']);
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    else{
        $user->redirectTo("../index.php");
    }
?>