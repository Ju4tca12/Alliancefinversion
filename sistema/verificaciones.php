<?php
include "../conexion.php";

$id_apre = isset($_POST['id_apre']) ? (int)$_POST['id_apre'] : 0;

if ($id_apre === 0) {
    echo json_encode(['error' => 'No se recibió el ID del aprendiz.']);
    exit;
}

// Consulta a la base de datos para obtener las horas, estado y notificado del aprendiz
$query = "SELECT horas, estado_apren, notificado, aprob FROM aprendiz WHERE id_apre = $id_apre";
$result = mysqli_query($conexion, $query);

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta a la base de datos: ' . mysqli_error($conexion)]);
    exit;
}

$aprendiz = mysqli_fetch_assoc($result);

if (!$aprendiz) {
    echo json_encode(['error' => 'No se encontró al aprendiz con el ID proporcionado.']);
    exit;
}

// Devolver los datos en formato JSON
echo json_encode([
    'horas' => $aprendiz['horas'],
    'estado_apren' => $aprendiz['estado_apren'],
    'notificado' => $aprendiz['notificado'],
    'aprob' => $aprendiz['aprob']
]);
?>
