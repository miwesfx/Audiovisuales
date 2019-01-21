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

echo '<h1>Detalles del espacio</h1>';

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

$id_espacio	= filter_input(INPUT_GET, 'id_espacio',	FILTER_SANITIZE_STRING);

$espacio = new Espacio($id_espacio);

?>
<form class="form-horizontal" action="espacios_edit.php" method="GET">
	<div class="form-group">
			<label class="control-label col-sm-4" for="centro">Campus: </label>
			<h5 class="col-sm-3"> <?PHP echo $espacio->mostrar_nombre_campus();?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="centro">Centro: </label>
			<h5 class="col-sm-3"> <?PHP echo $espacio->mostrar_nombre_centro();?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="espacio">Nombre del espacio: </label>
			<h5 class="col-sm-3"> <?PHP echo $espacio->mostrar_nombre_espacio();?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="planta">Planta en la que se encuentra: </label>
			<h5 class="col-sm-3"> <?PHP echo $espacio->mostrar_planta();?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="tipo">Tipo de espacio: </label>
			<h5 class="col-sm-3"> <?PHP echo $espacio->mostrar_tipo();?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="aforo">Introduzca el aforo: </label>
			<h5 class="col-sm-3"> <?PHP echo $espacio->mostrar_aforo();?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="videoconferencia">Videoconferencia: </label>
			<h5 class="col-sm-3"> <?PHP if($espacio->mostrar_videoconferencia())
											echo 'Sí';
										else
											echo 'No';
									?></h5>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="foto">Foto: </label>
			<h5 class="col-sm-3"> <?PHP echo '<img src="'.$espacio->mostrar_foto().'" alt="Foto del espacio" width="400"> '?></h5>
	</div>
	<input type="hidden" name="id_espacio" value="<?PHP echo $id_espacio;?>">
	<div class="form-group"> 
			<div class="col-sm-offset-3 col-sm-10">
				<button type="submit" class="btn btn-primary">Editar espacio</button>
			</div>
	</div>
</form>
  

</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>