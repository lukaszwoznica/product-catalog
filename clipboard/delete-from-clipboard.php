<?php
    require_once('../user_class.php');
    require_once('../session.php');
    $user = new User();

    if(isset($_GET['rid']) && intval($_GET['rid']) != 0 && isset($_SESSION['user_session'])){
        try{
            $stmt = $user->runQuery("SELECT user_id FROM clipboard WHERE id=:rid");
            $stmt->bindParam(":rid", $_GET['rid']);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['user_id'] == $_SESSION['user_session']){
                try{
                    $stmt = $user->runQuery("DELETE FROM clipboard WHERE id=:rid");
                    $stmt->bindParam(":rid", $_GET['rid']);
                    if($stmt->execute()){
                        $result = true;
                    }
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                    $result = 0;
                }
                $user->redirectTo("../clipboard.php?del_result=$result");
            }
            else{
                $user->redirectTo("../clipboard.php");    
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
            $user->redirectTo("../clipboard.php");
        }   
    }
    else{
        $user->redirectTo("../clipboard.php");
    }
?>
