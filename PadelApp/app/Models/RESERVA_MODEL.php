<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Santos
*/

//declaración de la clase
class RESERVA_MODEL{ 
	
	var $Usuario_Dni;
	var $Pista_idPista;
	var	$Pista_fecha;
	var	$Pista_hora;



    //Constructor de la clase
	function __construct($Usuario_Dni,$Pista_idPista,$Pista_fecha,$Pista_hora) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->Usuario_Dni = $Usuario_Dni;
		$this->Pista_idPista = $Pista_idPista;
		$this->Pista_fecha = $Pista_fecha;
        $this->Pista_hora=$Pista_hora;

		
		
        
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
					Pista_idPista,
					Pista_Hora,
					Pista_Fecha
       			from RESERVA 
    			where 
    				((BINARY Usuario_Dni LIKE '%$this->Usuario_Dni%')&&
					(BINARY Pista_idPista LIKE '%$this->Pista_idPista%') &&
                    (BINARY Pista_Fecha LIKE '%$this->Pista_fecha%') &&
    				(BINARY Pista_Hora LIKE '%$this->Pista_hora%') 
					
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
		if ( ( $this->Pista_fecha <> '' ) && ( $this->Pista_hora <> '' ) && ( $this->Usuario_Dni <> '' )) { 
            			
			$sql = "SELECT * FROM RESERVA WHERE (  Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora' && Usuario_Dni = '$this->Usuario_Dni')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 1 ) { 
					
					return 'Ya ha reservado esa pista';	
					
				}else{
					
					  $sql = "SELECT * FROM PISTA WHERE (  Fecha = '$this->Pista_fecha' && Hora = '$this->Pista_hora' && Disponibilidad = 1)";
					  if ( !$result = $this->mysqli->query( $sql ) ) { 						  
							return 'No se ha podido conectar con la base de datos';
						  
					  } else { 
						if ( $result->num_rows == 0 ) {			
							return 'La pista no está disponible';					
						} else {
								$sql = "INSERT INTO RESERVA (
									Usuario_Dni,
									Pista_idPista,
									Pista_Fecha,
									Pista_Hora
									) 
									VALUES(
										'$this->Usuario_Dni',
										'$this->Pista_idPista',
										'$this->Pista_fecha',
										'$this->Pista_hora'
									)";	

								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} else { 											
									return 'Inserción realizada con éxito'; 
								}										
							}
						  }
					}
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	} 

    

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM RESERVA WHERE (Usuario_Dni='$this->Usuario_Dni' && Pista_idPista = '$this->Pista_idPista' && Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM RESERVA WHERE (Usuario_Dni='$this->Usuario_Dni' && Pista_idPista = '$this->Pista_idPista' && Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora')";
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

		$sql = "SELECT * FROM RESERVA WHERE (Usuario_Dni='$this->Usuario_Dni' && Pista_idPista = '$this->Pista_idPista' && Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora')";// se construye la sentencia de busqueda de la tupla
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