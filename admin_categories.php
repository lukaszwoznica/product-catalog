<?php 
    require_once("session.php");
    require_once("user_class.php");
    require_once("functions/pagination.php");
    require_once("functions/echo-alert.php");

    define("NAVIGATION", true);
    define("ADMIN_PANEL", true);
    define("MODAL", true);

    $user = new User();

	if (isset($_SESSION['user_type']) & $_SESSION['user_type'] != 1){
		header("location: index.php");
    }

    $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
    if($page <= 0) 
        $page = 1;

    $per_page = 10;
    $start_point = ($page * $per_page) - $per_page;
    $statement = "categories ORDER BY cat_id DESC";
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
                        <h2 class="page-title">Zarządzenie kategoriami</h2>
                        <?php
                            if(isset($_GET['name_error'])){
                                echoAlert("danger", "Błąd!", "Kategoria o podanej nazwie już istnieje!");
                            }
                            else if(isset($_GET['add_result'])){
                                if ($_GET['add_result'] == true) {
                                    echoAlert("success", "Sukces!", "Nowa kategoria została dodana!");
                                }
                                else {
                                    echoAlert("danger", "Błąd!", "Nie udało się dodać nowej kategorii!");
                                }
                            }
                            else if(isset($_GET['del_result'])){
                                if($_GET['del_result'] == true){
                                    echoAlert("success", "Sukces!", "Kategoria została usunięta!");
                                }
                                else{
                                    echoAlert("danger", "Błąd", "Nie udało się usunąć kategorii");
                                }
                            }
                            else if(isset($_GET['update_result'])){
                                if($_GET['update_result'] == true){
                                    echoAlert("success", "Sukces!", "Kategoria została zaktualizowana!");
                                }
                                else{
                                    echoAlert("danger", "Błąd!", "Nie udało się zaktualizować kategorii!");
                                }
                            }     
                        ?>

                        <button type="button" class="btn btn-primary add-btn" data-toggle="modal"
                            data-target="#addCategoryModal">Dodaj
                            kategorię</button>


                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="align-middle" style="width: 10%">ID</th>
                                        <th class="align-middle" style="width: 30%">Nazwa kategorii</th>
                                        <th class="align-middle" style="width: 50%">Opis</th>
                                        <th class="align-middle" style="width: 5%">Edytuj</th>
                                        <th class="align-middle" style="width: 5%">Usuń</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                try {         
                                   
                                    $result =  $user->runQuery("SELECT * FROM {$statement} LIMIT {$start_point},{$per_page}");                             
                                    $result->execute();  
                                    while($row = $result->fetch(PDO::FETCH_ASSOC)){

                            ?>
                                    <tr>
                                        <td class="text-center align-middle">
                                            <?php echo $row['cat_id']; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $row['cat_name']; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php echo $row['cat_desc']; ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php 
                                                $id = $row['cat_id'];
                                                if (isset($_GET['page']) && intval($_GET['page']) != 0) {
                                                    echo "<a class=\"admin-panel-table-icon\" href=\"admin_categories.php?page=$page&cat_id=$id\">
                                                        <i class=\"fas fa-edit\"></i>
                                                      </a>"; 
                                                }
                                                else {
                                                    echo "<a class=\"admin-panel-table-icon\" href=\"admin_categories.php?cat_id=$id\">
                                                        <i class=\"fas fa-edit\"></i>
                                                      </a>";
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php 
                                                $type = "cat";     
                                                echo "<a class=\"admin-panel-table-icon\" onclick=\"return confirm('Czy na pewno chcesz usunąć tą kategorię?')\" 
                                                      href=\"admin/delete.php?id=$id&type=$type\">
                                                            <i class=\"fas fa-trash-alt\"></i>
                                                        </a>";     
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                    }
                                }
                                
                                catch (PDOException $e){
                                    echo $e->getMessage();
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <?php 
                            echo pagination($user, $statement, $per_page, $page, $url='?');
                        ?>
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

    <div class="modal fade" id="addCategoryModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title">Dodaj nową kategorię</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>


                <div class="modal-body">
                    <form method="post" action="admin/add_cat.php">
                        <div class="form-group">
                            <label for="catName">Nazwa kategorii:</label>
                            <input type="text" class="form-control" id="catName" name="catName" required>
                        </div>
                        <div class="form-group">
                            <label for="catDesc">Opis:</label>
                            <textarea type="text" class="form-control" id="catDesc" name="catDesc"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Dodaj</button>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
                </div>

            </div>
        </div>
    </div>

    <?php 
        if(isset($_GET['cat_id']) && intval($_GET['cat_id']) != 0){
            require_once('modals/category-edit-modal.php');?>
    <script type="text/javascript">
        $('#editCategoryModal').modal('show');
    </script><?php
        }
        if($user->isLoggedIn() && $_SESSION['user_type'] == 1){
            echo '<script src="js/admin-panel.js" type="text/javascript"></script>';
          }    
    ?>

</body>

</html>