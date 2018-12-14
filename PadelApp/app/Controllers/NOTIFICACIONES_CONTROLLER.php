<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/NOTIFICACIONES_MODEL.php'; 
include '../Models/NOTICIA_MODEL.php';
include '../Views/NOTIFICACIONES/NOTIFICACIONES_SHOWALL_View.php'; 
include '../Views/NOTIFICACIONES/NOTIFICACIONES_ADD_View.php'; 
include '../Views/NOTIFICACIONES/NOTIFICACIONES_DELETE_View.php';
include '../Views/DEFAULT_View.php';
include '../Views/MESSAGE_View.php';
require_once('../PHPMailer/class.phpmailer.php');

function get_data_form() {
	$IdNotificacion = $_REQUEST[ 'IdNotificacion' ];
	$Titulo = $_REQUEST[ 'Titulo' ];
	$Contenido = $_REQUEST[ 'Contenido' ]; 
	$Notificado = $_REQUEST[ 'Notificado' ];

	$NOTIFICACIONES = new NOTIFICACIONES_MODEL(
		$IdNotificacion,
		$Titulo,
		$Contenido,
		$Notificado
	);
	
	return $NOTIFICACIONES;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			if($_SESSION['tipo'] == 'Admin'){
				$dni=$_REQUEST[ 'Dni' ];
				new NOTIFICACIONES_ADD($dni);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		}else{
			if($_SESSION['tipo'] == 'Admin'){
				
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( '', $_REQUEST[ 'Titulo' ],$_REQUEST[ 'Contenido' ],$_REQUEST[ 'Notificado' ]);
				$respuesta = $NOTIFICACIONES->ADD();

				new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		}

		break;
	case 'DELETE':
		if ( !$_POST ) {
			if($_SESSION['tipo'] == 'Admin'){
				
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( $_REQUEST[ 'IdNotificacion' ], '', '','');
				$valores = $NOTIFICACIONES->RellenaDatos( $_REQUEST[ 'IdNotificacion' ]);
				new NOTIFICACIONES_DELETE( $valores);
				
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );	
			}
		}else{
			if($_SESSION['tipo'] == 'Admin'){			
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( $_REQUEST[ 'IdNotificacion' ],'', '', '');
				$respuesta = $NOTIFICACIONES->DELETE();
				new MESSAGE( $respuesta, '../Controllers/NOTIFICACIONES_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		}
		break;
	default: 
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( '', '', '','');
			} else {
				$NOTIFICACIONES = get_data_form();
			}

			$datos = $NOTIFICACIONES->SEARCH();
			$lista = array( 'Titulo','Notificado');
			new NOTIFICACIONES_SHOWALL( $lista, $datos);

		}else{
			$NOTICIA = new NOTICIA_MODEL( '', '', '');
			$datos = $NOTICIA->SEARCH();
			new USUARIO_DEFAULT($datos);
		}			
}
?>

