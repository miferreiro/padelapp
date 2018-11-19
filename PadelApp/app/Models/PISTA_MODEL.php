<?php


class PISTA_MODEL{ 

	var $idPista;
	var	$hora;
	var	$fecha;
	var $disponibilidad;
	
	function __construct($idPista,$hora,$fecha,$disponibilidad) {
		$this->idPista = $idPista;
        $this->hora=$hora;
		$this->disponibilidad = $disponibilidad;
		$this->fecha = $fecha;
		
        
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 


	function SEARCH() {
		$sql = "select  idPista,
                    Fecha,
					Hora,
					Disponibilidad
       			from PISTA 
    			where 
    				(
					(BINARY idPista LIKE '%$this->idPista%') &&
                    (BINARY Fecha LIKE '%$this->fecha%') &&
    				(BINARY Hora LIKE '%$this->hora%') &&
					(BINARY Disponibilidad LIKE '%$this->disponibilidad%')
    				)";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	}
	function SEARCH2() {
		$sql = "select  P.idPista,
                    P.Fecha,
					P.Hora,
					P.Disponibilidad,
					R.Usuario_Dni
       			from PISTA P, RESERVA R
    			where 
    				(
					(BINARY P.idPista LIKE '%$this->idPista%') &&
                     R.Pista_idPista=P.idPista &&   
                    (BINARY P.Fecha LIKE '%$this->fecha%') &&
                       R.Pista_Fecha = P.Fecha &&
    				(BINARY P.Hora LIKE '%$this->hora%') &&
                       R.Pista_Hora = P.Hora &&
					(BINARY P.Disponibilidad LIKE '%$this->disponibilidad%')
    				)";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 
	
	function PISTAS() {
		$sql = "select distinct idPista from PISTA order by 1";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 
	
	function FECHAS() {
		$sql = "select distinct Fecha from PISTA order by 1";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 
	
	function HORAS() {
		$sql = "select distinct Hora from PISTA order by 1";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 
	function HORASPROMOCION($hora,$fecha) {
		$sql = "select distinct Hora from PISTA WHERE (Fecha = '$fecha' && Hora = '$hora'&& Disponibilidad = 1)order by 1";
	 $resultado = $this->mysqli->query( $sql );				
	if($resultado->num_rows==1){
				return 1;
			}else {
				return 0;
			}
	} 
	function ComprobarDisp($idPista,$hora,$fecha) {
		$sql = "select Disponibilidad 
       			from PISTA
				where 
    				(
					idPista='$idPista' && Fecha='$fecha' && Hora ='$hora' && Disponibilidad = '1'
    				)";
		 $resultado = $this->mysqli->query( $sql ) ;
			if($resultado->num_rows==1){
				return 1;
			}else {
				return 0;
			}
			
		
	} 
    
	function ADD() {
            			
			$sql = "SELECT * FROM PISTA WHERE (  idPista = '$this->idPista')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 
						
						for($i=0 ; $i<7 ; $i++){				
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'11:00',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} 
								
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'12:30',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} 

							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'16:00',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								}
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'17:30',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								}
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'19:00',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} 						
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'20:30',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} 							
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$this->idPista',
                                ADDDATE(NOW(),$i),
								'22:00',
								'1'
								)";		
								
								if ( !$this->mysqli->query( $sql )) { 
									return 'Error en la inserción';
								} 
						}	
								return 'Inserción realizada con éxito'; 
				}	
	} 


	function DELETE() {
		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista')";
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows >=1 ) {
			
			$sql = "SELECT * FROM RESERVA WHERE (Pista_idPista = '$this->idPista')";
			$result = $this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM RESERVA WHERE (Pista_idPista = '$this->idPista')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "DELETE FROM PISTA WHERE (idPista = '$this->idPista' )";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		} 
		else
			return "No existe";
	} 


	function RellenaDatos() { 

		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista')";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
	function RellenaDatos2() { 

		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista' && Hora = '$this->hora' && Fecha = '$this->fecha')";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
	function RellenaDatos3() { 

		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista' && Fecha='$this->fecha')";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
	

	function EDIT() {
		$sql = "SELECT * FROM PISTA WHERE (idPista = '$this->idPista' && Hora = '$this->hora' && Fecha = '$this->fecha')";
		$result = $this->mysqli->query( $sql );
		if ( $result->num_rows == 1 ) {

			$sql = "UPDATE PISTA SET 
					idPista = '$this->idPista',
                    Hora='$this->hora',
					Fecha = '$this->fecha',
					Disponibilidad = '$this->disponibilidad'
				WHERE ( idPista = '$this->idPista' && Hora = '$this->hora' && Fecha = '$this->fecha'
				)";
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { 
				return 'Modificado correctamente';
			}

		} 
		else {
			return 'No existe en la base de datos';
		}
	} 

	
	function getLastIdPista(){
			
			$sql = "SELECT MAX(idPista) as num  FROM PISTA "; 
			
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
	
	
	function ACTUALIZAR(){
			$fecha = date("Y-m-d");
			
			$sql= "SELECT COUNT(DISTINCT FECHA) as fech FROM PISTA WHERE FECHA >= '$fecha'";
		    $dias = $this->mysqli->query( $sql );
			$dia= $dias->fetch_array();
			$sql= "SELECT MAX(idPista) as num  FROM PISTA ";
		    $pistas = $this->mysqli->query( $sql );
			$pista = $pistas->fetch_array();
		
			$sql = "DELETE FROM RESERVA WHERE Pista_Fecha < '$fecha'"; 
			$this->mysqli->query( $sql );		
			$sql = "DELETE FROM PISTA WHERE Fecha < '$fecha'"; 
			$this->mysqli->query( $sql );

			$sql = "DELETE FROM INSCRIPCIONPROMOCIONES WHERE Promociones_Fecha < '$fecha'"; 
			$this->mysqli->query( $sql );
			$sql = "DELETE FROM PROMOCIONES WHERE Fecha < '$fecha'"; 
			$this->mysqli->query( $sql );
		
			
		for($x=1 ; $x<=$pista['num'] ; $x++){	
		for($i=$dia['fech'] ; $i<7 ; $i++){				
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'11:00',
								'1'
								)";										
								$this->mysqli->query( $sql );

								
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'12:30',
								'1'
								)";		
								
								$this->mysqli->query( $sql );

							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'16:00',
								'1'
								)";		
								
								 $this->mysqli->query( $sql );
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'17:30',
								'1'
								)";		
								
								$this->mysqli->query( $sql );
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'19:00',
								'1'
								)";		
								
								$this->mysqli->query( $sql );						
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'20:30',
								'1'
								)";		
								
								$this->mysqli->query( $sql ); 							
							$sql = "INSERT INTO PISTA (
							    idPista,
								Fecha,
								Hora,
								Disponibilidad) 
								VALUES(
								'$x',
                                ADDDATE(NOW(),$i),
								'22:00',
								'1'
								)";		
								
								$this->mysqli->query( $sql );
						
	  }
	}
  } 
}
?>