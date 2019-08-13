<?php
    require_once('../user_class.php');
    $user = new User();
    if(isset($_GET['id']) && intval($_GET['id']) != 0 && isset($_GET['type'])){

        if($_GET['type'] == "cat"){
            try {
                $id = $_GET['id'];
                $stmt=$user->runQuery("DELETE FROM categories WHERE cat_id=:id");
                
                if($stmt->execute(array(':id'=>$id))){
                    $result = true;
                } else {
                    $result = false;
                }
                
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }

            $user->redirectTo("../admin_categories.php?del_result=$result");
        }

        else if($_GET['type'] == "prod"){
            $id = $_GET['id'];
            $have_img = false;
            try{
                $stmt=$user->runQuery("SELECT prod_img FROM products WHERE prod_id=:id");
                if ($stmt->execute(array(':id'=>$id))) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $prod_image = $row['prod_img'];
                    $reg_exp = "/no-image.png/";
                    if(!preg_match($reg_exp, $prod_image)){
                        $have_img = true;
                    }
                }
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }
            try {
                $stmt=$user->runQuery("DELETE FROM products WHERE prod_id=:id");
                if($stmt->execute(array(':id'=>$id))){
                    $result = true;
                    $prod_image = "../" . $prod_image;
                    if($have_img && is_file($prod_image)){
                        unlink($prod_image);
                    }
                } else {
                    $result = false;
                }
                
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }

            $user->redirectTo("../admin_products.php?del_result=$result");
        }

        else if($_GET['type'] == "usr"){
            try {
                $id = $_GET['id'];
                $stmt=$user->runQuery("DELETE FROM users WHERE user_id=:id");
                
                if($stmt->execute(array(':id'=>$id))){
                    $result = true;
                } else {
                    $result = false;
                }
                
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }

            $user->redirectTo("../admin_users.php?del_result=$result");
        }

        else {
            $user->redirectTo("../index.php");
        }
    }
    else {
        $user->redirectTo("../index.php");
    }
?>