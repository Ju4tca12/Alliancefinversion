<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['estado_apren']) || empty($_POST['cod_estado'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $estado_apren = $_POST['estado_apren'];
        $cod_estado = $_POST['cod_estado'];
        $query = mysqli_query($conexion, "SELECT * FROM estado_apre WHERE cod_estado = '$cod_estado'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        Estado ya registrado
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO estado_apre (estado_apren, cod_estado) VALUES ('$estado_apren', '$cod_estado')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                            Estado registrado correctamente
                          </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                            Error al registrar el estado
                          </div>';
            }
        }
    }
}

mysqli_close($conexion);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-primary text-white">
                Registro de estado en sofia plus
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="estado_apren">TIPO DE ESTADO</label>
                        <input type="text" placeholder="Ingrese un estado nuevo" name="estado_apren" id="estado_apren" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cod_estado">CODIGO DE ESTADO</label>
                        <input type="text" placeholder="Ingrese el codigo de estado" name="cod_estado" id="cod_estado" class="form-control">
                    </div>

                    <input type="submit" value="Guardar estado" class="btn btn-primary">
                    <a href="lista_estado.php" class="btn btn-danger">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
