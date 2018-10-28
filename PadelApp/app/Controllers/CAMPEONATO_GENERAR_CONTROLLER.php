<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/PAREJA_MODEL.php'; 
include '../Models/GRUPO_MODEL.php'; 
include '../Models/PARTIDO_MODEL.php'; 
include '../Models/ENFRENTAMIENTO_MODEL.php'; 

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

		if($numParejas < 8){
			new MESSAGE( 'No hay suficientes parejas para formar grupos', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' );
		}else{
			
			$numGrupos = 1;
			$letra = '';
			if($numParejas > 8 && $numParejas <= 16) $numGrupos = 2;	
			else if($numParejas > 16 && $numParejas <= 24) $numGrupos = 3;	
			else if($numParejas > 24 && $numParejas <= 32) $numGrupos = 4;	
			else if($numParejas > 32 && $numParejas <= 40) $numGrupos = 5;	
			else if($numParejas > 40 && $numParejas <= 48) $numGrupos = 6;	
			else if($numParejas > 48 && $numParejas <= 56) $numGrupos = 7;	
			else if($numParejas > 56) $numGrupos = 8;	
				
			$numParejasAsignadas = 0;	
				
			for($i = 1; $i <= $numGrupos; $i++){

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
				
				for($p1 = 1 + (($numGrupos - 1)*8) ; $p1 <= 8 + (($numGrupos - 1)*8);$p1++){
			//	for($p1 = 1 ; $p1 < 8;$p1++){	
					for($p2 = $p1+1 ; $p2 <= 8 + (($numGrupos - 1)*8);$p2++){
						
						$numPareja1 = $listaParejas[$p1];
						$numPareja2 = $listaParejas[$p2];
									
						$PARTIDO = create_partido($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento);
						$mensajeP = $PARTIDO->ADD();
						echo "Mensaje Partido: " . $mensajeP . "(" . $numEnfrentamiento . ")";

						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$numPareja1);
						$mensajeE1 = $ENFRENTAMIENTO->ADD();
						echo "Mensaje Partido: " . $mensajeE1 . "(" . $numPareja1 . ")";
						$numParejasAsignadas++;
						
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$numEnfrentamiento,$numPareja2);
						$mensajeE2 = $ENFRENTAMIENTO->ADD();		
						echo "Mensaje Partido: " . $mensajeE2 . "(" . $numPareja2 . ")";
						$numParejasAsignadas++;

						$numEnfrentamiento++;
							
					}					
				}
			}
			
			echo $numEnfrentamiento;
			echo $numParejasAsignadas;
			new MESSAGE( 'Grupos creados', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' );
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