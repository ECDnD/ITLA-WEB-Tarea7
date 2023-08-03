<?php
//Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();

//GET
if(isset($_GET['delete_id'])){
    $codigo = $_GET['delete_id'];

    var_dump($codigo);
    
    try{
        if($codigo != null){
            if($objUser -> delete($codigo)){
                $objUser -> redirect('index.php?deleted');
            }
        }
    } catch(PDOException $e){
        echo $e -> getMessage();
    }
};

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
                    <h1 style="margin-top: 10px">DataTable</h1>
                    <?php
                        if(isset($_GET['updated'])){
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                                <strong>User!</strong> Updated with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
                        } else if(isset($_GET['deleted'])){
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                                <strong>User!</strong> Deleted with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
                        } else if(isset($_GET['inserted'])){
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                                <strong>User!</strong> Inserted with success.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
                        } else if(isset($_GET['error'])){
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                                <strong>Error!</strong> Something went wrong with your action. Try again.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>';
                        }
                    ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Costo</th>
                                    <th>Existencia</th>
                                    <th>Suplidor</th>
                                </tr>
                            </thead>
                            <?php
                                $query = "SELECT * FROM productos";
                                $stmt = $objUser -> runQuery($query);
                                $stmt -> execute();
                            ?>
                            <tbody>
                                <?php
                                    if($stmt -> rowCount() > 0){
                                        while($rowUser = $stmt -> fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?php print($rowUser['codigo']); ?></td>

                                    <a href="from.php?edit_id=<?php print($rowUser['codigo']); ?>">
                                    <td><?php print($rowUser['nombre']); ?></td>

                                    <td><?php print($rowUser['descripcion']); ?></td>

                                    <td><?php print($rowUser['costo']); ?></td>

                                    <td><?php print($rowUser['existencia']); ?></td>

                                    <td><?php print($rowUser['suplidor']); ?></td>

                                    <td>
                                        <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['codigo']); ?>">
                                            <span data-feather="trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } } ?>
                        </table>
                    </div>
                </main>
            </div>
        </div>
        <!-- footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>

        <!-- Custom scripts -->
        <script>
            //JQuery confirmation
            $('.confirmation').on('click', function() {
                return confirm('Are you sure you want to delete this user?');
            });
        </script>
    </body>
</html>