<?php
include "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['num_fich']) || empty($_POST['usuario_id'])) {
    $alert = '<p class="error">Todos los campos son requeridos</p>';
  } else {
    $ficha_id = $_GET['id'];
    $num_fich = $_POST['num_fich'];
    $usuario_id = $_POST['usuario_id'];

    $sql_update = mysqli_query($conexion, "UPDATE ficha SET num_fich = '$num_fich', usuario_id = '$usuario_id' WHERE ficha_id = $ficha_id");

    if ($sql_update) {
      $alert = '<p class="success">Ficha actualizada correctamente</p>';
    } else {
      $alert = '<p class="error">Error al actualizar la ficha</p>';
    }
  }
}

// Mostrar Datos
if (empty($_REQUEST['id'])) {
  header("Location: lista_usuarios.php");
  exit;
}
$ficha_id = $_REQUEST['id'];

$sql = mysqli_query($conexion, "SELECT f.ficha_id, f.num_fich, u.idusuario, u.nombre FROM ficha f INNER JOIN usuario u ON f.usuario_id = u.idusuario WHERE f.ficha_id = $ficha_id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_usuarios.php");
  exit;
} else {
  $data = mysqli_fetch_array($sql);
  $num_fich = $data['num_fich'];
  $usuario_id = $data['idusuario'];
  $nombre = $data['nombre'];
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">
      <form action="" method="post">
        <?php echo isset($alert) ? $alert : ''; ?>
         <input type="hidden" name="ficha_id" value="<?php echo $ficha_id; ?>">
        <!-- <div class="form-group">
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
                </div>  -->

         
        
        <div class="form-group">
          <label for="num_fich">Numero de ficha</label>
          <input type="text" placeholder="Ingrese usuario" class="form-control" name="num_fich" id="num_fich" value="<?php echo $num_fich; ?>">

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
        <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar Ficha</button>
      </form>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
