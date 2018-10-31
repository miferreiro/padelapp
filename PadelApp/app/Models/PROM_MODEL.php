<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Santos
*/

//declaración de la clase
class PROM_MODEL{ 
	
	var	$fecha;
	var	$hora;



    //Constructor de la clase
	function __construct($fecha,$hora) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->fecha = $fecha;
        $this->hora=$hora;

		
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select
					Hora,
					Fecha
       			from promociones 
    			where 
    				(
                    (BINARY Fecha LIKE '%$this->fecha%') &&
    				(BINARY Hora LIKE '%$this->hora%') 
					
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
		
	if ( ( $this->fecha <> '' ) && ( $this->hora <> '' )  ) { 
            			
			$sql = "SELECT * FROM promociones WHERE (  Fecha = '$this->fecha' && Hora = '$this->hora')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 0 ) { 


							$sql = "INSERT INTO USUARIO (
							     Dni,
								 Login,
                                 Password,	     
					             Nombre,
					             Apellidos,
                                 Sexo,
								 Tipo,
					             Telefono
								) 
								VALUES(
								'$this->Dni',
								'$this->Login',
                                '$this->Password',	
								'$this->Nombre',
								'$this->Apellidos',
								'$this->Sexo',
								'$this->Tipo',
								'$this->Telefono'
								)";					
						}else {
					
						return 'Ya existe una promocion con la fecha y horas introducidas en la base de datos';// ya existe		
					}
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else { 											
						return 'Inserción realizada con éxito'; 
					}		
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	
	} // fin del metodo ADD

    

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM promociones WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			$sql = "SELECT * FROM inscripcionpromociones WHERE (Promociones_Fecha = '$this->fecha' && Promociones_Hora = '$this->hora')";
			$result = $this->mysqli->query( $sql );
			
			// se construye la sentencia sql de borrado
			if($result->num_rows == 1){
				$sql = "DELETE FROM inscripcionpromociones WHERE (Promociones_Fecha = '$this->fecha' && Promociones_Hora = '$this->hora')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "DELETE FROM promociones WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";
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

		$sql = "SELECT * FROM promociones WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";// se construye la sentencia de busqueda de la tupla
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