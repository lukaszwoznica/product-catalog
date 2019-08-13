<?php
    session_start();
    require_once("user_class.php");
    require_once('functions/select-products.php');
    require_once("functions/cat-name-by-id.php");

    define("NAVIGATION", true);
    define("ADMIN_PANEL", true);
    define("MODAL", true);

    $user = new User();

    if(isset($_GET['prod_id']) && intval($_GET['prod_id']) != 0){
        $prod_id = $_GET['prod_id'];
    }
    else{
        $user->redirectTo("index.php");
    }
    if(isset($_SESSION['user_session'])){
        $user_id = $_SESSION['user_session'];
    }
    $product_row = selectProductDetails($user, $prod_id);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        let p_id = "<?= $prod_id; ?>";
        let u_id = "<?= $user_id; ?>";
    </script>
    <script src="js/add-to-clipboard.js"></script>
    <link rel="stylesheet" href="style.css" />
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js"
        integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous">
    </script>
    <script src="js/sticky-nav.js"></script>
    <?php
        if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
            echo '<script src="js/admin-panel.js" type="text/javascript"></script>';
        }
    ?>
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
            else {
              require_once('navigations/user_nav.php');
            }
          ?>

            <div class="container">
                <nav aria-label="breadcrumb">
                    <div class="d-flex justify-content-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="products.php?cat_id=<?php echo $product_row['category_id']; ?>">
                                    <?php echo $product_row['cat_name']; ?>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo $product_row['prod_name']; ?></li>
                        </ol>
                    </div>
                </nav>


                <main>
                    <div class="main-content">
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <img src="<?php echo $product_row['prod_img']; ?>" class="rounded float-left img" alt="..." style="max-width: 100%; max-height: 550px;">
                            </div>
                            <div class="col-sm-6">
                                <div >
                                    <h1><?php echo $product_row['prod_name']; ?></h1>
                                    <h2><?php echo $product_row['prod_price']; ?> zł</h2>
                                    <p><?php echo $product_row['prod_desc']; ?></p>
                                </div>
                                <button type="submit" id="addToClip" class="btn btn-info btn-lg" 
                                    <?php if(!$user->isLoggedIn()) echo "disabled
                                                                        data-toggle='tooltip' 
                                                                        data-placement='bottom' 
                                                                        title='Zaloguj się aby dodać produkt do schowka'"; ?>>
                                    Dodaj do schowka
                                </button>
                                
                            </div>

                        </div>
                    </div>
                </main>
            </div>

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
        if($user->isLoggedIn()){
            require_once("modals/add-to-clipboard-modal.php");
        }
    ?>
    <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    </script>

</body>

</html>