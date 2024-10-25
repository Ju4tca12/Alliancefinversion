<?php include "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['estado_apren'])) {
    $alert = '<p class"error">Todo los campos son requeridos</p>';
  } else {
    $id_estado = $_GET['id'];
    $estado_apren = $_POST['estado_apren'];


    $sql_update = mysqli_query($conexion, "UPDATE estado_apre SET id_estado = '$id_estado', estado_apren = '$estado_apren' WHERE id_estado = $id_estado");
    $alert = '<p>Usuario Actualizado</p>';
  }
}

if (empty($_REQUEST['id'])) {
  header("Location: lista_usuarios.php");
}
$id_estado = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM estado_apre WHERE id_estado = $id_estado");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_usuarios.php");
} else {
  if ($data = mysqli_fetch_array($sql)) {
    $id_estado = $data['id_estado'];
    $estado_apren = $data['estado_apren'];

  }
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-6 m-auto">
      <form class="" action="" method="post">
        <?php echo isset($alert) ? $alert : ''; ?>
        <input type="hidden" name="id" value="<?php echo $id_estado; ?>">
        <div class="form-group">
          <label for="estado_apren">Estado de sofia plus</label>
          <input type="text" placeholder="Ingrese estado sofia plus" class="form-control" name="estado_apren" id="estado_apren" value="<?php echo $estado_apren; ?>">
        </div>
 

        <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar </button>
      </form>
    </div>
  </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>