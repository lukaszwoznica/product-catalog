<?php

function selectNavCategories($user){
    try {
        $result =  $user->runQuery("SELECT cat_id, cat_name FROM categories ORDER BY cat_name ASC");
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $cat_id = $row['cat_id'];
            echo "<a class=\"dropdown-item\" href=\"products.php?cat_id=$cat_id\">";
            echo $row['cat_name'];
            echo "</a>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
