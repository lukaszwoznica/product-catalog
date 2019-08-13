<?php
    function echoAlert($type, $title, $message){
        $alert_type = NULL;
        switch ($type){
            case "success":
                $alert_type = "alert-success";
                break;
            case "danger":
                $alert_type = "alert-danger";
                break;
            case "warning":
                $alert_type = "alert-warning";
            default:
                break;
        }

        if(!is_null($alert_type)){
            echo "<div class=\"alert $alert_type alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                <strong>$title</strong> $message
            </div>";
        }
    }
?>