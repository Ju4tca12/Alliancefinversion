<?php
require 'vendor/autoload.php';
include "../conexion.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtener y sanitizar parámetros de búsqueda y fechas
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$startDate = isset($_GET['startDate']) ? mysqli_real_escape_string($conexion, $_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? mysqli_real_escape_string($conexion, $_GET['endDate']) : '';

// Construir la consulta base
$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, p.programa_nom, f.num_fich, u.nombre AS nombre_usuario
          FROM aprendiz a
          JOIN ficha f ON a.num_fich = f.ficha_id
          JOIN usuario u ON a.usuario_id = u.idusuario
          JOIN programa p ON a.programa_nom = p.id_programa";

// Añadir condiciones de búsqueda
$conditions = [];

if (!empty($search)) {
    $conditions[] = "(a.nomb_apre LIKE '%$search%' OR a.apell_apre LIKE '%$search%' OR u.nombre LIKE '%$search%' OR p.programa_nom LIKE '%$search%' 
                      OR f.num_fich LIKE '%$search%' OR a.doc_apre LIKE '%$search%' OR a.fecha_rep LIKE '%$search%')";
}

if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "a.fecha_rep BETWEEN '$startDate' AND '$endDate'";
}

// Aplicar condiciones a la consulta
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

// Ejecutar consulta
$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Crear archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Definir encabezados de las columnas
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'NOMBRE');
$sheet->setCellValue('C1', 'APELLIDO');
$sheet->setCellValue('D1', 'T. DOCUMENTO');
$sheet->setCellValue('E1', 'DOCUMENTO');
$sheet->setCellValue('F1', 'HORAS');
$sheet->setCellValue('G1', 'PROGRAMA');
$sheet->setCellValue('H1', 'FICHA');
$sheet->setCellValue('I1', 'INSTRUCTOR');

// Llenar los datos
$row = 2;

while ($data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $data['id_apre']);
    $sheet->setCellValue('B' . $row, $data['nomb_apre']);
    $sheet->setCellValue('C' . $row, $data['apell_apre']);
    $sheet->setCellValue('D' . $row, $data['tip_doc']);
    $sheet->setCellValue('E' . $row, $data['doc_apre']);
    $sheet->setCellValue('F' . $row, $data['horas']);
    $sheet->setCellValue('G' . $row, $data['programa_nom']);
    $sheet->setCellValue('H' . $row, $data['num_fich']);
    $sheet->setCellValue('I' . $row, $data['nombre_usuario']);
    $row++;
}

// Exportar el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'Consolidado.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
