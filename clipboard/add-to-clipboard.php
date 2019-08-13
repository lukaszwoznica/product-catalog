<?php
    require_once('../user_class.php');
    $user = new User();
    $response = array();

    if(isset($_POST['prodId']) && isset($_POST['userId'])){
        try{
            $stmt = $user->runQuery("INSERT INTO clipboard (user_id, prod_id, quantity) VALUES (:u_id, :p_id, 1)");
            $stmt->bindParam("u_id", $_POST['userId']);
            $stmt->bindParam("p_id", $_POST['prodId']);
            if($stmt->execute()){
                $response['status'] = "success";
                $response['text'] = "Produkt został dodany do schowka!";
            }
        }
        catch(PDOException $e){
            $response['status'] = "error";
            $response['text'] = "Produkt znajduje się już w schowku!";
        }
        echo json_encode($response);
    }
?>
