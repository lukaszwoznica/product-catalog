<?php
    require_once('../user_class.php');
    $user = new User();
    $response = array();

    if(isset($_POST['rowId']) && isset($_POST['quantity'])){
        try{
            $stmt = $user->runQuery("UPDATE clipboard SET quantity=:qu WHERE id=:id");
            $stmt->bindParam("qu", $_POST['quantity']);
            $stmt->bindParam("id", $_POST['rowId']);
            if($stmt->execute());      
        }
        catch(PDOException $e){
            $response['status'] = "error";
            $response['text'] = "Nie udało się zapisać ilości!";
        }
        echo json_encode($response);
    }
?>
