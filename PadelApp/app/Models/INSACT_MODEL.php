<?php


class INSACT_MODEL{ 
	
	var $Usuario_Dni;
	var	$EscuelaDeportiva_fecha;
	var	$EscuelaDeportiva_hora;
	var $EscuelaDeportiva_actividad;
	var $mysqli; 


	function __construct($Usuario_Dni,$EscuelaDeportiva_fecha,$EscuelaDeportiva_hora,$EscuelaDeportiva_actividad) {
		$this->Usuario_Dni = $Usuario_Dni;
		$this->EscuelaDeportiva_fecha = $EscuelaDeportiva_fecha;
        $this->EscuelaDeportiva_hora=$EscuelaDeportiva_hora;
		$this->EscuelaDeportiva_actividad=$EscuelaDeportiva_actividad;


		include_once '../Functions/BdAdmin.php';

		$this->mysqli = ConectarBD();

	}

	
	function SEARCH() {
		$sql = "select  Usuario_Dni,
					EscuelaDeportiva_Hora,
					EscuelaDeportiva_Fecha,
					EscuelaDeportiva_Actividad
       			from AlumnosEscuela 
    			where 
    				((BINARY Usuario_Dni LIKE '%$this->Usuario_Dni%')&&
                    (BINARY EscuelaDeportiva_Fecha LIKE '%$this->EscuelaDeportiva_fecha%') &&
    				(BINARY EscuelaDeportiva_Hora LIKE '%$this->EscuelaDeportiva_hora%') &&
					(BINARY EscuelaDeportiva_Actividad LIKE '%$this->EscuelaDeportiva_actividad%')
    				)";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	} 
	function ComprobarInscritos2($fecha,$hora,$actividad) {
		$sql = "select COUNT(*)  as num
       			from AlumnosEscuela
				where 
    				(
					EscuelaDeportiva_Fecha='$fecha' && 
					EscuelaDeportiva_Hora ='$hora' &&
					EscuelaDeportiva_Actividad ='$actividad'
    				)";
			$resultado = $this->mysqli->query( $sql ) ;
			$result = $resultado->fetch_array();
			if($result['num']==4){
				return 0;
			}else {
				return 1;
			}
	}
	
	
	function ADDGRUPAL() {
		if ( ( $this->EscuelaDeportiva_fecha <> '' ) && ( $this->EscuelaDeportiva_hora <> '' ) && ( $this->Usuario_Dni <> '' )) { 
            			
			$sql = "SELECT * FROM AlumnosEscuela WHERE (  EscuelaDeportiva_Fecha = '$this->EscuelaDeportiva_fecha' && EscuelaDeportiva_Hora = '$this->EscuelaDeportiva_hora' && Usuario_Dni = '$this->Usuario_Dni' && EscuelaDeportiva_Actividad = '$this->EscuelaDeportiva_actividad')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 1 ) { 
					
					return 'Ya está inscrito en esa actividad';	
					
				}else{
					
					  $sql = "SELECT * FROM AlumnosEscuela WHERE (  EscuelaDeportiva_Fecha = '$this->EscuelaDeportiva_fecha' && EscuelaDeportiva_Hora = '$this->EscuelaDeportiva_hora' && EscuelaDeportiva_Actividad = '$this->EscuelaDeportiva_actividad')";
					  if ( !$result = $this->mysqli->query( $sql ) ) { 						  
							return 'No se ha podido conectar con la base de datos';
						  
					  } else { 
						if ( $result->num_rows >= 4 ) {			
							return 'Número máximo de inscritos alcanzado';					
						} else {
							
								$sql = "INSERT INTO AlumnosEscuela (
									Usuario_Dni,
									EscuelaDeportiva_Fecha,
									EscuelaDeportiva_Hora,
									EscuelaDeportiva_Actividad
									) 
									VALUES(
										'$this->Usuario_Dni',
										'$this->EscuelaDeportiva_fecha',
										'$this->EscuelaDeportiva_hora',
										'$this->EscuelaDeportiva_actividad'
									)";	
								if ( !$this->mysqli->query( $sql)) { 
									return 'Error en la inserción';
								}
								
							if ( $result->num_rows == 3 ) {	
								$sql = "SELECT Dni FROM Usuario WHERE Login = 'admin'";
								$admin1 = $this->mysqli->query($sql);							
								$admin2 = $admin1->fetch_array();
								$a =  $admin2 ['Dni'];
								$Pista = "SELECT DISTINCT idPista FROM pista WHERE Fecha = '$this->EscuelaDeportiva_fecha' && Disponibilidad = 1 LIMIT 1";
								$idpistas = $this->mysqli->query($Pista);
								$pista1 = $idpistas->fetch_array();
								$p = $pista1 ['idPista'];
								$sql2 = "INSERT INTO RESERVA (
									Usuario_Dni,
									Pista_idPista,
									Pista_Fecha,
									Pista_Hora
									) 
									VALUES(
										'$a',
										'$p',
										'$this->EscuelaDeportiva_fecha',
										'$this->EscuelaDeportiva_hora'
									)";

								if ( !$this->mysqli->query( $sql2 )) { 
									return 'Error en la inserción';
								} 
								$sql3 = "UPDATE PISTA SET 
										idPista = '$p',
										Fecha = '$this->EscuelaDeportiva_fecha',
										Hora='$this->EscuelaDeportiva_hora',
										Disponibilidad = '0'
									WHERE ( idPista = '$p' && Hora = '$this->EscuelaDeportiva_hora' && Fecha ='$this->EscuelaDeportiva_fecha'
									)";	
								
								if ( !$this->mysqli->query( $sql3 )) { 
									return 'Error en la inserción';
								}else{
								return 'Inserción realizada con éxito';
							}
								
								
							}else{
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

	
function ADDINDIVIDUAL() {
		if ( ( $this->EscuelaDeportiva_fecha <> '' ) && ( $this->EscuelaDeportiva_hora <> '' ) && ( $this->Usuario_Dni <> '' )) {
		$sql = "SELECT * FROM AlumnosEscuela WHERE (  EscuelaDeportiva_Fecha = '$this->EscuelaDeportiva_fecha' && EscuelaDeportiva_Hora = '$this->EscuelaDeportiva_hora' && EscuelaDeportiva_Actividad = '$this->EscuelaDeportiva_actividad')";
		if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 
            if($result->num_rows >= 1){	
				return 'Clase completa';
			}else{
			$sql = "SELECT * FROM AlumnosEscuela WHERE (  EscuelaDeportiva_Fecha = '$this->EscuelaDeportiva_fecha' && EscuelaDeportiva_Hora = '$this->EscuelaDeportiva_hora' && Usuario_Dni = '$this->Usuario_Dni' && EscuelaDeportiva_Actividad = '$this->EscuelaDeportiva_actividad')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 1 ) { 
					
					return 'Ya está inscrito en esa actividad';	
					
				}else{

							
								$sql = "INSERT INTO AlumnosEscuela (
									Usuario_Dni,
									EscuelaDeportiva_Fecha,
									EscuelaDeportiva_Hora,
									EscuelaDeportiva_Actividad
									) 
									VALUES(
										'$this->Usuario_Dni',
										'$this->EscuelaDeportiva_fecha',
										'$this->EscuelaDeportiva_hora',
										'$this->EscuelaDeportiva_actividad'
									)";	
								if ( !$this->mysqli->query( $sql)) { 
									return 'Error en la inserción';
								}else{
									$sql = "SELECT Dni FROM Usuario WHERE Login = 'admin'";
									$admin1 = $this->mysqli->query($sql);							
									$admin2 = $admin1->fetch_array();
									$a =  $admin2 ['Dni'];
									$Pista = "SELECT DISTINCT idPista FROM pista WHERE Fecha = '$this->EscuelaDeportiva_fecha' && Disponibilidad = 1 LIMIT 1";
									$idpistas = $this->mysqli->query($Pista);
									$pista1 = $idpistas->fetch_array();
									$p = $pista1 ['idPista'];
									$sql2 = "INSERT INTO RESERVA (
										Usuario_Dni,
										Pista_idPista,
										Pista_Fecha,
										Pista_Hora
										) 
										VALUES(
											'$a',
											'$p',
											'$this->EscuelaDeportiva_fecha',
											'$this->EscuelaDeportiva_hora'
										)";

									if ( !$this->mysqli->query( $sql2 )) { 
										return 'Error en la inserción';
									} 
									$sql3 = "UPDATE PISTA SET 
											idPista = '$p',
											Fecha = '$this->EscuelaDeportiva_fecha',
											Hora='$this->EscuelaDeportiva_hora',
											Disponibilidad = '0'
										WHERE ( idPista = '$p' && Hora = '$this->EscuelaDeportiva_hora' && Fecha ='$this->EscuelaDeportiva_fecha'
										)";	

									if ( !$this->mysqli->query( $sql3 )) { 
										return 'Error en la inserción';
									}else{
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
		$fecha = date("Y-m-d");
		$sql = "SELECT * FROM AlumnosEscuela WHERE (Usuario_Dni='$this->Usuario_Dni' && EscuelaDeportiva_Fecha = '$this->EscuelaDeportiva_fecha' && EscuelaDeportiva_Fecha > '$fecha' && EscuelaDeportiva_Hora = '$this->EscuelaDeportiva_hora' &&  EscuelaDeportiva_Actividad = '$this->EscuelaDeportiva_actividad' )";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {
	        $sql = "SELECT Dni FROM Usuario WHERE Login = 'admin'";
			$admin1 = $this->mysqli->query($sql);							
			$admin2 = $admin1->fetch_array();
			$a =  $admin2 ['Dni'];
			
			$sql = "DELETE FROM reserva WHERE (Usuario_Dni='$a' && Pista_Fecha = '$this->EscuelaDeportiva_fecha' && Pista_Hora = '$this->EscuelaDeportiva_hora')";
			$this->mysqli->query( $sql );
			
			$sql = "DELETE FROM AlumnosEscuela WHERE (Usuario_Dni='$this->Usuario_Dni' && EscuelaDeportiva_Fecha = '$this->EscuelaDeportiva_fecha' && EscuelaDeportiva_Hora = '$this->EscuelaDeportiva_hora' &&  EscuelaDeportiva_Actividad = '$this->EscuelaDeportiva_actividad')";
			$this->mysqli->query( $sql );
	
			return "Borrado correctamente";
		} 
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM AlumnosEscuela WHERE (Usuario_Dni='$this->Usuario_Dni')";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 

} 

?>