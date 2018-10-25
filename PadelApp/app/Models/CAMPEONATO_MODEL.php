<?php

class CAMPEONATO_MODEL{ 

	var $IdCampeonato; 
    var $FechaIni;
	var $FechaFin; 
	var $mysqli; 


    //Constructor de la clase
	function __construct($IdCampeonato,$FechaIni,$FechaFin) {

		$this->IdCampeonato = $IdCampeonato;
        $this->FechaIni=$FechaIni;
		$this->FechaFin = $FechaFin;
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdCampeonato,
					FechaIni,
                    FechaFin
       			from CAMPEONATO 
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
                    (BINARY FechaIni LIKE '%$this->FechaIni%') &&
    				(BINARY FechaFin LIKE '%$this->FechaFin%') 
			
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
		if ( ( $this->IdCampeonato <> '' ) ) {         
	
			$sql = "SELECT * FROM CAMPEONATO WHERE (  IdCampeonato = '$this->IdCampeonato')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos'; 
			} else { 

				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO CAMPEONATO (
									IdCampeonato,
									FechaIni,
									FechaFin
					             	) 
								VALUES(
								'$this->IdCampeonato',
                                '$this->FechaIni',
								'$this->FechaFin'
								)";					
					}
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else {			
					
						return 'Inserción realizada con éxito'; 
					
					}
						
			}
		} else { // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
			return 'Introduzca un valor';
		}
			
	} // fin del metodo ADD

    
	function DELETE() {

		$sql = "SELECT * FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {

			$sql = "DELETE FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato' )";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {
            
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
    

	function EDIT() {
		
		$sql = "SELECT * FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {

			$sql = "UPDATE CAMPEONATO SET 
					IdCampeonato = '$this->IdCampeonato',
                    FechaIni='$this->FechaIni',
					FechaFin = '$this->FechaFin'
				WHERE ( IdCampeonato = '$this->IdCampeonato'
				)";

			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { 
				return 'Modificado correctamente';
			}

		} 
		else {
			return 'No existe en la base de datos';
		}
	} 


	

 	}//fin de clase

?>