<?php
require_once '../../vendor/autoload.php'; // Ajusta la ruta si es necesario
include '../../conexion.php'; // Ajusta la ruta si es necesario

use setasign\Fpdi\Fpdi;

$id = isset($_GET['id']) ? mysqli_real_escape_string($conexion, $_GET['id']) : '';
if (empty($id)) {
    die("ID no proporcionado.");
}

$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, a.correo, a.descrip, a.estado_apren, p.programa_nom, f.num_fich, u.nombre 
          FROM aprendiz a 
          JOIN ficha f ON a.num_fich = f.ficha_id 
          JOIN usuario u ON a.usuario_id = u.idusuario 
          JOIN programa p ON a.programa_nom = p.id_programa 
          WHERE a.id_apre = '$id'";

$result = mysqli_query($conexion, $query);
if (mysqli_num_rows($result) == 0) {
    die("No se encontró información para el ID proporcionado.");
}

$data = mysqli_fetch_assoc($result);

// Carga el archivo de plantilla PDF
$pdf = new FPDI();
$pageCount = $pdf->setSourceFile('formato.pdf'); // Ajusta la ruta a tu archivo formato.pdf

// Importar y usar todas las páginas del archivo de plantilla
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $template = $pdf->importPage($pageNo);
    $pdf->addPage();
    $pdf->useTemplate($template);

    // Agregar contenido dinámico solo a la primera página
    if ($pageNo == 1) {
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(29, 85); 
        $pdf->Write(0, "Nombre: " . $data['nomb_apre'] . ' ' . $data['apell_apre']);
        $pdf->SetXY(29, 90); 
        $pdf->Write(0, "Programa: " . $data['programa_nom']);
        $pdf->SetXY(29, 95); 
        $pdf->Write(0, "Ficha: " . $data['num_fich']);
        $pdf->SetXY(29, 100); 
        $pdf->Write(0, "Correo: " . $data['correo']);
    }
}

// Descarga el PDF
$pdf->Output('D', "Aprendiz_{$data['nomb_apre']}_{$data['apell_apre']}.pdf");
?>

