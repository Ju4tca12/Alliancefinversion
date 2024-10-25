<?php
require_once '../../vendor/autoload.php'; // Incluye la autoload para las librerías necesarias
include '../../conexion.php'; // Incluye la conexión a la base de datos

use setasign\Fpdi\Fpdi;

$id = isset($_GET['id']) ? mysqli_real_escape_string($conexion, $_GET['id']) : '';
if (empty($id)) {
    die("ID no proporcionado."); // Valida que el ID esté presente
}

// Consulta SQL para obtener los datos del aprendiz
$query = "SELECT a.id_apre, a.nomb_apre, a.apell_apre, a.doc_apre, a.tip_doc, a.horas, a.correo, a.descrip, a.estado_apren, p.programa_nom, f.num_fich, u.nombre 
          FROM aprendiz a 
          JOIN ficha f ON a.num_fich = f.ficha_id 
          JOIN usuario u ON a.usuario_id = u.idusuario 
          JOIN programa p ON a.programa_nom = p.id_programa 
          WHERE a.id_apre = '$id'";

$result = mysqli_query($conexion, $query);
if (mysqli_num_rows($result) == 0) {
    die("No se encontró información para el ID proporcionado."); // Valida que el ID sea válido
}

$data = mysqli_fetch_assoc($result); // Obtiene los datos del aprendiz

// Carga el archivo de plantilla PDF
$pdf = new FPDI();
$pageCount = $pdf->setSourceFile('formato.pdf'); // Ruta al archivo de plantilla PDF

// Importa todas las páginas de la plantilla
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $template = $pdf->importPage($pageNo);
    $pdf->addPage();
    $pdf->useTemplate($template);

    // Si es la primera página, se llenan los datos específicos
    if ($pageNo == 1) {
        $pdf->SetFont('Arial', '', 11); // Configura la fuente
        $pdf->SetXY(29, 85); 
        $pdf->Write(0, "Nombre: " . $data['nomb_apre'] . ' ' . $data['apell_apre']); // Nombre del aprendiz
        $pdf->SetXY(29, 90); 
        $pdf->Write(0, "Programa: " . $data['programa_nom']); // Programa del aprendiz
        $pdf->SetXY(29, 95); 
        $pdf->Write(0, "Ficha: " . $data['num_fich']); // Número de ficha
        $pdf->SetXY(29, 100); 
        $pdf->Write(0, "Correo: " . $data['correo']); // Correo electrónico
    }
}

// Genera el PDF y lo envía al navegador con un nombre específico
$pdf->Output("Aprendiz_{$data['nomb_apre']}_{$data['apell_apre']}.pdf", 'I');
?>
