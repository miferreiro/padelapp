<?php

class CAMPEONATO_MODEL{ 

	var $IdCampeonato; 
    var $FechaIni;
	var $HoraIni;
	var $FechaFin;
	var $HoraFin;
	var $mysqli; 

	function __construct($IdCampeonato,$FechaIni,$HoraIni,$FechaFin,$HoraFin) {

		$this->IdCampeonato = $IdCampeonato;
        $this->FechaIni=$FechaIni;
		$this->HoraIni = $HoraIni;
		$this->FechaFin = $FechaFin;
		$this->HoraFin = $HoraFin;

		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {

		$sql = "select IdCampeonato,
					FechaIni,
					HoraIni,
                    FechaFin,
					HoraFin
       			from CAMPEONATO 
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
                    (BINARY  DATE_FORMAT(FechaIni,'%d/%m/%Y') LIKE '%$this->FechaIni%') &&
					(BINARY HoraIni LIKE '%$this->HoraIni%') &&
    				(BINARY DATE_FORMAT(FechaFin,'%d/%m/%Y') LIKE '%$this->FechaFin%') &&
					(BINARY HoraFin LIKE '%$this->HoraFin%')
			
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) ) {         
	
			$sql = "SELECT * FROM CAMPEONATO WHERE (  IdCampeonato = '$this->IdCampeonato')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 

				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO CAMPEONATO (
									IdCampeonato,
									FechaIni,
									HoraIni,
									FechaFin,
									HoraFin
					             	) 
								VALUES(
								'$this->IdCampeonato',
								STR_TO_DATE(REPLACE('$this->FechaIni','/','.'),GET_FORMAT(date,'EUR')),
								'$this->HoraIni',
								STR_TO_DATE(REPLACE('$this->FechaFin','/','.'),GET_FORMAT(date,'EUR')),
								'$this->HoraFin'
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

    
	function DELETE() {

		$sql = "SELECT * FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {

			$sql = "SELECT * FROM Enfrentamiento WHERE (IdCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM Enfrentamiento WHERE (IdCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "SELECT * FROM ELIMINATORIAS WHERE (IdCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM ELIMINATORIAS WHERE (IdCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "SELECT * FROM usuarioparejas WHERE (Pareja_idCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM usuarioparejas WHERE (Pareja_idCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "SELECT * FROM Pareja WHERE (idCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM Pareja WHERE (idCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			$sql = "SELECT * FROM Partido WHERE (IdCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM Partido WHERE (IdCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			$sql = "SELECT * FROM Grupo WHERE (IdCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM Grupo WHERE (IdCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			$sql = "SELECT * FROM Categoria WHERE (IdCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			if($result->num_rows >= 1){
				$sql = "DELETE FROM Categoria WHERE (IdCampeonato = '$this->IdCampeonato')";
				$this->mysqli->query( $sql );
			}
			$sql = "DELETE FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
			$this->mysqli->query( $sql );
			
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();
			$result[ 'FechaIni' ] = date( "d/m/Y", strtotime( $result[ 'FechaIni' ] ) );
			$result[ 'FechaFin' ] = date( "d/m/Y", strtotime( $result[ 'FechaFin' ] ) );
			return $result;
		}
	} 
    

	function EDIT() {
		
		$sql = "SELECT * FROM CAMPEONATO WHERE (IdCampeonato = '$this->IdCampeonato')";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {

			$sql = "UPDATE CAMPEONATO SET 
					IdCampeonato = '$this->IdCampeonato',
                    FechaIni=STR_TO_DATE(REPLACE('$this->FechaIni','/','.') ,GET_FORMAT(date,'EUR')),
					HoraIni='$this->HoraIni',
					FechaFin = STR_TO_DATE(REPLACE('$this->FechaFin','/','.') ,GET_FORMAT(date,'EUR')),
					HoraFin='$this->HoraFin'
				WHERE ( IdCampeonato = '$this->IdCampeonato'
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
	
	

 	}//fin de clase

?>