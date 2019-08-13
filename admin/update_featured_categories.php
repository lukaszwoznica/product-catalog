<?php
    if (isset($_POST['featuredCat1'])) {
        $cat_1 = $_POST['featuredCat1'];
        $cat_2 = $_POST['featuredCat2'];
        $cat_3 = $_POST['featuredCat3'];
        $cat_4 = $_POST['featuredCat4'];

        $cat_settings_file = "../cfg/featured_categories_config.json";
        $settings = json_decode(file_get_contents($cat_settings_file), true);

        if ($settings === null){
            header("Location: ../admin_featured_categories.php?update_result=0");
            exit();
        }

        $settings['category_1'] = $cat_1;
        $settings['category_2'] = $cat_2;
        $settings['category_3'] = $cat_3;
        $settings['category_4'] = $cat_4;
    
        $updated_settings = json_encode($settings);
        file_put_contents($cat_settings_file, $updated_settings);

        header("Location: ../admin_featured_categories.php?update_result=1");

    }
?>