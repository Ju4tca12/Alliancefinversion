<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
		<div class="sidebar-brand-icon rotate-n-15">
			<img src="../assets/img/logo.png"   style="height: 40px;
  width: 40px;   padding: 0rem;">
  
		</div>


		
		<div class="sidebar-brand-text mx-3">Alliance</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Menu principal
	</div> 

	

	<!-- Nav Item - Pages Collapse Menu -->


	<!-- Nav Item - Productos Collapse Menu -->
	<!-- <li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-fw fa-wrench"></i>
			<span>Productos</span>
		</a>
		<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_producto.php">Nuevo Producto</a>
				<a class="collapse-item" href="lista_productos.php">Productos</a>
			</div>
		</div>
	</li> -->

	<!-- Nav Item - Clientes Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="true" aria-controls="collapseUtilities">

		<i class="fas fa-solid fa-users"></i>
			<span>Aprendices</span>
		</a>
		<div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_aprendiz.php">Nuevo Aprendiz</a>
				<a class="collapse-item" href="lista_aprendiz.php">Aprendices</a>
			</div>
		</div>
	</li>
	<!-- Nav Item - Utilities Collapse Menu -->
	<!-- <li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-hospital"></i>
			<span>Proveedor</span>
		</a>
		<div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_proveedor.php">Nuevo Proveedor</a>
				<a class="collapse-item" href="lista_proveedor.php">Proveedores</a>
			</div>
		</div>
	</li> -->
	<?php if ($_SESSION['rol'] == 1) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUtilities">
			<i class=" fas fa-solid fa-user-plus"></i>
				<span>Usuarios e Instructores</span>
			</a>
			<div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="registro_usuario.php">Nuevo Usuario</a>
					<a class="collapse-item" href="lista_usuarios.php">Usuarios</a>
				</div>
			</div>
		</li>
	<?php } ?>


		<!-- Nav Item - Usuarios Collapse Menu -->
		<!-- <li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInstructor" aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-user"></i>
				<span>Instructor</span>
			</a>
			<div id="collapseInstructor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="registro_instructor.php">Nuevo Instructor</a>
					<a class="collapse-item" href="lista_instructor.php">Instructores</a>
				</div>
			</div>
		</li> -->

	<?php if ($_SESSION['rol'] == 1) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFicha" aria-expanded="true" aria-controls="collapseUtilities">
			<i class=" fas fa-solid fa-audio-description"></i>
				<span>Fichas</span>
			</a>
			<div id="collapseFicha" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="registro_ficha.php">Nueva Ficha</a>
					<a class="collapse-item" href="lista_ficha.php">Fichas</a>
				</div>
			</div>
		</li>
	<?php } ?>
	<?php if ($_SESSION['rol'] == 1) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseprograma" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-solid fa-id-card"></i>
				<span>Prográma</span>
			</a>
			<div id="collapseprograma" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="lista_programa.php">Lista de programas</a>
					<a class="collapse-item" href="registro_programa.php">Registrar programas.</a>
				</div>
			</div>
		</li>
	<?php } ?>
	<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefiltros" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-solid fa-file-signature"></i>
				<span>Filtro y cartas</span>
			</a>
			<div id="collapsefiltros" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
		
					<a class="collapse-item" href="filtros.php">Filtros</a>
				</div>
			</div>
		</li>
	<?php } ?>
	<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsereintegros" aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-user"></i>
				<span>Reintegro Especial</span>
			</a>
			<div id="collapsereintegros" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_reintegro.php">Nuevo reintegro</a>
					<a class="collapse-item" href="lista_reintegro.php">Listado de reintegros</a>
				</div>
			</div>
		</li>
	<?php } ?>
	<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsenovedad" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-regular fa-calendar-plus"></i>
				<span>Novedad en sofia</span>
			</a>
			<div id="collapsenovedad" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="lista_novedad.php"> Lista de Novedad</a>
					<a class="collapse-item" href="registro_novedad.php"> Registro de novedad</a>
					
					
				</div>
			</div>
		</li>
	<?php } ?>
	
	<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseestado" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-solid fa-question"></i>
				<span>Estado en sofia plus</span>
			</a>
			<div id="collapseestado" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="registro_estado.php">Nuevo estado</a>
					<a class="collapse-item" href="lista_estado.php">Estados de sofia</a>
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapresolucion" aria-expanded="true" aria-controls="collapseUtilities">
			<i class=" fas fa-regular fa-file-excel"></i>
				<span>Resoluciones </span>
			</a>
			<div id="collapresolucion" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
		
					<a class="collapse-item" href="resolucion.php">Resoluciones</a>
				</div>
			</div>
		</li>
	<?php } ?>

	

	<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapremesa" aria-expanded="true" aria-controls="collapseUtilities">
			<i class=" fas fa-regular fa-file-excel"></i>
				<span>Mesa Directiva </span>
			</a>
			<div id="collapremesa" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
		
					<a class="collapse-item" href="mesadir.php">Mesa Directiva</a>
				</div>
			</div>
		</li>
	<?php } ?>


	<li class="nav-item">
		<a class="nav-link collapsed" href="chat.php" >
		<i class="fas fa-solid fa-comments"></i>
			<span>Chat</span>		
		</a>
	</li>
	
	        <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

</ul>

