<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/CATEGORIA_MODEL.php';
include '../Models/NOTICIA_MODEL.php';
include '../Views/CAMPEONATO_CATEGORIA/CAMPEONATO_CATEGORIA_SHOWALL_View.php';
include '../Views/CAMPEONATO_CATEGORIA/CAMPEONATO_CATEGORIA_INSCRITOS_View.php';
include '../Views/CAMPEONATO_CATEGORIA/CAMPEONATO_CATEGORIA_DELETE.php';

include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';


function get_data_form(){
	
	$IdCampeonato = $_REQUEST['IdCampeonato'];
	$Tipo = $_REQUEST['Tipo'];
	$Nivel = $_REQUEST['Nivel'];
	
	$CATEGORIA = new CATEGORIA_MODEL(
		$IdCampeonato,
		$Tipo,
		$Nivel
	);
	
	return $CATEGORIA; 
}

if ( !isset( $_REQUEST[ 'action' ] ) ) { 
	$_REQUEST[ 'action' ] = ''; 
}


switch ( $_REQUEST[ 'action' ] ) {
	case "INSCRITOS":
		
		if($_SESSION['tipo'] == 'Admin'){

				$CATEGORIA=  get_data_form();

				$valores = $CATEGORIA->ListaInscritos();

				$lista = array( 'NumPareja','Login','IdCampeonato','Tipo','Nivel');
				$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$vuelta['Tipo'] = $_REQUEST['Tipo'];
				$vuelta['Nivel'] = $_REQUEST['Nivel'];
			
			   new CAMPEONATO_CATEGORIA_INSCRITOS($lista , $valores ,$vuelta);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
		

	break;
	case 'DELETE':
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){
				$CATEGORIA = new CATEGORIA_MODEL( $_REQUEST[ 'IdCampeonato' ], $_REQUEST[ 'Tipo' ], $_REQUEST[ 'Nivel' ]);

				$valores = $CATEGORIA->RellenaDatos( $_REQUEST[ 'IdCampeonato' ], $_REQUEST[ 'Tipo' ], $_REQUEST[ 'Nivel' ]);
            	
				new CAMPEONATO_CATEGORIA_DELETE( $valores);
				
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' );
			
			}
		
		} else {
			
			$CATEGORIA = new CATEGORIA_MODEL( $_REQUEST[ 'IdCampeonato' ],  $_REQUEST[ 'Tipo' ], $_REQUEST[ 'Nivel' ]);
			
			$respuesta = $CATEGORIA->DELETE1();
				
		
			
			
			
			if(($respuesta != 'Borrado correctamente')){
				new MESSAGE( 'Borrado incorrectamente', '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' );
			}else{
				new MESSAGE( $respuesta, '../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' );
			}
			
		}
		break;	

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
				$NOTICIA = new NOTICIA_MODEL( '', '', '');
    			$datos = $NOTICIA->SEARCH();
				new USUARIO_DEFAULT($datos);
			}

}
?>