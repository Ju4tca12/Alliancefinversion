<?php
include "../conexion.php";
require 'vendor/autoload.php'; // Asegúrate de tener PhpSpreadsheet instalado

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtener parámetros de filtro
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$startDate = isset($_GET['startDate']) ? mysqli_real_escape_string($conexion, $_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? mysqli_real_escape_string($conexion, $_GET['endDate']) : '';
$num_fich = isset($_GET['num_fich']) ? mysqli_real_escape_string($conexion, $_GET['num_fich']) : '';
$notificado = isset($_GET['notificado']) ? mysqli_real_escape_string($conexion, $_GET['notificado']) : '';
$aprob = isset($_GET['aprob']) ? mysqli_real_escape_string($conexion, $_GET['aprob']) : '';

// Construir la consulta base
$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, a.correo, a.descrip, a.fecha_rep, a.aprob, a.notificado, 
                  p.programa_nom, f.num_fich, u.nombre, n.des_novedad, e.estado_apren 
          FROM aprendiz a
          JOIN ficha f ON a.num_fich = f.ficha_id
          JOIN usuario u ON a.usuario_id = u.idusuario
          JOIN estado_apre e ON a.estado_apren = e.id_estado
          JOIN novedad n ON a.des_novedad = n.id_novedad
          JOIN programa p ON a.programa_nom = p.id_programa";

// Añadir condiciones de búsqueda
$conditions = [];

if (!empty($search)) {
    $conditions[] = "(a.nomb_apre LIKE '%$search%' OR a.apell_apre LIKE '%$search%' OR u.nombre LIKE '%$search%' OR p.programa_nom LIKE '%$search%' 
                      OR f.num_fich LIKE '%$search%' OR a.doc_apre LIKE '%$search%' OR a.fecha_rep LIKE '%$search%' OR a.aprob LIKE '%$search%' 
                      OR e.estado_apren LIKE '%$search%')";
}

if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "a.fecha_rep BETWEEN '$startDate' AND '$endDate'";
}

if (!empty($aprob)) {
    $conditions[] = "a.aprob = '$aprob'";
}

// Aplicar condiciones a la consulta
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

// Ejecutar consulta para obtener los datos
$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar los encabezados de columna
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Apellido');
$sheet->setCellValue('D1', 'Documento');
$sheet->setCellValue('E1', 'Tipo Documento');
$sheet->setCellValue('F1', 'Horas');
$sheet->setCellValue('G1', 'Correo');
$sheet->setCellValue('H1', 'Descripción');
$sheet->setCellValue('I1', 'Fecha Reporte');
$sheet->setCellValue('J1', 'Aprobación');
$sheet->setCellValue('K1', 'Notificado');
$sheet->setCellValue('L1', 'Programa');
$sheet->setCellValue('M1', 'Número de Ficha');
$sheet->setCellValue('N1', 'Nombre Usuario');
$sheet->setCellValue('O1', 'Descripción Novedad');
$sheet->setCellValue('P1', 'Estado');

// Agregar los datos al archivo Excel
$rowNum = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNum, $row['id_apre']);
    $sheet->setCellValue('B' . $rowNum, $row['nomb_apre']);
    $sheet->setCellValue('C' . $rowNum, $row['apell_apre']);
    $sheet->setCellValue('D' . $rowNum, $row['doc_apre']);
    $sheet->setCellValue('E' . $rowNum, $row['tip_doc']);
    $sheet->setCellValue('F' . $rowNum, $row['horas']);
    $sheet->setCellValue('G' . $rowNum, $row['correo']);
    $sheet->setCellValue('H' . $rowNum, $row['descrip']);
    $sheet->setCellValue('I' . $rowNum, $row['fecha_rep']);
    $sheet->setCellValue('J' . $rowNum, $row['aprob']);
    $sheet->setCellValue('K' . $rowNum, $row['notificado']);
    $sheet->setCellValue('L' . $rowNum, $row['programa_nom']);
    $sheet->setCellValue('M' . $rowNum, $row['num_fich']);
    $sheet->setCellValue('N' . $rowNum, $row['nombre']);
    $sheet->setCellValue('O' . $rowNum, $row['des_novedad']);
    $sheet->setCellValue('P' . $rowNum, $row['estado_apren']);
    $rowNum++;
}

// Escribir el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'datos_filtrados.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
