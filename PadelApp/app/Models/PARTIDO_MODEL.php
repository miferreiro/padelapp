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
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra,$NumEnfrentamiento,$Fecha,$Hora,$ParejaGanadora,$ParejaPerdedora) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		$this->NumEnfrentamiento = $NumEnfrentamiento;
		$this->Fecha = $Fecha;
		$this->Hora = $Hora;
		$this->ParejaGanadora = $ParejaGanadora;
		$this->ParejaPerdedora = $ParejaPerdedora;
		
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
									ParejaPerdedora
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
								NULL
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
					ParejaPerdedora
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
					(BINARY ParejaPerdedora LIKE '%$this->ParejaPerdedora%') 
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
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
					ParejaPerdedora = '$this->ParejaPerdedora'
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
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
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
				)";
	echo $sql;
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
					ParejaPerdedora = '$this->ParejaPerdedora'
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
	

	
 	}

?>