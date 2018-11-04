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
	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' ) && ( $this->NumEnfrentamiento <> '' )
		   && ( $this->NumPareja <> '' )) {         
	
			$sql = "SELECT * FROM ENFRENTAMIENTO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra ='$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción11'; 
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
								NULL
								)";					
					
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción22';
					} else {					
						return 'Inserción realizada con éxito'; 				
					}	
				}else{
						return 'Error en la insercion 44';
				}
			}
		} else { 
			return 'Error en la inserción33';
		}
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

		$sql = "SELECT DISTINCT E1.IdCampeonato as IdCampeonato,E1.Tipo as Tipo,E1.Nivel as Nivel,E1.Letra as Letra, E2.NumPareja as pareja1, E1.NumPareja as pareja2, E1.NumEnfrentamiento as NumEnfrentamiento, E1.Resultado as Resultado
		FROM ENFRENTAMIENTO E1,ENFRENTAMIENTO E2
		WHERE
		(E1.NumEnfrentamiento = E2.NumEnfrentamiento) && (E1.NumPareja != E2.NumPareja) &&
		(E1.IdCampeonato = '$this->IdCampeonato') && (E1.Tipo = '$this->Tipo') && (E1.Nivel = '$this->Nivel')  && (E1.Letra = '$this->Letra') 
		&&(E1.NumEnfrentamiento = '$this->NumEnfrentamiento') && (E1.NumPareja = '$this->NumPareja')
		GROUP BY E1.NumEnfrentamiento  

		";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	} 
	function EDIT() {
		
		$sql = 
		"SELECT * FROM ENFRENTAMIENTO 
		WHERE  
		(IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') 
		&& (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')
		
		";
	
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
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') 
				&& (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')
				";

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
	
	function listaEnfrentamiento(){
		
		
		$sql = "SELECT DISTINCT E2.NumPareja as pareja1, E1.NumPareja as pareja2,  E1.NumEnfrentamiento as numEnfrentamiento, E1.Resultado as resultado
				FROM ENFRENTAMIENTO E1,ENFRENTAMIENTO E2
				WHERE 
				(E1.NumEnfrentamiento = E2.NumEnfrentamiento) && (E1.NumPareja != E2.NumPareja)
				&&(E1.IdCampeonato = '$this->IdCampeonato') && (E1.Tipo = '$this->Tipo') && (E1.Nivel = '$this->Nivel') && (E1.Letra = '$this->Letra')
				GROUP BY E1.NumEnfrentamiento  
				ORDER BY E1.NumEnfrentamiento ASC, E1.NumPareja ASC
		
		";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
	
	}
 	}

?>