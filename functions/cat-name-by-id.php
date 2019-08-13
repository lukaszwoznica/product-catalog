<?php
 
function categoryNameById($conn, $id){
    $cat_name = "";
    try{
        $stmt =  $conn->runQuery("SELECT cat_name FROM categories WHERE cat_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $cat_name = $row['cat_name'];
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    return $cat_name;
}
?>