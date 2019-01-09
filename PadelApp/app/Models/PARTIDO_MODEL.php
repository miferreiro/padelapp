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
	function CUARTOS(){
	  $sql="SELECT * FROM `partido` WHERE IdCampeonato = '$this->IdCampeonato' && Tipo = '$this->Tipo' && Nivel='$this->Nivel' && Grupo_Letra = '$this->Letra' && Disputado = 0";
		$result = $this->mysqli->query( $sql );	
		if ( $result->num_rows == 0 ) {
		$sql="SELECT * FROM `clasificacion` WHERE IdCampeonato='$this->IdCampeonato'&& Tipo='$this->Tipo' && Nivel='$this->Nivel' && Letra='$this->Letra' LIMIT 8";
			$result = $this->mysqli->query( $sql );	
			$grupos = array();
			$q = 0;
			while ( $resultado = mysqli_fetch_array( $result ) ) {				
					$grupos[$q] = $resultado['NumPareja'];
					$q++;

			}
			$j=$q-1;
			for($i=0;$i<=$j;$i++){
			
		$sql = "SELECT MAX(NumEnfrentamiento) AS NumEnfrentamiento FROM PARTIDO";
		
		$resultado = $this->mysqli->query( $sql ); 
			$result = $resultado->fetch_array();	
			$MaxNumEn= $result['NumEnfrentamiento']+1;
			$sql="INSERT INTO PARTIDO(
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
								'$MaxNumEn',
								NULL,
								NULL,
								NULL,
								NULL,
								0
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
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$grupos[$i]',
								'Cuartos',
								NULL,
								NULL,
								NULL,
								0
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
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',		
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$grupos[$j]',
								'Cuartos',
								NULL,
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );

				$j--;
			}
			return 'Cuartos generados';
		}else{
			return 'No están todos los partidos disputados';
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
	function getLastFecha(){
		
			
			$sql = "SELECT MAX(Fecha) FROM PARTIDO";
			
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
		
		
	}
function comprobarFechaPartido(){
		
			
			$sql = "SELECT Fecha FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
			
			if(!$resultado = $this->mysqli->query( $sql )){
				return 'Error en la busqueda';
			}else{
				if( $resultado->num_rows == 0){
					return  date("Y-m-d");
				}else{
					$resul = $resultado->fetch_array();
					return $resul["Fecha"];
				}
			}
		
		
	}
	function comprobarFaseFinalizada(){
		
		$sql = "SELECT * FROM PARTIDO WHERE (Disputado = '0') && (Grupo_Letra = '$this->Letra') && (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Se encuentran todos los partidos disputados'; // 
		} else {     
			if ( $resultado->num_rows == 0 ) {
					return 0;
			}else{
					return 1;
			}
		}
	}

	

}

?>