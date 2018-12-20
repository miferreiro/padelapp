<?php

class PARTIDO_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Letra;
	var $NumEnfrentamiento;
	var $Fecha;
	var $Hora;
	var $ParejaGanadora;
	var $ParejaPerdedora;
	var $Disputado;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra,$NumEnfrentamiento,$Fecha,$Hora,$ParejaGanadora,$ParejaPerdedora,$Disputado) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		$this->NumEnfrentamiento = $NumEnfrentamiento;
		$this->Fecha = $Fecha;
		$this->Hora = $Hora;
		$this->ParejaGanadora = $ParejaGanadora;
		$this->ParejaPerdedora = $ParejaPerdedora;
		$this->Disputado = $Disputado;
		
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 



	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' ) && ( $this->NumEnfrentamiento <> '' )) {         
	
			$sql = "SELECT * FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra ='$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 
				
							$sql = "INSERT INTO PARTIDO (
									IdCampeonato,
									Tipo,
									Nivel,
									Grupo_Letra,
									NumEnfrentamiento,
									Fecha,
									Hora,
									ParejaGanadora,
									ParejaPerdedora,
									Disputado
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$this->NumEnfrentamiento',
								NULL,
								NULL,
								NULL,
								NULL,
								0
								)";					
					
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else {					
						return 'Inserción realizada con éxito'; 				
					}	
				}else{
					return 'Error en la inserción';
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
					Grupo_Letra,
					NumEnfrentamiento,
					Fecha,
					Hora,
					ParejaGanadora,
					ParejaPerdedora,
					Disputado
       			from PARTIDO 
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
					(BINARY Tipo LIKE '%$this->Tipo%') &&
					(BINARY Nivel LIKE '%$this->Nivel%') &&
					(BINARY Grupo_Letra LIKE '%$this->Letra%') &&
					(BINARY NumEnfrentamiento LIKE '%$this->NumEnfrentamiento%') &&
					(BINARY DATE_FORMAT(Fecha,'%d/%m/%Y') LIKE '%$this->Fecha%') &&
					(BINARY Hora LIKE '%$this->Hora%') &&
					(BINARY ParejaGanadora LIKE '%$this->ParejaGanadora%') 	&&
					(BINARY ParejaPerdedora LIKE '%$this->ParejaPerdedora%') &&
					(BINARY Disputado LIKE '%$this->Disputado%')
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 
	function ELIMINATORIAS(){
	  $sql="SELECT * FROM `partido` WHERE IdCampeonato = '$this->IdCampeonato' && Tipo = '$this->Tipo' && Nivel='$this->Nivel' && Grupo_Letra = '$this->Letra' && Disputado = 0";
		$result = $this->mysqli->query( $sql );	
		if ( $result->num_rows == 0 ) {
		$sql="SELECT * FROM `clasificacion` WHERE IdCampeonato='$this->IdCampeonato'&& Tipo='$this->Tipo' && Nivel='$this->Nivel' GROUP BY IdCampeonato,Tipo,Nivel,Letra";
			$result = $this->mysqli->query( $sql );	
			$grupos = array();
			$q = 0;
			while ( $resultado = mysqli_fetch_array( $datos ) ) {				
					$grupos[$q] = $resultado['NumPareja'];
					$q++;

			}
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'A',
								'1',
								'$grupos[0]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'H',
								'1',
								'$grupos[7]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );	
			
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'B',
								'2',
								'$grupos[1]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'G',
								'2',
								'$grupos[6]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );
			
			
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'C',
								'3',
								'$grupos[2]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'F',
								'3',
								'$grupos[5]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );
			
			
		    $sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'D',
								'4',
								'$grupos[3]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'E',
								'4',
								'$grupos[4]',
								'Cuartos',
								NULL,
								NULL,
								NULL
								)";
			$result = $this->mysqli->query( $sql );
		}
	}
	function DELETE() {

		$sql = "SELECT * FROM PARTIDO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {

			$sql = "DELETE FROM PARTIDO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
			
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 
	function DELETE_ALL() {

		$sql = "SELECT * FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Grupo_Letra = '$this->Letra')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows > 0  ) {
			$sql = "DELETE FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Grupo_Letra = '$this->Letra')";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Grupo_Letra = '$this->Letra')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	} 
	function RellenaDatos2() { 

		$sql = "SELECT * FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Grupo_Letra = '$this->Letra')&& (NumEnfrentamiento = '$this->NumEnfrentamiento')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	}

	function EDIT() {
		
		$sql = "SELECT * FROM PARTIDO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {
			
			$sql = "UPDATE PARTIDO SET 
					IdCampeonato = '$this->IdCampeonato',
					Tipo='$this->Tipo',
					Nivel='$this->Nivel',
					Grupo_Letra='$this->Letra',
					NumEnfrentamiento='$this->NumEnfrentamiento',
					Fecha = STR_TO_DATE(REPLACE('$this->Fecha','/','.') ,GET_FORMAT(date,'EUR')),
					Hora = '$this->Hora',
					ParejaGanadora = '$this->ParejaGanadora',
					ParejaPerdedora = '$this->ParejaPerdedora',
					Disputado= '$this->Disputado'
				WHERE ((IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
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
	function EDIT2() {
		
		$sql = "SELECT * FROM PARTIDO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {

			$sql = "UPDATE PARTIDO SET 
					Fecha = NULL,
					Hora = NULL
				WHERE ((IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
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

	function EDIT3() {
		
		$sql = "SELECT * FROM PARTIDO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {
		
			$sql = "UPDATE PARTIDO SET 
					IdCampeonato = '$this->IdCampeonato',
					Tipo='$this->Tipo',
					Nivel='$this->Nivel',
					Grupo_Letra='$this->Letra',
					NumEnfrentamiento='$this->NumEnfrentamiento',
					Fecha = '$this->Fecha',
					Hora = '$this->Hora',
					ParejaGanadora = '$this->ParejaGanadora',
					ParejaPerdedora = '$this->ParejaPerdedora',
					Disputado = '$this->Disputado'
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
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
	function getLastNumEnfrentamiento(){
		if (( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' )){
			
			$sql = "SELECT MAX(NumEnfrentamiento) WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Grupo_Letra = '$this->Letra') FROM PARTIDO";
			
			if(!$this->mysqli->query( $sql )){
				return 'Error en la busqueda';
			}else{
				$resultado = $this->mysqli->query( $sql );
				$resul = $resultado->fetch_array();
				if($resul == NULL){
					return(0);
				}else{
					return($resul[0]);
				}
			}
		}else { 
			return 'Error en la busqueda';
		}
		
	}
	function comprobarFaseFinalizada(){
		
		$sql = "SELECT * FROM PARTIDO WHERE (Disputado = '0') && (Grupo_Letra = '$this->Letra')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Se encuentran todos los partidos disputados'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	}

	
 	}
	function comprobarMaxFecha(){
		$sql = "SELECT MAX(Fecha) FROM PARTIDO WHERE (Disputado = '1') && (Grupo_Letra = '$this->Letra')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	}


?>