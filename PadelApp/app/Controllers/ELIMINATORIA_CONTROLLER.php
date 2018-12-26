<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/CAMPEONATO_MODEL.php'; 
include '../Models/ELIMINATORIA_MODEL.php';
include '../Models/PARTIDO_MODEL.php';

include '../Models/CATEGORIA_MODEL.php'; 
include '../Models/GRUPO_MODEL.php'; 
include '../Models/NOTICIA_MODEL.php';

include '../Views/ELIMINATORIA/ELIMINATORIA_TABLA_View.php';
include '../Views/ELIMINATORIA/ELIMINATORIA_EDIT_View.php';

include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php'; 






function get_data_form_grupo(){
	
	$IdCampeonato = $_REQUEST['IdCampeonato'];
	$Tipo = $_REQUEST['Tipo'];
	$Nivel = $_REQUEST['Nivel'];
	$Letra= $_REQUEST['Letra'];
	
	
	return $GRUPO; 
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'GENERAR':
	

		if($_SESSION['tipo'] == 'Admin'){
			
			$PARTIDO= new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],'','','','','','');
			if(date("Y-m-d")>$PARTIDO->getLastFecha()){
			
			$respuesta=$PARTIDO->CUARTOS();
				new MESSAGE( $respuesta, '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel']);	
			}else{  
			new MESSAGE( 'Debe esperar a que finalice la fase de grupos', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel']);			
		}
					
	
		}else{  
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );			
		}
	
		break;
	
	case "EDITAR":
	
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){

				$ELIMINATORIA = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'','','','','');
				$valores = $ELIMINATORIA->RellenaDatos();
				new ELIMINATORIA_EDIT( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/GRUPO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
			}
		} else {
				$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
			   if($PARTIDO->comprobarFechaPartido()< date("Y-m-d")){
			 
				$ELIMINATORIA1 = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],$_REQUEST['Fase'],$_REQUEST['ResultadoSet1Par1'],$_REQUEST['ResultadoSet2Par1'],$_REQUEST['ResultadoSet3Par1'],'');
				$respuesta = $ELIMINATORIA1->EDIT();
				
			
				$ELIMINATORIA2 = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],$_REQUEST['Fase'],$_REQUEST['ResultadoSet1Par2'],$_REQUEST['ResultadoSet2Par2'],$_REQUEST['ResultadoSet3Par2'],'');
				$respuesta2 = $ELIMINATORIA2->EDIT();
			    $ELIMINATORIA2->ganador($_REQUEST['ResultadoSet1Par1'],$_REQUEST['ResultadoSet2Par1'],$_REQUEST['ResultadoSet3Par1'],$_REQUEST['ResultadoSet1Par2'],$_REQUEST['ResultadoSet2Par2'],$_REQUEST['ResultadoSet3Par2'],$_REQUEST['pareja1']);
			

				$res=$PARTIDO->comprobarFaseFinalizada();
				if($res==0){
					if($_REQUEST['Fase']=='Cuartos'){
						$ELIMINATORIASEMIS = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
						$ELIMINATORIASEMIS->semis();
					}
					if($_REQUEST['Fase']=='Semifinales'){
						$ELIMINATORIAFINAL = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
						$ELIMINATORIAFINAL->finalistas();
					}
				}
			new MESSAGE( $respuesta, '../Controllers/ELIMINATORIA_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=CUADRO');
		}else{
			new MESSAGE( 'Ha de pasar la fecha del partido para poder editarlo', '../Controllers/ELIMINATORIA_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=CUADRO');	   
			   }
		}
	break;
		
	case "CUADRO":
		if($_SESSION['tipo'] == 'Admin'){
			$ELIMINATORIA = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],'','','','','','','');
			$datos=$ELIMINATORIA->IntegrantesEliminatorias();
			new ELIMINATORIA_TABLA($datos);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CALENDARIO_CONTROLLER.php' );
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
			$NOTICIA = new NOTICIA_MODEL( '', '', '');
			$datos = $NOTICIA->SEARCH();
			new USUARIO_DEFAULT($datos);
		}
			
}

?>