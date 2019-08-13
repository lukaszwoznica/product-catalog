<?php
    require_once('../user_class.php');
    $user = new User();
    define('MB', 1048576);

    if(isset($_POST['prodName'])){
        $name = $_POST['prodName'];
        $desc = $_POST['prodDesc'];
        $category = $_POST['prodCat'];
        $price = (float) $_POST['prodPrice'];
        $add_date = date('d-m-Y');
        $img = "products_img/no-image.png";

        if (is_uploaded_file($_FILES["prodImg"]["tmp_name"])) {
            $file_type = $_FILES["prodImg"]["type"];
            $allowed_types = array("image/jpeg", "image/gif", "image/png");
            
            if($_FILES["prodImg"]["size"] > 10 * MB){
                $img_size_error = true;        
            }
            else if (in_array($file_type, $allowed_types)){
                $stmt = $user->runQuery("SELECT prod_id FROM products ORDER BY prod_id DESC LIMIT 1");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if($stmt->rowCount() < 1)
                    $last_id = 1;
                else
                    $last_id = $row['prod_id'] + 1;
                
                $target_dir = "../products_img/";
                $new_img = $last_id . ".jpg";
                $target_file = $target_dir . $new_img;
                move_uploaded_file($_FILES["prodImg"]["tmp_name"], $target_file);
                $img = "products_img/" . $new_img;
            }
        }
        
        try {
            $stmt = $user->runQuery("SELECT prod_name FROM products WHERE prod_name=:nam");
            $stmt->execute(array(':nam' => $name));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row['prod_name'] == $name){
                $name_error = true;
                $user->redirectTo("../admin_products.php?name_error=$name_error");                
            }
            else{
                try {
                    $stmt = $user->runQuery("INSERT INTO products (prod_name, prod_desc, prod_img, add_date, category_id, prod_price) 
                                                    VALUES (:nam, :des, :img, :date, :cat, :pri)");
                    $stmt->bindParam(":nam", $name);
                    $stmt->bindParam(":des", $desc);
                    $stmt->bindParam(":img", $img);
                    $stmt->bindParam(":date", $add_date);
                    $stmt->bindParam(":cat", $category);
                    $stmt->bindParam(":pri", $price);
                    
                    if ($stmt->execute()) {
                        $result = true;
                        if($img_size_error){
                            $user->redirectTo("../admin_products.php?add_result=$result&img_size_error=$img_size_error");
                        }
                        else{
                            $user->redirectTo("../admin_products.php?add_result=$result");
                        }
                    } 
                    else {
                        $result = false;
                        $user->redirectTo("../admin_products.php?add_result=$result");
                    }
                } 
                catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    else {
        $user->redirectTo("../index.php");
    }
?>