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

$id_espacio	= filter_input(INPUT_GET, 'id_espacio',	FILTER_SANITIZE_STRING);

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

if(isset($id_espacio)){
	$espacio = new Espacio($id_espacio);
	echo '<h1>Dispositivos en '.$espacio->mostrar_nombre_espacio().'</h1>';
}
else 
	echo '<h1>Dispositivos</h1>';
?>

<table class="table table-hover">
    <thead>
      <tr>
		<th>Código de modelo	</th>
		<th>Tipo				</th>
		<th>Fecha de instalación</th>
		<th>Fecha de entrega	</th>
		<th>Número de serie		</th>
		<th>Nº Inventario		</th>
      </tr>
    </thead>
    <tbody>        

<?PHP
if(isset($id_espacio))
	$resultado = mysqli_query($connect, "SELECT id_dispositivo,id_espacio,cod_modelo,tipo,fecha_instalacion,fecha_entrega,serie,inventario FROM dispositivos WHERE id_espacio=$id_espacio");
else
	$resultado = mysqli_query($connect, "SELECT id_dispositivo,id_espacio,cod_modelo,tipo,fecha_instalacion,fecha_entrega,serie,inventario FROM dispositivos");
while($fila=$resultado->fetch_assoc()){
	if(empty($fila['id_dispositivo']))
		echo "No hay resultados que mostrar";
	else{
	$dispositivo = new Dispositivo($fila['id_dispositivo'],$fila['id_espacio'],$fila['inventario'],$fila['serie'],$fila['cod_modelo'],$fila['tipo'],$fila['fecha_instalacion'],$fila['fecha_entrega']);
	echo "<tr>";
	echo "<td>".$dispositivo->mostrar_cod_modelo()			."</td>";
	echo "<td>".$dispositivo->mostrar_tipo()				."</td>";
	echo "<td>".$dispositivo->mostrar_fecha_instalacion()	."</td>";
	echo "<td>".$dispositivo->mostrar_fecha_entrega()		."</td>";
	echo "<td>".$dispositivo->mostrar_serie()				."</td>";
	echo "<td>".$dispositivo->mostrar_inventario()			."</td>";
	echo "</tr>";
	}
}

?>
	</tbody>
</table>

</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>