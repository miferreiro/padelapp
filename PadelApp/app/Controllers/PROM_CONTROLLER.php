<?php

session_start(); 
include '../Functions/Authentication.php';

if (!IsAuthenticated()){
	
 	header('Location:../index.php');
}

include '../Models/PROM_MODEL.php'; 
include '../Models/PISTA_MODEL.php'; 
include '../Views/PROMOCIÓN/PROM_SHOWALL.php'; 
include '../Views/PROMOCIÓN/PROM_DELETE.php';
include '../Views/PROMOCIÓN/PROM_SHOWCURRENT.php'; 
include '../Views/PROMOCIÓN/PROM_ADD.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';

function get_data_form() {
	$fecha = $_REQUEST[ 'Fecha' ]; 
	$hora = $_REQUEST[ 'Hora' ];
	$action = $_REQUEST[ 'action' ]; 

	$PROM = new PROM_MODEL(
		$fecha,
		$hora
);
	
	return $PROM;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new PROM_ADD();
		} else {
		    $PROM = get_data_form();
			$respuesta = $PROM->ADD();
			
			new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
		}
	
		break;
	case 'DELETE':
		if ( !$_POST ) {

			$PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
			$valores = $PROM->RellenaDatos();

			new PROM_DELETE( $valores);
			
		} else {
			$PROM = get_data_form();
			
			$respuesta = $PROM->DELETE();
			
			new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
		}
		break;

	case 'SHOWCURRENT':
		           $PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		           $valores = $PROM->RellenaDatos();
		           new PROM_SHOWCURRENT( $valores );
		break;
	default: 
			if($_SESSION['tipo'] == 'Admin'){
						if ( !$_POST ) {
							$PROM = new PROM_MODEL( '', '');
							
						} else {
							$PROM = get_data_form();
						}
						
						$datos = $PROM->SEARCH();
						
						$lista = array('Fecha','Hora');
						
						new PROM_SHOWALL( $lista, $datos);
			}else{
				new USUARIO_DEFAULT();
			}
   				
			
}

?>