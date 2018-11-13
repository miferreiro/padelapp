<?php

class RESERVA_MODEL{ 
	
	var $Usuario_Dni;
	var $Pista_idPista;
	var	$Pista_fecha;
	var	$Pista_hora;


	function __construct($Usuario_Dni,$Pista_idPista,$Pista_fecha,$Pista_hora) {
		
		$this->Usuario_Dni = $Usuario_Dni;
		$this->Pista_idPista = $Pista_idPista;
		$this->Pista_fecha = $Pista_fecha;
        $this->Pista_hora=$Pista_hora;

		include_once '../Functions/BdAdmin.php';

		$this->mysqli = ConectarBD();

	} 


	function SEARCH() {

		$sql = "select  Usuario_Dni,
					Pista_idPista,
					Pista_Hora,
					Pista_Fecha
       			from RESERVA 
    			where 
    				((BINARY Usuario_Dni LIKE '%$this->Usuario_Dni%')&&
					(BINARY Pista_idPista LIKE '%$this->Pista_idPista%') &&
                    (BINARY Pista_Fecha LIKE '%$this->Pista_fecha%') &&
    				(BINARY Pista_Hora LIKE '%$this->Pista_hora%') 
					
    				)";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 


	function ADD() {
		if ( ( $this->Pista_fecha <> '' ) && ( $this->Pista_hora <> '' )&& ( $this->Pista_idPista <> '' ) && ( $this->Usuario_Dni <> '' )) { 
            			
			$sql = "SELECT * FROM RESERVA WHERE ( Pista_idPista = '$this->Pista_idPista' &&  Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora' && Usuario_Dni = '$this->Usuario_Dni')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 1 ) { 
					
					return 'Ya ha reservado esa pista';	
					
				}else{
					
					  $sql = "SELECT * FROM PISTA WHERE (  Fecha = '$this->Pista_fecha' && Hora = '$this->Pista_hora' && Disponibilidad = 1)";
					  if ( !$result = $this->mysqli->query( $sql ) ) { 						  
							return 'No se ha podido conectar con la base de datos';
						  
					  } else { 
						if ( $result->num_rows == 0 ) {			
							return 'La pista no está disponible';					
						} else {
								$sql = "INSERT INTO RESERVA (
									Usuario_Dni,
									Pista_idPista,
									Pista_Fecha,
									Pista_Hora
									) 
									VALUES(
										'$this->Usuario_Dni',
										'$this->Pista_idPista',
										'$this->Pista_fecha',
										'$this->Pista_hora'
									)";	
								$sql2 = "UPDATE PISTA SET 
										idPista = '$this->Pista_idPista',
										Hora='$this->Pista_hora',
										Fecha = '$this->Pista_fecha',
										Disponibilidad = '0'
									WHERE ( idPista = '$this->Pista_idPista' && Hora = '$this->Pista_hora' && Fecha = '$this->Pista_fecha'
									)";

								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} else { 
									if ( !$this->mysqli->query( $sql2 )) { 
									return 'Error en la inserción';
										} else { 
									return 'Inserción realizada con éxito'; 
								}
							  }										
							}
						  }
					}
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	} 

    
	function DELETE() {
		
		$sql = "SELECT * FROM RESERVA WHERE (Usuario_Dni='$this->Usuario_Dni' && Pista_idPista = '$this->Pista_idPista' && Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora')";
	
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {
			
			$sql = "DELETE FROM RESERVA WHERE (Usuario_Dni='$this->Usuario_Dni' && Pista_idPista = '$this->Pista_idPista' && Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora')";
			
			$this->mysqli->query( $sql );
			
			return "Borrado correctamente";
		} 
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM RESERVA WHERE (Usuario_Dni='$this->Usuario_Dni' && Pista_idPista = '$this->Pista_idPista' && Pista_Fecha = '$this->Pista_fecha' && Pista_Hora = '$this->Pista_hora')";// se construye la sentencia de busqueda de la tupla

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 

			$result = $resultado->fetch_array();
			return $result;
		}
	} 

	function RESERVACAMP(){

            	
					
	  $sql = "SELECT * FROM PISTA WHERE (  Fecha = '$this->Pista_fecha' && Hora = '$this->Pista_hora' && Disponibilidad = 1)";
	  if ( !$result = $this->mysqli->query( $sql ) ) { 						  
			return 'No se ha podido conectar con la base de datos';
		  
	  } else { 
		if ( $result->num_rows == 0 ) {			
			return 'La pista no está disponible';					
		} else {
				
				$idPista="";
				while($fila = mysqli_fetch_array($result)){
					$idPista = $fila['idPista'];
					break;
				}
				echo $idPista;
				echo "aqwq";
				$sql = "INSERT INTO RESERVA (
					Usuario_Dni,
					Pista_idPista,
					Pista_Fecha,
					Pista_Hora
					) 
					VALUES(
						'$this->Usuario_Dni',
						'$idPista',
						'$this->Pista_fecha',
						'$this->Pista_hora'
					)";	
				$sql2 = "UPDATE PISTA SET 
						idPista = '$idPista',
						Hora='$this->Pista_hora',
						Fecha = '$this->Pista_fecha',
						Disponibilidad = '0'
					WHERE ( idPista = '$idPista' && Hora = '$this->Pista_hora' && Fecha = '$this->Pista_fecha'
					)";

				if ( !$this->mysqli->query( $sql )) { 
					return 'Error en la inserción';
				} else { 
					if ( !$this->mysqli->query( $sql2 )) { 
					return 'Error en la inserción';
						} else { 
					return 'Inserción realizada con éxito'; 
				}
			  }										
			}
		  }

	}
	

} 

?>