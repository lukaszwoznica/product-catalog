<?php
    require_once('../user_class.php');
    $user = new User();

    if (isset($_GET['user_id']) && intval($_GET['user_id']) != 0) {
        if (isset($_POST['userName'])) {
            $user_name = $_POST['userName'];
            $user_email = $_POST['userEmail'];
            $user_type = $_POST['userType'];
            echo $user_name;
            echo $user_email;
            echo $user_type;
            try {
                $stmt = $user->runQuery("SELECT user_name FROM users WHERE user_name = :nam AND user_id != :id");
                $stmt->execute(array(':nam' => $user_name, ':id' => $_GET['user_id']));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($row['user_name'] == $user_name) {
                    $name_error = true;
                    $user->redirectTo("../admin_users.php?name_error=$name_error");
                } else {
                    try {
                        $stmt = $user->runQuery("UPDATE users SET user_name=:nam, user_email=:mail, type_id=:utype WHERE user_id=:id");
                        $stmt->bindParam(":nam", $user_name);
                        $stmt->bindParam(":mail", $user_email);
                        $stmt->bindParam(":utype", $user_type);
                        $stmt->bindParam(":id", $_GET['user_id']);

                        if ($stmt->execute()) {
                            $result = true;
                            $user->redirectTo("../admin_users.php?update_result=$result");
                        } else {
                            $result = false;
                            $user->redirectTo("../admin_users.php?update_result=$result");
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