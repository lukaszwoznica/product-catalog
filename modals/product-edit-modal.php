<?php
    if(!defined("MODAL"))
        header('Location: ../index.php');
    try {
        $result =  $user->runQuery("SELECT prod_name, prod_desc, category_id, prod_price, prod_img FROM products WHERE prod_id = :id");
        $result->bindParam(":id", $_GET['prod_id']);
        $result->execute();
        $edit_prod_row = $result->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>


<div class="modal fade" id="editProductModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">Edytuj produkt</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


            <div class="modal-body">
                <form method="post" enctype="multipart/form-data"
                    action="admin/update_prod.php?prod_id=<?php echo $_GET['prod_id']; ?>">
                    <div class="form-group">
                        <label for="prodName">Nazwa produktu:</label>
                        <input type="text" class="form-control" id="prodName" name="prodName"
                            value="<?php echo $edit_prod_row['prod_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prodDesc">Opis:</label>
                        <textarea type="text" class="form-control" id="prodDesc"
                            name="prodDesc"><?php echo $edit_prod_row['prod_desc']; ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="prodCat">Kategoria:</label>
                            <select class="form-control" id="prodCat" name="prodCat">
                                <?php 
                                        try {
                                            $stmt =  $user->runQuery("SELECT cat_id, cat_name FROM categories ORDER BY cat_name ASC");
                                            $stmt->execute();
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $cat_id = $row['cat_id'];
                                                echo "<option value=\"$cat_id\" ";
                                                    if($cat_id == $edit_prod_row['category_id']) echo "selected";
                                                    echo ">";
                                                echo $row['cat_name'];
                                                echo "</option>";
                                            }
                                        } catch (PDOException $e) {
                                            echo $e->getMessage();
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="prodPrice">Cena:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <div class="input-group-text">PLN</div>
                                </div>
                                <input type="text" class="form-control" id="prodPrice" name="prodPrice"
                                    value="<?php echo $edit_prod_row['prod_price']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group custom-file">
                        <input type="file" class="form-control custom-file-input" id="prodImg" name="prodImg"
                            accept="image/*">
                        <label class="custom-file-label"for="prodImg" id="imgLabel"><?php echo $edit_prod_row['prod_img']; ?></label>
                    </div>
                    <div class="form-group">
                        <a href="admin/delete_prod_img.php?prod_id=<?php echo $_GET['prod_id']?>"><button type="button" class="btn btn-outline-danger btn-block">Usuń bieżące zdjęcie</button></a>                
                    </div>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </form>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
            </div>

        </div>
    </div>
</div>
