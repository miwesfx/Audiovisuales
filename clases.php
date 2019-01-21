<?PHP

/*--------------------------------------------------------------------------*/

//CLASE CAMPUS
class Campus {

	//Atributos
   var 	$id_campus;
		
	//Constructor
   function __construct($entero_campus)
   {
	   $this->id_campus = $entero_campus;
   }

   //Métodos observadores
   function mostrar_id_campus()			{	return $this->id_campus;		}
   function mostrar_nombre_campus()		{	$connect = conectarBD();
											$acentos = $connect->query("SET NAMES 'utf8'");
											$resultado = mysqli_query($connect, "SELECT nombre FROM campus WHERE id_campus=".$this->id_campus."");
											$fila=$resultado->fetch_assoc();
											mysqli_close($connect);
											return $fila['nombre'];
										}
										
}

/*--------------------------------------------------------------------------*/

//CLASE  CENTRO
class Centro extends Campus{
	//Atributos
	var $id_centro;
	
	//Constructor
	function __construct($entero_centro)
	{
		$connect = conectarBD();
		$acentos = $connect->query("SET NAMES 'utf8'");
		$resultado = mysqli_query($connect, "SELECT id_campus FROM centros WHERE id_centro=".$entero_centro."");
		$fila=$resultado->fetch_assoc();
		mysqli_close($connect);
		
		$this->id_campus 		= $fila['id_campus'];
		$this->id_centro 		= $entero_centro;
	}
	
	//Métodos observadores
	function mostrar_id_centro()		{		return $this->id_centro;	}
	function mostrar_nombre_centro()	{		$connect = conectarBD();
												$acentos = $connect->query("SET NAMES 'utf8'");
												$resultado = mysqli_query($connect, "SELECT nombre FROM centros WHERE id_centro=".$this->id_centro."");
												$fila=$resultado->fetch_assoc();
												mysqli_close($connect);
												return $fila['nombre'];
										}
	
	
	//Métodos modificadores
	//function mod_id_centro($entero)		{	$this->id_centro = $entero;		}
	//function mod_nombre_centro($cadena)	{	$this->nombre_centro= $cadena;	}
}

/*--------------------------------------------------------------------------*/

//CLASE ESPACIO
class Espacio extends Centro{
	//Atributos
	var $id_espacio,
		$recursos; //Array con id_items en ella
	
	//Constructor
	function __construct($entero_espacio/*,$vector_recursos*/)
	{
		$connect = conectarBD();
		$acentos = $connect->query("SET NAMES 'utf8'");
		$resultado = mysqli_query($connect, "SELECT id_centro,id_campus FROM espacios WHERE id_espacio=".$entero_espacio."");
		$fila=$resultado->fetch_assoc();
		mysqli_close($connect);		
		
		$this->id_espacio 		= $entero_espacio;
		$this->id_centro 		= $fila['id_centro'];
		$this->id_campus 		= $fila['id_campus'];
		//$this->recursos			= $vector_recursos;
	}
	
	//Métodos observadores
	function mostrar_id_espacio()	{	return $this->id_espacio;		}
	function mostrar_recursos()		{	return $this->recursos;			}
	function mostrar_nombre_espacio(){	$connect = conectarBD();
										$acentos = $connect->query("SET NAMES 'utf8'");
										$resultado = mysqli_query($connect, "SELECT nombre FROM espacios WHERE id_espacio=".$this->id_espacio."");
										$fila=$resultado->fetch_assoc();
										mysqli_close($connect);
										return $fila['nombre'];	
									}
	function mostrar_planta()		{	$connect = conectarBD();
										$acentos = $connect->query("SET NAMES 'utf8'");
										$resultado = mysqli_query($connect, "SELECT planta FROM espacios WHERE id_espacio=".$this->id_espacio."");
										$fila=$resultado->fetch_assoc();
										mysqli_close($connect);
										return $fila['planta'];										
									}
	function mostrar_tipo()			{	$connect = conectarBD();
										$acentos = $connect->query("SET NAMES 'utf8'");
										$resultado = mysqli_query($connect, "SELECT tipo FROM espacios WHERE id_espacio=".$this->id_espacio."");
										$fila=$resultado->fetch_assoc();
										mysqli_close($connect);
										return $fila['tipo'];
									}
									
