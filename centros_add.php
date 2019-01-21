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

echo '<h1>Agregar centros</h1>';

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");


$resultado = mysqli_query($connect, "SELECT id_campus,nombre FROM campus ORDER BY nombre");
?>

<form class="form-horizontal" action="./centros_crear.php" method="POST">
	<div class="form-group">
		<label class="control-label col-sm-4" for="campus">Seleccione el campus donde se encuentra el centro:</label>
		<div class="col-sm-2">
			<select class="form-control" name="id_campus">
			<?PHP
			while($fila=$resultado->fetch_assoc()){
				echo '<option value="'.$fila['id_campus'].'">'.$fila['nombre'].'</option>';
			}?>
			</select>
		</div>
	</div>	
	<div class="form-group">
			<label class="control-label col-sm-4" for="centro">Introduzca el nombre del centro: </label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="centro" required>
			</div>
	</div>
	<div class="form-group"> 
			<div class="col-sm-offset-3 col-sm-10">
				<button type="submit" class="btn btn-primary">Agregar centro</button>
			</div>
	</div>
</form>






  

</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>