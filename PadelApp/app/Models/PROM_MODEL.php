<?php

class PROM_MODEL{ 
	
	var	$fecha;
	var	$hora;

	function __construct($fecha,$hora) {
		$this->fecha = $fecha;
        $this->hora=$hora;

		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {
		$sql = "select
					Hora,
					Fecha
       			from promociones 
    			where 
    				(
                    (BINARY Fecha LIKE '%$this->fecha%') &&
    				(BINARY Hora LIKE '%$this->hora%') 
					
    				)";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	} 


	function ADD() {
		
	if ( ( $this->fecha <> '' ) && ( $this->hora <> '' )  ) { 
            			
			$sql = "SELECT * FROM promociones WHERE (  Fecha = '$this->fecha' && Hora = '$this->hora')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 0 ) { 


							$sql = "INSERT INTO promociones (
							     Fecha,
								 Hora
								) 
								VALUES(
								'$this->fecha',
								'$this->hora'
								)";					
						}else {
					
						return 'Ya existe una promocion con la fecha y horas introducidas en la base de datos';// ya existe		
					}
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else { 											
						return 'Inserción realizada con éxito'; 
					}		
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	
	} 


	function DELETE() {
		$sql = "SELECT * FROM promociones WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {
			$sql = "SELECT * FROM inscripcionpromociones WHERE (Promociones_Fecha = '$this->fecha' && Promociones_Hora = '$this->hora')";
			$result = $this->mysqli->query( $sql );
			
			
			if($result->num_rows == 1){
				$sql = "DELETE FROM inscripcionpromociones WHERE (Promociones_Fecha = '$this->fecha' && Promociones_Hora = '$this->hora')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "DELETE FROM promociones WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";
			
			$this->mysqli->query( $sql );
			
			return "Borrado correctamente";
		} 
		else
			return "No existe";
	} 


	function RellenaDatos() { 

		$sql = "SELECT * FROM promociones WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";// se construye la sentencia de busqueda de la tupla
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {
            
			$result = $resultado->fetch_array();
			return $result;
		}
	} 


	

} 

?>