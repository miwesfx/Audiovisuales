<?php   
session_start();
if(!userIsAuth()){
    header('Location: ./index.php');
  }
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
	
	<script>
		function cargarPagina() {
			location.href = "./index.php";
		}
	</script>
  <!-- ES -->
 </head>
<body onload="setTimeout(cargarPagina, 2000);">
<div class="contenido">
<?PHP

include_once './cabecera.php';
include_once './clases.php';
include_once './conexion.php';

echo '<h1>Actualizando espacio</h1>';

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

$id_espacio			= filter_input(INPUT_POST, 'id_espacio',		FILTER_SANITIZE_STRING);
$nombre				= filter_input(INPUT_POST, 'nombre',			FILTER_SANITIZE_STRING);
$planta				= filter_input(INPUT_POST, 'planta',			FILTER_SANITIZE_STRING);
$tipo				= filter_input(INPUT_POST, 'tipo',				FILTER_SANITIZE_STRING);
$aforo				= filter_input(INPUT_POST, 'aforo',				FILTER_SANITIZE_STRING);
$videoconferencia	= filter_input(INPUT_POST, 'videoconferencia',	FILTER_SANITIZE_STRING);


$espacio = new Espacio($id_espacio);


if(!empty($nombre))
				$espacio->modificar_nombre($nombre);
if(!empty($planta))
				$espacio->modificar_planta($planta);			
if(!empty($tipo))
				$espacio->modificar_tipo($tipo);			
if(!empty($aforo))
				$espacio->modificar_aforo($aforo);			
if(!empty($videoconferencia))
				$espacio->modificar_videoconferencia($videoconferencia);			
?>

</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>