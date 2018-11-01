<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}


include '../Models/USUARIO_MODEL.php';
include '../Models/CAMPEONATO_MODEL.php';
include '../Models/CATEGORIA_MODEL.php';
include '../Models/PAREJA_MODEL.php';
include '../Models/USUARIO_PAREJA_MODEL.php';
include '../Views/CATEGORIA/CATEGORIA_SHOWALL_View.php';
include '../Views/CATEGORIA/CATEGORIA_INSCRIPTION_View.php';
include '../Views/CATEGORIA/CATEGORIA_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php'; 


function get_data_form_pareja($numPareja) {
	
	$idCampeonato = $_REQUEST[ 'IdCampeonato' ]; 
	$tipo = $_REQUEST[ 'Tipo' ];
	$nivel = $_REQUEST[ 'Nivel' ]; 
	$capitan= $_REQUEST[ 'Capitan' ]; 
	
 
	$PAREJA = new PAREJA_MODEL(
		$idCampeonato,
		$tipo,
		$nivel,
		$numPareja,
		$capitan
	);
	
	return $PAREJA;
}

function get_data_form_usuario_pareja($numPareja,$usuarioDni) {
	
	$idCampeonato = $_REQUEST[ 'IdCampeonato' ]; 
	$tipo = $_REQUEST[ 'Tipo' ];
	$nivel = $_REQUEST[ 'Nivel' ]; 
	
 
	$USUARIO_PAREJA = new USUARIO_PAREJA_MODEL(
		$usuarioDni,
		$idCampeonato,
		$tipo,
		$nivel,
		$numPareja
	);
	
	return $USUARIO_PAREJA;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'INSCRIPTION' :
		if($_SESSION['tipo'] == 'Deportista'){
			if( !$_POST){
				$valores['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$valores['Tipo'] = $_REQUEST['Tipo'];
				$valores['Nivel'] = $_REQUEST['Nivel'];
				
				new CATEGORIA_INSCRIPTION($valores);
			}else{
				$PAREJAAUX = new PAREJA_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],'','');
				$numPareja = $PAREJAAUX->getLastNumPareja();
				
				$USUARIO = new USUARIO_MODEL($_REQUEST['Login2'],'', '', '', '', '', '', '','');
				
				
				if($USUARIO->existLogin()){				
					
					$PAREJA = get_data_form_pareja($numPareja + 1);
					$respuesta = $PAREJA->ADD();
					
					if($respuesta == 'Error en la inserción'){
						new MESSAGE( 'Error en la inserción', '../Controllers/CATEGORIA_CONTROLLER.php' );
					}else{
						
						$USUARIO1 = new USUARIO_MODEL( $_REQUEST['Login1'],'','', '', '', '', '', '','');
						$dniPareja1 = $USUARIO1->obtenerDni();
						
						$USUARIO_PAREJA1 = get_data_form_usuario_pareja(($numPareja + 1),$dniPareja1);
						$respuesta1 = $USUARIO_PAREJA1->ADD();
				
						if($respuesta1 == 'Error en la inserción'){
							$PAREJA->DELETE();
							new MESSAGE( $respuesta1, '../Controllers/CATEGORIA_CONTROLLER.php' );
						}else{
							
							$USUARIO2 = new USUARIO_MODEL( $_REQUEST['Login2'], '', '', '', '', '', '', '','');
							$dniPareja2 = $USUARIO2->obtenerDni();
						
							$USUARIO_PAREJA2 = get_data_form_usuario_pareja($numPareja + 1,$dniPareja2);
							$respuesta2 = $USUARIO_PAREJA2->ADD();
							
							if($respuesta2 == 'Error en la inserción'){
								$PAREJA->DELETE();
								$USUARIO_PAREJA1->DELETE();									
								new MESSAGE( $respuesta2, '../Controllers/CATEGORIA_CONTROLLER.php' );
							}else{
								new MESSAGE( $respuesta2, '../Controllers/CATEGORIA_CONTROLLER.php' );
							}
								
						}
					}
					
				}else{
					new MESSAGE( 'No existe el otro componente de la pareja', '../Controllers/CATEGORIA_CONTROLLER.php' );
				}
			}
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}		
		
		break;	
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Deportista'){

			$CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '', '', '');

			$valores = $CAMPEONATO ->RellenaDatos();
			$valores['Tipo'] = $_REQUEST['Tipo'];
			$valores['Nivel'] = $_REQUEST['Nivel'];

		   new CATEGORIA_SHOWCURRENT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
		
		//Final del bloque
		break;		
	default: 
		
		if($_SESSION['tipo'] == 'Deportista'){
			
			if ( !$_POST ) {
				$CATEGORIA= new CATEGORIA_MODEL( '', '', '');
				//Si se reciben datos
			} else {
				//$USUARIO = get_data_form();
			}
			$datos = $CATEGORIA->SEARCH();
			$lista = array( 'IdCampeonato','Tipo','Nivel');
			new CATEGORIA_SHOWALL( $lista, $datos);

		}else{
			new USUARIO_DEFAULT();
		}			
}

?>