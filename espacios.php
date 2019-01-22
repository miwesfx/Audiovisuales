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

$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

$id_centro 				= filter_input(INPUT_GET, 'id_centro',			FILTER_SANITIZE_STRING);
$videoconferencia 		= filter_input(INPUT_GET, 'videoconferencia',	FILTER_SANITIZE_STRING);
$tipo_aux 				= filter_input(INPUT_GET, 'tipo',				FILTER_SANITIZE_STRING);
$aforo					= filter_input(INPUT_GET, 'aforo',				FILTER_SANITIZE_STRING);

if(isset($id_centro) && !isset($videoconferencia)){
	$centro = new Centro($id_centro);
	echo '<h2>Espacios de '.$centro->mostrar_nombre_centro().'</h2>';
}
elseif(isset($id_centro) && isset($videoconferencia)){
	$centro = new Centro($id_centro);
	echo '<h2>'.$centro->mostrar_nombre_centro().' - '.$centro->mostrar_nombre_campus().'</h2>';
}
else
	echo '<h2>Espacios</h2>';

	echo '<h3><a href="./index.php?tab='.$centro->mostrar_id_campus().'">Atrás</a></h3>';

//Carga los diferentes posibles valores del campo enum|set
$resultado = mysqli_query($connect,"SELECT COLUMN_TYPE	AS texto FROM information_schema.COLUMNS WHERE TABLE_NAME='espacios' AND COLUMN_NAME='tipo'");
$resultado = $resultado->fetch_assoc();
$tipo_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $resultado['texto']));

?>

<form class="form-horizontal" action="./espacios.php" method="GET">
	<div class="form-group">
			<label class="control-label col-sm-4" for="tipo">Tipo de espacio: </label>
			<div class="col-sm-3">
				<select  class="form-control" name="tipo" required>
					<option value="any" <?PHP 	if(!strcmp($tipo_aux,"any")) echo "selected";?>>Cualquiera</option>
					<?PHP
					foreach($tipo_array as $tipo){
						if($tipo_aux==$tipo) 
							echo '<option value="'.$tipo.'" selected>'.$tipo.'</option>';
						else
							echo '<option value="'.$tipo.'">'.$tipo.'</option>';
					}
					?>
				</select>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="videoconferencia">Videoconferencia: </label>
			<div class="col-sm-3">
			<select  class="form-control" name="videoconferencia" required>
				<option value="any" <?PHP if(!strcmp($videoconferencia,"any"))	echo "selected";?>>Cualquiera	</option>
				<option value="0" 	<?PHP if(!strcmp($videoconferencia,"0"))	echo "selected";?>>No			</option>
				<option value="1" 	<?PHP if(!strcmp($videoconferencia,"1"))	echo "selected";?>>Sí			</option>				
			</select>
			</div>
	</div>
	<div class="form-group">
			<label class="control-label col-sm-4" for="aforo">Aforo: </label>
			<div class="col-sm-3">
			<select  class="form-control" name="aforo" required>
				<option value="any"		<?PHP if(!strcmp($aforo,"any"))		echo "selected";?>>Cualquiera	</option>
				<option value="small"	<?PHP if(!strcmp($aforo,"small"))	echo "selected";?>>Entre 1 y 12	</option>
				<option value="medium"	<?PHP if(!strcmp($aforo,"medium"))	echo "selected";?>>Entre 13 y 30</option>
				<option value="big"		<?PHP if(!strcmp($aforo,"big"))		echo "selected";?>>Más de 30	</option>				
			</select>
			</div>
	</div>
	<input type="hidden" name="id_centro" value="<?PHP if(isset($id_centro)){echo "$id_centro";}?>">
	<div class="form-group"> 
			<div class="col-sm-offset-3 col-sm-10">
				<button type="submit" class="btn btn-primary">Aplicar filtros</button>
			</div>
	</div>
</form>




<table class="table table-hover">
    <thead>
      <tr>
		<th>Planta	</th>
        <th>Espacio	</th>
		<th>Tipo	</th>
		<th>Aforo	</th>
      </tr>
    </thead>
    <tbody>        

<?PHP	

$aux0="";
$aux1="";
$aux2="";
$aux3="";
if(!strcmp($aforo,"small"))
	$aux3 = " AND aforo<13";
elseif(!strcmp($aforo,"medium"))
	$aux3 = " AND aforo BETWEEN 13 AND 30";
elseif(!strcmp($aforo, "big"))
	$aux3 = " AND aforo>30";


if(isset($id_centro))
	$aux0="  WHERE id_centro = $id_centro";
if($videoconferencia!="any")
	$aux1=" AND videoconferencia = $videoconferencia";
if($tipo_aux!="any")
	$aux2=" AND tipo='$tipo_aux'";
$consultageneral = 	"SELECT id_espacio FROM espacios".$aux0.$aux1.$aux2.$aux3." ORDER BY planta,tipo,nombre ASC";

//echo $consultageneral;

//if(isset($id_centro))
	$resultado = mysqli_query($connect, $consultageneral);
/*if(isset($id_centro) && isset($videoconferencia))
	$resultado = mysqli_query($connect, "SELECT id_espacio FROM espacios WHERE id_centro = $id_centro AND videoconferencia = 1 ORDER BY planta,tipo,nombre ASC");
elseif(isset($id_centro) && !isset($videoconferencia))
	$resultado = mysqli_query($connect, "SELECT id_espacio FROM espacios WHERE id_centro = $id_centro ORDER BY planta,tipo,nombre ASC");
else
	$resultado = mysqli_query($connect, "SELECT id_espacio FROM espacios ORDER BY id_campus,id_centro,nombre");*/

while($fila=$resultado->fetch_assoc()){
	$espacio = new Espacio($fila['id_espacio']);
	echo "<tr>";
	echo '<td><a href="./espacios_detalles.php?id_espacio='.$espacio->mostrar_id_espacio().'"><div>'.$espacio->mostrar_planta().			'</div></a></td>';
	echo '<td><a href="./espacios_detalles.php?id_espacio='.$espacio->mostrar_id_espacio().'"><div>'.$espacio->mostrar_nombre_espacio().	'</div></a></td>';
	echo '<td><a href="./espacios_detalles.php?id_espacio='.$espacio->mostrar_id_espacio().'"><div>'.$espacio->mostrar_tipo().				'</div></a></td>';
	echo '<td><a href="./espacios_detalles.php?id_espacio='.$espacio->mostrar_id_espacio().'"><div>'.$espacio->mostrar_aforo().				'</div></a></td>';
	echo "</tr>";
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