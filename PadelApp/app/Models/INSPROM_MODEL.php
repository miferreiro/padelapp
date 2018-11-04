<?php


class INSPROM_MODEL{ 
	
	var $Usuario_Dni;
	var	$Promociones_fecha;
	var	$Promociones_hora;
	var $mysqli; 


	function __construct($Usuario_Dni,$Promociones_fecha,$Promociones_hora) {
		$this->Usuario_Dni = $Usuario_Dni;
		$this->Promociones_fecha = $Promociones_fecha;
        $this->Promociones_hora=$Promociones_hora;


		include_once '../Functions/BdAdmin.php';

		$this->mysqli = ConectarBD();

	}

	
	function SEARCH() {
		$sql = "select  Usuario_Dni,
					Promociones_Hora,
					Promociones_Fecha
       			from inscripcionpromociones 
    			where 
    				((BINARY Usuario_Dni LIKE '%$this->Usuario_Dni%')&&
                    (BINARY Promociones_Fecha LIKE '%$this->Promociones_fecha%') &&
    				(BINARY Promociones_Hora LIKE '%$this->Promociones_hora%') 
					
    				)";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->Promociones_fecha <> '' ) && ( $this->Promociones_hora <> '' ) && ( $this->Usuario_Dni <> '' )) { 
            			
			$sql = "SELECT * FROM INSCRIPCIONPROMOCIONES WHERE (  Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora' && Usuario_Dni = '$this->Usuario_Dni')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 1 ) { 
					
					return 'Ya está inscrito en esa promoción';	
					
				}else{
					
					  $sql = "SELECT * FROM inscripcionpromociones WHERE (  Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";
					  if ( !$result = $this->mysqli->query( $sql ) ) { 						  
							return 'No se ha podido conectar con la base de datos';
						  
					  } else { 
						if ( $result->num_rows >= 4 ) {			
							return 'Número máximo de inscritos alcanzado';					
						} else {

								$sql = "INSERT INTO INSCRIPCIONPROMOCIONES (
									Usuario_Dni,
									Promociones_Fecha,
									Promociones_Hora
									) 
									VALUES(
										'$this->Usuario_Dni',
										'$this->Promociones_fecha',
										'$this->Promociones_hora'
									)";	

								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} else { 											
									return 'Inserción realizada con éxito'; 
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
		$sql = "SELECT * FROM inscripcionpromociones WHERE (Usuario_Dni='$this->Usuario_Dni' && Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {
	
			$sql = "DELETE FROM inscripcionpromociones WHERE (Usuario_Dni='$this->Usuario_Dni' && Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";
			
			$this->mysqli->query( $sql );
	
			return "Borrado correctamente";
		} 
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM inscripcionpromociones WHERE (Usuario_Dni='$this->Usuario_Dni' && Promociones_Fecha = '$this->Promociones_fecha' && Promociones_Hora = '$this->Promociones_hora')";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 

} 

?>