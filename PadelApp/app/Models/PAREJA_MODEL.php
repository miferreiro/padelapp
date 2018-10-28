<?php

class PAREJA_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $NumPareja;
	var $Capitan;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$NumPareja,$Capitan) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->NumPareja = $NumPareja;
		$this->Capitan = $Capitan;
		
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->NumPareja <> '' ) ) {         
	
			$sql = "SELECT * FROM PAREJA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción3'; 
			} else { 

				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO PAREJA (
									IdCampeonato,
									Tipo,
									Nivel,
									NumPareja,
									Capitan
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->NumPareja',
								'$this->Capitan'
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
	
	function getParejasCategoria(){
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' )){
				
			$sql = "SELECT NumPareja FROM PAREJA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') ORDER BY NumPareja";
		
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'No existe en la base de datos'; // 
			} else {            
				$result = $resultado->fetch_array();	
				return $result;
			}

		}else { 
			return 'Error en la busqueda';
		}
	}
	function getLastNumPareja(){
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' )){
			
			$sql = "SELECT MAX(NumPareja) WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') FROM PAREJA";
			
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

 	}//fin de clase

?>