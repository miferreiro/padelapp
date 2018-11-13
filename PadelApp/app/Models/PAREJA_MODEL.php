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
	
			$sql = "SELECT * FROM PAREJA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')&& (NumPareja = '$this->NumPareja')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
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
	
	function DELETE() {

		$sql = "SELECT * FROM PAREJA WHERE (idCampeonato = '$this->IdCampeonato') && (tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (NumPareja = '$this->NumPareja')";

		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {
				
			$sql = "DELETE FROM PAREJA WHERE (idCampeonato = '$this->IdCampeonato') && (tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (NumPareja = '$this->NumPareja')";

			$this->mysqli->query( $sql );
	
			return "Borrado correctamente";
		}else{
			return "No existe";
		}
	} 
	
	function getParejasCategoria(){
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' )){
				
			$sql = "SELECT *  FROM PAREJA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') ";
		
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'No existe en la base de datos'; // 
			} else {            
				
				return $resultado;
			}

		}else { 
			return 'Error en la busqueda';
		}
	}
	function getLastNumPareja(){
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' )){
			
			$sql = "SELECT MAX(NumPareja) as num  FROM PAREJA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')"; 
			
			if(!$this->mysqli->query( $sql )){
				return 'Error en la busqueda';
			}else{
				$resultado = $this->mysqli->query( $sql );
				$result = $resultado->fetch_array();
				if($result['num'] == NULL){
					return(0);
				}else{
					return($result['num']);
				}
			}
		}else { 
			return 'Error en la busqueda';
		}
		
	}
	
	function esCapitan($capitan){
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' )){
			
			$sql = "SELECT * FROM PAREJA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Capitan = '$capitan')";
			if(!$result =$this->mysqli->query( $sql )){
				return 'Error en la busqueda';
			}else{
				
				if ( $result->num_rows == 0 ) { 
					return false;
				}else{
					return true;
				}
			}
		}else { 
			return 'Error en la busqueda';
		}			
		
	}
	
	function estaInscito($login1,$login2){
	
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' )){
			
			$sql = "SELECT * FROM USUARIOPAREJAS UP, USUARIO U 
			WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (UP.Usuario_Dni = U.Login)
			&& ((U.login = '$login1' ) || (U.login = '$login2'))";
			
			echo $sql;
			if(!$result =$this->mysqli->query( $sql )){
				return 'Error en la busqueda';
			}else{
				
				if ( $result->num_rows == 0 ) { 
					return false;
				}else{
					return true;
				}
			}
		}else { 
			return 'Error en la busqueda';
		}
	
	}

	function numPareja($dni){
					
			$sql = "SELECT Pareja_NumPareja as num  FROM USUARIOPAREJAS WHERE (Pareja_idCampeonato = '$this->IdCampeonato') && (Pareja_Tipo = '$this->Tipo') && (Pareja_Nivel = '$this->Nivel')&& (Usuario_Dni = '$dni')"; 
			
			if(!$this->mysqli->query( $sql )){
				return 'Error en la busqueda';
			}else{
				$resultado = $this->mysqli->query( $sql );
				$result = $resultado->fetch_array();
				if($result['num'] == NULL){
					return(0);
				}else{
					return($result['num']);
				}
			}

		
	
	}
	
 	}//fin de clase

?>