<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Lista de novedad en sofia plus</h1>
		<?php if ($_SESSION['rol'] == 1) { ?>
		<a href="registro_ficha.php" class="btn btn-primary">Nuevo</a>
		<?php } ?>
	</div>



    <div class="row">   
		<div class="col-lg-12">	
	    	<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table">
					<thead class="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>NOVEDAD</th>
                                    <?php if ($_SESSION['rol'] == 1) { ?>
                                    <th>ACCIONES</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../conexion.php";

                                $query = mysqli_query($conexion, "SELECT * FROM novedad");
                                $result = mysqli_num_rows($query);
                                if ($result > 0) {
                                    while ($data = mysqli_fetch_assoc($query)) { ?>
                                        <tr>
                                            <td><?php echo $data['id_novedad']; ?></td>
                                            <td><?php echo $data['des_novedad']; ?></td>
                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                            <td>
                                                <a href="editar_novedad.php?id=<?php echo $data['id_novedad']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                                <form action="eliminar_novedad.php?id=<?php echo $data['id_novedad']; ?>" method="post" class="confirmar d-inline">
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

