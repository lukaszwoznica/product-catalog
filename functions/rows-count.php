<?php
    function countRows($conn, $query){
        try {
            $stmt =  $conn->runQuery("SELECT COUNT(*) as 'count' FROM {$query}");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'];
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>