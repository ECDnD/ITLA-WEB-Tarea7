<?php
//Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();
//GET
if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    $stmt = $objUser -> runQuery("SELECT * FROM productos WHERE codigo = :codigo");
    $stmt -> execute(array(":codigo" => $codigo));
    $rowUser = $stmt -> fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $rowUser = null;
}

//POST
if(isset($_POST['btn_save'])){
    $name = strip_tags($_POST['nombre']);
    $name = strip_tags($_POST['descripcion']);
    $name = strip_tags($_POST['costo']);
    $name = strip_tags($_POST['existencia']);
    $name = strip_tags($_POST['suplidor']);

    try{
        if($codigo != null){
            if($objUser -> update($codigo, $nombre, $descripcion, $costo, $existencia, $suplidor)){
                $objUser -> redirect('index.php?updated');
            }
        } else{
            if($objUser -> insert($nombre, $descripcion, $costo, $existencia, $suplidor)){
                $objUser -> redirect('index.php?inserted');
            } else {
                $objUser -> redirect('index.php?error');
            }
        }
    } catch(PDOException $e){
        echo $e -> getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Head metas, css, and title -->
        <?php require_once 'includes/head.php'; ?>
    </head>
    <body>
        <!-- Header banner -->
        <?php require_once 'includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar menu -->
                <?php require_once 'includes/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <h1 style="margin-top: 10px">Add / Edit Users</h1>
                    <form method="post">
                        <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input class="form-control" type="text" name="codigo" id="codigo" value="<?php print($rowUser['codigo'])?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Inserte nombre del producto" value="<?php print($rowUser['nombre'])?>" required maxlength="200">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Inserte descripción del producto" value="<?php print($rowUser['descripcion'])?>" required>
                        </div>
                        <div class="form-group">
                            <label for="costo">Costo</label>
                            <input class="form-control" type="number" name="costo" id="costo" placeholder="Inserte costo del producto" value="<?php print($rowUser['costo'])?>" required maxlength="11">
                        </div>
                        <div class="form-group">
                            <label for="existencia">Existencia</label>
                            <input class="form-control" type="radio" id="existencia_si" name="existencia" value="Si">
                            <label for="html">Si</label>
                            <input class="form-control" type="radio" id="existencia_no" name="existencia" value="No" checked>
                            <label for="css">No</label>
                        </div>
                        <div class="form-group">
                            <label for="suplidor">Suplidor</label>
                            <!--<input class="form-control" type="text" name="suplidor" id="suplidor" value="<?php print($rowUser['suplidor'])?>" required maxlength="200"> -->
                            <select class="form-control" name="suplidor" id="suplidor">
                                <option value="rica">Rica</option>
                                <option value="induveca">Induveca</option>
                                <option value="sosua">Sosua</option>
                                <option value="victorina">Victorina</option>
                            </select>
                        </div>
                        <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="Save">
                    </form>
                </main>
            </div>
        </div>
        <!-- footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>
    </body>
</html>