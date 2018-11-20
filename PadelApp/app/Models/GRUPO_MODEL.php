<?php

class GRUPO_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Letra;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {

		$sql = "select IdCampeonato,
					Tipo,
					Nivel,
					Letra
       			from GRUPO 
    			where 
    				(
					(BINARY IdCampeonato LIKE '%$this->IdCampeonato%') &&
					(BINARY Tipo LIKE '%$this->Tipo%') &&
					(BINARY Nivel LIKE '%$this->Nivel%') &&
					(BINARY Letra LIKE '%$this->Letra%') 
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Letra <> '' )) {         
	
			$sql = "SELECT * FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra ='$this->Letra')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 
							$sql = "INSERT INTO GRUPO (
									IdCampeonato,
									Tipo,
									Nivel,
									Letra
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra'
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

		$sql = "SELECT * FROM GRUPO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {

			$sql = "DELETE FROM GRUPO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra')";
			
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 
	function DELETE_ALL() {

		$sql = "SELECT * FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows > 0  ) {
			$sql = "DELETE FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
			$this->mysqli->query( $sql );
			return "Borrado correctamente";
		}
		else
			return "No existe";
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM GRUPO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	} 
	//Fin
	function ListaParejasGrupo(){
		
	
		$sql = "SELECT DISTINCT P.NumPareja as NumPareja,U.Login as Login,P.IdCampeonato as IdCampeonato,P.Tipo as Tipo, P.Nivel as Nivel, G.Letra as Letra
		from USUARIOPAREJAS UP, USUARIO U,PAREJA P,GRUPO G,ENFRENTAMIENTO E
		where 
		(U.Dni = UP.Usuario_Dni) && (UP.Pareja_NumPareja = P.NumPareja) && (P.IdCampeonato = UP.Pareja_idCampeonato)  && (P.Tipo = UP.Pareja_Tipo) && (P.Nivel = UP.Pareja_Nivel) 
		&&(P.IdCampeonato = '$this->IdCampeonato') && (P.Tipo = '$this->Tipo') && (P.Nivel = '$this->Nivel') &&
		(G.IdCampeonato = '$this->IdCampeonato') && (G.Tipo = '$this->Tipo') && (G.Nivel = '$this->Nivel') && (G.Letra = '$this->Letra') &&
		(E.IdCampeonato = '$this->IdCampeonato') && (E.Tipo = '$this->Tipo') && (E.Nivel = '$this->Nivel') && (E.Letra = '$this->Letra') && (E.NumPareja = P.NumPareja)
		";

		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
		
	}
	
	function ListaParejasGrupoNum(){
		
		$sql = "SELECT DISTINCT  E.NumPareja as NumPareja
		FROM GRUPO G,Enfrentamiento E
		WHERE  
		 (G.IdCampeonato = E.IdCampeonato) && (G.Tipo = E.Tipo) && (G.Nivel = E.Nivel) && (G.Letra = E.Letra)
         && (G.IdCampeonato = '$this->IdCampeonato') && (G.Tipo = '$this->Tipo') && (G.Nivel = '$this->Nivel') && (G.Letra = '$this->Letra')
		ORDER BY E.NumPareja";
		

		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
		
	}
	
	function existenGrupos(){
		
		$sql = "SELECT * FROM GRUPO WHERE  (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') ";
		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows >= 1 ) {
			return True;
		}
		else{
			return False;		
		}
	
 	}
	function Clasif(){
		$sql = "SELECT * FROM CLASIFICACION WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra='$this->Letra') ";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { 
			return $resultado;
		}
	}

}

?>