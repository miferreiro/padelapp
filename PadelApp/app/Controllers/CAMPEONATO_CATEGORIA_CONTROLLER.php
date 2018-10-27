<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/CATEGORIA_MODEL.php';
include '../Views/CAMPEONATO_CATEGORIA/CAMPEONATO_CATEGORIA_SHOWALL_View.php';

include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';


function get_data_form(){
	
	$IdCampeonato = $_REQUEST['IdCampeonato'];
	$Tipo = $_REQUEST['Tipo'];
	$Nivel = $_REQUEST['Nivel'];
	$CATEGORIA = new $CATEGORIA(
		$login,
		$IdGrupo   
	);
	
	return $CATEGORIA; 
}

if ( !isset( $_REQUEST[ 'action' ] ) ) { 
	$_REQUEST[ 'action' ] = ''; 
}


switch ( $_REQUEST[ 'action' ] ) {
	default: 
			if($_SESSION['tipo'] == 'Admin'){
				if ( !$_POST ) {
					$CATEGORIA = new CATEGORIA_MODEL( $_REQUEST['IdCampeonato'], '', '');						
				} else {
					$CATEGORIA = new CATEGORIA_MODEL( $_REQUEST['IdCampeonato'], '', '');		
				}
				$datos = $CATEGORIA->SEARCH();
				$lista = array( 'IdCampeonato','Tipo','Nivel');

				new CAMPEONATO_CATEGORIA_SHOWALL( $lista, $datos);
			
   			}else{
				new USUARIO_DEFAULT();
			}

}
?>