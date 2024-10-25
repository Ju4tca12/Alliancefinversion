<?php
include_once "includes/header.php";
include "../conexion.php";

// Número de registros por página
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;

// Número de la página actual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Obtener y sanitizar parámetros de búsqueda y fechas
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$startDate = isset($_GET['startDate']) ? mysqli_real_escape_string($conexion, $_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? mysqli_real_escape_string($conexion, $_GET['endDate']) : '';

$idUser = $_SESSION['idUser'];
$rol = $_SESSION['rol'];

// Construir la consulta base
$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, a.correo, a.descrip,a.aprob,
 a.fecha_not, a.notificado, p.programa_nom, f.num_fich,  u.nombre, n.des_novedad, e.estado_apren 
          FROM aprendiz a
          JOIN ficha f ON a.num_fich = f.ficha_id
          JOIN usuario u ON a.usuario_id = u.idusuario
          JOIN estado_apre e ON a.estado_apren = e.id_estado
          JOIN novedad n ON a.des_novedad = n.id_novedad
          JOIN programa p ON a.programa_nom = p.id_programa 
          WHERE a.notificado = 1";

// Añadir condiciones según el rol
if ($rol != 1 && $rol != 3) {
    $query .= " WHERE a.usuario_id = '$idUser'";
}

// Añadir condiciones de búsqueda
$conditions = [];

if (!empty($search)) {
    $conditions[] = "(a.nomb_apre LIKE '%$search%' OR a.apell_apre LIKE '%$search%' OR u.nombre LIKE '%$search%' OR p.programa_nom LIKE '%$search%' 
                      OR f.num_fich LIKE '%$search%' OR a.doc_apre LIKE '%$search%' OR a.fecha_not LIKE '%$search%' OR e.estado_apren LIKE '%$search%')";
}

// Añadir condiciones de fechas
if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "a.fecha_not BETWEEN '$startDate' AND '$endDate'";
}

// Aplicar condiciones a la consulta
if (count($conditions) > 0) {
    $query .= " AND " . implode(' AND ', $conditions);
}

// Agregar limitación a la consulta
$query .= " LIMIT $offset, $records_per_page";

// Ejecutar consulta
$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}


$total_query = "SELECT COUNT(*) as total
                FROM aprendiz a
                 JOIN ficha f ON a.num_fich = f.ficha_id
                 JOIN usuario u ON a.usuario_id = u.idusuario
                 JOIN estado_apre e ON a.estado_apren = e.id_estado
                 JOIN novedad n ON a.des_novedad = n.id_novedad
                 JOIN programa p ON a.programa_nom = p.id_programa";



$total_conditions = [];

if ($rol != 1 && $rol != 3) {
    $total_conditions[] = "a.usuario_id = '$idUser'";
}

if (!empty($search)) {
    $total_conditions[] = "(a.nomb_apre LIKE '%$search%' OR a.apell_apre LIKE '%$search%' OR u.nombre LIKE '%$search%' OR p.programa_nom LIKE '%$search%' 
                            OR f.num_fich LIKE '%$search%' OR a.doc_apre LIKE '%$search%' OR a.fecha_not LIKE '%$search%' OR e.estado_apren LIKE '%$search%')";
}

if (!empty($startDate) && !empty($endDate)) {
    $total_conditions[] = "a.fecha_not BETWEEN '$startDate' AND '$endDate'";
}


if (count($total_conditions) > 0) {
    $total_query .= " WHERE " . implode(' AND ', $total_conditions);
}


