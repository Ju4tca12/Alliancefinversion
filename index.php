<?php
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
    header('location: sistema/');
} else {
    if (!empty($_POST)) {
        if (empty($_POST['correo']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-danger" role="alert">Ingrese su correo y su clave</div>';
        } else {
            require_once "conexion.php";
            $email = mysqli_real_escape_string($conexion, $_POST['correo']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM 
            usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.correo = '$email' AND u.clave = '$clave'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) { 
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['email'] = $dato['correo']; 
                $_SESSION['user'] = $dato['usuario'];
                $_SESSION['rol'] = $dato['idrol'];
                $_SESSION['rol_name'] = $dato['rol'];
                header('location: sistema/');
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Usuario o Contraseña Incorrecta</div>';
                session_destroy();
            }
        }
    }
}



// Nueva función para filtrar información por idusuario
function filtrarInformacionPorUsuario($tabla, $conexion) {
    $idUser = $_SESSION['idUser'];
    $query = mysqli_query($conexion, "SELECT * FROM $tabla WHERE usuario_id = '$idUser'");
    return $query;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Kreaftware Innovative</title>

  <!-- Custom fonts for this template-->
  <link href="sistema/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="estilos.css" rel="stylesheet">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body class="bg-gradient-primary">

  <div class="container-login">
    <!-- Outer Row -->

    <div class="wrap-login">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          
        <img src="../assets/img/Login.png"   style="height: 120px;
          width: 300px;   padding: 0rem;">


          <form class="login-form validate-form" id="loginuser" action="" method="post">
         
     
  
            <div class="wrap-input100" data-validate="Usuario incorrecto">
              <input class="input100" type="text" id="correo" name="correo" style=" font-family: Helvetica, Arial, sans-serif;" placeholder="Correo elctronico">
              <span class="focus-efecto"></span>
            </div>
            <div class="wrap-input100" data-validate="Contraseña incorrecto">
              <input class="input100" type="password" id="Contraseña" name="clave" style=" font-family: Helvetica, Arial, sans-serif;" placeholder="Contraseña">
              <span class="focus-efecto"></span>
            </div>
            <div class="container-login-form-btn">
              <div class="wrap-login-form-btn">
                <div class="login-form-bgbtn"></div>
                <button type="submit" id="loginuser" style=" font-family: Helvetica, Arial, sans-serif;" class="login-form-btn">INGRESAR</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="jquery/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
   
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sweetalert2@10.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="sistema/js/sb-admin-2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


  <script>
    document.getElementById('loginuser').addEventListener('click', function() {
      var correo = document.getElementById('correo').value;
      var clave = document.getElementById('clave').value;

      if (!correo || !clave) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Usuario y contraseña no pueden estar vacíos.'
        });
      } else {
        Swal.fire({
   
          icon: "success",
          title: "Bienvenido",
          showConfirmButton: false,
          timer: 1500
        }).then((result) => {
       
            document.getElementById('loginuser').submit();
         
        });
      }
    });
  </script>

</body>

</html>