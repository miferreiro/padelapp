<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}


include '../Models/PARTIDO_MODEL.php';
include '../Models/CAMPEONATO_MODEL.php';
include '../Models/CATEGORIA_MODEL.php';
include '../Models/GRUPO_MODEL.php';
include '../Models/PAREJA_MODEL.php';
include '../Models/ENFRENTAMIENTO_MODEL.php';
include '../Models/USUARIO_PAREJA_MODEL.php';
include '../Views/CALENDARIO/CALENDARIO_SHOWALL_View.php';
include '../Views/CALENDARIO/CALENDARIO_SHOWCURRENT_View.php';
include '../Views/CALENDARIO/CALENDARIO_TABLA_View.php';
include '../Views/CALENDARIO/CALENDARIO_EDIT_View.php';
include '../Views/CALENDARIO/CALENDARIO_INFORMACION_View.php';
include '../Views/CALENDARIO/CALENDARIO_ACEPTAR_View.php';
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php'; 

function get_data_form(){
	
	$IdCampeonato = $_REQUEST['IdCampeonato'];
	$Tipo = $_REQUEST['Tipo'];
	$Nivel = $_REQUEST['Nivel'];
	$Letra= $_REQUEST['Letra'];
	$GRUPO= new GRUPO_MODEL(
		$IdCampeonato,
		$Tipo,
		$Nivel,
		$Letra
	);
	
	return $GRUPO; 
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case "ACEPTAR" :
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Deportista'){
				
				$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['numEnfrentamiento'],'','');
				$valores = $PARTIDO->RellenaDatos2();
				$valores['pareja1'] = $_REQUEST['pareja1'];
				$valores['pareja2'] = $_REQUEST['pareja2'];
				
				new CALENDARIO_ACEPTAR( $valores);
				
			}else{
					new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
			}
		} else {
			
			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['Fecha'],$_REQUEST['Hora']);
			$respuesta = $PARTIDO->EDIT();
			
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'',3);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],'',3);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			
			new MESSAGE( $respuesta, '../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		}

	break;
	case "DENEGAR" :
		if ( $_POST ) {
			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['Fecha'],$_REQUEST['Hora']);
			$respuesta = $PARTIDO->EDIT();
			
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'',0);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],'',0);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			
			new MESSAGE( $respuesta, '../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		
		}
	
	break;
	case "PROPONER" :
	
	
	break;
	case "INFORMACION":

		if($_SESSION['tipo'] == 'Deportista'){

			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['numEnfrentamiento'],$_REQUEST['pareja1'],'','');
			$valores = $ENFRENTAMIENTO->RellenaDatos();
		
			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['numEnfrentamiento'],'','');
			$valores2 = $PARTIDO->RellenaDatos();
		
			new CALENDARIO_INFORMACION($valores,$valores2);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		}
	
	break;
	case "TABLA":
		if($_SESSION['tipo'] == 'Deportista'){

				$GRUPO =  get_data_form();

				$listaParejas = $GRUPO ->ListaParejasGrupoNum();

				$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],'','','','');
				
				$listaEnfrentamientos = $ENFRENTAMIENTO->listaEnfrentamiento();
				$listaEnfrentamientos2 = $ENFRENTAMIENTO->listaEnfrentamientoCalendario($_SESSION['dni']);
				
				$PAREJA = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
				$capitan = $PAREJA->esCapitan($_SESSION['login']);
				
				//$lista = array( 'NumPareja','Login','IdCampeonato','Tipo','Nivel','Letra');
				$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$vuelta['Tipo'] = $_REQUEST['Tipo'];
				$vuelta['Nivel'] = $_REQUEST['Nivel'];
				$vuelta['Letra'] = $_REQUEST['Letra'];
			   new CALENDARIO_TABLA($listaParejas , $listaEnfrentamientos ,$listaEnfrentamientos2, $vuelta,$capitan);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CALENDARIO_CONTROLLER.php' );
		}
	
	break;
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Deportista'){

			$CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '', '', '');

			$valores = $CAMPEONATO ->RellenaDatos();
			$valores['Tipo'] = $_REQUEST['Tipo'];
			$valores['Nivel'] = $_REQUEST['Nivel'];

		   new CALENDARIO_SHOWCURRENT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CALENDARIO_CONTROLLER.php' );
		}
		
		//Final del bloque
		break;		
	default: 
		
		if($_SESSION['tipo'] == 'Deportista'){
			
	
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL( '', '', '', '', '', '', '', '','');
		
			$datos = $ENFRENTAMIENTO->obtenerGruposDisponibles($_SESSION['dni']);
			$lista = array( 'IdCampeonato','Tipo','Nivel','Letra');
			new CALENDARIO_SHOWALL( $lista, $datos);

		}else{
			new USUARIO_DEFAULT();
		}	
			
}

?>