<?php 

function selectCategories($conn, $id)
{
    try {
        $stmt =  $conn->runQuery("SELECT cat_id, cat_name FROM categories ORDER BY cat_name ASC");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cat_id = $row['cat_id'];
            echo "<option value=\"$cat_id\" ";
                if($id == $cat_id) echo "selected";
            echo ">";
            echo $row['cat_name'];
            echo "</option>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>