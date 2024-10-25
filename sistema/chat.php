<?php
include_once "includes/header.php";
include "../conexion.php";

// Verificar si la sesión no ha iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$idUser = $_SESSION['idUser']; // ID del usuario actual
$rol = $_SESSION['rol']; // Rol del usuario
$search = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : ''; // Búsqueda de contactos

// Consulta de usuarios para mostrar en la lista de contactos
$queryUsuarios = "SELECT idusuario, nombre, rol FROM usuario WHERE idusuario != $idUser";
if (!empty($search)) {
    $queryUsuarios .= " AND (nombre LIKE '%$search%' OR correo LIKE '%$search%')";
}
$resultUsuarios = mysqli_query($conexion, $queryUsuarios);

// Enviar mensaje al destinatario seleccionado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idDestinatario = $_POST['idDestinatario'];
    $mensaje = mysqli_real_escape_string($conexion, $_POST['mensaje']);

    $queryEnviar = "INSERT INTO mensajes (idremitente, iddestinatario, mensaje) VALUES ($idUser, $idDestinatario, '$mensaje')";
    mysqli_query($conexion, $queryEnviar);
}

// Obtener el ID del destinatario de los mensajes
$idDestinatario = isset($_GET['idDestinatario']) ? $_GET['idDestinatario'] : 0;

// Consulta para obtener los mensajes entre el usuario actual y el destinatario
$queryMensajes = "SELECT m.*, u.nombre AS nombre_remitente 
                 FROM mensajes m 
                 JOIN usuario u ON m.idremitente = u.idusuario 
                 WHERE (m.iddestinatario = $idUser AND m.idremitente = $idDestinatario) 
                    OR (m.iddestinatario = $idDestinatario AND m.idremitente = $idUser) 
                 ORDER BY m.fecha ASC";
$resultMensajes = mysqli_query($conexion, $queryMensajes);
?>

                     
<div class="container-fluid">
   
</div>




<div class="container-fluid">


                            <div class="card shadow mb-3">
                                <div class="card-header py-6">
                                    <h6 class="m-0 font-weight-bold text-primary">Aprendices en deserción</h6>
                                </div>
                                <div class="row">
                                    
        <div class="col-lg-4">
        &nbsp&nbsp&nbsp
            <!-- Buscador de contactos -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <form method="GET" action="chat.php" class="form-inline mb-4">
                            <div class="search-container">
                                <input type="text" id="searchInput" name="search" class="form-control mb-2 mr-sm-2" placeholder="Buscar usuario..." value="<?php echo htmlspecialchars($search); ?>">
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button type="button" class="reset-button" onclick="resetSearch()">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Lista de contactos -->
            <div class="list-group">
                <?php while ($usuario = mysqli_fetch_assoc($resultUsuarios)) {
                    if ($rol == 2 && $usuario['rol'] == 2) {
                        continue;
                    }
                ?>
                    <a href="chat.php?idDestinatario=<?php echo $usuario['idusuario']; ?>" class="list-group-item list-group-item-action <?php echo ($idDestinatario == $usuario['idusuario']) ? 'active' : ''; ?>">
                        <?php echo $usuario['nombre']; ?>
                    </a>
                <?php } ?>
                
            </div>
        </div>

        <div class="col-lg-8">

        &nbsp&nbsp&nbsp
            <!-- Área del chat -->
            <?php if ($idDestinatario != 0) { ?>
                <div class="chat-box">
                    <?php while ($mensaje = mysqli_fetch_assoc($resultMensajes)) { ?>
                        <div class="message">
                            <strong><?php echo $mensaje['nombre_remitente']; ?>:</strong>
                            <p><?php echo $mensaje['mensaje']; ?></p>
                            <div class="time"><?php echo $mensaje['fecha']; ?></div>
                        </div>
                    <?php } ?>
                </div>
                <form method="POST" action="chat.php?idDestinatario=<?php echo $idDestinatario; ?>" class="form-inline mt-4" style="position: relative;">
                    <textarea name="mensaje" style="width: 950px; padding-right: 100px;" class="form-control mr-sm-2" placeholder="Escribe tu mensaje..." required></textarea>
                    <input type="hidden" name="idDestinatario" value="<?php echo $idDestinatario; ?>">
                    <button type="submit" class="btn btn-primary" style="position: absolute; right: 0; top: 10; height: 100%; width: 15%; border: none; background: transparent; color: green;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            <?php } else { ?>
                <div class="alert alert-info">Seleccione un Chat</div>
            <?php } ?>
        </div>
    </div>
                                    <hr>
                                    Styling for the area chart can be found in the
                               
                            </div>

			
</div>
</div>


<?php include "includes/footer.php"; ?>



