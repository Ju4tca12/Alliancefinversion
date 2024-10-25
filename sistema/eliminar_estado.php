<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id_estado = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM estado_apre WHERE id_estado = $id_estado");
    mysqli_close($conexion);
    header("location: lista_estado.php");
}
?>

 



