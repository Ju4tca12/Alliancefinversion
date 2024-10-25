<?php
if (!empty($_GET['id'])) {
    require("../conexion.php");
    $id_apre = $_GET['id'];
    
    $query_update = mysqli_query($conexion, "UPDATE aprendiz SET notificado = NULL, fecha_not = NULL WHERE id_apre = $id_apre");

    if ($query_update) {
    
        header("location: resolucion.php");
    } else {
        echo "Error al actualizar los campos.";
    }
    
    mysqli_close($conexion);
}
?>
