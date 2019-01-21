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

echo '<h1>Agregar espacios</h1>';

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

$id_centro	= filter_input(INPUT_GET, 'id_centro',	FILTER_SANITIZE_STRING);
//echo "Id_centro: ".$id_centro;

//Carga los diferentes posibles valores del campo enum|set
$resultado = mysqli_query($connect,"SELECT COLUMN_TYPE	AS texto FROM information_schema.COLUMNS WHERE TABLE_NAME='espacios' AND COLUMN_NAME='tipo'");
$resultado = $resultado->fetch_assoc();
$tipo_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $resultado['texto']));

//Carga los diferentes posibles valores del campo enum|set
$resultado = mysqli_query($connect,"SELECT COLUMN_TYPE	AS texto FROM information_schema.COLUMNS WHERE TABLE_NAME='espacios' AND COLUMN_NAME='planta'");
$resultado = $resultado->fetch_assoc();
$planta_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $resultado['texto']));


?>
<form class="form-horizontal" action="./espacios_crear.php" method="POST">
	<div class="form-group">
		<label class="control-label col-sm-4" for="campus">Seleccione el centro donde se encuentra el espacio:</label>
		<div class="col-sm-3">
			<select class="form-control" name="campus_centro">
			<?PHP
			$resultado = mysqli_query($connect, "SELECT id_centro FROM centros ORDER BY id_campus");
			while($fila=$resultado->fetch_assoc()){
				$centro = new Centro($fila['id_centro']);
				echo '<option value="'.$centro->mostrar_id_campus().'+'.$centro->mostrar_id_centro().'"';
				if($centro->mostrar_id_centro()==$id_centro)
					echo " selected";
				echo '>'.$centro->mostrar_nombre_campus().' - '.$centro->mostrar_nombre_centro().'</option>';
			}?>
			</select>
		</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="espacio">Introduzca el nombre del espacio: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="espacio" required>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="planta">Seleccione la planta en la que se encuentra: </label>
			<div class="col-sm-3">
			<select  class="form-control" name="planta" required>
				<?PHP
				foreach($planta_array as $planta)
					echo '<option value="'.$planta.'">'.$planta.'</option>';
				?>
			</select>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="tipo">Seleccione el tipo de espacio: </label>
			<div class="col-sm-3">
			<select  class="form-control" name="tipo" required>
				<?PHP
				foreach($tipo_array as $tipo){
					echo '<option value="'.$tipo.'">'.$tipo.'</option>';
				}
				?>
			</select>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="aforo">Aforo: </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="aforo">
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="videoconferencia">Videconferencia: </label>
			<div class="col-sm-3">
			<select  class="form-control" name="videoconferencia" required>
				<option value="0">	No</option>
				<option value="1">	Sí</option>
			</select>
			</div>
	</div>
	<div class="form-group"> 
			<div class="col-sm-offset-3 col-sm-10">
				<button type="submit" class="btn btn-primary">Agregar espacio</button>
			</div>
	</div>
</form>
  

</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>