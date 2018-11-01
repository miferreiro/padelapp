<?php

class USUARIO_PAREJA_MODEL{ 
	var $UsuDni;
	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $NumPareja;
	var $mysqli; 

	function __construct($UsuDni,$IdCampeonato,$Tipo,$Nivel,$NumPareja) {

		$this->UsuDni = $UsuDni;
		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->NumPareja = $NumPareja;
		
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) && ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->NumPareja <> '' ) && ( $this->UsuDni <> '' ) ) {         
	
			$sql = "SELECT * FROM USUARIOPAREJAS WHERE  (Pareja_idCampeonato = '$this->IdCampeonato') && (Pareja_Tipo = '$this->Tipo') && (Pareja_Nivel = '$this->Nivel') && (Usuario_Dni = '$this->UsuDni') && (Pareja_NumPareja = '$this->NumPareja')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 

				if ( $result->num_rows == 0 ) { 
						$sql = "INSERT INTO usuarioparejas (
								Usuario_Dni,
								Pareja_idCampeonato,
								Pareja_Tipo,
								Pareja_Nivel,
								Pareja_NumPareja
								) 
							VALUES(
							'$this->UsuDni',
							'$this->IdCampeonato',							
							'$this->Tipo',
							'$this->Nivel',
							'$this->NumPareja'
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

		$sql = "SELECT * FROM USUARIOPAREJAS WHERE (Pareja_idCampeonato = '$this->IdCampeonato') && (Pareja_Tipo = '$this->Tipo') && (Pareja_Nivel = '$this->Nivel') && (Usuario_Dni = '$this->UsuDni') && (Pareja_NumPareja = '$this->NumPareja')";

		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {
				
			$sql = "DELETE FROM USUARIOPAREJAS WHERE (Pareja_idCampeonato = '$this->IdCampeonato') && (Pareja_Tipo = '$this->Tipo') && (Pareja_Nivel = '$this->Nivel') && (Usuario_Dni = '$this->UsuDni') && (Pareja_NumPareja = '$this->NumPareja')";

			$this->mysqli->query( $sql );
	
			return "Borrado correctamente";
		}else{
			return "No existe";
		}
	} 
	
 	}

?>