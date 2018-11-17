  <?php

session_start();
include '../Functions/Authentication.php'; 
include '../Functions/Comprobar_Disponibilidad.php'; 

if (!IsAuthenticated()){
	
 	header('Location:../index.php');
}
include '../Models/RESERVA_MODEL.php';
include '../Models/PISTA_MODEL.php'; 
include '../Views/PISTA/PISTA_SHOWALL.php'; 
include '../Views/PISTA/PISTA_EDIT.php';
include '../Views/PISTA/PISTA_SHOWCURRENT.php';
include '../Views/PISTA/PISTA_DELETE.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php'; 


function get_data_form() {
	
	$idPista = $_REQUEST[ 'idPista' ]; 
	$hora = $_REQUEST[ 'Hora' ]; 
	$fecha = $_REQUEST[ 'Fecha' ]; 
	$disponibilidad = $_REQUEST[ 'Disponibilidad' ];
	$action = $_REQUEST[ 'action' ]; 
   
	$PISTA = new PISTA_MODEL(
		$idPista,
		$hora,
		$fecha,
		$disponibilidad
		
	);
	
	return $PISTA;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {

				$PISTA = new PISTA_MODEL( '', '', '', '');
				$ultimaPista = $PISTA->	getLastIdPista();
				$PISTA = new PISTA_MODEL( $ultimaPista+1, '', '', '');
				$respuesta = $PISTA->ADD();
				new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );


			} else {
				new MESSAGE( 'La PISTA no tiene los permisos necesarios', '../Controllers/PISTA_CONTROLLER.php' );
			}
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {

					$PISTA = new PISTA_MODEL( $_REQUEST[ 'idPista' ], '', '', '');

					$valores = $PISTA->RellenaDatos( $_REQUEST[ 'idPista' ] );
					$lista = array('Usuario_Dni','Pista_Fecha','Pista_Hora');
					$RESERVA = new RESERVA_MODEL('',$_REQUEST[ 'idPista' ],'',''); 
					$lista2 = $RESERVA->SEARCH();

					new PISTA_DELETE( $valores,$lista,$lista2);

			} else {
				$PISTA = new PISTA_MODEL( $_REQUEST[ 'idPista' ], '', '', '');
				$respuesta = $PISTA->DELETE();
				new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );
			}
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if($_SESSION['tipo'] == 'Admin'){
			if ( !$_POST ) {


				$PISTA = new PISTA_MODEL( $_REQUEST[ 'idPista' ], $_REQUEST['Hora'], $_REQUEST['Fecha'], '');
				$valores = $PISTA->RellenaDatos2( );
				new PISTA_EDIT( $valores);

			} else {

				$PISTA = get_data_form();
				$respuesta = $PISTA->EDIT();
				new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );
			}
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;

	case 'SHOWCURRENT':
			if($_SESSION['tipo'] == 'Admin' ||$_SESSION['tipo'] == 'Deportista' ){
			   $PISTA = new PISTA_MODEL(  $_REQUEST[ 'idPista' ],'','','');
				$valores = $PISTA->SEARCH();
				$lista = array('Fecha','Hora','Disponibilidad');
				$lista2 = array('Pista_Fecha','Pista_Hora','Usuario_Dni');
				$RESERVA = new RESERVA_MODEL('',$_REQUEST[ 'idPista' ],'','');
				$valores2= $RESERVA->SEARCH();

			   new PISTA_SHOWCURRENT($lista,$lista2,$valores, $valores2);
			
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;
	default: 
			if($_SESSION['tipo'] == 'Admin' ||$_SESSION['tipo'] == 'Deportista'){
				if ( !$_POST ) { 
					$PISTA = new PISTA_MODEL( '', '','', '');
				} else {
					$PISTA = get_data_form();
				}

				$datos = $PISTA->HORAS();
				$datos2 = $PISTA->FECHAS();

				$lista = $PISTA->PISTAS();

				new PISTA_SHOWALL( $lista, $datos, $datos2);

   			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			
}

?>