<?php
    require_once('../user_class.php');
    $user = new User();
    $result = 0;

    if (isset($_GET['slide_nr']) && intval($_GET['slide_nr']) != 0) {
        $slide_to_delete = "../slides_img/slide" . $_GET['slide_nr'] . ".jpg";
        if(is_file($slide_to_delete)){
            unlink($slide_to_delete);
            $result = true;
        }
    }

    $user->redirectTo("../admin_slides.php?del_result=$result");
?>