	function mostrar_aforo()		{	$connect = conectarBD();
										$acentos = $connect->query("SET NAMES 'utf8'");
										$resultado = mysqli_query($connect, "SELECT aforo FROM espacios WHERE id_espacio=".$this->id_espacio."");
										$fila=$resultado->fetch_assoc();
										mysqli_close($connect);
										return $fila['aforo'];
									}
	function mostrar_videoconferencia(){$connect = conectarBD();
										$acentos = $connect->query("SET NAMES 'utf8'");
										$resultado = mysqli_query($connect, "SELECT videoconferencia FROM espacios WHERE id_espacio=".$this->id_espacio."");
										$fila=$resultado->fetch_assoc();
										mysqli_close($connect);
										return $fila['videoconferencia'];
									}											
	function mostrar_foto()			{	$connect = conectarBD();
										$acentos = $connect->query("SET NAMES 'utf8'");
										$resultado = mysqli_query($connect, "SELECT foto FROM espacios WHERE id_espacio=".$this->id_espacio."");
										$fila=$resultado->fetch_assoc();
										mysqli_close($connect);
										if(!empty($fila['foto']))
											return $fila['foto'];
										else
											return "./fotos_espacios/default.jpg";
									}
	
	
	//Métodos modificadores	
	function modificar_nombre($nombre)	{	$connect = conectarBD();
											$acentos = $connect->query("SET NAMES 'utf8'");
											mysqli_query($connect, "UPDATE espacios SET nombre = '$nombre' WHERE id_espacio=".$this->id_espacio."");
											mysqli_close($connect);
										}
	function modificar_planta($planta)	{	$connect = conectarBD();
											$acentos = $connect->query("SET NAMES 'utf8'");
											mysqli_query($connect, "UPDATE espacios SET planta = '$planta' WHERE id_espacio=".$this->id_espacio."");
											mysqli_close($connect);
										}
	function modificar_tipo($tipo)	{	$connect = conectarBD();
											$acentos = $connect->query("SET NAMES 'utf8'");
											mysqli_query($connect, "UPDATE espacios SET tipo = '$tipo' WHERE id_espacio=".$this->id_espacio."");
											mysqli_close($connect);
										}
	function modificar_aforo($aforo)	{	$connect = conectarBD();
											$acentos = $connect->query("SET NAMES 'utf8'");
											mysqli_query($connect, "UPDATE espacios SET aforo = '$aforo' WHERE id_espacio=".$this->id_espacio."");
											mysqli_close($connect);
										}
	function modificar_videoconferencia($videoconferencia)	{	$connect = conectarBD();
																$acentos = $connect->query("SET NAMES 'utf8'");
																mysqli_query($connect, "UPDATE espacios SET videoconferencia = '$videoconferencia' WHERE id_espacio=".$this->id_espacio."");
																mysqli_close($connect);
															}	
	
	
	
	//Métodos modificadores
	/*function mod_id_espacio($entero){	$this->id_espacio = $entero;	}
	function mod_nombre_espacio($cadena){$this->nombre_espacio = $cadena;}
	function mod_planta($cadena)	{	$this->planta = $cadena;		}
	function mod_tipo($cadena)		{	$this->tipo = $cadena;			}
	function mod_recursos($cadena)	{	$this->recursos = $cadena;		}*/
}

/*--------------------------------------------------------------------------*/

//CLASE DISPOSTIVOS
class Dispositivo {
	//Atributos
	var $id_dispositivo,
		$id_espacio,
		$inventario,
		$serie,
		$cod_modelo,
		$tipo,
		$fecha_instalacion,
		$fecha_entrega;
		/*$cod_concurso,
		$estado,
		$foto,
		$historico; //array con las ubicaciones en las que ha estado instalado*/
		
	//Constructor
	function __construct($entero_dispositivo,$entero_espacio,$entero_inventario,$cadena_serie,$cadena_cod_modelo,$cadena_tipo,$fec_insta,$fec_entrega/*,$cadena_cod_concurso,$cadena_estado,$cadena_foto,$vector_historico*/){
		$this->id_dispositivo 			= $entero_dispositivo;
		$this->id_espacio				= $entero_espacio;
		$this->inventario				= $entero_inventario;
		$this->serie					= $cadena_serie;
		$this->cod_modelo				= $cadena_cod_modelo;
		$this->tipo						= $cadena_tipo;
		$this->fecha_instalacion 		= $fec_insta;
		$this->fecha_entrega			= $fec_entrega;
		/*$this->cod_concurso			= $cadena_cod_concurso;
		$this->estado					= $cadena_estado;
		$this->foto						= $cadena_foto;
		$this->historico				= $vector_historico;	*/
	}
	
	//Métodos observadores
	function mostrar_id_dispositivo(){		return $this->id_dispositivo;	}
	function mostrar_id_espacio()	{		return $this->id_espacio;		}
	function mostrar_inventario()	{		return $this->inventario;		}
	function mostrar_serie()		{		return $this->serie;			}
	function mostrar_cod_modelo()	{		return $this->cod_modelo;		}
	function mostrar_tipo()			{		return $this->tipo;				}
	function mostrar_fecha_instalacion(){	return $this->fecha_instalacion;}
	function mostrar_fecha_entrega(){		return $this->fecha_entrega;	}
	/*function mostrar_foto()			{		return $this->foto;				}
	function mostrar_historico()	{		return $this->historico;		}*/
}

/*--------------------------------------------------------------------------*/

//CLASE Proveedores
class Proveedores{
	//Atributos
	var $id_proveedor,
		$nombre,
		$responsable,
		$telefono,
		$email,
		$direccion,
		$direccion_reparacion;
	
	//Constructor
	function __construct($entero_proveedor,$cadena_nombre,$cadena_responsable,$entero_telefono,$cadena_email,$cadena_direccion,$cadena_direccion_reparacion){
		$this->id_proveedor			= $entero_proveedor;
		$this->nombre				= $cadena_nombre;
		$this->responsable			= $cadena_responsable;
		$this->telefono				= $entero_telefono;
		$this->email				= $cadena_email;
		$this->direccion			= $cadena_direccion;
		$this->direccion_reparacion = $cadena_direccion_reparacion;
	}
	
	//Métodos observadores
	function mostrar_proveedor()		{		return $this->id_proveedor;		}
	function mostrar_nombre()			{		return $this->nombre;			}
	function mostrar_responsable()		{		return $this->responsable;		}
	function mostrar_telefono()			{		return $this->telefono;			}
	function mostrar_email()			{		return $this->email;			}
	function mostrar_direccion()		{		return $this->direccion;		}
	function mostrar_direccion_reparacion(){	return $this->direccion_reparacion;}
}

/*--------------------------------------------------------------------------*/
?>