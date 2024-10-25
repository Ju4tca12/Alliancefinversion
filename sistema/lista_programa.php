<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Listar programas</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_programa.php" class="btn btn-primary">Nuevo</a>
		<?php } ?>
	</div>

	<div class="row">
		<div class="col-lg-12">	
        <div class="table-responsive">
				<table class="table table-bordered" id="table">
					<thead class="thead">
						<tr>
							<th>ID</th>
							<th>PROGRAMA</th>
							<th>INSTRUCTOR</th>					
							<?php if ($_SESSION['rol'] == 1) { ?>
							<th>ACCIONES</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php
						include "../conexion.php";

						$query = mysqli_query($conexion,"SELECT  p.id_programa, p.programa_nom,  u.nombre  
						FROM programa P  
						INNER JOIN usuario u ON p.usuario_id = u.idusuario");

						$result = mysqli_num_rows($query);
						if ($result > 0) {
							while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td><?php echo $data['id_programa']; ?></td>
									<td><?php echo $data['programa_nom']; ?></td>
									<td><?php echo $data['nombre']; ?></td>
									<?php if ($_SESSION['rol'] == 1) { ?>
									<td>
										<a href="editar_programa.php?id=<?php echo $data['id_programa']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Editar</a>
										<form action="eliminar_usuario.php?id=<?php echo $data['id_programa']; ?>" method="post" class="confirmar d-inline">
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

