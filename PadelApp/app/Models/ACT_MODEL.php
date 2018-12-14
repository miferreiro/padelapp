<?php

class ACT_MODEL{ 
	
	var	$fecha;
	var	$hora;
	var $actividad;
	var $mysqli; 
	
	function __construct($fecha,$hora,$actividad) {
		$this->fecha = $fecha;
        $this->hora=$hora;
		$this->actividad=$actividad;

		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {
		$sql = "select
					Hora,
					Fecha,
					Actividad
       			from EscuelaDeportiva 
    			where 
    				(
                    (BINARY Fecha LIKE '%$this->fecha%') &&
    				(BINARY Hora LIKE '%$this->hora%') &&
					(BINARY Actividad LIKE '%$this->actividad%')
    				)";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	} 

	function ADD() {
		
	if ( ( $this->fecha <> '' ) && ( $this->hora <> '' )  ) { 
            			
			$sql = "SELECT * FROM EscuelaDeportiva WHERE (  Fecha = '$this->fecha' && Hora = '$this->hora' && Actividad = '$this->actividad')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 
					if ( $result->num_rows == 0 ) { 
						$sql = "INSERT INTO EscuelaDeportiva (
								 Fecha,
								 Hora,
								 Actividad
								) 
								VALUES(
								'$this->fecha',
								'$this->hora',
								'$this->actividad'
								)";	
						if ( !$this->mysqli->query( $sql )) { 
							return 'Error en la inserción';
						} else { 											
							return 'Inserción realizada con éxito'; 
						}										
					}else {
					
						return 'Ya existe una actividad con la fecha y horas introducidas en la base de datos';// ya existe		
					}
					
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	
	} 


	function DELETE() {
		$sql = "SELECT * FROM EscuelaDeportiva WHERE (Fecha = '$this->fecha' && Hora = '$this->hora' && Actividad = '$this->actividad')";
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {
			$sql = "SELECT * FROM AlumnosEscuela WHERE (EscuelaDeportiva_Fecha = '$this->fecha' && EscuelaDeportiva_Hora = '$this->hora' && EscuelaDeportiva_Actividad = '$this->actividad')";
			$result = $this->mysqli->query( $sql );
			
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM AlumnosEscuela WHERE (EscuelaDeportiva_Fecha = '$this->fecha' && EscuelaDeportiva_Hora = '$this->hora' && EscuelaDeportiva_Actividad = '$this->actividad')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "DELETE FROM EscuelaDeportiva WHERE (Fecha = '$this->fecha' && Hora = '$this->hora' && Actividad = '$this->actividad')";
			
			$this->mysqli->query( $sql );
			
			return "Borrado correctamente";
		} 
		else
			return "No existe";
	} 


	function RellenaDatos() { 

		$sql = "SELECT * FROM EscuelaDeportiva WHERE (Fecha = '$this->fecha' && Hora = '$this->hora')";// se construye la sentencia de busqueda de la tupla
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {
            
			$result = $resultado->fetch_array();
			return $result;
		}
	} 


	

} 

?>