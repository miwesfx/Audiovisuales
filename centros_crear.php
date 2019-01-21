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
        
$centro		= filter_input(INPUT_POST, 'centro',	FILTER_SANITIZE_STRING);
$id_campus 	= filter_input(INPUT_POST, 'id_campus',	FILTER_SANITIZE_STRING);

$resultado = mysqli_query($connect, "INSERT INTO centros (nombre,id_campus) VALUES ('".$centro."','".$id_campus."')");

?>

<script>
function cargarPagina() {
    location.href = "./centros_add.php";
}
</script>
</body>