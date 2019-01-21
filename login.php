<?php   
session_start();
?>
<?php
function userIsAuth(){
  // Si no hay una sesión iniciada, lo hacemos
  if ( !isset($_SESSION) ){
    session_start();
  }
 
  // If existe la variable de sesión "user" entonces es que un usuario ha iniciado sesión
  if ( isset($_SESSION['uid']) ){
    return true;
  } else {
    return false;
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Control salas audiovisuales</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- ES -->
 </head>

<body>
<div class="contenido">
<?php
include_once './cabecera.php';
include_once './conexion.php';

function login($username, $password){
  if ( !isset($_SESSION) ){
    session_start();
  }
 //-----------------------------
 
 $ldaphost = "ldap://ldap.uca.es/";

// Conexión al servidor LDAP
$ldapconn = ldap_connect($ldaphost)
          or die("Could not connect to \{$ldaphost\}");

// Ejemplo de autenticación
$ldaprdn  = 'cn='.$username.',dc=uca,dc=es';     // ldap rdn or dn
$ldappass = $password;  // associated password


if ($ldapconn) {

    // realizando la autenticación
	error_reporting(E_ERROR | E_PARSE | E_NOTICE); //Evita que aparezca un Warning en pantalla si no valida contra el LDAP
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
	
    // verificación del enlace
    if ($ldapbind) {
        //echo "LDAP bind successful...<br>";
		$_SESSION['uid'] = $username;
		// Busca la entrada del UID del usuario
		$sr=ldap_search($ldapconn, "dc=uca, dc=es", "uid=$username");
		$info = ldap_get_entries($ldapconn, $sr);		
		/*
		for ($i=0; $i<$info["count"]; $i++) {
			echo "Nombre: " . $info[$i]["fn"][0] ." ". $info[$i]["sn1"][0] ." ".$info[$i]["sn2"][0] ."<br />";
		}
		*/
		//echo "Closing connection";
		ldap_close($ldapconn);
		return true;
	}
	else 
		return false;
	}
}


function do_html_form_login(){
    ?>
	<div class="row">
		<div class="col-sm-4 col-md-offset-4">
			<h1>Login</h1>
				
			<!--el siguiente formulario inserta un jugador en la tabla de jugadores. Crear una página de registro de nuevo jugador-->
			<form action="login.php" method="post">
				<div class="form-group">
					<label>Nombre de usuario: </label><input type="text" class="form-control" name="username" required="required"><br>
					
					<label>Password: </label><input type="password" class="form-control" name="password" required="required"><br>
					
					<p><input class="btn btn-primary btn-send" type="submit" value="Entrar"></p>
				</div>
			</form>
		</div>
	</div>
<?PHP
	}
	
	// Comprobamos si hemos iniciado sesión con anterioridad
if (userIsAuth()) {
  echo '<p>Tienes una sesión abierta como <b>'.$_SESSION['uid'].'</b></p><p>¿Quieres cerrar la sesión actual?</p>
		<p><a href="logout.php" class="btn btn-danger btn-send btn-lg" style="color:white;"> Cerrar sesión </a> | 
		<a href="index.php" class="btn btn-primary btn-send btn-lg" style="color:white;"> Continuar navegando </a></p>
		</div></div>';
  include_once './footer.php';
  exit;// Para que no muestre el cuadro de login
// Comprobamos si hemos recibido algo del formulario de login y que estos datos no sean vacios
} else if ($_POST) {
  if (!empty($_POST['username']) && !empty($_POST['password']) ) {
 
    $username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);  //filtra la entrada para no acceder directamente al array global $_POST
    $password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);  //filtra la entrada para no acceder directamente al array global $_POST
 
    if ( login($username, $password) ) {
      echo 'Enhorabuena ' . htmlentities($username) . '. Te has autenticado correctamente. Serás redireccionado a la pantalla de <a href="index.php">inicio</a>';
	  echo "<script>setTimeout(cargarInicio, 1000);
			function cargarInicio() {
			location.href = \"./index.php\";
			}</script>";
		echo "</div></div>";
		include_once './footer.php';
      exit;
    } else {
		echo '<div class="row">
				<div class="col-sm-4 col-md-offset-4">
					<div class="alert alert-danger">
						<strong>¡Error!</strong> No hemos encontrado este nombre de usuario y/o contraseña en nuestra base de datos
					</div>
				</div>
			</div>';
    }
 
  } else {
    echo '¡Tienes que rellenar todos los campos!';
  }
}
do_html_form_login();

?>

</div>
</div>
<?php 
include_once './footer.php';
?>
</body>
</html>