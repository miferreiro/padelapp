<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Santos
*/

//declaración de la clase
class INSPROM_MODEL{ 
	
	var $Usuario_Dni;
	var	$Promociones_fecha;
	var	$Promociones_hora;



    //Constructor de la clase
	function __construct($Usuario_Dni,$Promociones_fecha,$Promociones_hora) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->Usuario_Dni = $Usuario_Dni;
		$this->Promociones_fecha = $Promociones_fecha;
        $this->Promociones_hora=$Promociones_hora;

		
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  Usuario_Dni,
					Promociones_Hora,
					Promociones_Fecha
       			from inscripcionpromociones 
    			where 
    				((BINARY Usuario_Dni LIKE '%$this->Usuario_Dni%')&&
                    (BINARY Promociones_Fecha LIKE '%$this->Promociones_fecha%') &&
    				(BINARY Promociones_Hora LIKE '%$this->Promociones_hora%') 
					
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH


	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		
		
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						
						if($mensaje == 'Inserción realizada con éxito'){//miramos si la inserción en USU_GRUPO tuvo exito
							return 'Inserción realizada con éxito'; //operacion de insertado correcta
						}else{//si la insercion no tuvo exito
							return $mensaje;
						}	
					}
	
	} // fin del metodo ADD

    

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM inscripcionpromociones WHERE (Usuario_Dni='$this->Usuario_Dni' && Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM inscripcionpromociones WHERE (Usuario_Dni='$this->Usuario_Dni' && Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else
			return "No existe";
	} // fin metodo DELETE

	// funcion RellenaDatos()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function RellenaDatos() { 

		$sql = "SELECT * FROM inscripcionpromociones WHERE (Usuario_Dni='$this->Usuario_Dni' && Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";// se construye la sentencia de busqueda de la tupla
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Aplicamos fetch_array sobre $resultado para crear un array y se guarda en $result
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()


	

} //fin de clase

?>