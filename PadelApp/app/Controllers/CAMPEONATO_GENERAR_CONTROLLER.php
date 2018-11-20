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
include '../Locales/Strings_' . $_SESSION['idioma'] . '.php';

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

function create_partido($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento) {
	 
	$PARTIDO = new PARTIDO_MODEL(
		$idCampeonato,
		$tipo,
		$nivel,
		$letra,
		$NumEnfrentamiento,
		NULL,
		NULL,
		NULL,
		NULL
	);
	
	return $PARTIDO;
}

function create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento,$numPareja) {
	 
	$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL(
		$idCampeonato,
		$tipo,
		$nivel,
		$letra,
		$NumEnfrentamiento,
		$numPareja,
		NULL,
		NULL,
		NULL,
		'0'
	);
	
	return $ENFRENTAMIENTO;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'GENERAR':
	if($_SESSION['tipo'] == 'Admin'){
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
				//echo $aux[$q];
					// <br> <?php
				$q++;

		}
	
		
		if($numParejas < 8){
			new MESSAGE( 'No hay suficientes parejas para formar grupos', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php?IdCampeonato=' .$_REQUEST[ 'IdCampeonato' ] );
		}else{
			
			$existenGrupos = new GRUPO_MODEL($idCampeonato,$tipo,$nivel,'');
			$existen = $existenGrupos->existenGrupos();
			
			if($existen){
				new MESSAGE( 'Ya existen grupos generados', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php?IdCampeonato=' .$_REQUEST[ 'IdCampeonato' ] );
			}else{
				set_time_limit(300);
				$numGrupos = 1;
				$letra = '';
				//$numParejas = 95;
				//echo  $strings['Antes: '].$numParejas;
					?><!--<br>-->  <?php
					$stringParejas = '';
				if($numParejas > 12 && $numParejas < 16){
				
					 $numParejasDesInscritas= $numParejas % 12;  
					 
					 $numParejas = $numParejas - $numParejasDesInscritas;
				}

				//echo $strings['Después: '].$numParejas;
					?><!--<br>-->  <?php
				if($numParejas > 12 && $numParejas <= 24) $numGrupos = 2;	
				else if($numParejas > 24 && $numParejas <= 36) $numGrupos = 3;	
				else if($numParejas > 36 && $numParejas <= 48) $numGrupos = 4;	
				else if($numParejas > 48 && $numParejas <= 60) $numGrupos = 5;	
				else if($numParejas > 60 && $numParejas <= 72) $numGrupos = 6;	
				else if($numParejas > 72 && $numParejas <= 84) $numGrupos = 7;	
				else if($numParejas > 84 && $numParejas <= 96) $numGrupos = 8;	
				
				
				$numParejasSobrantes = $numParejas % (8 * $numGrupos);
				$numParejas  -= $numParejasSobrantes;
				//echo "Despues2: " . $numParejas;
					?><!--<br>-->  <?php
				//echo 'numParejasSobrantes: ' . $numParejasSobrantes;
					?><!--<br>-->  <?php
				$numParejasAsignadas = 0;	
					
				for($i = 0; $i < $numGrupos; $i++){

					
					//echo "----";
					?><!--<br>-->  <?php
					//echo "Num grupo:  " . ($i + 1);
					?><!--<br>-->  <?php
					//echo "----";
					?><!--<br>-->  <?php
					
					if($i == 0) $letra = 'A';
					else if($i == 1) $letra = 'B';
					else if($i == 2) $letra = 'C';
					else if($i == 3) $letra = 'D';
					else if($i == 4) $letra = 'E';
					else if($i == 5) $letra = 'F';
					else if($i == 6) $letra = 'G';
					else if($i == 7) $letra = 'H';

					$GRUPO = create_grupo($idCampeonato,$tipo,$nivel,$letra);
					$GRUPO->ADD();
					$NumEnfrentamiento = 1;
					
					for($p1 =  (($i )*8) ; $p1 < 8 + (($i)*8);$p1++){

						for($p2 = $p1+1 ; $p2 < 8 + (($i)*8);$p2++){
		
							$numPareja1 = $aux[$p1];
							$numPareja2 = $aux[$p2];
							//echo 'Pareja 1: ' . $numPareja1 . ' -- $p1; ' . $p1;
								?><!--<br>-->  <?php
							//echo 'Pareja 2: ' . $numPareja2 . ' -- $p2; ' . $p2;
								?><!--<br>-->  <?php
							
							$PARTIDO = create_partido($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento);
							$mensajeP = $PARTIDO->ADD();
							//echo "Mensaje Partido: " . $mensajeP . "(" . $NumEnfrentamiento . ")" . "\n" ;
							?><!--<br>-->  <?php
							
							$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento,$numPareja1);
							$mensajeE1 = $ENFRENTAMIENTO->ADD();
							//echo "Mensaje Enfrentamiento: " . $mensajeE1 . "(" . $numPareja1 . ")" . "\n"; 
							
							?><!--<br>-->  <?php
							$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento,$numPareja2);
							$mensajeE2 = $ENFRENTAMIENTO->ADD();		
							//echo "Mensaje Enfrentamiento: " . $mensajeE2 . "(" . $numPareja2 . ")" . "\n";
							$numParejasAsignadas++;
							?><!--<br>-->  <?php
							?><!--<br>-->  <?php
							$NumEnfrentamiento++;
								
						}					
					}
				}
				
				//echo '------------------------------------------';
				?><!--<br>-->  <?php
				//echo $numParejasSobrantes;
				?> <!--<br>-->  <?php
				?> <!--<br>-->  <?php
				$contadorParejas= 0;
				$contadorGrupos = 1;
				$letra = 'A';
				//echo '$numParejas ' . $numParejas;
				?> <!--<br>--> <?php
				for($pa = 0; $pa < $numParejasSobrantes ; $pa++){
					//echo '------------------------------------------';
					?> <!--<br>--> <?php
					//echo 'Grupo: ' . $letra;
					//echo '------------------------------------------';
					?><!-- <br> --><?php
					$pareja1 = $numParejas + $pa;
					//echo '$pareja1 : ' .$pareja1;
					?><!-- <br> --><?php
					$parejaSobrante1 = $aux[$pareja1];
					//echo $parejaSobrante1 . '-- $numParejas + $pa: ' . $pareja1;
					?><!-- <br> --><?php
					
					$numParejasGrupo =  create_grupo($idCampeonato,$tipo,$nivel,$letra);
					$listaParejasGrupo = $numParejasGrupo->ListaParejasGrupoNum();
					
					$aux2 = array();
					$q = 0;
					while ( $fila = mysqli_fetch_array( $listaParejasGrupo ) ) {

					$aux2[$q] = $fila['NumPareja'];
					//echo $aux2[$q];
					/// <br> <?php
							$q++;

					}
					//echo 'Longitud: ' .  sizeof($aux2);
					?> <!--<br>--> <?php
					
					
					for($i = 0; $i < sizeof($aux2); $i++){
						
						//$sum2 = ($contadorGrupos * 8) + $i;
						//$parejaContraria = $aux[($sum2) ];
						$parejaContraria2 = $aux2[$i];

						//echo 'ParejaSobrante: ' . $parejaSobrante1 . ' -- $numParejas + $pa; ' . $pareja1 ;
								?><!-- <br> --><?php
						//echo 'ParejaContraria: ' . $parejaContraria2 . ' -- $i; ' . $i;
								?><!-- <br> --><?php
						
						$PARTIDO = create_partido($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento);
						$mensajeP1 = $PARTIDO->ADD();
						//echo "Mensaje Partido: " . $mensajeP1 . "(" . $NumEnfrentamiento . ")" . "\n" ;
						?><!-- <br> --><?php
						
						
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento,$parejaSobrante1 );
						$mensajeE11 = $ENFRENTAMIENTO->ADD();
						//echo "Mensaje Enfrentamiento2: " . $mensajeE11 . "(" . $parejaSobrante1 . ")" . "\n"; 
						
						?> <!--<br>--> <?php
						$ENFRENTAMIENTO = create_enfrentamiento($idCampeonato,$tipo,$nivel,$letra,$NumEnfrentamiento,$parejaContraria2 );
						$mensajeE22 = $ENFRENTAMIENTO->ADD();		
						//echo "Mensaje Enfrentamiento2: " . $mensajeE22 . "(" . $parejaContraria2  . ")" . "\n";
						
						//$numParejasAsignadas++;
						?> <!--<br>--> <?php
						?> <!--<br>--> <?php
						$NumEnfrentamiento++;
			
					}
					
					$contadorParejas++;
						if($contadorParejas == 4){
						
								$contadorGrupos++;
								
								if($contadorGrupos == 2) $letra = 'B';
								else if($contadorGrupos == 3) $letra = 'C';
								else if($contadorGrupos == 4) $letra = 'D';
								else if($contadorGrupos == 5) $letra = 'E';
								else if($contadorGrupos == 6) $letra = 'F';
								else if($contadorGrupos == 7) $letra = 'G';
								else if($contadorGrupos == 8) $letra = 'H';
								
								$contadorParejas= 0;
						}	
					
				}
				
				//echo $NumEnfrentamiento;
				//echo"\n\n";
				//echo $numParejasAsignadas;
				//echo"\n\n";
				
				new MESSAGE( 'Grupos creados','../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php.?IdCampeonato='.$_REQUEST['IdCampeonato'] );
			
			}			
		}
	}else{
		new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
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