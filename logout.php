<?php   
session_start();
?>
﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Jugones 0.1beta</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- ES -->
<script>
function cargarInicio() {
    location.href = "./index.php";
}
</script>
</head>

<body onload="setTimeout(cargarInicio, 3000);">    
<div class="contenido">  
<?php
include_once './cabecera.php';
echo '<div class="container">';
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

<?php
// Comprobamos si tenemos alguna sesión iniciada
if (userIsAuth()) {
  if ( !isset($_SESSION) ){
    session_start();
  }
 
  unset($_SESSION['uid']);
  session_destroy();
 
  echo 'Ha salido correctamente. Volver a la pantalla de <a href="index.php">inicio</a>';
 
} 
else {
  echo 'No tiene ninguna sesión de usuario activa';
}
?>
</div>
</div>
<?php 
include_once './footer.php';
?>
</body>
</html>


