<?php
    require_once("../user_class.php");
    require( "../vendor/autoload.php" );

    define('MB', 1048576);
    $user = new User();
    $up_err = 0;
    $size_err = 0;

    if (is_uploaded_file($_FILES["slide1"]["tmp_name"])) {
        $file_type = $_FILES["slide1"]["type"];
        $allowed_types = array("image/jpeg", "image/gif", "image/png");
            
        if($_FILES["slide1"]["size"] > 15 * MB){
            $size_err = 1;        
        }
        else if (in_array($file_type, $allowed_types)){
            $target_file = "../slides_img/slide1.jpg";
            try {
                $imagine =  new Imagine\Gd\Imagine();
                $image = $imagine->open($_FILES["slide1"]["tmp_name"])
                            ->resize(new Imagine\Image\Box(1920, 500))
                            ->save($target_file);
            }
            catch(Imagine\Exception\Exception $e){
                echo $e->getMessage();
                $up_err = 1;
            }
        }
    }
    if (is_uploaded_file($_FILES["slide2"]["tmp_name"])) {
        $file_type = $_FILES["slide2"]["type"];
        $allowed_types = array("image/jpeg", "image/gif", "image/png");
            
        if($_FILES["slide2"]["size"] > 15 * MB){
            $size_err = 2;        
        }
        else if (in_array($file_type, $allowed_types)){
            try {
                $target_file = "../slides_img/slide2.jpg";
                $imagine =  new Imagine\Gd\Imagine();
                $image = $imagine->open($_FILES["slide2"]["tmp_name"])
                            ->resize(new Imagine\Image\Box(1920, 500))
                            ->save($target_file);
                            echo '2ok';
            }
            catch(Imagine\Exception\Exception $e){
                echo $e->getMessage();
                $up_err = 2;
            }
        }
    }
    if (is_uploaded_file($_FILES["slide3"]["tmp_name"])) {
        $file_type = $_FILES["slide3"]["type"];
        $allowed_types = array("image/jpeg", "image/gif", "image/png");
            
        if($_FILES["slide3"]["size"] > 15 * MB){
            $size_err = 3;        
        }
        else if (in_array($file_type, $allowed_types)){
            try {
                $target_file = "../slides_img/slide3.jpg";
                $imagine =  new Imagine\Gd\Imagine();
                $image = $imagine->open($_FILES["slide3"]["tmp_name"])
                            ->resize(new Imagine\Image\Box(1920, 500))
                            ->save($target_file);
                            echo '3ok';
            }
            catch(Imagine\Exception\Exception $e){
                echo $e->getMessage();
                $up_err = 3;
            }
        }
    }
    
    $user->redirectTo("../admin_slides.php?up_err=$up_err&size_err=$size_err");
    
?>