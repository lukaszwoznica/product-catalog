<?php
    require_once('../user_class.php');
    $user = new User();
    define('MB', 1048576);

    if (isset($_GET['prod_id']) && intval($_GET['prod_id']) != 0) {
        if (isset($_POST['prodName'])) {
            $name = $_POST['prodName'];
            $desc = $_POST['prodDesc'];
            $category = $_POST['prodCat'];
            $price = $_POST['prodPrice'];

            $stmt = $user->runQuery("SELECT prod_img FROM products WHERE prod_id = :id");
            $stmt->execute(array(':id' => $_GET['prod_id']));
            $img_row = $stmt->fetch(PDO::FETCH_ASSOC);
            $new_img = $img_row['prod_img'];

            if (is_uploaded_file($_FILES["prodImg"]["tmp_name"])) {
                $target_file = "../" . $new_img;
                $file_type = $_FILES["prodImg"]["type"];
                $allowed_types = array("image/jpeg", "image/gif", "image/png");
        
                if ($_FILES["prodImg"]["size"] > 10 * MB) {
                    $img_size_error = true;
                } elseif (in_array($file_type, $allowed_types)) {
                    if ($img_row['prod_img'] == "products_img/no-image.png") {
                        $target_file = "../products_img/" . $_GET['prod_id'] . ".jpg";
                        $new_img = substr($target_file, 3);
                    }
                    
                    move_uploaded_file($_FILES["prodImg"]["tmp_name"], $target_file);
                }
            }

            
            try {
                $stmt = $user->runQuery("SELECT prod_name FROM products WHERE prod_name = :nam AND prod_id != :id");
                $stmt->execute(array(':nam' => $name, ':id' => $_GET['prod_id']));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($row['prod_name'] == $name) {
                    $name_error = true;
                    $user->redirectTo("../admin_products.php?name_error=$name_error");
                } else {
                    try {
                        $stmt = $user->runQuery("UPDATE products SET prod_name = :nam, prod_desc = :des, category_id = :cat, prod_price = :prc, prod_img = :img  WHERE prod_id = :id");
                        $stmt->bindParam(":nam", $name);
                        $stmt->bindParam(":des", $desc);
                        $stmt->bindParam(":id", $_GET['prod_id']);
                        $stmt->bindParam(":cat", $category);
                        $stmt->bindParam(":prc", $price);
                        $stmt->bindParam(":img", $new_img);

                        if ($stmt->execute()) {
                            $result = true;
                            if ($img_size_error) {
                                $user->redirectTo("../admin_products.php?update_result=$result&img_size_error=$img_size_error");
                            } else {
                                $user->redirectTo("../admin_products.php?update_result=$result");
                            }
                        } else {
                            $result = false;
                            $user->redirectTo("../admin_products.php?update_result=$result");
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }  
        }
        else {
            $user->redirectTo("../index.php");
        }
    }
    else {
        $user->redirectTo("../index.php");
    }
?>