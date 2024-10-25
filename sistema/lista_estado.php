<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de estado en  sofia plus</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_ficha.php" class="btn btn-primary">Nuevo</a>
		<?php } ?>
	</div>



    <div class="row">   
		<div class="col-lg-12">	
	    	<div class="table-responsive">
				<table class="table table-bordered" id="table">
					<thead class="table table-bordered " width="100%" cellspacing="0">
                                <tr>
                                    <th>ID</th>
                                    <th>TIPO DE ESTADO</th>
                                    <?php if ($_SESSION['rol'] == 1) { ?>
                                    <th>ACCIONES</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../conexion.php";

                                $query = mysqli_query($conexion, "SELECT * FROM estado_apre");
                                $result = mysqli_num_rows($query);
                                if ($result > 0) {
                                    while ($data = mysqli_fetch_assoc($query)) { ?>
                                        <tr>
                                            <td><?php echo $data['id_estado']; ?></td>
                                            <td><?php echo $data['estado_apren']; ?></td>
                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                            <td>
                                                <a href="editar_estado.php?id=<?php echo $data['id_estado']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                                <form action="eliminar_estado.php?id=<?php echo $data['id_estado']; ?>" method="post" id="eliminar_estado_<?php echo $data['id_estado']; ?>" class="confirmar d-inline">
                                                    <button class="btn btn-danger" onclick="confirmarEliminar(<?php echo $data['id_estado']; ?>)" type="button"><i class='fas fa-trash-alt'></i></button>
                                                </form>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>

				</table>
			  </div>
        </div>
     </div>
		

                                         


</div>
<!-- /.en la limitrnancion   dlem cod de estado se cuentnra.,   todoa la informacion  
 rekacuinn con los estados   
ya que debe ser informacion relavante, se sedebe agregar un estado 0 selccioón, cuando el sistema 
validen quue no se encuentre esn estaod selccione no permita generar los certficados estas alertas 
pre estrabblecidad 
em im cod.js llamado selccione 
    -->

</div>



<?php include_once "includes/footer.php"; ?>


<script>

    function confirmarEliminar(id_estado) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará los estados de los aprendices.",
        icon: 'warning',
        input: 'password',  
        inputPlaceholder: 'Ingresa tu clave para confirmar',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar',
        preConfirm: (clave) => {
            if (!clave) {
                Swal.showValidationMessage('Debes ingresar tu clave');
            } else {
                // Enviar clave para validación
                return fetch('validar_clave.php', {
                    method: 'POST',
                    body: new URLSearchParams('clave=' + encodeURIComponent(clave)),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(response => response.text())
                .then(text => {
                    if (text === 'Clave válida') {
                        return true;
                    } else {
                        Swal.showValidationMessage('Clave incorrecta');
                        return false;
                    }
                });
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Si la clave es válida y el usuario confirma
            Swal.fire({
                title: 'Confirmación',
                text: "El estado sera eliminado permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                            text: "Estado eliminado exitosamentes",
                            icon: "success",
                            preConfirm: () => {
                                document.getElementById('eliminar_estado_' + id_estado).submit();
                            }
                        });
          
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'Cancelado',
                text: 'El estado no se ha eliminado',
                icon: 'info'
            });
        }
    });
}



    
</script> 

