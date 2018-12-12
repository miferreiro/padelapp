<?php

class ENFRENELIMINATORIA_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Fase;
	var $NumEnfrentamiento;
	var $NumPareja;
	var $Resultado;
	var $EstadoPropuesta;
	var $ResultadoSet1;
	var $ResultadoSet2;
	var $ResultadoSet3;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$NumPareja,$ResultadoSet1,$ResultadoSet2,$ResultadoSet3,$EstadoPropuesta) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Fase = $Fase;
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
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Fase <> '' ) && ( $this->NumEnfrentamiento <> '' )
		   && ( $this->NumPareja <> '' )) {         
	
			$sql = "SELECT * FROM enfreneliminatorias WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Fase ='$this->Fase') && (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 

							$sql = "INSERT INTO enfreneliminatorias (
									IdCampeonato,
									Tipo,
									Nivel,
									Fase,
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
								'$this->Fase',
								'$this->NumEnfrentamiento',
								'$this->NumPareja',
								NULL,
								NULL,
								NULL,
								'0'
								)";					
					echo $sql;
					echo '<br>';
					
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
    
}

?>