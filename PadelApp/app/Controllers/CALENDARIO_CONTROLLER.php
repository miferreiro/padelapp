<?php

session_start(); 
include '../Functions/Authentication.php'; 
include '../Functions/Comprobar_Disponibilidad.php';

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/USUARIO_MODEL.php';
include '../Models/ELIMINATORIA_MODEL.php';
include '../Models/PARTIDO_MODEL.php';
include '../Models/CAMPEONATO_MODEL.php';
include '../Models/CATEGORIA_MODEL.php';
include '../Models/GRUPO_MODEL.php';
include '../Models/PAREJA_MODEL.php';
include '../Models/NOTICIA_MODEL.php';
include '../Models/PISTA_MODEL.php';
include '../Models/RESERVA_MODEL.php';
include '../Models/ENFRENTAMIENTO_MODEL.php';
include '../Models/USUARIO_PAREJA_MODEL.php';
include '../Views/CALENDARIO/CALENDARIO_SHOWALL_View.php';
include '../Views/CALENDARIO/CALENDARIO_SHOWCURRENT_View.php';
include '../Views/CALENDARIO/CALENDARIO_TABLA_View.php';
include '../Views/CALENDARIO/CALENDARIO_INFORMACION_View.php';
include '../Views/CALENDARIO/CALENDARIO_ACEPTAR_View.php';
include '../Views/CALENDARIO/CALENDARIO_PROPONER_View.php';
include '../Views/ELIMINATORIA/ELIMINATORIA_TABLA2_View.php';
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
				
				$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
				$valores = $PARTIDO->RellenaDatos2();
				$valores['pareja1'] = $_REQUEST['pareja1'];
				$valores['pareja2'] = $_REQUEST['pareja2'];
				
				new CALENDARIO_ACEPTAR( $valores);
				
			}else{
					new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
			}
		} else {
			
			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['Fecha'],$_REQUEST['Hora'],'','','');
			$respuesta = $PARTIDO->EDIT3();
			
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'','','',3);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],'','','',3);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			
			//Añadir  reserva
			
			$USUARIO = new USUARIO_MODEL('admin','','','','','','','','');
			$dniAdmin = $USUARIO->obtenerDni();
			$RESERVA = new RESERVA_MODEL($dniAdmin,'',$_REQUEST['Fecha'],$_REQUEST['Hora']);
			$respuesta = $RESERVA->RESERVACAMP();
			
			if($respuesta != 'Inserción realizada con éxito'){
				
				$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],NULL,NULL,'','','');
				$respuesta2 = $PARTIDO->EDIT3();

				$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'','','',0);
				$respuesta3 = $ENFRENTAMIENTO->EDIT2();
				$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],'','','',0);
				$respuesta4 = $ENFRENTAMIENTO->EDIT2();

				new MESSAGE( $respuesta, '../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
				
			}else{
					new MESSAGE( $respuesta, '../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
			}
			
			
			

		}

	break;
	case "DENEGAR" :
		if($_SESSION['tipo'] == 'Deportista'){
		if ( $_POST ) {
			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
			$respuesta1 = $PARTIDO->EDIT2();
			
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'','','',0);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],'','','',0);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			
			new MESSAGE( $respuesta1, '../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		
		}}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		}
	
	break;
	case "PROPONER" :
		if(!$_POST){
		
			if($_SESSION['tipo'] == 'Deportista'){
					
				$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
				$valores = $PARTIDO->RellenaDatos2();
				$valores['pareja1'] = $_REQUEST['pareja1'];
				$valores['pareja2'] = $_REQUEST['pareja2'];
				
				$PISTA= new PISTA_MODEL('','','','');
				$datos = $PISTA->HORAS();
				$datos2 = $PISTA->FECHAS();
				
				new CALENDARIO_PROPONER( $valores,$datos,$datos2);
							
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
			}	
		}else{			
			
			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['Fecha'],$_REQUEST['Hora'],'','','');
			$respuesta = $PARTIDO->EDIT3();
			
			$PAREJA2 = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
			$numParejaActual = $PAREJA2->numPareja($_SESSION['dni']);

			$num1 =  $_REQUEST['pareja1'];
			$num2 =  $_REQUEST['pareja2'];

			
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$num1,'','','',1);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$num2,'','','',2);
			$respuesta = $ENFRENTAMIENTO->EDIT2();
			
			new MESSAGE( $respuesta, '../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		}

	break;
	case "INFORMACION":

		if($_SESSION['tipo'] == 'Deportista'){

			$ELIMINATORIA = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'','','','','');

			$valores = $ELIMINATORIA->RellenaDatos2();

			$PARTIDO = new PARTIDO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],'','','','','');
			$valores2 = $PARTIDO->RellenaDatos2();

			$PAREJA2 = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
			$numParejaActual = $PAREJA2->numPareja($_SESSION['dni']);	
		
			new CALENDARIO_INFORMACION($valores,$valores2,$numParejaActual);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/CALENDARIO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
		}
	
	break;
	case "TABLA":
		if($_SESSION['tipo'] == 'Deportista'){

				$GRUPO =  get_data_form();

				$listaParejas = $GRUPO ->ListaParejasGrupoNum();

				$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],'','','','','','');
				
				$listaEnfrentamientos = $ENFRENTAMIENTO->listaEnfrentamiento();
				$listaEnfrentamientos2 = $ENFRENTAMIENTO->listaEnfrentamientoCalendario($_SESSION['dni']);
				
				$PAREJA = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
				$capitan = $PAREJA->esCapitan($_SESSION['login']);
				
				$PAREJA2 = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
				$numParejaActual = $PAREJA2->numPareja($_SESSION['dni']);		

				//$lista = array( 'NumPareja','Login','IdCampeonato','Tipo','Nivel','Letra');
				$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$vuelta['Tipo'] = $_REQUEST['Tipo'];
				$vuelta['Nivel'] = $_REQUEST['Nivel'];
				$vuelta['Letra'] = $_REQUEST['Letra'];
			   new CALENDARIO_TABLA($listaParejas , $listaEnfrentamientos ,$listaEnfrentamientos2, $vuelta,$capitan,$numParejaActual);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CALENDARIO_CONTROLLER.php' );
		}
	
	break;
	case "CUADRO":
		if($_SESSION['tipo'] == 'Deportista'){

			
				
				$PAREJA = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
				$capitan = $PAREJA->esCapitan($_SESSION['login']);
				
				$PAREJA2 = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
				$numParejaActual = $PAREJA2->numPareja($_SESSION['dni']);		

			    $ELIMINATORIA = new ELIMINATORIA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],'','','','','','','');
				$datos=$ELIMINATORIA->IntegrantesEliminatorias();
				new ELIMINATORIA_TABLA2($datos, $capitan);
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
			
	
			$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL( '', '', '', '', '', '', '', '','','');
		
			$datos = $ENFRENTAMIENTO->obtenerGruposDisponibles($_SESSION['dni']);
			$lista = array( 'IdCampeonato','Tipo','Nivel','Letra');
			new CALENDARIO_SHOWALL( $lista, $datos);

		}else{
			$NOTICIA = new NOTICIA_MODEL( '', '', '');
    		$datos = $NOTICIA->SEARCH();
			new USUARIO_DEFAULT($datos);
		}	
			
}

?>