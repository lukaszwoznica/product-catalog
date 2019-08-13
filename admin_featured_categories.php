<?php 
    require_once("session.php");
    require_once("user_class.php");
    require_once("functions/select-categories.php");
    require_once("functions/echo-alert.php");

    define("NAVIGATION", true);
    define("ADMIN_PANEL", true);
    define("MODAL", true);

    $user = new User();

	if (isset($_SESSION['user_type']) & $_SESSION['user_type'] != 1){
		header("location: index.php");
    }

    $cat_settings_file = "cfg/featured_categories_config.json";
    $settings = json_decode(file_get_contents($cat_settings_file), true);
    
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />

    <title>Katalog produktów</title>

    <meta name="description" content="Internetowy katalog produktów" />
    <meta name="keywords" content="katalog, produkty, online" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" />
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous">
    </script>
    <script src="js/sticky-nav.js"></script>
</head>

<body>
    <div class="wrapper">

        <?php
            if($user->isLoggedIn() && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){
                require_once('admin-panel.php');
            }
        ?>

        <div class="main-page">
            <header>
                <div class="jumbotron text-center">

                    <?php
                        if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
                        require_once('admin-panel-button.php');
                    }
                    ?>

                    <h1>Katalog Produktów</h1>

                </div>
            </header>

            <?php 
            if(!$user->isLoggedIn()){
              require_once('navigations/basic_nav.php');
            }
            else if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){
              require_once('navigations/admin_nav.php');
            }
            else 
              require_once('navigations/user_nav.php');
          ?>

            <main>
                <div class="main-content">
                    <div class="container">
                        <h2 class="page-title">Ustawienia polecanych kategorii</h2>
                        <?php
                        if(isset($_GET['update_result'])){
                            if ($_GET['update_result'] == true) {
                                echoAlert("success", "Sukces!", "Polecane kategorie zostały zaktualizowane!");
                            }
                            else {
                                echoAlert("danger", "Błąd!", "Nie udało się zaktualizować polecanych kategorii!");
                            }
                        }
                        ?>
                        <div class="col-6 mx-auto">
                        <div class="card card-body bg-light">
                        <form action="admin/update_featured_categories.php" method="post">
                            <div class="form-group">
                                <label for="featuredCat1">Polecana kategoria 1:</label>
                                <select class="custom-select" name="featuredCat1">
                                    <?php 
                                        selectCategories($user, $settings['category_1']);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="featuredCat2">Polecana kategoria 2:</label>
                                <select class="custom-select" name="featuredCat2">
                                    <?php 
                                        selectCategories($user, $settings['category_2']);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="featuredCat3">Polecana kategoria 3:</label>
                                <select class="custom-select" name="featuredCat3">
                                    <?php 
                                        selectCategories($user, $settings['category_3']);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="featuredCat4">Polecana kategoria 4:</label>
                                <select class="custom-select" name="featuredCat4">
                                    <?php 
                                        selectCategories($user, $settings['category_4']);
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Zapisz ustawienia</button>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer>
                <div class="footer text-center">
                    <div class="footer-social">
                        <a href="#"><i class="footer-social-icon fab fa-facebook-square"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-instagram"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-twitter-square"></i></a>
                        <a href="#"><i class="footer-social-icon fab fa-youtube-square"></i></a>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    <?php
      if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
        echo '<script src="js/admin-panel.js" type="text/javascript"></script>';
      }    
    ?>
    <?php if (isset($_GET['cat_id'])) { ?>
    <script type="text/javascript">
        $('#editCategoryModal').modal('show');
    </script>
    <?php
        }       
    ?>
</body>

</html>