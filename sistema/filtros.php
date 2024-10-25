<?php
include_once "includes/header.php";
include "../conexion.php";

$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;

// Número de la página actual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Obtener y sanitizar parámetros de búsqueda y fechas
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$startDate = isset($_GET['startDate']) ? mysqli_real_escape_string($conexion, $_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? mysqli_real_escape_string($conexion, $_GET['endDate']) : '';
$notificado = isset($_GET['notificado']) ? mysqli_real_escape_string($conexion, $_GET['notificado']) : ''; // 0 o 1
$aprob = isset($_GET['aprob']) ? mysqli_real_escape_string($conexion, $_GET['aprob']) : '';

$idUser = $_SESSION['idUser'];
$rol = $_SESSION['rol'];

// Construir la consulta base
$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, a.correo, a.descrip, a.fecha_rep, a.aprob, a.notificado, 
                 p.programa_nom, f.num_fich, u.nombre, n.des_novedad, e.estado_apren 
          FROM aprendiz a
          JOIN ficha f ON a.num_fich = f.ficha_id
          JOIN usuario u ON a.usuario_id = u.idusuario
          JOIN estado_apre e ON a.estado_apren = e.id_estado
          JOIN novedad n ON a.des_novedad = n.id_novedad
          JOIN programa p ON a.programa_nom = p.id_programa";

// Añadir condiciones según el rol
if ($rol != 1 && $rol != 3) {
    $query .= " WHERE a.usuario_id = '$idUser'";
}

// Añadir condiciones de búsqueda
$conditions = [];

// Filtros de búsqueda general
if (!empty($search)) {
    $conditions[] = "(a.nomb_apre LIKE '%$search%' OR a.apell_apre LIKE '%$search%' OR u.nombre LIKE '%$search%' OR p.programa_nom LIKE '%$search%' 
                      OR f.num_fich LIKE '%$search%' OR a.doc_apre LIKE '%$search%' OR a.fecha_rep LIKE '%$search%' OR a.aprob LIKE '%$search%' 
                      OR e.estado_apren LIKE '%$search%')";
}

// Filtros por fecha
if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "a.fecha_rep BETWEEN '$startDate' AND '$endDate'";
}

// Filtro por estado de notificación
if ($notificado !== '') {
    $conditions[] = "a.notificado = '$notificado'";
}

// Filtro por estado de aprobación
if (!empty($aprob)) {
    $conditions[] = "a.aprob = '$aprob'";
}

// Aplicar condiciones a la consulta
if (count($conditions) > 0) {
    if (strpos($query, 'WHERE') === false) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    } else {
        $query .= " AND " . implode(' AND ', $conditions);
    }
}

// Limitar resultados
$query .= " LIMIT $offset, $records_per_page";

// Ejecutar consulta
$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Consulta para conteo total
$total_query = "SELECT COUNT(*) as total
                FROM aprendiz a
                JOIN ficha f ON a.num_fich = f.ficha_id
                JOIN usuario u ON a.usuario_id = u.idusuario
                JOIN estado_apre e ON a.estado_apren = e.id_estado
                JOIN novedad n ON a.des_novedad = n.id_novedad
                JOIN programa p ON a.programa_nom = p.id_programa";

// Añadir condiciones de rol y búsqueda a la consulta total
$total_conditions = [];

if ($rol != 1 && $rol != 3) {
    $total_conditions[] = "a.usuario_id = '$idUser'";
}

if (!empty($startDate) && !empty($endDate)) {
    $total_conditions[] = "a.fecha_rep BETWEEN '$startDate' AND '$endDate'";
}

// Aplicar condiciones a la consulta total
if (count($total_conditions) > 0) {
    $total_query .= " WHERE " . implode(' AND ', $total_conditions);
}

// Ejecutar consulta de conteo total
$total_result = mysqli_query($conexion, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);
?>



<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-3">


<form class="form-inline" method="get">
    <!-- Existing search and date filters -->
    <input type="text" name="search" class="form-control mb-2 mr-sm-2" placeholder="Buscar..." value="<?php echo htmlspecialchars($search); ?>">
    <input type="date" name="startDate" class="form-control mb-2 mr-sm-2" value="<?php echo htmlspecialchars($startDate); ?>">
    <input type="date" name="endDate" class="form-control mb-2 mr-sm-2" value="<?php echo htmlspecialchars($endDate); ?>">
                <select name="notificado" class="form-control mb-2 mr-sm-2">
                        <option value="">-- Notificado --</option>
                        <option value="1" <?php if ($notificado === '1') echo 'selected'; ?>>Sí</option>
                        <option value="0" <?php if ($notificado === '0') echo 'selected'; ?>>No</option>
                    </select>
                <select name="aprob" class="form-control mb-2 mr-sm-2">
                    <option value="">-- Aprobación --</option>
                    <option value="aprobar" <?php if ($aprob === 'aprobar') echo 'selected'; ?>>Aprobado</option>
                    <option value="rechazar" <?php if ($aprob === 'rechazar') echo 'selected'; ?>>No Aprobado</option>
                    <option value="seleccione" <?php if ($aprob === 'seleccione') echo 'selected'; ?>>Sin seleccionar</option>
                </select>


    <button type="submit" class="btn btn-primary mb-2">Buscar</button>
