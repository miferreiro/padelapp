<?php

class ENFRENTAMIENTO_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Letra;
	var $NumEnfrentamiento;
	var $NumPareja;
	var $Resultado;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra,$NumEnfrentamiento,$NumPareja,$Resultado) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		$this->NumEnfrentamiento = $NumEnfrentamiento;
		$this->NumPareja = $NumPareja;
		$this->Resultado = $Resultado;
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {

		$sql = "select IdCampeonato,
					Tipo,
					Nivel,
					Letra,
					NumEnfrentamiento,
					NumPareja,
					Resultado					
       			from ENFRENTAMIENTO
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
					(BINARY Tipo LIKE '%$this->Tipo%') &&
					(BINARY Nivel LIKE '%$this->Nivel%') &&
					(BINARY Grupo_Letra LIKE '%$this->Letra%') &&
					(BINARY NumEnfrentamiento LIKE '%$this->NumEnfrentamiento%') &&
					(BINARY NumPareja LIKE '%$this->NumPareja%') &&
					(BINARY Resultado LIKE '%$this->Resultado%') 				
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' ) && ( $this->NumEnfrentamiento <> '' )
		   && ( $this->NumPareja <> '' )) {         
	
			$sql = "SELECT * FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra ='$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO ENFRENTAMIENTO (
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Resultado
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$this->NumEnfrentamiento',
								'$this->NumPareja',
								'$this->Resultado'
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

		$sql = "SELECT * FROM ENFRENTAMIENTO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {

			$sql = "DELETE FROM ENFRENTAMIENTO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";
			
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 
	function DELETE_ALL() {

		$sql = "SELECT * FROM ENFRENTAMIENTO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Letra = '$this->Letra') && (NumPareja = '$this->NumPareja')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows > 0  ) {
			$sql = "DELETE FROM ENFRENTAMIENTO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Letra = '$this->Letra') && (NumPareja = '$this->NumPareja')";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM ENFRENTAMIENTO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Letra = '$this->Letra') && (NumPareja = '$this->NumPareja')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	} 
	function EDIT() {
		
		$sql = "SELECT * FROM ENFRENTAMIENTO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {

			$sql = "UPDATE ENFRENTAMIENTO SET 
					IdCampeonato = '$this->IdCampeonato',
					Tipo='$this->Tipo',
					Nivel='$this->Nivel',
					Letra='$this->Letra',
					NumEnfrentamiento='$this->NumEnfrentamiento',
					NumPareja = '$this->NumPareja',
					Resultado = '$this->Resultado'
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')
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
	
	
 	}

?>