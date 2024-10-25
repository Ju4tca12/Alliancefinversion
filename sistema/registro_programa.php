<?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['programa_nom'])|| empty($_POST['nombre'])) {
      $alert = '<div class="alert alert-danger" role="alert">
                Todo los campos son obligatorios
              </div>';
    } else {

      $programa_nom = $_POST['programa_nom'];
      $usuario_id = $_POST['nombre'];

      $query_insert = mysqli_query($conexion, "INSERT INTO programa(programa_nom, usuario_id) values ('$programa_nom','$usuario_id')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
                Programa registrado exitosamente
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
     <h1 class="h3 mb-0 text-gray-800">Registro de programa</h1>
     <a href="lista_programa.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off" id="registro_programa">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
  
         <div class="form-group">
           <label for="programa_nom">Nombre del programa</label>
           <input type="num" placeholder="Ingrese nombre del programa" name="programa_nom" id="programa_nom" class="form-control">
         </div>
                        <div class="form-group">
                  <label>Instructor</label> 
                  <select id="nombre" name="nombre" class="form-control">
                    <option value="">Seleccione</option> <!-- Opción por defecto -->
                    <?php       
                    $idUser = $_SESSION['idUser'];
                    $rol = $_SESSION['rol'];
                    $sql = "SELECT idusuario, nombre FROM usuario";

                    if ($rol == 2) {
                      $sql .= " WHERE idusuario = $idUser AND rol = 2";
                    } else if ($rol == 1) {
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

         <input type="submit" value="Guardar Programa" class="btn btn-primary">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>

 <script>

    document.getElementById('registro_programa').addEventListener('submit', function(event) {
    event.preventDefault(); 

    var programa_nom = document.getElementById('programa_nom').value;
    var nombre = document.getElementById('nombre').value;


    
    

    if (programa_nom === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor, el nombre del Programa del formación',
            icon: 'info'
        });
        return; 
    }
    if (nombre === '') {
        Swal.fire({
            title: 'Falta información',
            text: 'Por favor ingrese el nombre del instructor',
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
                document.getElementById('registro_programa').submit();
            });
        }
    });
});  

  </script>  