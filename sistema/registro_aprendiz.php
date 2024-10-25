<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nomb_apre']) || empty($_POST['apell_apre']) || empty($_POST['doc_apre']) || empty($_POST['tip_doc']) 
      || empty($_POST['horas']) || empty($_POST['correo']) || empty($_POST['descrip']) || empty($_POST['num_fich'])
      || empty($_POST['programa_nom']) || empty($_POST['des_novedad'])  || empty($_POST['nombre'])  ) {
        
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $nomb_apre = $_POST['nomb_apre'];
        $apell_apre = $_POST['apell_apre'];
        $doc_apre = $_POST['doc_apre'];
        $tip_doc = $_POST['tip_doc'];
        $horas = $_POST['horas'];
        $correo = $_POST['correo'];
        $descrip = $_POST['descrip'];
        $programa_nom = $_POST['programa_nom'];
        $num_fich = $_POST['num_fich'];
        $programa_nom = $_POST['programa_nom'];
        $estado_apren = $_POST['estado_apren'];
        $des_novedad = $_POST['des_novedad'];
        $usuario_id = $_POST['nombre'];     

        

        $query_insert = mysqli_query($conexion, "INSERT INTO aprendiz(nomb_apre, apell_apre, doc_apre, tip_doc,horas,correo,descrip,programa_nom, num_fich, des_novedad, estado_apren,usuario_id)
         VALUES ('$nomb_apre', '$apell_apre', '$doc_apre', '$tip_doc', '$horas', '$correo', '$descrip','$programa_nom', '$num_fich' , '$des_novedad', '$estado_apren', '$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">Aprendiz registrado exitosamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al registrar el aprendiz</div>';
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Aprendices para deserción</h1>
        <a href="lista_aprendices.php" class="btn btn-primary">Regresar</a>
    </div>


   

    
    <div class="row">
    <div class="col-lg-8 m-auto">
        <form action="" method="post" autocomplete="off" id="registro_aprendiz">
            <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nomb_apre">Nombre Aprendiz</label>
                        <input type="text" placeholder="Ingrese nombre del aprendiz" name="nomb_apre" id="nomb_apre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="apell_apre">Apellido Aprendiz</label>
                        <input type="text" placeholder="Ingrese apellido del aprendiz" name="apell_apre" id="apell_apre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tip_doc">Tipo de documento</label>
                        <select id="tip_doc" class="form-control" name="tip_doc">
                            <option value="Seleccione">Selecciona Documento</option>
                            <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                            <option value="Cedula">Cédula de ciudadanía</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="doc_apre">Documento Aprendiz</label>
                        <input type="number" placeholder="Ingrese documento del aprendiz" name="doc_apre" id="doc_apre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="horas">Horas</label>
                        <input type="number" placeholder="Horas de inasistencia del aprendiz" name="horas" id="horas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="mail" placeholder="Ingrese correo del aprendiz" name="correo" id="correo" class="form-control">
                    </div>
                </div>

                <!-- Segunda columna -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="descrip">Descripción</label>
                        <input type="text" placeholder="Ingrese descripción de inasistencia del aprendiz" name="descrip" id="descrip" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Programa</label>
                        <?php
                    $query_programa = mysqli_query($conexion, "SELECT id_programa, programa_nom FROM programa ORDER BY programa_nom ASC");
                    $resultado_programa = mysqli_num_rows($query_programa);
                    ?>
                    <select id="programa_nom" name="programa_nom" class="form-control">
                        <?php
                        if ($resultado_programa > 0) {
                            while ($programa = mysqli_fetch_array($query_programa)) {
                                echo "<option value='{$programa['id_programa']}'>{$programa['programa_nom']}</option>";
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label>Ficha</label>
                        <?php
                    $query_ficha = mysqli_query($conexion, "SELECT ficha_id, num_fich FROM ficha ORDER BY num_fich ASC");
                    $resultado_ficha = mysqli_num_rows($query_ficha);
                    ?>
                    <select id="num_fich" name="num_fich" class="form-control">
                        <?php
                        if ($resultado_ficha > 0) {
                            while ($ficha = mysqli_fetch_array($query_ficha)) {
                                echo "<option value='{$ficha['ficha_id']}'>{$ficha['num_fich']}</option>";
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <?php
                    $query_estado = mysqli_query($conexion, "SELECT id_estado, estado_apren FROM estado_apre ORDER BY estado_apren ASC");
                    $resultado_estado = mysqli_num_rows($query_estado);
                    ?>
                    <select id="estado_apren" name="estado_apren" class="form-control">
                        <?php
                        if ($resultado_estado> 0) {
                            while ($estado_apren = mysqli_fetch_array($query_estado)) {
                                echo "<option value='{$estado_apren['id_estado']}'>{$estado_apren['estado_apren']}</option>";
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label>Novedad en Sofia Plus</label>
                        <?php
                    $query_novedad = mysqli_query($conexion, "SELECT id_novedad, des_novedad FROM novedad ORDER BY des_novedad ASC");
                    $resultado_novedad = mysqli_num_rows($query_novedad);
                    ?>
                    <select id="des_novedad" name="des_novedad" class="form-control">
                        <?php
                        if ($resultado_novedad> 0) {
                            while ($des_novedad = mysqli_fetch_array($query_novedad)) {
                                echo "<option value='{$des_novedad['id_novedad']}'>{$des_novedad['des_novedad']}</option>";
                            }
                        }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre de instructor</label>
                        <select id="nombre" name="nombre" class="form-control">
                                            <?php       
                                            $idUser = $_SESSION['idUser'];
                                            $rol = $_SESSION['rol'];
                                            $sql = "SELECT idusuario, nombre FROM usuario";

                                            if ($rol == 2  ) {
                                                $sql .= " WHERE idusuario = $idUser AND rol = 2";
                                            }

                                            // Si el rol es 1 (administrador), no se aplica ningún filtro adicional
                                            // Los administradores pueden ver todos los usuarios del rol 2
                                            else if ($rol == 1) {
                                                $sql .= " WHERE rol = 2";
                                            }

                                            $sql .= " ORDER BY nombre ASC";

                                            // Ejecutar la consulta SQL
                                            $query_usuario = mysqli_query($conexion, $sql);
                                            $resultado_usuario = mysqli_num_rows($query_usuario);

                                            if ($resultado_usuario > 0) {
                                                while ($usuario = mysqli_fetch_array($query_usuario)) {
                                                    echo "<option value='{$usuario['idusuario']}'>{$usuario['nombre']}</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No se encontró el usuario o no tiene permisos suficientes</option>";
                                            }
                                            ?>
                                        </select>
                    </div>
                </div>
            </div>
            <input type="submit" value="Guardar Aprendiz" class="btn btn-primary">
        </form>
    </div>
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>

    



</script>
<?php include_once "includes/footer.php"; ?>