$total_result = mysqli_query($conexion, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

?>




<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
   


        <form class="form-inline">
           
           <input type="date" name="startDate" class="form-control mb-2 mr-sm-2" value="<?php echo htmlspecialchars($startDate); ?>">
           <input type="date" name="endDate" class="form-control mb-2 mr-sm-2" value="<?php echo htmlspecialchars($endDate); ?>">
           <button type="submit" class="btn btn-primary mb-2">Buscar por fecha</button>
           
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
   
           <input  type="text" name="search" class="form-control mb-2 mr-sm-2" placeholder="Buscar..." value="<?php echo htmlspecialchars($search); ?>">
               <button type="submit" class="btn btn-primary mb-2">Buscar</button>
   
           </form>
       
            <?php if ($rol == 1 || $rol == 3): ?>
                <a href="generar_excel_reso.php?search=<?php echo urlencode($search); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>" class="btn btn-success mb-2 mr-sm-2">Generar Excel</a>
            <?php endif; ?>
  
      
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      

        
    </div>



    <div class="card shadow mb-4">
        
             <div class="card-header py-3">
                
                 <!-- Opciones de cantidad de registros por página -->

                   <h6 class="m-0 font-weight-bold text-primary">Filtro de los aprendices</h6>
                       </div>
                         <div class="card-body"> 
                            <div class="table-responsive">
                             <div class="mb-4">
                                <form method="get" class="form-inline">
                                    <label class="mr-sm-2">Mostrar:</label>
                                    <select name="records_per_page" class="form-control mb-2 mr-sm-2" onchange="this.form.submit()">
                                        <option value="10" <?php if ($records_per_page == 10) echo 'selected'; ?>>10</option>
                                        <option value="25" <?php if ($records_per_page == 25) echo 'selected'; ?>>25</option>
                                        <option value="50" <?php if ($records_per_page == 50) echo 'selected'; ?>>50</option>
                                        <option value="100" <?php if ($records_per_page == 100) echo 'selected'; ?>>100</option>
                                        <option value="500" <?php if ($records_per_page == 500) echo 'selected'; ?>>500</option>
                                    </select>
                                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                </form>
                            </div>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>NOMBRE Y APELLIDO</th>
                            <th>CORREO</th>
                            <th>PROGRAMA</th>
                            <th>FICHA</th>
                            <th>FECHA REPORTE</th>
                            <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
                                <th>ACCIONES</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class="truncated"><button class="toggle-btn btn btn-info">+</button></td>
                                    <td><?php echo $data['id_apre']; ?></td>
                                    <td><?php echo $data['nomb_apre'] . ' ' . $data['apell_apre']; ?></td>
                                    <td><?php echo $data['correo']; ?></td>
                                    <td><?php echo $data['programa_nom']; ?></td>
                                    <td><?php echo $data['num_fich']; ?></td>
                                    <td><?php echo $data['fecha_not']; ?></td>
                                    <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
                                        <td class="truncated">
                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                                <!-- Formulario para eliminar notificado y fecha_not, SIN action=delete_full -->
                                                <form action="eliminar_aprendiz.php?id=<?php echo $data['id_apre']; ?>" method="post" id="eliminar_aprendiz_<?php echo $data['id_apre']; ?>" class="confirmar d-inline">
                                                    <button class="btn btn-danger" onclick="confirmarEliminar(<?php echo $data['id_apre']; ?>)" type="button"><i class='fas fa-trash-alt'></i></button>
                                                </form>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>

                                </tr>
                                <tr class="details-row"> <!-- Hidden row for details -->
                                    <td colspan="15">
                                        <div>
                                          
                                            <p><strong>Nombre:</strong> <?php echo $data['nomb_apre'] . ' ' . $data['apell_apre']; ?></p>
                                            <p><strong>Documento:</strong> <?php echo $data['doc_apre']; ?></p>
                                            <p><strong>Horas:</strong> <?php echo $data['horas']; ?></p>
                                            <p><strong>Programa:</strong> <?php echo $data['programa_nom']; ?></p>
                                            <p><strong>Ficha:</strong> <?php echo $data['num_fich']; ?></p>
                                            <p><strong>Instructor:</strong> <?php echo $data['nombre']; ?></p>
                                            <p><strong>Fecha:</strong> <?php echo $data['fecha_not']; ?></p>
                                            <p><strong>Novedad:</strong> <?php echo $data['des_novedad']; ?></p>
                                            <p><strong>Estado:</strong> <?php echo $data['estado_apren']; ?></p>
                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='15'>No hay registros</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tr>
                    <th></th>
                            <th>ID</th>
                            <th>NOMBRE Y APELLIDO</th>
                            <th>CORREO</th>
                            <th>PROGRAMA</th>
                            <th>FICHA</th>
                            <th>FECHA REPORTE</th>
                            <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
                                <th>ACCIONES</th>
                            <?php } ?>
                           
                        </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- desarrolle controles de la paginai -->
    <div class="pagination">
    <?php if ($page > 1): ?>
        <a style="background-color: #fff; border-color: #101010; color: #101010;"
           href="?page=<?php echo $page - 1; ?>&records_per_page=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>"
           class="btn btn-primary">Anterior</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&records_per_page=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>"
           class="btn btn-primary <?php echo $i == $page ? 'active' : ''; ?>"
           style="background-color: #fff; border-color: #101010; color: #101010;">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a style="background-color: #fff; border-color: #101010; color: #101010;"
           href="?page=<?php echo $page + 1; ?>&records_per_page=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>"
           class="btn btn-primary">Siguiente</a>
    <?php endif; ?>
</div>


    <div class="mb-4">
        <?php
        $start = $offset + 1;
        $end = min($offset + $records_per_page, $total_records);
        echo "<p>Mostrando $start - $end de $total_records registros</p>";
        ?>
    </div>
</div>
</div>

<?php include_once "includes/footer.php"; ?>

<style>
    .truncated {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px; /* Ajusta el ancho máximo según tus necesidades */
    }
    .details-row {
        display: none;
    }
    .pagination {
        margin: 20px 0;
        text-align: center;
    }
    .pagination a {
        margin: 0 5px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        color: #007bff;
        text-decoration: none;
        border-radius: 4px;
    }
    .pagination a.active {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
</style>

<script>
    $(document).ready(function() {
        $('.toggle-btn').on('click', function() {
            var detailsRow = $(this).closest('tr').next('.details-row');
            detailsRow.toggle();
            $(this).text(detailsRow.is(':visible') ? '-' : '+');
        });
    });


    
function enviarp(id) {
    window.location.href = 'enviar_pdf.php?id=' + id;
}

function confirmarEliminar(id_apre) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará el registro de notificacíon del aprendiz.",
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
                return false;
            } else {
         
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
                })
                .catch(error => {
                    Swal.showValidationMessage('Error en la validación de la clave');
                    return false;
                });
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
 
            Swal.fire({
                title: 'Confirmación',
                text: "Se eliminara el registro de notificación del aprendiz.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
    
                    document.getElementById('eliminar_aprendiz_' + id_apre).submit();
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'Cancelado',
                text: 'El registro de notificación aprendiz no ha sido eliminado',
                icon: 'info'
            });
        }
    });
}



</script>
