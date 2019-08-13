<?php
  session_start();
  require_once("user_class.php");
  require_once('functions/select-products.php');
  require_once('functions/pagination.php');
  require_once('functions/rows-count.php');
  require_once("functions/cat-name-by-id.php");

  define("NAVIGATION", true);
  define("ADMIN_PANEL", true);
  define("MODAL", true);

  $user = new User();

  if(isset($_GET['cat_id']) && intval($_GET['cat_id']) != 0){
    $cat_id = $_GET['cat_id'];
  }
  else{
    $user->redirectTo("index.php");
  }

  $sort_type = "new";
  $per_page = 12;

  if (isset($_GET['srt'])) {
      $sort_type = $_GET['srt'];
  }
  if (isset($_GET['dsp'])) {
    $per_page = $_GET['dsp'];
  }

  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if($page <= 0) 
      $page = 1;

  $start_point = ($page * $per_page) - $per_page;
  $statement = "products WHERE category_id = {$cat_id}";
  $total = countRows($user, $statement);
  if($start_point >= $total && $total != 0){
    $user->redirectTo("products.php?cat_id=$cat_id&srt=$sort_type&dsp=$per_page&page=1");
  }

  $category_name = categoryNameById($user, $cat_id);
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

      <div class="container">
        <nav aria-label="breadcrumb">
          <div class="d-flex justify-content-center">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $category_name; ?></li>
            </ol>
          </div>
        </nav>


        <main>
          <div class="main-content">
            <h1><?php echo $category_name ?></h1>
            <div class="row filters-row">
              <div class="filters-form-wrapper">
                <form class="form-inline" method="get" action="products.php?cat_id=<?php echo $cat_id; ?>">
                  <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                  <div class="form-group mb-2">
                    <label for="sortType">Sortuj:</label>
                    <select class="custom-select filters-select" name="srt">
                      <option value="new" <?php if($sort_type=="new") echo "selected"; ?>>Od najnowszego</option>
                      <option value="pasc" <?php if($sort_type=="pasc") echo "selected"; ?>>Po cenie rosnąco</option>
                      <option value="pdesc" <?php if($sort_type=="pdesc") echo "selected"; ?>>Po cenie malejąco</option>
                      <option value="az" <?php if($sort_type=="az") echo "selected"; ?>>Alfabetycznie A-Z</option>
                      <option value="za" <?php if($sort_type=="za") echo "selected"; ?>>Alfabetycznie Z-A</option>
                    </select>
                  </div>
                  <div class="form-group mx-md-3 mb-2">
                    <label for="showItemsNum">Pokaż na stronie:</label>
                    <select class="custom-select filters-select" name="dsp">
                      <option value="12" <?php if($per_page==12) echo "selected"; ?>>12</option>
                      <option value="24" <?php if($per_page==24) echo "selected"; ?>>24</option>
                      <option value="36" <?php if($per_page==36) echo "selected"; ?>>36</option>
                    </select>
                  </div>
                  <div class="form-group mb-2">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">
                    <button type="submit" class="btn btn-primary">Zastosuj</button>
                  </div>
                </form>
              </div>
            </div>
            <?php
              selectProducts($user, $cat_id, $sort_type, $start_point, $per_page);
            ?>
            <div class="row justify-content-center">
              <?php 
                echo pagination($user, $statement, $per_page, $page, $url="?cat_id=$cat_id&srt=$sort_type&dsp=$per_page&");
              ?>
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
      if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
        echo '<script src="js/admin-panel.js" type="text/javascript"></script>';
      }
  ?>

</body>

</html>