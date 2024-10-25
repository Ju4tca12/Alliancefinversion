<?php

$nueva_clave = '12345'; 
$nueva_clave_encriptada = password_hash($nueva_clave, PASSWORD_DEFAULT);


echo "Clave encriptada: " . $nueva_clave_encriptada;
?>
