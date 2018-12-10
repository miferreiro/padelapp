<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/NOTICIA_MODEL.php'; 
include '../Views/NOTICIA/NOTICIA_SHOWALL_View.php'; 
include '../Views/NOTICIA/NOTICIA_ADD_View.php'; 
include '../Views/NOTICIA/NOTICIA_DELETE_View.php';
include '../Views/DEFAULT_View.php';
include '../Views/MESSAGE_View.php';


function get_data_form() {
	
	$Titulo = $_REQUEST[ 'Titulo' ];
	$Contenido = $_REQUEST[ 'Contenido' ]; 
	$fotopersonal = null;


	if ( isset( $_FILES[ 'fotopersonal' ][ 'name' ] ) ) {
		$nombreFoto = $_FILES[ 'fotopersonal' ][ 'name' ];
	} else {
		$nombreFoto = null;
	}

	if ( isset( $_FILES[ 'fotopersonal' ][ 'tmp_name' ] ) ) {
		$nombreTempFoto = $_FILES[ 'fotopersonal' ][ 'tmp_name' ];
	} else {
		$nombreTempFoto = null;
	}


	if ( $nombreFoto != null ) {
		$dir_subida = '../Files/';
		$fotopersonal = $dir_subida . $nombreFoto;
		move_uploaded_file( $nombreTempFoto, $fotopersonal );
	}	

	$NOTICIA = new NOTICIA_MODEL(
		$Titulo,
		$Contenido,
		$fotopersonal
	);
	
	return $NOTICIA;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			if($_SESSION['tipo'] == 'Admin'){
				new NOTICIA_ADD();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		}else{
			if($_SESSION['tipo'] == 'Admin'){
				
				$NOTICIA = get_data_form();
				$respuesta = $NOTICIA->ADD();

				new MESSAGE( $respuesta, '../Controllers/NOTICIA_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		}

		break;
	case 'DELETE':
		if ( !$_POST ) {
			if($_SESSION['tipo'] == 'Admin'){
				
				$NOTICIA = new NOTICIA_MODEL( $_REQUEST[ 'Titulo' ], '', '');
				$valores = $NOTICIA->RellenaDatos( $_REQUEST[ 'Titulo' ] );
				new NOTICIA_DELETE( $valores);
				
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );	
			}
		}else{
			if($_SESSION['tipo'] == 'Admin'){			
				$NOTICIA = new NOTICIA_MODEL( $_REQUEST['Titulo'], '', '');
				$respuesta = $NOTICIA->DELETE();
				new MESSAGE( $respuesta, '../Controllers/NOTICIA_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		}
		break;
	default: 
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {
				$NOTICIA = new NOTICIA_MODEL( '', '', '');
			} else {
				$NOTICIA = get_data_form();
			}

			$datos = $NOTICIA->SEARCH();
			$lista = array( 'Titulo');
			new NOTICIA_SHOWALL( $lista, $datos);

		}else{
			new USUARIO_DEFAULT();
		}			
}
?>

