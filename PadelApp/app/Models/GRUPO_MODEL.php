<?php

class GRUPO_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Letra;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {

		$sql = "select IdCampeonato,
					Tipo,
					Nivel,
					Letra
       			from GRUPO 
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
					(BINARY Tipo LIKE '%$this->Tipo%') &&
					(BINARY Nivel LIKE '%$this->Nivel%') &&
					(BINARY Letra LIKE '%$this->Letra%') 
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' )) {         
	
			$sql = "SELECT * FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra ='$this->Letra')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO GRUPO (
									IdCampeonato,
									Tipo,
									Nivel,
									Letra
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra'
								)";					
					}
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else {					
						return 'Inserción realizada con éxito'; 				
					}						
			}
		} else { 
			return 'Error en la inserción';
		}
	} 
    
	function DELETE() {

		$sql = "SELECT * FROM GRUPO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {

			$sql = "DELETE FROM GRUPO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra')";
			
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 
	function DELETE_ALL() {

		$sql = "SELECT * FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows > 0  ) {
			$sql = "DELETE FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	} 

 	}//fin de clase

?>