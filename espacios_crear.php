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

<body onload="setTimeout(cargarPagina, 100);">

<?PHP
include_once './clases.php';
include_once './conexion.php';

$connect=conectarBD();		
$acentos = $connect->query("SET NAMES 'utf8'");
        
$espacio			= filter_input(INPUT_POST, 'espacio',			FILTER_SANITIZE_STRING);
$ids				= filter_input(INPUT_POST, 'campus_centro',		FILTER_SANITIZE_STRING);
$planta 			= filter_input(INPUT_POST, 'planta',			FILTER_SANITIZE_STRING);
$tipo 				= filter_input(INPUT_POST, 'tipo',				FILTER_SANITIZE_STRING);
$aforo				= filter_input(INPUT_POST, 'aforo',				FILTER_SANITIZE_STRING);
$videoconferencia	= filter_input(INPUT_POST, 'videoconferencia',	FILTER_SANITIZE_STRING);

list($id_campus, $id_centro) = explode("+", $ids);

if($resultado = mysqli_query($connect, "INSERT INTO espacios (id_campus,id_centro,nombre,planta,tipo,aforo,videoconferencia) 
VALUES ('".$id_campus."','".$id_centro."','".$espacio."','".$planta."','".$tipo."','".$aforo."','".$videoconferencia."')"))
	echo "Espacio agregado con éxito";

?>

<script>
function cargarPagina() {
    location.href = "./espacios_add.php?id_centro=<?PHP echo $id_centro; ?>";
}
</script>
</body>