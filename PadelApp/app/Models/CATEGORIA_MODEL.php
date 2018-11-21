<?php

class CATEGORIA_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {

		$sql = "select Cat.IdCampeonato as IdCampeonato,
					Cat.Tipo as Tipo,
					Cat.Nivel as Nivel,
					Cam.FechaIni as FechaIni,
					Cam.FechaFin as FechaFin,
					Cam.HoraIni as HoraIni,
					Cam.HoraFin as HoraFin,
					(select count(numPareja)  from Pareja where  IdCampeonato = Cat.IdCampeonato  && Tipo = Cat.Tipo  && Nivel LIKE Cat.Nivel) as numInscritos
					
       			from CATEGORIA Cat, CAMPEONATO Cam
    			where 
    				(
					(BINARY Cat.IdCampeonato LIKE '%$this->IdCampeonato%') &&
					(BINARY Cat.Tipo LIKE '%$this->Tipo%') &&
					(BINARY Cat.Nivel LIKE '%$this->Nivel%')	
					&& (Cat.IdCampeonato = Cam.IdCampeonato))
    				";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 

			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) ) {         
	
			$sql = "SELECT * FROM CATEGORIA WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 

				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO CATEGORIA (
									IdCampeonato,
									Tipo,
									Nivel
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel'
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

		$sql = "SELECT * FROM CATEGORIA WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {

			$sql = "DELETE FROM CATEGORIA WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 
	function DELETE_ALL() {

		$sql = "SELECT * FROM CATEGORIA WHERE  (IdCampeonato = '$this->IdCampeonato') ";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows > 0 ) {

			$sql = "DELETE FROM CATEGORIA WHERE  (IdCampeonato = '$this->IdCampeonato') ";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM CATEGORIA WHERE (IdCampeonato = '$this->IdCampeonato')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	} 
    
	function ListaInscritos(){
		
		$sql = "SELECT P.NumPareja as NumPareja,U.Login as Login,P.IdCampeonato as IdCampeonato,P.Tipo as Tipo, P.Nivel as Nivel
		FROM PAREJA P, USUARIOPAREJAS UP, USUARIO U
		WHERE  (
		P.IdCampeonato = '$this->IdCampeonato') && (P.Tipo = '$this->Tipo') && (P.Nivel = '$this->Nivel')
		&& (U.Dni = UP.Usuario_Dni) && (UP.Pareja_NumPareja = P.NumPareja)
		&& (P.IdCampeonato = UP.Pareja_idCampeonato)  && (P.Tipo = UP.Pareja_Tipo) && (P.Nivel = UP.Pareja_Nivel) 
		ORDER BY P.NumPareja	
		";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
	}

 	}//fin de clase

?>