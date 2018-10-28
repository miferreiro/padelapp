<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/USUARIO_MODEL.php'; 
include '../Views/USUARIO/USUARIO_SHOWALL_View.php'; 
include '../Views/USUARIO/USUARIO_SEARCH_View.php';
include '../Views/USUARIO/USUARIO_ADD_View.php'; 
include '../Views/USUARIO/USUARIO_EDIT_View.php';
include '../Views/USUARIO/USUARIO_DELETE_View.php';
include '../Views/USUARIO/USUARIO_SHOWCURRENT_View.php'; 
include '../Views/DEFAULT_View.php';
include '../Views/MESSAGE_View.php';


function get_data_form() {
	
	$dni = $_REQUEST[ 'Dni' ];
	$login = $_REQUEST[ 'login' ]; 
	$password = $_REQUEST[ 'password' ];
	$nombre = $_REQUEST[ 'nombre' ]; 
	$apellidos = $_REQUEST[ 'apellidos' ]; 
	$sexo = $_REQUEST[ 'sexo' ]; 
	$tipo = $_REQUEST[ 'Tipo' ];	
	$telefono = $_REQUEST[ 'telefono' ]; 
	$action = $_REQUEST[ 'action' ]; 

	$USUARIO = new USUARIO_MODEL(
		$login,
		$password,
		$dni,
		$nombre,
		$apellidos,
		$sexo,
		$telefono,
		$tipo
	);
	
	return $USUARIO;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){
				new USUARIO_ADD();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		} else {
			$USUARIO = get_data_form();
			$respuesta = $USUARIO->ADD();

			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}

		break;
	case 'DELETE':
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){
				
				$USUARIO = new USUARIO_MODEL( '', '', $_REQUEST[ 'Dni' ], '', '', '', '', '', '');
				$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'Dni' ] );
				new USUARIO_DELETE( $valores);
				
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );	
			}
		} else {
			
			$USUARIO = get_data_form();
			$respuesta = $USUARIO->DELETE();
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){
				$USUARIO = new USUARIO_MODEL( '', '', $_REQUEST[ 'Dni' ], '', '', '', '', '','');
				$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'Dni' ] );
				new USUARIO_EDIT( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		} else {
			$USUARIO = get_data_form();
			$respuesta = $USUARIO->EDIT();
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			
			if($_SESSION['tipo'] == 'Admin'){
				new USUARIO_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		} else {
			
			$USUARIO = get_data_form();
			$datos = $USUARIO->SEARCH();
			$lista = array( 'Login','Dni','Nombre','Apellidos');
			new USUARIO_SHOWALL( $lista, $datoss );
		}
		break;
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Admin'){
			   $USUARIO = new USUARIO_MODEL( '', '', $_REQUEST[ 'Dni' ], '', '', '', '', '');
			   $valores = $USUARIO->RellenaDatos( $_REQUEST[ 'Dni' ] ); 
			   new USUARIO_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;
	default: 
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {
				$USUARIO = new USUARIO_MODEL( '', '', '', '', '', '', '', '', '');
			} else {
				$USUARIO = get_data_form();
			}

			$datos = $USUARIO->SEARCH();
			$lista = array( 'Dni','Login','Nombre','Apellidos','Sexo','Telefono','Tipo');
			new USUARIO_SHOWALL( $lista, $datos);

		}else{
			new USUARIO_DEFAULT();
		}
			
}

?>