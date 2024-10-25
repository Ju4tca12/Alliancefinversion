<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de apendices en reintegro</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_ficha.php" class="btn btn-primary">Nuevo</a>
		<?php } ?>
	</div>



    <div class="row">   
		<div class="col-lg-12">	
	    	<div class="table-responsive">
				<table class="table  table-bordered" id="table">
					<thead class="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>DOCUMENTO</th>
                                    <th>NOMBRE</th>
                                    <th>FECHA DE REINTEGRO</th>
                                    <th>FICHA DE REINTEGRO</th>
                                    <th>FICHAS ANTERIOR</th>
                                   
                                    <?php if ($_SESSION['rol'] == 1) { ?>
                                    <th>ACCIONES</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../conexion.php";

                                $query = mysqli_query($conexion, "SELECT * FROM reintegro");
                                $result = mysqli_num_rows($query);
                                if ($result > 0) {
                                    while ($data = mysqli_fetch_assoc($query)) { ?>
                                        <tr>
                                            <td><?php echo $data['cod_reintegro']; ?></td>
                                            <td><?php echo $data['doc_reintegro']; ?></td>
                                            <td><?php echo $data['nom_rein']; ?></td>
                                            <td><?php echo $data['fech_rein']; ?></td> 
                                            <td><?php echo $data['ficha_anterior']; ?></td>
                                            <td><?php echo $data['ficha_reinte']; ?></td>  
                            
                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                            <td>
                                                <a href="editar_novedad.php?id=<?php echo $data['cod_reintegro']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                                <form action="eliminar_novedad.php?id=<?php echo $data['cod_reintegro']; ?>" method="post" class="confirmar d-inline">
                                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>

