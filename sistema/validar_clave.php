<?php

$clave_encriptada_bd = '$2y$10$AW6wgQDGroEbJUpIXKKcCuof.sDxZzDf8bt3c5sGY/lFoHj3mHP6q';

$clave_ingresada = isset($_POST['clave']) ? $_POST['clave'] : '';


if (password_verify($clave_ingresada, $clave_encriptada_bd)) {
    echo 'Clave válida';
} else {
    echo 'Clave incorrecta';
}
?>
