<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/CAMPEONATO_MODEL.php'; 
include '../Models/PAREJA_MODEL.php'; 
include '../Models/GRUPO_MODEL.php'; 
include '../Models/PARTIDO_MODEL.php'; 
include '../Models/ENFRENTAMIENTO_MODEL.php'; 

include '../Views/CAMPEONATO_CATEGORIA/CAMPEONATO_CATEGORIA_SHOWALL_View.php';
include '../Views/CAMPEONATO/CAMPEONATO_SHOWALL_View.php';


include '../Views/DEFAULT_View.php';
include '../Views/MESSAGE_View.php';



function create_grupo($idCampeonato,$tipo,$nivel,$letra) {
	 
	$GRUPO = new GRUPO_MODEL(
		$idCampeonato,
		$tipo,
		$nivel,
		$letra
	);
	
	return $GRUPO;
}

function create_partido($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento) {
	 
	$PARTIDO = new PARTIDO_MODEL(
		$idCampeonato,
		$tipo,
		$nivel,
		$letra,
		$numEnfrentamiento,
		NULL,
		NULL
	);
	
	return $PARTIDO;
}

function create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$numPareja) {
	 
	$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL(
		$idCampeonato,
		$tipo,
		$nivel,
		$letra,
		$numEnfrentamiento,
		$numPareja,
		NULL
	);
	
	return $ENFRENTAMIENTO;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'GENERAR':
	
		$idCampeonato = $_REQUEST[ 'IdCampeonato' ]; 
		$tipo = $_REQUEST[ 'Tipo' ];
		$nivel = $_REQUEST[ 'Nivel' ]; 
		
		$PAREJA = new PAREJA_MODEL($idCampeonato,$tipo,$nivel,'','');
		$listaParejas = $PAREJA->getParejasCategoria();
		$numParejas = $PAREJA->getLastNumPareja();		
		
		//Construyo el array
		$q = 0;
		$aux = array();
		while ( $fila = mysqli_fetch_array( $listaParejas ) ) {
			
				$aux[$q] = $fila['NumPareja'];
				echo $aux[$q];
					?> <br> <?php
				$q++;

		}

		
		if($numParejas < 8){
			new MESSAGE( 'No hay suficientes parejas para formar grupos', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php?IdCampeonato=' .$_REQUEST[ 'IdCampeonato' ] );
		}else{
			
			
			$numGrupos = 1;
			$letra = '';
			//$numParejas = 95;
			echo "Antes: " . $numParejas;
			if($numParejas > 12 && $numParejas < 16) $numParejas -= $numParejas % 12;
			/*else if($numParejas > 28 && $numParejas < 32) $numParejas -= $numParejas % 28 ;
			else if($numParejas > 44 && $numParejas < 48) $numParejas -= $numParejas % 44 ;
			else if($numParejas > 60 && $numParejas < 64) $numParejas -= $numParejas % 60 ;
			else if($numParejas > 76 && $numParejas < 80) $numParejas -= $numParejas % 76 ;
			else if($numParejas > 92 && $numParejas < 96) $numParejas -= $numParejas % 92;*/
			echo "Despues: " . $numParejas;
			
			if($numParejas > 12 && $numParejas <= 24) $numGrupos = 2;	
			else if($numParejas > 24 && $numParejas <= 36) $numGrupos = 3;	
			else if($numParejas > 36 && $numParejas <= 48) $numGrupos = 4;	
			else if($numParejas > 48 && $numParejas <= 60) $numGrupos = 5;	
			else if($numParejas > 60 && $numParejas <= 72) $numGrupos = 6;	
			else if($numParejas > 72 && $numParejas <= 84) $numGrupos = 7;	
			else if($numParejas > 84 && $numParejas <= 96) $numGrupos = 8;	
			
			
			$numParejasSobrantes = $numParejas % (8 * $numGrupos);
			$numParejas  -= $numParejasSobrantes;
			echo "Despues2: " . $numParejas;
			echo $numParejasSobrantes;
			
			$numParejasAsignadas = 0;	
				
			for($i = 1; $i <= $numGrupos; $i++){

				
				echo "----";
				?> <br> <?php
				echo "Num grupo:  " . $i;
				?> <br> <?php
				echo "----";
				?> <br> <?php
				
				if($i == 1) $letra = 'A';
				else if($i == 2) $letra = 'B';
				else if($i == 3) $letra = 'C';
				else if($i == 4) $letra = 'D';
				else if($i == 5) $letra = 'E';
				else if($i == 6) $letra = 'F';
				else if($i == 7) $letra = 'G';
				else if($i == 8) $letra = 'H';

				$GRUPO = create_grupo($idCampeonato,$tipo,$nivel,$letra);
				$GRUPO->ADD();
				$numEnfrentamiento = 1;
				
				for($p1 =  (($numGrupos - 1)*8) ; $p1 < 8 + (($numGrupos - 1)*8);$p1++){

					for($p2 = $p1+1 ; $p2 < 8 + (($numGrupos - 1)*8);$p2++){
	
						$numPareja1 = $aux[$p1];
						$numPareja2 = $aux[$p2];
						echo $numPareja1;
						echo "\n\n";
						echo $numPareja2;
						echo "\n\n";
						
						$PARTIDO = create_partido($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento);
						$mensajeP = $PARTIDO->ADD();
						echo "Mensaje Partido: " . $mensajeP . "(" . $numEnfrentamiento . ")" . "\n" ;
						?> <br> <?php
						
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$numPareja1);
						$mensajeE1 = $ENFRENTAMIENTO->ADD();
						echo "Mensaje Partido: " . $mensajeE1 . "(" . $numPareja1 . ")" . "\n"; 
						
						?> <br> <?php
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$numPareja2);
						$mensajeE2 = $ENFRENTAMIENTO->ADD();		
						echo "Mensaje Partido: " . $mensajeE2 . "(" . $numPareja2 . ")" . "\n";
						$numParejasAsignadas++;
						?> <br> <?php
						?> <br> <?php
						$numEnfrentamiento++;
							
					}					
				}
			}
			
			
				$contadorParejas= 0;
				$contadorGrupos = 1;
				$letra = 'A';
				for($pa = 0; $pa < $numParejasSobrantes ; $pa++){
					echo $numParejas . "--" . $pa;
					$parejaSobrante = $aux[$numParejas + $pa];
							
					for($i = 0; $i < 8 + $pa; $i++){
						$parejaContraria = $aux[$numParejas - 8 + $i ];
						
						echo $parejaSobrante;
						echo $parejaContraria;
						
						
						$PARTIDO = create_partido($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento);
						$mensajeP1 = $PARTIDO->ADD();
						echo "Mensaje Partido: " . $mensajeP1 . "(" . $numEnfrentamiento . ")" . "\n" ;
						?> <br> <?php
						
						
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$parejaSobrante );
						$mensajeE11 = $ENFRENTAMIENTO->ADD();
						echo "Mensaje Partido: " . $mensajeE11 . "(" . $parejaSobrante . ")" . "\n"; 
						
						?> <br> <?php
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$parejaContraria );
						$mensajeE22 = $ENFRENTAMIENTO->ADD();		
						echo "Mensaje Partido: " . $mensajeE22 . "(" . $parejaContraria  . ")" . "\n";
						
						$numParejasAsignadas++;
						?> <br> <?php
						?> <br> <?php
						$numEnfrentamiento++;
						
						$contadorParejas++;
						if($contadorParejas == 4){
						
								$contadorGrupos++;
								
								if($contadorGrupos == 2) $letra = 'B';
								else if($contadorGrupos == 3) $letra = 'C';
								else if($$contadorGrupos == 4) $letra = 'D';
								else if($contadorGrupos == 5) $letra = 'E';
								else if($contadorGrupos == 6) $letra = 'F';
								else if($contadorGrupos == 7) $letra = 'G';
								else if($contadorGrupos == 8) $letra = 'H';
							
						}				
					}
				}
				
					echo $numEnfrentamiento;
				echo"\n\n";
				echo $numParejasAsignadas;
				echo"\n\n";
				new MESSAGE( 'Grupos creados','../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php.?IdCampeonato='.$_REQUEST['IdCampeonato'] );
		
				
			}
			
				
			

		
		
		break;
	default: 
		if($_SESSION['tipo'] == 'Admin'){
				if ( !$_POST ) {
					$CAMPEONATO = new CAMPEONATO_MODEL( '', '', '','','');						
				} else {
					$CAMPEONATO = get_data_form();
				}
				$datos = $CAMPEONATO->SEARCH();
				$lista = array( 'IdCampeonato','FechaIni','HoraIni','FechaFin','HoraFin');

				new CAMPEONATO_SHOWALL( $lista, $datos);

		}else{
			new USUARIO_DEFAULT();
		}
		
		
}

?>