</form>


<?php if ($rol == 1 || $rol == 3): ?>
    <a href="generar_excel_not.php?search=<?php echo urlencode($search); ?> &aprob=<?php echo urlencode($aprob); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>" class="btn btn-success mb-2 mr-sm-2">Generar Excel</a>
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
                                    <td class="truncated"><?php echo $data['id_apre'];?> </td>
                                    <td  class="truncated"><?php echo $data['nomb_apre'] . ' ' . $data['apell_apre']; ?></td>
                                    <td><?php echo $data['correo']; ?></td>
                                    <td class="truncated"><?php echo $data['programa_nom']; ?></td>
                                    <td><?php echo $data['num_fich']; ?></td>
                                    <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) { ?>
                                        <td class="truncated">
                                        <a href="editar_aprendiz.php?id=<?php echo $data['id_apre']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                            <a  href="dompdf/cartas.php?id=<?php echo $data['id_apre']; ?>" type="button" data-toggle="tooltip" title="Ver" class="btn docs-tooltip btn-warning btn-xs" style="background-color: #6fc7fc; border-color: #acebf7; color: #fff"><i class="fa fa-eye"></i></a>
                                            <a href="dompdf/descargar_carta.php?id=<?php echo $data['id_apre']; ?>" class="btn btn-danger" title="Descargar"><i class='fas fa-file-pdf'></i></a>
                                            <a type="button" data-toggle="tooltip" onclick="enviarp('<?php echo $data['id_apre']; ?>')" title="Enviar PDF" class="btn docs-tooltip btn-warning btn-xs" style="background-color: #fce34f; border-color: #fce34f; color: #fff"><i class="fa fa-envelope-open"></i></a>
                                            <?php if ($_SESSION['rol'] == 1) { ?>
                                    
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
                                            <p><strong>Fecha:</strong> <?php echo $data['fecha_rep']; ?></p>
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
        <a style="background-color: #fff; border-color: #ebebeb; color: #858796;"
           href="?page=<?php echo $page - 1; ?>&records_per_page=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>"
           class="btn btn-primary">Anterior</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&records_per_page=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>&startDate=<?php echo urlencode($startDate); ?>&endDate=<?php echo urlencode($endDate); ?>"
           class="btn btn-primary <?php echo $i == $page ? 'active' : ''; ?>"
           style="background-color: #fff; border-color: #ebebeb; color: #858796;">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a style="background-color: #fff; border-color: #ebebeb; color: #858796;"
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
    // Realizar una verificación de las horas del aprendiz antes de enviar el correo
    $.ajax({
        url: 'verificaciones.php',  // Archivo que verifica las horas del aprendiz
        type: 'POST',
        data: { id_apre: id },
        success: function(response) {
            var data = JSON.parse(response);

            if (data.horas == 0 || data.horas == '' || data.horas === null) {
                Swal.fire(
                    'Aprendiz sin horas',
                    'Este aprendiz no tiene horas asignadas.',
                    'warning'
                );
            } else if (data.estado_apren == 2) {
                Swal.fire(
                    'Aprendiz Cancelado',
                    'El aprendiz ya se encuentra cancelado en sofia plus, no se puede enviar la carta.',
                    'warning'
                );
            } else if (data.estado_apren == 6) {
                Swal.fire(
                    'Aprendiz sin estado',
                    'El aprendiz se encuentra sin estado, no se puede enviar la carta.',
                    'warning'
                );
            } else if (data.estado_apren == 3) {
                Swal.fire(
                    'Aprendiz en retiro voluntario',
                    'El aprendiz se encuentra en estado de retiro voluntario, no se puede enviar la carta.',
                    'warning'
                );
            } else if (data.estado_apren == 4) {
                Swal.fire(
                    'Aprendiz aplazado',
                    'El aprendiz se encuentra en estado aplazado en sofia plus, no se puede enviar la carta.',
                    'warning'
                );
            } else if (data.notificado == 1) {
                Swal.fire(
                    'Aprendiz ya notificado',
                    'Este aprendiz ya fue notificado, no se puede enviar la carta de nuevo.',
                    'warning'
                );
            } else if (data.aprob === 'rechazar' || data.aprob === 'seleccione' || data.aprob === '') {
                Swal.fire(
                    'Aprendiz no aprobado por mesa directiva',
                    'El aprendiz no fue aprobado por la mesa directiva, no se puede enviar la carta.',
                    'warning'
                );
            } else {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Se enviará la carta al aprendiz.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, enviar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si confirma, se envía el PDF
                        $.ajax({
                            url: 'enviar_pdf.php?id=' + id,
                            type: 'POST',
                            data: { id_apre: id }, 
                            success: function(response) {
                                Swal.fire(
                                    'Enviado',
                                    'El correo se envió satisfactoriamente.',
                                    'success'
                                ).then(() => {
                                    window.location.href = 'filtros.php';
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Error',
                                    'No se pudo enviar la carta al correo.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        },
        error: function() {
            Swal.fire(
                'Error',
                'No se pudo verificar las horas del aprendiz.',
                'error'
            );
        }
    });
}




</script>

