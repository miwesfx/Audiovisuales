<?php   
session_start();
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
<style>

</style>
	   
	   
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


if(userIsAuth()){
$connect = conectarBD();
$acentos = $connect->query("SET NAMES 'utf8'");

//Guarda los centros en un array de objetos Centro
$centros = array();
$resultado = mysqli_query($connect, "SELECT id_centro FROM centros ORDER BY id_campus,nombre");
while($fila=$resultado->fetch_assoc()){
	$centro = new Centro($fila['id_centro']);
	$centros[]=$centro;
}

//Guarda los campus en un array de objetos Campus
$campuses = array();
$resultado = mysqli_query($connect, "SELECT id_campus FROM campus ORDER BY id_campus");
while($fila=$resultado->fetch_assoc()){
	$campus = new Campus($fila['id_campus']);
	$campuses[]=$campus;
}
/*
$ldaphost = "ldap://ldap.uca.es/";

// Conexión al servidor LDAP
$ldapconn = ldap_connect($ldaphost)
          or die("Could not connect to {$ldaphost}");

// ejemplo de autenticación
$ldaprdn  = 'cn=anonimo,dc=uca,dc=es';     // ldap rdn or dn
$ldappass = 'anonimo';  // associated password


if ($ldapconn) {

    // realizando la autenticación
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
	
    // verificación del enlace
    if ($ldapbind) {
        echo "LDAP bind successful...<br>";
		
		// Search surname entry
		$sr=ldap_search($ldapconn, "dc=uca, dc=es", "uid=".$_SESSION['uid']."");  
		echo "Search result is " . $sr . "<br />";

		echo "Number of entries returned is " . ldap_count_entries($ldapconn, $sr) . "<br />";
			
		echo "Getting entries ...<p>";
		$info = ldap_get_entries($ldapconn, $sr);
		echo "Data for " . $info["count"] . " items returned:<p>";

		//var_dump($info);
		echo "<br><hr>";
		
		
		for ($i=0; $i<$info["count"]; $i++) {
			//var_dump($info[$i]);
			echo "UID: "				. $info[$i]["uid"][0]	. "<br />";
			echo "NIF: "				. $info[$i]["nif"][0]	. "<br />";
			echo "Nombre: "				. $info[$i]["fn"][0]	. "<br />";
			echo "Primer apellido: "	. $info[$i]["sn1"][0]	. "<br />";
			echo "Segundo apellido: "	. $info[$i]["sn2"][0]	. "<br />";
			echo "Mail_1: "				. $info[$i]["mail"][0]	. "<br />";
			//echo "Mail_2: " . $info[$i]["mail"][1] . "<br />";
			if($info[$i]['pas'][0]=='S')
				echo "Es PAS<br /><hr />";
			else
				echo "No es PAS<br /><hr />";
		}

		echo "Closing connection";
		ldap_close($ldapconn);
		
	}
	else {
        echo "LDAP bind failed...";
    }
}*/


?>
  <h2>Espacios para videoconferencia</h2>
  <ul class="nav nav-tabs">
	<?PHP
	foreach($campuses as $campus){
		echo '<li';	if($campus->mostrar_id_campus()==1)echo ' class="active"';	echo '><a data-toggle="tab" href="#'.$campus->mostrar_id_campus().'">'.$campus->mostrar_nombre_campus().'</a></li>';
	}
	?>
  </ul>
	
  <div class="tab-content">
    	
	<?PHP
	foreach($campuses as $campus){
	
    echo '<div id="'.$campus->mostrar_id_campus().'" class="tab-pane fade'; if($campus->mostrar_id_campus()==1) echo ' in active'; echo '">';
	?>
	<table class="table table-hover">
		<thead>
		  <tr>
			<th>Centro</th>
		  </tr>
		</thead>
		<tbody>
		<?PHP	
		foreach($centros as $centro)
			if($centro->id_campus==$campus->mostrar_id_campus())
				echo '<tr><td><a href="/audiovisuales/espacios.php?id_centro='.$centro->mostrar_id_centro().'&videoconferencia=1"><div>'.$centro->mostrar_nombre_centro().'</div></a></td></tr>';
		?>
		</tbody>
	</table>
	</div>
	<?PHP
	}
    ?>
  </div>
<?PHP }
else
	echo '<h2 align="center">Herramienta de control de espacios audiovisuales</h2>
			<div class="row">
				<div class="col-sm-4 col-md-offset-4">
					<h1>Login</h1>
						
					<!--el siguiente formulario inserta un jugador en la tabla de jugadores. Crear una página de registro de nuevo jugador-->
					<form action="login.php" method="post">
						<div class="form-group">
							<label>Nombre de usuario: </label><input type="text" class="form-control" name="username" required="required"><br>
							
							<label>Password: </label><input type="password" class="form-control" name="password" required="required"><br>
							
							<p><input class="btn btn-primary btn-send" type="submit" value="Entrar"></p>
						</div>
					</form>
				</div>
			</div>'?>
</div>
<?php 
	include_once './footer.php';
?>
</body>
</html>