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
<body onload="setTimeout(cargarPagina, 10);">

<?PHP
include_once './clases.php';
include_once './conexion.php';

$connect=conectarBD();		
$acentos = $connect->query("SET NAMES 'utf8'");
        
$cod_modelo		= filter_input(INPUT_POST, 'cod_modelo',	FILTER_SANITIZE_STRING);
$tipo 			= filter_input(INPUT_POST, 'tipo',			FILTER_SANITIZE_STRING);
$serie			= filter_input(INPUT_POST, 'serie',			FILTER_SANITIZE_STRING);
$inventario		= filter_input(INPUT_POST, 'inventario',	FILTER_SANITIZE_STRING);
$instalacion	= filter_input(INPUT_POST, 'instalacion',	FILTER_SANITIZE_STRING);
$entrega		= filter_input(INPUT_POST, 'entrega',		FILTER_SANITIZE_STRING);

list($id_campus, $id_centro) = explode("+", $ids);

$resultado = mysqli_query($connect, "INSERT INTO dispositivos (cod_modelo,tipo,serie,fecha_inventario,fecha_instalacion,entrega) 
										VALUES ('".$cod_modelo."','".$tipo."','".$serie"','".$inventario."','".$instalacion."','".$entrega."')");

?>

<script>
function cargarPagina() {
    location.href = "./espacios_add.php";
}
</script>
</body>