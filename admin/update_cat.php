<?php
    require_once('../user_class.php');
    $user = new User();

    if (isset($_GET['cat_id']) && intval($_GET['cat_id']) != 0) {
        if (isset($_POST['catName'])) {
            $name = $_POST['catName'];
            $desc = $_POST['catDesc'];

            try {
                $stmt = $user->runQuery("SELECT cat_name FROM categories WHERE cat_name = :nam AND cat_id != :id");
                $stmt->execute(array(':nam' => $name, ':id' => $_GET['cat_id']));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($row['cat_name'] == $name) {
                    $name_error = true;
                    $user->redirectTo("../admin_categories.php?name_error=$name_error");
                } else {
                    try {
                        $stmt = $user->runQuery("UPDATE categories SET cat_name=:nam, cat_desc=:des WHERE cat_id=:id");
                        $stmt->bindParam(":nam", $name);
                        $stmt->bindParam(":des", $desc);
                        $stmt->bindParam(":id", $_GET['cat_id']);

                        if ($stmt->execute()) {
                            $result = true;
                            $user->redirectTo("../admin_categories.php?update_result=$result");
                        } else {
                            $result = false;
                            $user->redirectTo("../admin_categories.php?update_result=$result");
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            $user->redirectTo("../index.php");
        }
    }
    else {
        $user->redirectTo("../index.php");
    }
?>