<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Santos
*/

//declaración de la clase
class PISTA_MODEL{ 

	var $idPista;
	var	$hora;
	var	$fecha;
	var $disponibilidad;
	
    //Constructor de la clase
	function __construct($idPista,$hora,$fecha,$disponibilidad) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->idPista = $idPista;
        $this->hora=$hora;
		$this->disponibilidad = $disponibilidad;
		$this->fecha = $fecha;
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  idPista,
                    Fecha,
					Hora,
					Disponibilidad
       			from PISTA 
    			where 
    				(
					(BINARY idPista LIKE '%$this->idPista%') &&
                    (BINARY Fecha LIKE '%$this->fecha%') &&
    				(BINARY Hora LIKE '%$this->hora%') &&
					(BINARY Disponibilidad LIKE '%$this->disponibilidad%')
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
	
	
	function PISTAS() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select distinct idPista
       			from PISTA";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo PISTAS
	
	function HORAS() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select distinct Hora 
       			from PISTA";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo HORAS
	function ComprobarDisp($idPista,$hora,$fecha) {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select Disponibilidad 
       			from PISTA
				where 
    				(
					idPista='$idPista' && Fecha='$fecha' && Hora ='$hora' && Disponibilidad = '1'
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		 $resultado = $this->mysqli->query( $sql ) ;
			if($resultado->num_rows==1){
				return 1;
			}else {
				return 0;
			}
			
		
	} // fin metodo ComprobarDisp

	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM PISTA";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				if ( $result->num_rows == 0 ) { 
					
					$c = "SELECT * FROM PISTA ORDER BY idPista DESC LIMIT 1";
					
					$sql = "SELECT * FROM PISTA WHERE (idPista = '$c + 1')";
					
					if ( $result->num_rows != 0 ) {
						return 'Ya existe un PISTA con el idPista introducido en la base de datos';// ya existe
						
					} else { //si ninguna de las claves candidatas son iguales, insertamos la PISTA
                           
						$dia = time();
						
							for($i=0 ; $i<7 ; $i++){
						
							$dia = date('d',$dia+84600); 
						
						
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$c+1',
                                '$dia',
								'9:00',
								'1'
								)";		
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$c+1',
                                '$dia',
								'10:30',
								'1'
								)";					
							}
						}

					}
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						
						if($mensaje == 'Inserción realizada con éxito'){//miramos si la inserción en USU_GRUPO tuvo exito
							return 'Inserción realizada con éxito'; //operacion de insertado correcta
						}else{//si la insercion no tuvo exito
							return $mensaje;
						}	
					}
	}
	} // fin del metodo ADD

    

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM PISTA WHERE (idPista = '$this->idPista' )";
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

		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista')";// se construye la sentencia de busqueda de la tupla
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Aplicamos fetch_array sobre $resultado para crear un array y se guarda en $result
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase

			//modificamos los atributos de la tabla PISTA
			$sql = "UPDATE PISTA SET 
					idPista = '$this->idPista',
                    Hora='$this->hora',
					Fecha = '$this->fecha',
					Disponibilidad = '$this->disponibilidad'
				WHERE ( idPista = '$this->idPista'
				)";
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		else {
			return 'No existe en la base de datos';
		}
	} // fin del metodo EDIT


	

} //fin de clase

?>