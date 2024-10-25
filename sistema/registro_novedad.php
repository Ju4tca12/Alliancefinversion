<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['des_novedad']) || empty($_POST['cod_novedad'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $des_novedad = $_POST['des_novedad'];
        $cod_novedad = $_POST['cod_novedad'];
        $query = mysqli_query($conexion, "SELECT * FROM novedad WHERE cod_novedad = '$cod_novedad'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        Novedad ya registrado
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO novedad (des_novedad, cod_novedad) VALUES ('$des_novedad', '$cod_novedad')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                            Novedad  registrada correctamente
                          </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                            Error al registrar la novedad
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
                        <label for="cod_novedad">CODIGO DE ESTADO</label>
                        <input type="text" placeholder="Ingrese un codigo" name="cod_novedad" id="cod_novedad" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="des_novedad">NUEVA NOVEDAD</label>
                        <input type="text" placeholder="Ingrese descripcion del estado" name="des_novedad" id="des_novedad" class="form-control">
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
