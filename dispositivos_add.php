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
  <!-- ES -->
 </head>
<body>
<div class="contenido">
<?PHP

include_once './cabecera.php';
include_once './clases.php';
include_once './conexion.php';

echo '<h1>Agregar dispositivos</h1>';

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

?>
<form class="form-horizontal" action="/dispositivos_crear.php" method="POST">	
	<div class="form-group">
			<label class="control-label col-sm-4" for="cod_modelo">Introduzca el código del modelo del dispositivo: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="cod_modelo" required>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="tipo">Introduzca el tipo: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="tipo" required> 
				Videoproyector, pantalla, monitor, soporte, pizarra interactiva, selector, distribuidor, escalador, extensor, cámara, joystick, tarjeta digitalizadora, videograbador IP, mesa mezcla
				amplificador, etapa de potencia, amplificador-mezclador, mezclador, matriz de sonido, cancelador, caja acústica,micrófonía inalámbrica, sistema de debate, botonera de control, unidad de control
				caja de conexiones, conexión inalámbrica, mesa de profesor, rack, atril, mesa de presidencia, cableado, cuadro eléctrico, iluminación
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="serie">Introduzca el número de serie: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="serie" required>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="inventario">Introduzca el número de inventario: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="inventario" required>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="instalacion">Introduzca la fecha de instalación: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="instalacion" required>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="entrega">Introduzca la fecha de entrega: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="entrega" required>
			</div>
	</div>
	<div class="form-group"> 
			<div class="col-sm-offset-3 col-sm-10">
				<button type="submit" class="btn btn-primary">Agregar dispositivo</button>
			</div>
	</div>
</form>
  

</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>