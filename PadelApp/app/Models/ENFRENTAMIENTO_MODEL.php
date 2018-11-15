<?php

class ENFRENTAMIENTO_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Letra;
	var $NumEnfrentamiento;
	var $NumPareja;
	var $Resultado;
	var $EstadoPropuesta;
	var $ResultadoSet1;
	var $ResultadoSet2;
	var $ResultadoSet3;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra,$NumEnfrentamiento,$NumPareja,$ResultadoSet1,$ResultadoSet2,$ResultadoSet3,$EstadoPropuesta) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		$this->NumEnfrentamiento = $NumEnfrentamiento;
		$this->NumPareja = $NumPareja;
		$this->ResultadoSet1 = $ResultadoSet1;		
		$this->ResultadoSet2 = $ResultadoSet2;		
		$this->ResultadoSet3 = $ResultadoSet3;
		$this->EstadoPropuesta = $EstadoPropuesta;
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 
	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' ) && ( $this->NumEnfrentamiento <> '' )
		   && ( $this->NumPareja <> '' )) {         
	
			$sql = "SELECT * FROM ENFRENTAMIENTO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra ='$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";

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
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$this->NumEnfrentamiento',
								'$this->NumPareja',
								NULL,
								NULL,
								NULL,
								'0'
								)";					
					
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else {					
						return 'Inserción realizada con éxito'; 				
					}	
				}else{
						return 'Error en la insercion';
				}
			}
		} else { 
			return 'Error en la inserción';
		}
	} 
    
	function SEARCH() {

		$sql = "select IdCampeonato,
					Tipo,
					Nivel,
					Letra,
					NumEnfrentamiento,
					NumPareja,
					ResultadoSet1,
					ResultadoSet2,
					ResultadoSet3,
					EstadoPropuesta;					
       			from ENFRENTAMIENTO
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
					(BINARY Tipo LIKE '%$this->Tipo%') &&
					(BINARY Nivel LIKE '%$this->Nivel%') &&
					(BINARY Grupo_Letra LIKE '%$this->Letra%') &&
					(BINARY NumEnfrentamiento LIKE '%$this->NumEnfrentamiento%') &&
					(BINARY NumPareja LIKE '%$this->NumPareja%') &&
					(BINARY ResultadoSet1 LIKE '%$this->ResultadoSet1%') &&		
					(BINARY ResultadoSet2 LIKE '%$this->ResultadoSet2%') &&		
					(BINARY ResultadoSet3 LIKE '%$this->ResultadoSet3%') &&		
					(BINARY EstadoPropuesta LIKE '%$this->EstadoPropuesta%') 
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

		$sql = "SELECT DISTINCT E1.IdCampeonato as IdCampeonato,E1.Tipo as Tipo,E1.Nivel as Nivel,E1.Letra as Letra, E2.NumPareja as pareja1, E1.NumPareja as pareja2,
		E1.ResultadoSet1 as ResultadoSet1Par1, E1.ResultadoSet2 as ResultadoSet2Par1, E1.ResultadoSet3 as ResultadoSet3Par1, 
		E2.ResultadoSet1 as ResultadoSet1Par2, E2.ResultadoSet2 as ResultadoSet2Par2, E2.ResultadoSet3 as ResultadoSet3Par2,
		E1.EstadoPropuesta as propuestaPareja1,  E2.EstadoPropuesta as propuestaPareja2

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
	function RellenaDatos2() { 

		$sql = "SELECT DISTINCT E1.IdCampeonato as IdCampeonato,E1.Tipo as Tipo,E1.Nivel as Nivel,E1.Letra as Letra, E1.NumPareja as pareja1, E2.NumPareja as pareja2, 
		E1.NumEnfrentamiento as NumEnfrentamiento, 
		E1.ResultadoSet1 as ResultadoSet1Par1, E1.ResultadoSet2 as ResultadoSet2Par1, E1.ResultadoSet3 as ResultadoSet3Par1, 
		E2.ResultadoSet1 as ResultadoSet1Par2, E2.ResultadoSet2 as ResultadoSet2Par2, E2.ResultadoSet3 as ResultadoSet3Par2,
		
		E1.EstadoPropuesta as propuestaPareja1,  E2.EstadoPropuesta as propuestaPareja2
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
					ResultadoSet1 = '$this->ResultadoSet1',
					ResultadoSet2 = '$this->ResultadoSet2',
					ResultadoSet3 = '$this->ResultadoSet3',
					EstadoPropuesta = '$this->EstadoPropuesta'
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
	function EDIT2() {
		
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
					EstadoPropuesta = '$this->EstadoPropuesta'
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
				
		$sql = "SELECT DISTINCT E1.NumPareja as pareja1,  E2.NumPareja as pareja2,E1.NumEnfrentamiento as NumEnfrentamiento,
				E1.ResultadoSet1 as ResultadoSet1Par1, E1.ResultadoSet2 as ResultadoSet2Par1, E1.ResultadoSet3 as ResultadoSet3Par1, 
				E2.ResultadoSet1 as ResultadoSet1Par2, E2.ResultadoSet2 as ResultadoSet2Par2, E2.ResultadoSet3 as ResultadoSet3Par2,
					
					E1.Letra FROM ENFRENTAMIENTO E1,ENFRENTAMIENTO E2 
				
				WHERE (E1.NumEnfrentamiento = E2.NumEnfrentamiento) &&(E1.IdCampeonato = '$this->IdCampeonato') && (E1.Tipo = '$this->Tipo') 
				&& (E1.Nivel = '$this->Nivel') && (E1.Letra = '$this->Letra') &&
					(E1.IdCampeonato = E2.IdCampeonato) && (E1.Tipo = E2.Tipo) && (E1.Nivel = E2.Nivel) && (E1.Letra = E2.Letra)
					&&(E1.NumPareja != E2.NumPareja)
					
					group by E1.NumEnfrentamiento
					ORDER BY E1.NumEnfrentamiento ASC, E1.NumPareja ASC";
	//echo $sql;
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
	
	}
	function listaEnfrentamientoCalendario($dni){
		
		
		$sql = "SELECT DISTINCT E2.NumPareja as pareja1, E1.NumPareja as pareja2,  E1.NumEnfrentamiento as NumEnfrentamiento,


				E1.ResultadoSet1 as ResultadoSet1Par1, E1.ResultadoSet2 as ResultadoSet2Par1, E1.ResultadoSet3 as ResultadoSet3Par1, 
				E2.ResultadoSet1 as ResultadoSet1Par2, E2.ResultadoSet2 as ResultadoSet2Par2, E2.ResultadoSet3 as ResultadoSet3Par2,
				E2.EstadoPropuesta as propuestaPareja1,  E1.EstadoPropuesta as propuestaPareja2
				FROM ENFRENTAMIENTO E1,ENFRENTAMIENTO E2, USUARIOPAREJAS U
				WHERE 
				(E1.NumEnfrentamiento = E2.NumEnfrentamiento) 
				&&(E1.IdCampeonato = '$this->IdCampeonato') && (E1.Tipo = '$this->Tipo') && (E1.Nivel = '$this->Nivel') && (E1.Letra = '$this->Letra')
				&&(U.Pareja_idCampeonato = E1.IdCampeonato) && (U.Pareja_Tipo = E1.Tipo) && (U.Pareja_Nivel = E1.Nivel) && (U.Usuario_Dni = '$dni') && (U.Pareja_NumPareja = E2.NumPareja || U.Pareja_NumPareja = E1.NumPareja)
				&&
				(E1.IdCampeonato = E2.IdCampeonato) && (E1.Tipo = E2.Tipo) && (E1.Nivel = E2.Nivel) && (E1.Letra = E2.Letra)
				&&(E1.NumPareja != E2.NumPareja)
				GROUP BY E1.NumEnfrentamiento  
				ORDER BY E1.NumEnfrentamiento ASC		
		";
//echo $sql;
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
	
	}
	function obtenerGruposDisponibles($dni){
	
		$sql = "SELECT DISTINCT E.IdCampeonato as IdCampeonato, E.Tipo as Tipo, E.Nivel as Nivel, E.Letra as Letra
				FROM ENFRENTAMIENTO E, USUARIOPAREJAS U
				WHERE (E.IdCampeonato = U.Pareja_idCampeonato) && (E.Tipo = U.Pareja_Tipo) && (E.Nivel = U.Pareja_Nivel) && 
				(E.NumPareja = U.Pareja_NumPareja) & (U.Usuario_Dni = '$dni')
				";
				
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
 	}
}

?>