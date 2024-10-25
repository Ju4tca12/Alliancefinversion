<?php
require '../vendor/autoload.php';
include '../conexion.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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



$nomb_apre = isset($data['nomb_apre']) ? $data['nomb_apre'] : 'Desconocido';
$apell_apre = isset($data['apell_apre']) ? $data['apell_apre'] : 'Desconocido';
$correo_aprendiz = $data['correo'];

$tempDir = 'C:\wamp64\projet_sena\Alliance\sistema'; 

if (!is_dir($tempDir)) {
    mkdir($tempDir, 0777, true);
}

$pdfFilename = "aprendiz{$nomb_apre}_{$apell_apre}.pdf";
$pdfPath = $tempDir . DIRECTORY_SEPARATOR . $pdfFilename; 

if (!file_exists('dompdf/formato.pdf')) {
    die("El archivo formato.pdf no se encuentra.");
}

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile('dompdf/formato.pdf'); 

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $template = $pdf->importPage($pageNo);
    $pdf->addPage();
    $pdf->useTemplate($template);

    if ($pageNo == 1) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(29, 85); 
        $pdf->Write(0, "Nombre: " . $nomb_apre . ' ' . $apell_apre);
        $pdf->SetXY(29, 90); 
        $pdf->Write(0, "Programa: " . $data['programa_nom']);
        $pdf->SetXY(29, 95); 
        $pdf->Write(0, "Ficha: " . $data['num_fich']);
        $pdf->SetXY(29, 100); 
        $pdf->Write(0, "Correo: " . $correo_aprendiz);
    }
}

$pdf->Output($pdfPath, 'F'); 

// Enviar el correo
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPDebug = 2; 
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jumancamilo@gmail.com';
    $mail->Password = 'fvzphqvdvorxxtom';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('jumancamilo@gmail.com', 'Correo de prueba');
    $mail->addAddress($correo_aprendiz);

  
    $mail->addCC('juantellez@kreaftware.com ');

    $mail->isHTML(true);
    $mail->Subject = 'Proceso de desercion "correo de prueba"';
    $mail->Body = 'Este correo es unicamente de prueba, hacer caso omiso a la deserción';

  
    $mail->addAttachment($pdfPath, $pdfFilename);

    $autorizacionPath = 'dompdf/autorizacion.pdf';
    $autorizacionFilename = 'AUTORIZACION PARA NOTIFICACION POR VIA ELECTRONICA';

    if (file_exists($autorizacionPath)) {

    $mail->addAttachment($autorizacionPath, $autorizacionFilename);
    } else {
        echo "El archivo autorización.pdf no se encuentra.";
    }

    $mail->send();
    echo 'El correo ha sido enviado con éxito';

   
    $updateQuery = "UPDATE aprendiz SET notificado = 1, fecha_not = NOW() WHERE id_apre = '$id'";
    mysqli_query($conexion, $updateQuery);

  
    if (file_exists($pdfPath)) {
        unlink($pdfPath);
    }

} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}

?>
