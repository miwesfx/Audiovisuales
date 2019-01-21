<style>
  body {
    <-background-image: url("images/fondos/portero.png");
    background-repeat: no-repeat;
    background-position: right top;->
	}
	.navbar{
		background-color:#343a40;
		padding-top: 10px;
		padding-bottom: 10px;
		font-size: 1.5 rem;
	}

html, body {
  height: 100%;
}
body {
  display: flex;
  flex-direction: column;
}
.contenido {
  flex: 1 0 auto;
}
td a:hover {
    color: black !important;
}

<?PHP
$ldaphost = "ldap://ldap.uca.es/";

// Conexión al servidor LDAP
$ldapconn = ldap_connect($ldaphost)
          or die("Could not connect to {$ldaphost}");

// ejemplo de autenticación
$ldaprdn  = 'cn=anonimo,dc=uca,dc=es';		// ldap rdn or dn
$ldappass = 'anonimo';  					// associated password

if ($ldapconn) {

    // realizando la autenticación
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
	
    // verificación del enlace
    if ($ldapbind) {
		
		// Busca el UID del usuario
		$sr=ldap_search($ldapconn, "dc=uca, dc=es", "uid=".$_SESSION['uid']."");
		$info = ldap_get_entries($ldapconn, $sr);
				
		/*for ($i=0; $i<$info["count"]; $i++) {
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
		}*/

		//echo "Closing connection";
		//ldap_close($ldapconn);
		
	}
	else {
        echo "LDAP bind failed...";
    }
}
?>


</style>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="index.php"><img src="./logo_uca.png" alt="Logo UCA" height="45"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
         <li><a href="index.php">Inicio</a></li>
         		<?PHP  //PHP Muestra el menu si ha iniciado sesión
				if(userIsAuth()){?>
				<!--<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultar<span class="caret"></span></a>
					<ul class="dropdown-menu">
					<li><a href="campus.php">		Campus		</a></li>
						<li><a href="centros.php">		Centros		</a></li>
						<li><a href="espacios.php">		Espacios	</a></li
						<li><a href="dispositivos.php">	Dispositivos</a></li>
					</ul>
				</li>>-->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Agregar<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="centros_add.php">		Centros		</a></li>
						<li><a href="espacios_add.php">		Espacios	</a></li>
						<li><a href="dispositivos_add.php">	Dispositivos</a></li>
					</ul>
				</li>
				<!--
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Editar<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="centros_edit.php">			Centros		</a></li>
						<li><a href="espacios_edit.php">		Espacios	</a></li>
						<li><a href="dispositivos_edit.php">	Dispositivos</a></li>
					</ul>
				</li>
				-->
				<?PHP } ?>				
      </ul>
      <ul class="nav navbar-nav navbar-right">
			<?PHP  //PHP Muestra el menu si ha iniciado sesión
			if(userIsAuth()){?>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <b><i><?PHP echo $info[0]["fn"][0]." ".$info[0]["sn1"][0]." ".$info[0]["sn2"][0]; ?></i></b><span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="./perfil.php">			Perfil		</a></li>
					<li><a href="./grupos.php">			Grupos		</a></li>
					<li><a href="./mensajes.php">		Mensajes	</a></li>
					<li><a href="./estadisticas.php">	Estadísticas</a></li>
				</ul>
			</li>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			<?PHP }
			else{?>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			<?PHP } ?>
      </ul>
    </div>
  </div>
</nav>