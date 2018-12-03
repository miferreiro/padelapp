<?php

session_start(); 
include '../Functions/Authentication.php';
include '../Functions/ComprobarInscritos.php'; 
include '../Functions/Comprobar_Disponibilidad.php'; 

if (!IsAuthenticated()){
	
 	header('Location:../index.php');
}

include '../Models/ACT_MODEL.php'; 
include '../Models/INSACT_MODEL.php'; 
include '../Models/PISTA_MODEL.php'; 
include '../Views/ACTIVIDADES/ACT_SHOWALL_View.php'; 
include '../Views/ACTIVIDADES/ACT_DELETE_View.php';
include '../Views/ACTIVIDADES/ACT_SHOWCURRENT_View.php'; 
include '../Views/ACTIVIDADES/ACT_SEARCH_View.php'; 
include '../Views/ACTIVIDADES/ACT_ADD_View.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';

function get_data_form() {
	$fecha = $_REQUEST[ 'Fecha' ]; 
	$hora = $_REQUEST[ 'Hora' ];
	$actividad = $_REQUEST[ 'Actividad' ];
	$action = $_REQUEST[ 'action' ]; 

	$ACT = new ACT_MODEL(
		$fecha,
		$hora,
		$actividad
);
	
	return $ACT;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if($_SESSION['tipo'] == 'Admin'){
		if ( !$_POST ) {
			$PISTA= new PISTA_MODEL('','','','');
			$ACT= new ACT_MODEL('','','');
			$datos = $PISTA->HORAS();
			$datos2 = $PISTA->FECHAS();
		
			new ACT_ADD($datos, $datos2);
		} else {
		    $ACT= get_data_form();
			$respuesta = $ACT->ADD();
			new MESSAGE( $respuesta, '../Controllers/ACT_CONTROLLER.php' );
		}
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}	
		break;
		
		
	case 'DELETE':
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {

				$ACT = new ACT_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ], $_REQUEST[ 'Actividad' ]);
				$valores = $ACT->RellenaDatos();
				$lista= array('EscuelaDeportiva_Fecha', 'EscuelaDeportiva_Hora', 'EscuelaDeportiva_Actividad', 'Usuario_Dni');
				$INSACT = new INSACT_MODEL('', $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ], $_REQUEST[ 'Actividad' ]);
				$lista2 = $INSACT->SEARCH();
				new ACT_DELETE( $valores, $lista, $lista2);

			} else {
				$ACT = get_data_form();

				$respuesta = $ACT->DELETE();

				new MESSAGE( $respuesta, '../Controllers/ACT_CONTROLLER.php' );
			}
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;
	case 'SEARCH':
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {

				if($_SESSION['tipo'] == 'Admin'){
					new ACT_SEARCH();
				}else{
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACT_CONTROLLER.php' );
				}

			} else {			
				$ACT = get_data_form();
				$datos = $ACT->SEARCH();
				$lista = array('Fecha','Hora','Actividad');

				new ACT_SHOWALL( $lista, $datos );			
			}
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Admin'){
		   $ACT = new ACT_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ], $_REQUEST[ 'Actividad' ]);
		   $lista = $ACT->RellenaDatos();
		   $INSACT = new INSACT_MODEL('', $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ], $_REQUEST[ 'Actividad' ]);
		   $lista2 = array('EscuelaDeportiva_Fecha', 'EscuelaDeportiva_Hora', 'EscuelaDeportiva_Actividad', 'Usuario_Dni');
		   $valores = $INSACT->SEARCH();
		   new ACT_SHOWCURRENT($lista, $lista2, $valores );
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;
	default: 
		if($_SESSION['tipo'] == 'Admin' ||$_SESSION['tipo'] == 'Deportista'){
				if ( !$_POST ) {
					$ACT = new ACT_MODEL( '', '', '');
					
				} else {
					$ACT = get_data_form();
				}
				if($_SESSION['tipo'] == 'Admin'){		
					$datos = $ACT->SEARCH();
				}else{
					$datos = $ACT->SEARCH();
				}
				
				$lista = array('Fecha','Hora', 'Actividad');
				
				new ACT_SHOWALL( $lista, $datos);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}	
}

?>