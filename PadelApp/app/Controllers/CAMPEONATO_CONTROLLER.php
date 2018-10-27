<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/CAMPEONATO_MODEL.php'; 
include '../Models/CATEGORIA_MODEL.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_SHOWALL_View.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_SEARCH_View.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_ADD_View.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_DELETE_View.php';
include '../Views/CAMPEONATO/CAMPEONATO_SHOWCURRENT_View.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php'; 

function get_data_form() {
	
	$idCampeonato = $_REQUEST[ 'IdCampeonato' ]; 
	$fechaIni = $_REQUEST[ 'FechaIni' ]; 
	$fechaFin = $_REQUEST[ 'FechaFin' ] ; 
    $horaIni =  $_REQUEST[ 'HoraIni' ] ; 
	$horaFin =  $_REQUEST[ 'HoraIni' ] ; 
    
	$CAMPEONATO = new CAMPEONATO_MODEL(
		$idCampeonato,
		$fechaIni,
		$horaIni,
		$fechaFin,
		$horaFin
	);
	
	return $CAMPEONATO;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){
				new CAMPEONATO_ADD();
			}else{  
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );			
			}
		} else {
			$CAMPEONATO = get_data_form();
			$respuesta = $CAMPEONATO->ADD();
			$respuesta1 = '';
			$respuesta2 = '';
			$respuesta3 = '';
			$respuesta4 = '';
			$respuesta5 = '';
			$respuesta6 = '';
			$respuesta7 = '';
			$respuesta8 = '';
			$respuesta9 = '';
			
			$categoria = $_POST['categoria'];
			
			if ( in_array('Masculina1', $categoria)){
				$CATEGORIAMA1 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Masculino',1);
				$respuesta1 = $CATEGORIAMA1->ADD();			
			}
			
			if(in_array('Masculina2', $categoria)){
				$CATEGORIAMA2 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Masculino',2);
				$respuesta2 = $CATEGORIAMA2->ADD();
			}
			
			
			if(in_array('Masculina3', $categoria)){
				$CATEGORIAMA3 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Masculino',3);
				$respuesta3 = $CATEGORIAMA3->ADD();
			}
			

			if(in_array('Femenina1', $categoria)){
				$CATEGORIAF1 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Femenino',1);
				$respuesta4 = $CATEGORIAF1->ADD();
			}
			
			
			if(in_array('Femenina2', $categoria)){
	
				$CATEGORIAF2 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Femenino',2);
				$respuesta5 = $CATEGORIAF2->ADD();
			}
			

			if(in_array('Femenina3', $categoria)){
				$CATEGORIAF3 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Femenino',3);
				$respuesta6 = $CATEGORIAF3->ADD();
			}
			
			
			if(in_array('Mixta1', $categoria)){
					$CATEGORIAMI1 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Mixto',1);
					$respuesta7 = $CATEGORIAMI1->ADD();
			}
			
			
			if(in_array('Mixta2', $categoria)){
				$CATEGORIAMI2 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Mixto',2);
				$respuesta8 = $CATEGORIAMI2->ADD();
			}
			
			
			if(in_array('Mixta3', $categoria)){
				$CATEGORIAMI3 = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'Mixto',3);
				$respuesta9 = $CATEGORIAMI3->ADD();
			}
			
			
			if($respuesta == 'Error en la inserción' || $respuesta1 == 'Error en la inserción' ||$respuesta2 == 'Error en la inserción' ||
			  $respuesta3 == 'Error en la inserción' ||$respuesta4 == 'Error en la inserción' ||$respuesta5 == 'Error en la inserción' ||
			   $respuesta6 == 'Error en la inserción' ||$respuesta7 == 'Error en la inserción' ||$respuesta8 == 'Error en la inserción' ||
			  $respuesta9 == 'Error en la inserción'){
				
				$CAMPEONATO->DELETE();
				
				if(in_array('Masculina1', $categoria)){$CATEGORIAMA1->DELETE();}
				if(in_array('Masculina2', $categoria)){$CATEGORIAMA2->DELETE();}
				if(in_array('Masculina3', $categoria)){$CATEGORIAMA3->DELETE();}
				if(in_array('Femenina1', $categoria)){$CATEGORIAF1->DELETE();}
				if(in_array('Femenina2', $categoria)){$CATEGORIAF2->DELETE();}
				if(in_array('Femenina3', $categoria)){$CATEGORIAF3->DELETE();}
				if(in_array('Mixta1', $categoria)){$CATEGORIAMI1->DELETE();}
				if(in_array('Mixta2', $categoria)){$CATEGORIAMI2->DELETE();}
				if(in_array('Mixta3', $categoria)){$CATEGORIAMI3->DELETE();}
				
				new MESSAGE( 'Error en la inserción', '../Controllers/CAMPEONATO_CONTROLLER.php' );
				
			}else{
				new MESSAGE( $respuesta, '../Controllers/CAMPEONATO_CONTROLLER.php' );
			}
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){
				$CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '','','');

				$valores = $CAMPEONATO->RellenaDatos( $_REQUEST[ 'IdCampeonato' ] );
            
				new CAMPEONATO_DELETE( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );
			
			}
		
		} else {
			
			$CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '','','');
			
			$CATEGORIA = new CATEGORIA_MODEL($CAMPEONATO->IdCampeonato,'','');
			
			$respuesta1 = $CATEGORIA->DELETE_ALL();
				
			$respuesta = $CAMPEONATO->DELETE();

			
			
			if(($respuesta != 'Borrado correctamente') | ($respuesta1 != 'Borrado correctamente')){
				new MESSAGE( 'Borrado incorrectamente', '../Controllers/CAMPEONATO_CONTROLLER.php' );
			}else{
				new MESSAGE( $respuesta, '../Controllers/CAMPEONATO_CONTROLLER.php' );
			}
			
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {		
			if($_SESSION['tipo'] == 'Admin'){
				new CAMPEONATO_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );			
			}
		
		} else {
			
			$CAMPEONATO = get_data_form();
		
			$datos = $CAMPEONATO->SEARCH();

			$lista = array( 'IdCampeonato','FechaIni','HoraIni','FechaFin','HoraFin');			
		
			new CAMPEONATO_SHOWALL( $lista, $datos );
			
			
		}

		break;
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Admin'){

			   $CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '','','');

			   $valores = $CAMPEONATO->RellenaDatos( $_REQUEST[ 'IdCampeonato' ] );
			   new CAMPEONATO_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );
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