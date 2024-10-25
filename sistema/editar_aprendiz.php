<?php
include "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nomb_apre']) || empty($_POST['apell_apre']) || empty($_POST['doc_apre']) || empty($_POST['tip_doc']) 
        || empty($_POST['horas']) || empty($_POST['correo']) || empty($_POST['descrip']) || empty($_POST['num_fich'])
        || empty($_POST['programa_nom'])  || empty($_POST['des_novedad']) || empty($_POST['estado_apren']) || empty($_POST['usuario_id'])) {
      
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $aprendiz_id = $_GET['id']; 
        $nomb_apre = $_POST['nomb_apre'];
        $apell_apre = $_POST['apell_apre'];
        $doc_apre = $_POST['doc_apre'];
        $tip_doc = $_POST['tip_doc'];
        $horas = $_POST['horas'];
        $correo = $_POST['correo'];
        $descrip = $_POST['descrip'];
        $programa_nom = $_POST['programa_nom'];
        $num_fich = $_POST['num_fich'];
        $des_novedad = $_POST['des_novedad'];
        $estado_apren = $_POST['estado_apren'];
        $usuario_id = $_POST['usuario_id'];


        $sql_update = mysqli_query($conexion, "UPDATE aprendiz 
                                               SET nomb_apre = '$nomb_apre', apell_apre = '$apell_apre', doc_apre = '$doc_apre', tip_doc = '$tip_doc', 
                                                   horas = '$horas', correo = '$correo', descrip = '$descrip', programa_nom = '$programa_nom', 
                                                   des_novedad = '$des_novedad', num_fich = '$num_fich', estado_apren = '$estado_apren', usuario_id = '$usuario_id' 
                                               WHERE id_apre = $aprendiz_id");

        if ($sql_update) {
            $alert = '<div class="alert alert-primary" role="alert">Aprendiz actualizado correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el aprendiz</div>';
        }
    }
}

// Mostrar Datos
                  if (empty($_REQUEST['id'])) {
                      header("Location: lista_aprendices.php");
                      exit;
                  }

                  $aprendiz_id = $_REQUEST['id'];

                  $sql = mysqli_query($conexion, "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, a.correo, a.descrip, a.des_novedad, 
                                                        a.num_fich, a.estado_apren, a.usuario_id, p.programa_nom, f.num_fich, u.nombre as instructor, e.estado_apren
                                                  FROM aprendiz a
                                                  INNER JOIN programa p ON a.programa_nom = p.id_programa
                                                  INNER JOIN ficha f ON a.num_fich = f.ficha_id
                                                  INNER JOIN usuario u ON a.usuario_id = u.idusuario
                                                  INNER JOIN estado_apre e ON a.estado_apren = e.id_estado
                                                  WHERE a.id_apre = $aprendiz_id");

                  $result_sql = mysqli_num_rows($sql);
                  if ($result_sql == 0) {
                      header("Location: lista_aprendices.php");
                      exit;
                  } else {
                      $data = mysqli_fetch_array($sql);
                      $nomb_apre = $data['nomb_apre'];
                      $apell_apre = $data['apell_apre'];
                      $doc_apre = $data['doc_apre'];
                      $tip_doc = $data['tip_doc'];
                      $horas = $data['horas'];
                      $correo = $data['correo'];
                      $descrip = $data['descrip'];
                      $programa_nom = $data['programa_nom'];
                      $num_fich = $data['num_fich'];
                      $des_novedad = $data['des_novedad'];
                      $estado_apren = $data['estado_apren'];
                      $usuario_id = $data['usuario_id'];
                      $instructor = $data['instructor'];
                  }
                  ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">
    <form action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="aprendiz_id" value="<?php echo $aprendiz_id; ?>">
                <div class="form-group">
                    <label for="nomb_apre">Nombre</label>
                    <input type="text" placeholder="Ingrese nombre del aprendiz" class="form-control" name="nomb_apre" id="nomb_apre" value="<?php echo $nomb_apre; ?>">
                </div>
                <div class="form-group">
                    <label for="apell_apre">Apellido</label>
                    <input type="text" placeholder="Ingrese apellido del aprendiz" class="form-control" name="apell_apre" id="apell_apre" value="<?php echo $apell_apre; ?>">
                </div>
                <div class="form-group">
                    <label for="doc_apre">Documento</label>
                    <input type="text" placeholder="Ingrese documento del aprendiz" class="form-control" name="doc_apre" id="doc_apre" value="<?php echo $doc_apre; ?>">
                </div>
              
                <div class="form-group">
                    <label for="apell_apre">Tipo de documento</label>
                        <select type="select" placeholder="Ingrese Tipo de documento" id="tip_doc" class="form-control"  name="tip_doc" id="tip_doc" value="<?php echo $tip_doc; ?>">
                            <option value="Seleccione">Selecciona Documento</option>
                            <option value="TI">Tarjeta de identidad</option>
                            <option value="CC">Cedula de ciudadania</option>                                    
                        </select>
                </div>
                <div class="form-group">
                    <label for="horas">Horas</label>
                    <input type="text" placeholder="Ingrese horas" class="form-control" name="horas" id="horas" value="<?php echo $horas; ?>">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" placeholder="Ingrese correo" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>">
                </div>
                <div class="form-group">
                    <label for="descrip">Descripción</label>
                    <input type="text" placeholder="Ingrese descripción" class="form-control" name="descrip" id="descrip" value="<?php echo $descrip; ?>">
                </div>
                <div class="form-group">
                    <label for="des_novedad">Novedad</label>
                    <input type="text" placeholder="Ingrese des_novedad" class="form-control" name="des_novedad" id="des_novedad" value="<?php echo $des_novedad; ?>">
                </div>
                <div class="form-group">
                    <label for="programa_nom">Programa</label>
                    <select name="programa_nom" id="programa_nom" class="form-control">
                        <?php
                        $query_programa = mysqli_query($conexion, "SELECT * FROM programa");
                        while ($row = mysqli_fetch_array($query_programa)) {
                            $selected = ($row['id_programa'] == $programa_nom) ? 'selected' : '';
                            echo "<option value='" . $row['id_programa'] . "' $selected>" . $row['programa_nom'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="num_fich">Ficha</label>
                    <select id="num_fich" name="num_fich" class="form-control">
                        <?php
                        $query_ficha = mysqli_query($conexion, "SELECT ficha_id, num_fich FROM ficha ORDER BY num_fich ASC");
                        $resultado_ficha = mysqli_num_rows($query_ficha);
                        if ($resultado_ficha > 0) {
                            while ($ficha = mysqli_fetch_array($query_ficha)) {
                                $selected = ($ficha['ficha_id'] == $num_fich) ? 'selected' : '';
                                echo "<option value='{$ficha['ficha_id']}' $selected>{$ficha['num_fich']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="usuario_id">Instructor</label>
                    <select name="usuario_id" id="usuario_id" class="form-control">
                        <?php
                        $query_instructor = mysqli_query($conexion, "SELECT * FROM usuario");
                        while ($row = mysqli_fetch_array($query_instructor)) {
                            $selected = ($row['idusuario'] == $usuario_id) ? 'selected' : '';
                            echo "<option value='" . $row['idusuario'] . "' $selected>" . $row['nombre'] . "</option>";
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
                
                <input type="submit" value="Actualizar Aprendiz" class="btn btn-primary">
                <a href="lista_aprendiz.php" class="btn btn-danger">Regresar</a>
                &nbsp&nbsp
                <a href="filtros.php" class="btn btn-danger">Regresar a filtros</a>
            </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
