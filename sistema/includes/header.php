<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}

include "includes/functions.php";
include "../conexion.php"; // Asegúrate de que esto sea correcto

// Consulta para contar los aprendices notificados
$query = "SELECT COUNT(*) as notificado FROM aprendiz WHERE notificado = 1";
$result = mysqli_query($conexion, $query);

// Verifica si la consulta fue exitosa
if ($result) {
    $data = mysqli_fetch_assoc($result); // Almacena el número de aprendices notificados
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

// Consulta para contar el total de aprendices
$totalQuery = "SELECT COUNT(*) as total FROM aprendiz";
$totalResult = mysqli_query($conexion, $totalQuery);

// Verifica si la consulta fue exitosa
if ($totalResult) {
    $totalData = mysqli_fetch_assoc($totalResult);
    $totalAprendices = $totalData['total'];
} else {
    echo "Error en la consulta total: " . mysqli_error($conexion);
}

// Calcula el porcentaje de notificados
$porcentaje = $totalAprendices > 0 ? ($data['notificado'] / $totalAprendices) * 100 : 0; // Evita división por cero

// Cierra la conexión después de realizar ambas consultas
mysqli_close($conexion);
?>


<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
	<meta name="author" content="">

	<title>Alliance</title>

	<!-- Custom styles for this template-->
	<link href="css/style.css" rel="stylesheet">
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>



<body id="page-top">
	<?php
	include "../conexion.php";
	$query_data = mysqli_query($conexion, "CALL data();");
	$result_data = mysqli_num_rows($query_data);
	if ($result_data > 0) {
		$data = mysqli_fetch_assoc($query_data);
	}

	?>
	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php include_once "includes/menu.php"; ?>
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-primary text-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>
					<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<div class="topbar-divider d-none d-sm-block"></div>

						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
				
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline small text-white"><?php echo $_SESSION['nombre']; ?></span>
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									<?php echo $_SESSION['email']; ?>
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="salir.php">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Salir
								</a>
							</div>
						</li>

					</ul>

				</nav>
