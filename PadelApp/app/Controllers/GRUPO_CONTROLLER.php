<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/GRUPO_MODEL.php';
include '../Models/ENFRENTAMIENTO_MODEL.php';
include '../Views/GRUPO/GRUPO_CATEGORIA_SHOWALL_View.php';
include '../Views/GRUPO/GRUPO_CATEGORIA_PAREJAS_View.php';
include '../Views/GRUPO/GRUPO_CATEGORIA_TABLA_View.php';
include '../Views/ENFRENTAMIENTO/ENFRENTAMIENTO_EDIT_View.php';
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';


function get_data_form(){
	
	$IdCampeonato = $_REQUEST['IdCampeonato'];
	$Tipo = $_REQUEST['Tipo'];
	$Nivel = $_REQUEST['Nivel'];
	$Letra= $_REQUEST['Letra'];
	$GRUPO= new GRUPO_MODEL(
		$IdCampeonato,
		$Tipo,
		$Nivel,
		$Letra
	);
	
	return $GRUPO; 
}

if ( !isset( $_REQUEST[ 'action' ] ) ) { 
	$_REQUEST[ 'action' ] = ''; 
}


switch ( $_REQUEST[ 'action' ] ) {
	
	case "EDITAR":
	
		if ( !$_POST ) {

			if($_SESSION['tipo'] == 'Admin'){

				$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],'','','','');
				$valores = $ENFRENTAMIENTO->RellenaDatos();
			
				new ENFRENTAMIENTO_EDIT( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios','../Controllers/GRUPO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA' );
			}
		} else {
				$ENFRENTAMIENTO1 = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja1'],$_REQUEST['ResultadoSet1Par1'],$_REQUEST['ResultadoSet2Par1'],$_REQUEST['ResultadoSet3Par1'],'');
				$respuesta = $ENFRENTAMIENTO1->EDIT();
			
				$ENFRENTAMIENTO2 = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],$_REQUEST['NumEnfrentamiento'],$_REQUEST['pareja2'],$_REQUEST['ResultadoSet1Par2'],$_REQUEST['ResultadoSet2Par2'],$_REQUEST['ResultadoSet3Par2'],'');
				$respuesta2 = $ENFRENTAMIENTO2->EDIT();
				echo $respuesta2;
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php?IdCampeonato=' . $_REQUEST['IdCampeonato'] . '&Tipo='.$_REQUEST['Tipo']. '&Nivel='.$_REQUEST['Nivel'] . '&Letra='.$_REQUEST['Letra'] . '&action=TABLA');
		}
		break;
	
	case "TABLA":
		if($_SESSION['tipo'] == 'Admin'){

				$GRUPO =  get_data_form();

				$listaParejas = $GRUPO ->ListaParejasGrupoNum();

				$ENFRENTAMIENTO = new ENFRENTAMIENTO_MODEL($_REQUEST['IdCampeonato'],$_REQUEST['Tipo'],$_REQUEST['Nivel'],$_REQUEST['Letra'],'','','','','','');
				
				$listaEnfrentamientos = $ENFRENTAMIENTO->listaEnfrentamiento();
				
				
				//$lista = array( 'NumPareja','Login','IdCampeonato','Tipo','Nivel','Letra');
				$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$vuelta['Tipo'] = $_REQUEST['Tipo'];
				$vuelta['Nivel'] = $_REQUEST['Nivel'];
				$vuelta['Letra'] = $_REQUEST['Letra'];
			   new GRUPO_CATEGORIA_TABLA($listaParejas , $listaEnfrentamientos ,$vuelta);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
	
	break;
	case "PAREJAS":
		
		if($_SESSION['tipo'] == 'Admin'){

				
				$GRUPO =  get_data_form();

				$valores = $GRUPO ->ListaParejasGrupo();

				$lista = array( 'NumPareja','Login','IdCampeonato','Tipo','Nivel','Letra');
				$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$vuelta['Tipo'] = $_REQUEST['Tipo'];
				$vuelta['Nivel'] = $_REQUEST['Nivel'];
				$vuelta['Letra'] = $_REQUEST['Letra'];
				
			   new GRUPO_CATEGORIA_PAREJAS($lista , $valores ,$vuelta);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
	break;
	default: 
			if($_SESSION['tipo'] == 'Admin'){
			
				$GRUPO = new GRUPO_MODEL( $_REQUEST['IdCampeonato'],  $_REQUEST['Tipo'], $_REQUEST['Nivel'],'');						
			
				$datos = $GRUPO->SEARCH();
				$lista = array( 'Letra','IdCampeonato','Tipo','Nivel');
				$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
				$vuelta['Tipo'] = $_REQUEST['Tipo'];
				$vuelta['Nivel'] = $_REQUEST['Nivel'];
				new GRUPO_CATEGORIA_SHOWALL( $lista, $datos,$vuelta);
			
   			}else{
				new USUARIO_DEFAULT();
			}

}
?>