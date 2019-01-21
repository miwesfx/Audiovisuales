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

echo '<h1>Campus</h1>';

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");
?>

<table class="table table-hover">
    <thead>
      <tr>
        <th>Campus</th>
      </tr>
    </thead>
    <tbody>

<?PHP
$resultado = mysqli_query($connect, "SELECT id_campus FROM campus");
while($fila=$resultado->fetch_assoc()){
	$campus = new Campus($fila['id_campus']);
	echo '<tr><td><a href="./centros.php?id_campus='.$campus->mostrar_id_campus().'"><div>'.$campus->mostrar_nombre_campus().'</div></a></td></tr>';
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