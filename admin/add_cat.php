<?php
    require_once('../user_class.php');
    $user = new User();

    if(isset($_POST['catName'])){
        $name = $_POST['catName'];
        $desc = $_POST['catDesc'];
        
        try {
            $stmt = $user->runQuery("SELECT cat_name FROM categories WHERE cat_name=:nam");
            $stmt->execute(array(':nam' => $name));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row['cat_name'] == $name){
                $name_error = true;
                $user->redirectTo("../admin_categories.php?name_error=$name_error");
            }
            else{
                try {
                    $stmt = $user->runQuery("INSERT INTO categories (cat_name, cat_desc) VALUES (:nam, :des)");
                    $stmt->bindParam(":nam", $name);
                    $stmt->bindParam(":des", $desc);

                    if ($stmt->execute()) {
                        $result = true;
                        $user->redirectTo("../admin_categories.php?add_result=$result");
                    } else {
                        $result = false;
                        $user->redirectTo("../admin_categories.php?add_result=$result");
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