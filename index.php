<?php
  session_start();
  require_once("user_class.php");
  require_once("functions/cat-name-by-id.php");
  require_once("functions/select-products.php");

  define("NAVIGATION", true);
  define("ADMIN_PANEL", true);
  define("MODAL", true);

  $user = new User();

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
            else {
                $user_id = $_SESSION['user_session'];
                require_once('navigations/user_nav.php');
            }
          ?>

      <main>
        <div class="main-content">
          <div id="mainCarousel" class="carousel slide d-none d-lg-block" data-ride="carousel">
            <!-- Wskazniki -->
            <ol class="carousel-indicators">
              <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#mainCarousel" data-slide-to="1"></li>
              <li data-target="#mainCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Pojemnik na slajdy -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100 carousel-item-img" src="slides_img/slide1.jpg" alt="Slide1"
                  onerror="this.onerror=null;this.src='slides_img/empty-slide.png';" />
              </div>

              <div class="carousel-item">
                <img class="d-block w-100 carousel-item-img" src="slides_img/slide2.jpg" alt="Slide2"
                  onerror="this.onerror=null;this.src='slides_img/empty-slide.png';" />
              </div>

              <div class="carousel-item">
                <img class="d-block w-100 carousel-item-img" src="slides_img/slide3.jpg" alt="Slide3"
                  onerror="this.onerror=null;this.src='slides_img/empty-slide.png';" />
              </div>
            </div>

            <!-- Kontrolki prawo/lewo -->
            <a href="#mainCarousel" class="carousel-control-prev" data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="sr-only">Previous</span>
            </a>

            <a href="#mainCarousel" class="carousel-control-next" data-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="container">

            <section>
              <div class="section-header text-center">
                <h1>Najnowsze produkty</h1>
              </div>

              <div class="row">
                <?php 
                  selectLatestProducts($user);
                ?>
              </div>
            </section>

            <section>
              <div class="section-header text-center">
                <h1>Polecane kategorie</h1>
              </div>
              <div class="row">
                <div class="col-lg-3 col-sm-6">
                  <a href="products.php?cat_id=<?php echo $settings['category_1']; ?>">
                    <div class="card text-white bg-primary category-card">
                      <h3 class="card-title category-card-title">
                        <?php 
                        echo categoryNameById($user, $settings['category_1']); 
                      ?>
                      </h3>
                    </div>
                  </a>
                </div>

                <div class="col-lg-3 col-sm-6">
                  <a href="products.php?cat_id=<?php echo $settings['category_2']; ?>">
                    <div class="card text-white bg-secondary category-card">
                      <h3 class="card-title category-card-title">
                        <?php 
                          echo categoryNameById($user, $settings['category_2']); 
                        ?>
                      </h3>
                    </div>
                  </a>
                </div>

                <div class="col-lg-3 col-sm-6">
                  <a href="products.php?cat_id=<?php echo $settings['category_3']; ?>">
                    <div class="card text-white bg-info category-card">
                      <h3 class="card-title category-card-title">
                        <?php 
                          echo categoryNameById($user, $settings['category_3']); 
                        ?>
                      </h3>
                    </div>
                  </a>
                </div>

                <div class="col-lg-3 col-sm-6">
                  <a href="products.php?cat_id=<?php echo $settings['category_4']; ?>">
                    <div class="card text-white bg-dark category-card">
                      <h3 class="card-title category-card-title">
                        <?php 
                          echo categoryNameById($user, $settings['category_4']); 
                        ?>
                      </h3>
                    </div>
                </div>
                </a>
              </div>
            </section>
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
</body>

</html>