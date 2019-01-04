<?php

class ELIMINATORIA_MODEL{ 

	var $IdCampeonato; 
    var $Tipo;
	var $Nivel;
	var $Letra;
	var $NumEnfrentamiento;
	var $NumPareja;
	var $Fase;
	var $Resultado;
	var $EstadoPropuesta;
	var $ResultadoSet1;
	var $ResultadoSet2;
	var $ResultadoSet3;
	var $mysqli; 

	function __construct($IdCampeonato,$Tipo,$Nivel,$Letra,$NumEnfrentamiento,$NumPareja,$Fase,$ResultadoSet1,$ResultadoSet2,$ResultadoSet3,$EstadoPropuesta) {

		$this->IdCampeonato = $IdCampeonato;
		$this->Tipo = $Tipo;
		$this->Nivel = $Nivel;
		$this->Letra = $Letra;
		$this->NumEnfrentamiento = $NumEnfrentamiento;
		$this->NumPareja = $NumPareja;
		$this->Fase = $Fase;
		$this->ResultadoSet1 = $ResultadoSet1;		
		$this->ResultadoSet2 = $ResultadoSet2;		
		$this->ResultadoSet3 = $ResultadoSet3;
		$this->EstadoPropuesta = $EstadoPropuesta;
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 
	function ADD() {
		if ( ( $this->IdCampeonato <> '' ) &&  ( $this->Tipo <> '' ) && ( $this->Nivel <> '' ) && ( $this->Fase <> '' ) && ( $this->Letra <> '' )&& ( $this->NumEnfrentamiento <> '' )
		   && ( $this->NumPareja <> '' )) {         
	
			$sql = "SELECT * FROM eliminatorias WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Fase ='$this->Fase') && (Letra ='$this->Letra')&& (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'Error en la inserción'; 
			} else { 
				if ( $result->num_rows == 0 ) { 

							$sql = "INSERT INTO eliminatorias (
									IdCampeonato,
									Tipo,
									Nivel,
									Fase,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',							
								'$this->Tipo',
								'$this->Nivel',
								'$this->Fase',
								'$this->Letra',
								'$this->NumEnfrentamiento',
								'$this->NumPareja',
								NULL,
								NULL,
								NULL,
								'0'
								)";					
					
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else {					
						return 'Inserción realizada con éxito'; 				
					}	
				}else{
						return 'Error en la insercion';
				}
			}
		} else { 
			return 'Error en la inserción';
		}
	} 
	function EDIT() {
		
		$sql = 
		"SELECT * FROM ELIMINATORIAS 
		WHERE  
		(IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') 
		&& (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja') 
		
		";
	
		$result = $this->mysqli->query( $sql );

		if ( $result->num_rows == 1 ) {

			$sql = "UPDATE ELIMINATORIAS SET 
					IdCampeonato = '$this->IdCampeonato',
					Tipo='$this->Tipo',
					Nivel='$this->Nivel',
					Fase='$this->Fase',
					Letra='$this->Letra',
					NumEnfrentamiento='$this->NumEnfrentamiento',
					NumPareja = '$this->NumPareja',
					ResultadoSet1 = '$this->ResultadoSet1',
					ResultadoSet2 = '$this->ResultadoSet2',
					ResultadoSet3 = '$this->ResultadoSet3',
					EstadoPropuesta = '$this->EstadoPropuesta'
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Letra = '$this->Letra') 
				&& (NumEnfrentamiento = '$this->NumEnfrentamiento') && (NumPareja = '$this->NumPareja')
				";

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
	function ganador($ResultadoSet1Par1,$ResultadoSet2Par1,$ResultadoSet3Par1,$ResultadoSet1Par2,$ResultadoSet2Par2,$ResultadoSet3Par2,$NumPareja1){
		$countPar1=0;
		$countPar2=0;
		if($ResultadoSet1Par1>$ResultadoSet1Par2){
			$countPar1++;
		}else{
			$countPar2++;
		}
		if($ResultadoSet2Par1>$ResultadoSet2Par2){
			$countPar1++;
		}else{
			$countPar2++;
		}
		if($ResultadoSet3Par1!=0 || $ResultadoSet3Par2!=0){
			
		if($ResultadoSet3Par1>$ResultadoSet3Par2){
			$countPar1++;
		}else{
			$countPar2++;
		}
		}

		if($countPar1>$countPar2){
			$sql = "UPDATE PARTIDO SET
					ParejaGanadora = '$NumPareja1',
					ParejaPerdedora = '$this->NumPareja',
					Disputado = '1'
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
				";

			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { 
				return 'Modificado correctamente';
			}
		}else{
			$sql = "UPDATE PARTIDO SET 
					ParejaGanadora = '$this->NumPareja',
					ParejaPerdedora = '$NumPareja1',
					Disputado = '1'
				WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')
				";

			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { 
				return 'Modificado correctamente';
			}
		}
	}
function semis(){
	$sql="SELECT NumPareja FROM `eliminatorias` E, `partido` P WHERE E.IdCampeonato = P.IdCampeonato && E.Tipo = P.Tipo && E.Nivel = P.Nivel && E.Letra = P.Grupo_Letra && E.NumEnfrentamiento = P.NumEnfrentamiento && NumPareja=ParejaGanadora";
	$result = $this->mysqli->query( $sql );	
	$NumPar = array();
	$q = 1;
	while ( $resultado = mysqli_fetch_array( $result ) ) {				
					$NumPar[$q] = $resultado['NumPareja'];
					$q++;

			}
	$Enfrenta=rand(2,4);
	$sql = "SELECT MAX(NumEnfrentamiento) AS NumEnfrentamiento FROM PARTIDO";
		
	$resultado = $this->mysqli->query( $sql ); 
    $result = $resultado->fetch_array();	
	$MaxNumEn= $result['NumEnfrentamiento']+1;
	$sql="INSERT INTO PARTIDO(
									IdCampeonato,
									Tipo,
									Nivel,
									Grupo_Letra,
									NumEnfrentamiento,
									Fecha,
									Hora,
									ParejaGanadora,
									ParejaPerdedora,
									Disputado
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								ADDDATE(NOW(),5),
								'20:30:00',
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$NumPar[1]',
								'Semifinales',
								NULL,
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$NumPar[$Enfrenta]',
								'Semifinales',
								NULL,
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );	
	        $restantes=array();
			$j=0;
			for($i=2;$i<=4;$i++){
				if($i!=$Enfrenta){
					$restantes[$j]=$NumPar[$i];
					$j++;
				}
			}
	$sql = "SELECT MAX(NumEnfrentamiento) AS NumEnfrentamiento FROM PARTIDO";
		
	$resultado = $this->mysqli->query( $sql ); 
    $result = $resultado->fetch_array();	
	$MaxNumEn= $result['NumEnfrentamiento']+1;
	$sql="INSERT INTO PARTIDO(
									IdCampeonato,
									Tipo,
									Nivel,
									Grupo_Letra,
									NumEnfrentamiento,
									Fecha,
									Hora,
									ParejaGanadora,
									ParejaPerdedora,
									Disputado
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								ADDDATE(NOW(),5),
								'22:00:00',
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$restantes[0]',
								'Semifinales',
								NULL,
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$restantes[1]',
								'Semifinales',
								NULL,
								NULL,
								NULL,
								0
								)";
					$result = $this->mysqli->query( $sql );
	return "Semifinales generadas correctamente";
			}
function finalistas(){
	$sql= "SELECT ParejaGanadora FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$this->NumEnfrentamiento')";
	$result=$this->mysqli->query( $sql );
	$resultado=$result->fetch_array();
	$finalista1=$resultado['ParejaGanadora'];
	$sql= "SELECT DISTINCT NumEnfrentamiento FROM `eliminatorias` WHERE Fase='Semifinales' && NumEnfrentamiento<>'$this->NumEnfrentamiento'";
	$result=$this->mysqli->query( $sql );
	$resultado=$result->fetch_array();
	$NumEm=$resultado['NumEnfrentamiento'];
	$sql= "SELECT ParejaGanadora FROM PARTIDO WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel') && (Grupo_Letra = '$this->Letra') && (NumEnfrentamiento = '$NumEm')";
	$result=$this->mysqli->query( $sql );
	$resultado=$result->fetch_array();
	$finalista2=$resultado['ParejaGanadora'];
		
		$sql = "SELECT MAX(NumEnfrentamiento) AS NumEnfrentamiento FROM PARTIDO";
		
		$resultado = $this->mysqli->query( $sql ); 
		  
			$result = $resultado->fetch_array();	
			$MaxNumEn= $result['NumEnfrentamiento']+1;
			$sql="INSERT INTO PARTIDO(
									IdCampeonato,
									Tipo,
									Nivel,
									Grupo_Letra,
									NumEnfrentamiento,
									Fecha,
									Hora,
									ParejaGanadora,
									ParejaPerdedora,
									Disputado
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								ADDDATE(NOW(),5),
								'20:30:00',
								NULL,
								NULL,
								0
								)";
				$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$finalista1',
								'Final',
								NULL,
								NULL,
								NULL,
								0
								)";
			$result = $this->mysqli->query( $sql );	
			$sql="INSERT INTO ELIMINATORIAS(
									IdCampeonato,
									Tipo,
									Nivel,
									Letra,
									NumEnfrentamiento,
									NumPareja,
									Fase,
									ResultadoSet1,
									ResultadoSet2,
									ResultadoSet3,
									EstadoPropuesta
					             	) 
								VALUES(
								'$this->IdCampeonato',		
								'$this->Tipo',
								'$this->Nivel',
								'$this->Letra',
								'$MaxNumEn',
								'$finalista2',
								'Final',
								NULL,
								NULL,
								NULL,
								0
								)";
			if(!$result = $this->mysqli->query( $sql )){
				return 'Error en la inserción';
			}else{
				return 'Finales generadas correctamente';
			}
			
}
	
	function RellenaDatos() { 

		$sql = "SELECT DISTINCT E1.IdCampeonato as IdCampeonato,E1.Tipo as Tipo,E1.Nivel as Nivel,E1.Letra as Letra,E1.Fase as Fase,
		E1.NumEnfrentamiento,E2.NumPareja as pareja2, E1.NumPareja as pareja1,
		E1.ResultadoSet1 as ResultadoSet1Par1, E1.ResultadoSet2 as ResultadoSet2Par1, E1.ResultadoSet3 as ResultadoSet3Par1, 
		E2.ResultadoSet1 as ResultadoSet1Par2, E2.ResultadoSet2 as ResultadoSet2Par2, E2.ResultadoSet3 as ResultadoSet3Par2
		FROM ELIMINATORIAS E1,ELIMINATORIAS E2
		WHERE
		(E1.IdCampeonato = E2.IdCampeonato) && (E1.Tipo = E2.Tipo) && (E1.Nivel = E2.Nivel) && (E1.Letra = E2.Letra) &&
		(E1.NumEnfrentamiento = E2.NumEnfrentamiento) && (E1.NumPareja != E2.NumPareja) &&
		(E1.IdCampeonato = '$this->IdCampeonato') && (E1.Tipo = '$this->Tipo') && (E1.Nivel = '$this->Nivel')  && (E1.Letra = '$this->Letra') 
		&&(E1.NumEnfrentamiento = '$this->NumEnfrentamiento') && (E1.NumPareja = '$this->NumPareja')
		GROUP BY E1.NumEnfrentamiento  

		";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			$result = $resultado->fetch_array();	
			return $result;
		}
	}	
function IntegrantesEliminatorias() { 

		$sql = "SELECT * FROM ELIMINATORIAS WHERE (IdCampeonato = '$this->IdCampeonato') && (Tipo = '$this->Tipo') && (Nivel = '$this->Nivel')  && (Letra = '$this->Letra') ORDER BY NumEnfrentamiento";
		
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else {            
			return $resultado;
		}
	}
}
?>