<!-- formato_pdf.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formato PDF</title>
    <style>
        /* Estilos personalizados para el formato PDF */
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin: 20px;
        }
        .content p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Información del Aprendiz</h1>
    </div>
    <div class="content">
        <p><strong>Nombre:</strong> <?php echo $data['nomb_apre']; ?></p>
        <p><strong>Apellido:</strong> <?php echo $data['apell_apre']; ?></p>
        <p><strong>Correo:</strong> <?php echo $data['correo']; ?></p>
        <p><strong>Programa:</strong> <?php echo $data['programa_nom']; ?></p>
        <p><strong>Ficha:</strong> <?php echo $data['num_fich']; ?></p>
        <!-- Agrega más campos según sea necesario -->
    </div>
    <div class="footer">
        <p>Footer del documento</p>
    </div>
</body>
</html>
