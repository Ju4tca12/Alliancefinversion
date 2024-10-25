<?php
require 'vendor/autoload.php';
include "../conexion.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$startDate = isset($_GET['startDate']) ? mysqli_real_escape_string($conexion, $_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? mysqli_real_escape_string($conexion, $_GET['endDate']) : '';

// Construir la consulta base
$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.fecha_not, p.programa_nom, f.num_fich, u.nombre 
          AS nombre_usuario
          FROM aprendiz a
          JOIN ficha f ON a.num_fich = f.ficha_id
          JOIN usuario u ON a.usuario_id = u.idusuario
          JOIN programa p ON a.programa_nom = p.id_programa";

// Añadir condiciones de búsqueda
$conditions = [];

if (!empty($search)) {
    $conditions[] = "(a.nomb_apre LIKE '%$search%' OR a.apell_apre LIKE '%$search%' OR u.nombre LIKE '%$search%' OR p.programa_nom LIKE '%$search%' 
                      OR f.num_fich LIKE '%$search%' OR a.doc_apre LIKE '%$search%' OR a.fecha_not LIKE '%$search%')";
}

if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "a.fecha_not BETWEEN '$startDate' AND '$endDate'";
}

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'NOMBRE Y APELLIDO');
$sheet->setCellValue('C1', 'DOCUMENTO');
$sheet->setCellValue('D1', 'PROGRAMA');
$sheet->setCellValue('E1', 'FICHA');
$sheet->setCellValue('E1', 'FECHA_NOTIFICACIÓN');


$sheet->getColumnDimension('A')->setWidth(5);   
$sheet->getColumnDimension('B')->setWidth(35); 
$sheet->getColumnDimension('C')->setWidth(25);  
$sheet->getColumnDimension('D')->setWidth(50);  
$sheet->getColumnDimension('E')->setWidth(15);  

$sheet->getRowDimension('1')->setRowHeight(30);  


$row = 2;
while ($data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $data['id_apre']);
    $sheet->setCellValue('B' . $row, $data['nomb_apre'] . ' ' . $data['apell_apre']);
    $sheet->setCellValue('C' . $row, $data['doc_apre']);
    $sheet->setCellValue('D' . $row, $data['programa_nom']);
    $sheet->setCellValue('E' . $row, $data['num_fich']);
    $sheet->setCellValue('E' . $row, $data['fecha_not']);
    
    // Puedes ajustar la altura de las filas de datos si es necesario
    $sheet->getRowDimension($row)->setRowHeight(20);
    
    $row++;
}

// Exportar el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'resolucion.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>