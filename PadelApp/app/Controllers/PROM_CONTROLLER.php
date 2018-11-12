<?php

session_start(); 
include '../Functions/Authentication.php';
include '../Functions/ComprobarInscritos.php'; 
include '../Functions/Comprobar_Disponibilidad.php'; 

if (!IsAuthenticated()){
	
 	header('Location:../index.php');
}

include '../Models/PROM_MODEL.php'; 
include '../Models/INSPROM_MODEL.php'; 
include '../Models/PISTA_MODEL.php'; 
include '../Views/PROMOCION/PROM_SHOWALL_View.php'; 
include '../Views/PROMOCION/PROM_DELETE_View.php';
include '../Views/PROMOCION/PROM_SHOWCURRENT_View.php'; 
include '../Views/PROMOCION/PROM_SEARCH_View.php'; 
include '../Views/PROMOCION/PROM_ADD_View.php'; 
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
			$PISTA= new PISTA_MODEL('','','','');
			$PROM= new PROM_MODEL('','');
			$datos = $PISTA->HORAS();
			$datos2 = $PISTA->FECHAS();
			//Variable que almacena array con el nombre de los atributos
			new PROM_ADD($datos, $datos2);//nos muestra una vista showall con todos los permisos
		} else {
		    $PROM= get_data_form();	
			$respuesta = $PROM->ADD();
			new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
		}
	
		break;
		
		
	case 'DELETE':
		if ( !$_POST ) {

			$PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
			$valores = $PROM->RellenaDatos();
			$lista= array('Promociones_Fecha', 'Promociones_Hora', 'Usuario_Dni');
			$INSPROM = new INSPROM_MODEL('', $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
			$lista2 = $INSPROM->SEARCH();
			new PROM_DELETE( $valores, $lista, $lista2);
			
		} else {
			$PROM = get_data_form();
			
			$respuesta = $PROM->DELETE();
			
			new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
						
			if($_SESSION['tipo'] == 'Admin'){
				new PROM_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PROM_CONTROLLER.php' );
			}

		} else {
			
			$PROM = get_data_form();
			$datos = $PROM->SEARCH();
			$lista = array('Fecha','Hora');
		
			new PROM_SHOWALL( $lista, $datos );
			
			
		}
		//Final  boque
		break;
	case 'SHOWCURRENT':
		   $PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		   $lista = $PROM->RellenaDatos();
		   $INSPROM = new INSPROM_MODEL('', $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		   $lista2 = array('Promociones_Fecha', 'Promociones_Hora', 'Usuario_Dni');
		   $valores = $INSPROM->SEARCH();
		   new PROM_SHOWCURRENT($lista, $lista2, $valores );
		break;
	default: 
						if ( !$_POST ) {
							$PROM = new PROM_MODEL( '', '');
							
						} else {
							$PROM = get_data_form();
						}
					if($_SESSION['tipo'] == 'Admin'){		
						$datos = $PROM->SEARCH();
					}else{
						$datos = $PROM->SEARCH();
					}
						
						$lista = array('Fecha','Hora');
						
						new PROM_SHOWALL( $lista, $datos);

   				
			
}

?>