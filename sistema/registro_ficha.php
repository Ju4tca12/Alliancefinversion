<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['num_fich']) || empty($_POST['fecha_ini']) || empty($_POST['fecha_fin']) || empty($_POST['nombre'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                Todos los campos son obligatorios  
              </div>';
    } else {
        $num_fich = $_POST['num_fich'];
        $fecha_ini = $_POST['fecha_ini'];
        $fecha_fin = $_POST['fecha_fin'];
        $usuario_id = $_POST['nombre']; 

        $query_insert = mysqli_query($conexion, "INSERT INTO ficha (num_fich, fecha_ini, fecha_fin, usuario_id) values ('$num_fich', '$fecha_ini', '$fecha_fin', '$usuario_id')");
        if ($query_insert) {
            $alert = '<div class="alert alert-primary" role="alert">
                Ficha registrada exitosamente
              </div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">
                Error al registrar la ficha
              </div>';
        }
    }
}
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">Panel de Ficha</h1>
     <a href="lista_ficha.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off" id="registro_ficha">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
           <label>Instructor</label> 
         
             <select id="nombre" name="nombre" class="form-control">
                                            <?php       
                                            $idUser = $_SESSION['idUser'];
                                            $rol = $_SESSION['rol'];
                                            $sql = "SELECT idusuario, nombre FROM usuario";

                                            if ($rol == 2  ) {
                                                $sql .= " WHERE idusuario = $idUser AND rol = 2";
                                            }
                                    
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
         <div class="form-group">
           <label for="num_fich">Numero ficha</label>
           <input type="num" placeholder="Ingrese numero de ficha" name="num_fich" id="num_fich" class="form-control">
         </div>
         <div class="form-group">
           <label for="fecha_ini">Fecha de inicio</label>
           <input type="date" placeholder="Ingrese fecha de inicio" name="fecha_ini" id="fecha_ini" class="form-control">
         </div>
         <div class="form-group">
           <label for="fecha_fin">Fecha fin</label>
           <input type="date" placeholder="Ingrese fecha fin" name="fecha_fin" id="fecha_fin" class="form-control">
         </div>
         <input type="submit" value="Guardar ficha" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>

 <script>

document.getElementById('registro_ficha').addEventListener('submit', function(event) {
    event.preventDefault(); 


    var num_fich = document.getElementById('num_fich').value;
    var fecha_ini = document.getElementById('fecha_ini').value;
    var fecha_fin = document.getElementById('fecha_fin').value;

    
    

    if (num_fich === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, el numero de ficha',
            icon: 'info'
        });
        return; 
    }
    if (fecha_ini === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor ingrese fecha inicio',
            icon: 'info'
        });
        return; 
    }
    if (fecha_fin === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, ingrese fecha fin',
            icon: 'info'
        });
        return; 
    }

  
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres crear la ficha?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
          
 
            Swal.fire({
                title: "Exitoso",
                text: "Ficha registrada exitosamente",
                icon: "success"
            }).then(() => {
                document.getElementById('registro_ficha').submit();
            });
        }
    });
});  

  </script>