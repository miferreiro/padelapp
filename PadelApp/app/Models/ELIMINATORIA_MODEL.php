<?php

class ELIMINATORIA_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Fase;
	var $Letra;
	var $NumEnfrentamiento;
	var $Fecha;
	var $Hora;
	var $ParejaGanadora;
	var $ParejaPerdedora;
	var $Disputado;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Fase,$Letra,$NumEnfrentamiento,$Fecha,$Hora,$ParejaGanadora,$ParejaPerdedora,$Disputado) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Fase = $Fase;
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
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Fase <> '' ) && ( $this->Letra <> '' )  && ( $this->NumEnfrentamiento <> '' )) {         
	
			$sql = "SELECT * FROM ELIMINATORIAS WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Fase ='$this->Fase')&& (Letra ='$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 
				
							$sql = "INSERT INTO ELIMINATORIAS (
									IdCampeonato,
									Tipo,
									Nivel,
									Fase,
									Letra,
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
								'$this->Fase',
								'$this->Letra',
								'$this->NumEnfrentamiento',
								NULL,
								NULL,
								NULL,
								NULL,
								0
								)";					
				echo $sql;
				echo '<br>';		
					
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
    
	
	
	

	
 	}

?>