<?php
    require_once("session.php");
    require_once("user_class.php");
    require_once("functions/echo-alert.php");
 
    $user = new User();

    define("NAVIGATION", true);
    define("ADMIN_PANEL", true);
    define("MODAL", true);

    if(!$user->isLoggedIn()){
        $user->redirectTo("index.php");
    }
    else{
        $user_id = $_SESSION['user_session'];
        $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
        if($page <= 0) 
            $page = 1;

        $per_page = 10;
        $start_point = ($page * $per_page) - $per_page;
    }

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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="js/bootstrap-input-spinner.js"></script>
    <script src="js/clipboard-change-quantity.js"></script>
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

        <div class="main-page">
            <header>
                <div class="jumbotron text-center">
                    <h1>Katalog Produktów</h1>
                </div>

            </header>
            <?php require_once('navigations/user_nav.php'); ?>

            <main>
                <div class="main-content">
                    <div class="container">
                        <?php
                            if(isset($_GET['del_result'])){
                                    if($_GET['del_result'] == true){
                                        echoAlert("success", "Sukces!", "Produkt został usunięty ze schowka!");
                                    }
                                    else{
                                        echoAlert("danger", "Błąd", "Nie udało się usunąć produktu ze schowka!");
                                }
                            }
                        ?>
                       
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-dark">
                                       <tr>
                                            <th class="align-middle" style="width: 10%"></th>
                                            <th class="align-middle" style="width: 40%">Nazwa produktu</th>
                                            <th class="align-middle" style="width: 15%">Cena</th>
                                            <th class="align-middle" style="width: 15%">Ilość</th>
                                            <th class="align-middle" style="width: 15%">Wartość</th>
                                            <th class="align-middle" style="width: 5%">Usuń</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try {         
                                        $stmt =  $user->runQuery("SELECT id, prod_img, prod_name, prod_price, quantity
                                                                FROM clipboard
                                                                INNER JOIN products ON clipboard.prod_id = products.prod_id
                                                                WHERE clipboard.user_id = $user_id");                             
                                        $stmt->execute();  
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                        <tr>
                                            <td class="text-center align-middle">
                                                <img class="img-fluid img-thumbnail" style="min-width: 60px"
                                                    src="<?php echo $row['prod_img']; ?>">
                                            </td>
                                            <td class="align-middle">
                                                <p><?php echo $row['prod_name']; ?></p>
                                            </td>
                                            <td class="text-center align-middle">
                                                <p class="product-price"><?php echo $row['prod_price'] . " zł"; ?></p>

                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="input-group">
                                                    <?php $id = $row['id']; ?>
                                                    <input type="hidden" class="row-id" value="<?php echo $id;  ?>">
                                                    <input type="number" class="form-control"
                                                        value="<?php echo $row['quantity']; ?>" min="1">
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="product-value"></span> zł
                                            </td>
                                            <td class="text-center align-middle">
                                                <?php  
                                                echo "<a class=\"admin-panel-table-icon\" onclick=\"return confirm('Czy na pewno chcesz usunąć ten produkt ze schowka?')\" 
                                                      href=\"clipboard/delete-from-clipboard.php?rid=$id\">
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
                                    <tfoot style="background: #ededed;">
                                        <tr>
                                            <td colspan="6" class="text-center align-middle">
                                                Łączna wartość:
                                                <strong><span id="totalPrice"></span> zł</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        
                        <div class="row">
                            <a href="generate-pdf.php">
                                <button type="submit" class="btn btn-info" style="padding: 0.8rem;">
                                    <i class="far fa-file-pdf mr-1" style="font-size: 1.5rem;"></i> Wygeneruj kosztorys
                                    w PDF
                                </button>
                            </a>
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

    <script>
        $("input[type='number']").inputSpinner()
    </script>
</body>

</html>