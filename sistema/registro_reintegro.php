<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['doc_reintegro']) || empty($_POST['nom_rein']) || empty($_POST['fech_rein'])
     || empty($_POST['ficha_anterior']) || empty($_POST['ficha_reinte'])) {
        $alert = '<div class="alert alert-danger" role="alert">
                        Todo los campos son obligatorios
                    </div>';
    } else {
        $doc_reintegro = $_POST['doc_reintegro'];
        $nom_rein = $_POST['nom_rein'];
        $fech_rein = $_POST['fech_rein'];
        $ficha_anterior = $_POST['ficha_anterior'];
        $ficha_reinte = $_POST['ficha_reinte'];
        $query = mysqli_query($conexion, "SELECT * FROM reintegro WHERE cod_reintegro = '$cod_reintegro'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        Aprendiz en reintegro ya registrado
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO reintegro (nom_rein,doc_reinegro,fech_rein,ficha_anterior, ficha_rein, cod_reintegro) 
            VALUES ('$nom_rein', '$doc_rein', '$fecha_rein', '$ficha_anterior, '$ficha_reinte', '$cod_estado')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">
                             Aprendiz en reientegrado correctamente
                          </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                            Error al registrar el reintegro del aprendiz
                          </div>';
            }
        }
    }
}

mysqli_close($conexion);
?>

<div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">Registro de programa</h1>
     <a href="lista_programa.php" class="btn btn-primary">Regresar</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off" id="reintegro_aprendiz">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
  
         <div class="form-group">
                        <label for="nom_rein">Nombre del aprendiz</label>
                        <input type="text" placeholder="Ingrese el nombre del aprendiz" name="nom_rein" id="nom_rein" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="doc_rein">Documento del aprendiz</label>
                        <input type="text" placeholder="Ingrese el codigo de estado" name="doc_rein" id="doc_rein" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fech_rein">Fecha de reinetegro</label>
                        <input type="text" placeholder="Ingrese el codigo de estado" name="fech_rein" id="fech_rein" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ficha_anterior">Ficha antigua del aprendiz</label>
                        <input type="text" placeholder="Ingrese la ficha anteiror del aprendiz" name="ficha_anterior" id="ficha_anterior" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ficha_reinte">Ficha de reintegro del aprendiz</label>
                        <input type="text" placeholder="Ingrese ficha de reintegro del aprendiz" name="ficha_reinte" id="ficha_reinte" class="form-control">
                    </div>

                    <input type="submit" value="Guardar aprendiz" class="btn btn-primary">
        


       </form>
     </div>
   </div>
</div>

</div>
</div>


   
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>

            <script>

            document.getElementById('reintegro_aprendiz').addEventListener('submit', function(event) {
            event.preventDefault(); 

            var nom_rein = document.getElementById('nom_rein').value;
            var doc_rein = document.getElementById('doc_rein').value;
            var ficha_anterior = document.getElementById('ficha_anterior').value;

      


            if (nom_rein === '') {
                Swal.fire({
                    title: 'Falta información',
                    text: 'Por favor ingrese nombre del aprendiz en reintegro',
                    icon: 'info'
                });
                return; 
            }
            if (doc_rein === '') {
                Swal.fire({
                    title: 'Falta información',
                    text: 'Por favor ingrese docuemtno del aprendiz',
                    icon: 'info'
                });
                return; 
            }
            
            if (ficha_anterior === '') {
                 Swal.fire({
                    title: 'Falta información',
                    text: 'Por favor ingrese la ficha anteriora del aprendiz',
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
                        document.getElementById('reintegro_aprendiz').submit();
                    });
                }
            });
            });  

            </script>   
