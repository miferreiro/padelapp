 <?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
	
 	header('Location:../index.php');
}

include '../Models/RESERVA_MODEL.php';
include '../Models/NOTIFICACIONES_MODEL.php';
include '../Models/PISTA_MODEL.php'; 
include '../Views/RESERVA/RESERVA_SHOWALL.php'; 
include '../Views/RESERVA/RESERVA_DELETE.php'; 
include '../Views/DEFAULT_View.php';
include '../Views/MESSAGE_View.php'; 
require_once('../PHPMailer/class.phpmailer.php');

function get_data_form() {
	$Usuario_Dni=$_REQUEST[ 'Usuario_Dni'];
	$Pista_idPista = $_REQUEST[ 'Pista_idPista' ]; 
	$Pista_fecha = $_REQUEST[ 'Pista_Fecha' ];
	$Pista_hora = $_REQUEST[ 'Pista_Hora' ]; 
	$action = $_REQUEST[ 'action' ]; 
    
	$RESERVA = new RESERVA_MODEL(
		$Usuario_Dni,
		$Pista_idPista,
		$Pista_fecha,
		$Pista_hora
);
	
	return $RESERVA;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
			if($_SESSION['tipo'] == 'Deportista'){
				$RESERVA = get_data_form();
				$respuesta = $RESERVA->ADD();
				$Contenido =  "Se ha realizado satisfactoriamente una reserva en la pista ";
				$Contenido.= $_REQUEST[ 'Pista_idPista' ];
				$Contenido.= " el día ";
				$Contenido.= date( "d/m/Y", strtotime( $_REQUEST[ 'Pista_Fecha' ]) ) ;
				$Contenido.= " a las ";
				$Contenido.= $_REQUEST[ 'Pista_Hora' ];
				$Contenido.= " . Atentamente PadelApp S.L.";
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( '', 'Reserva de pista', $Contenido ,$_REQUEST[ 'Usuario_Dni' ]);
				$NOTIFICACIONES->ADD();
				new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PISTA_CONTROLLER.php' );
			}
		break;
	case 'DELETE':
		if($_SESSION['tipo'] == 'Deportista'){	
		if ( !$_POST ) {
				$RESERVA = new RESERVA_MODEL( $_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);

				$valores = $RESERVA->RellenaDatos($_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);

				new RESERVA_DELETE($valores);
			
		} else {
			$RESERVA = get_data_form();

			$respuesta = $RESERVA->DELETE();
				$Contenido =  "Confirmada la cancelación de su reserva en la pista ";
				$Contenido.= $_REQUEST[ 'Pista_idPista' ];
				$Contenido.= " el día ";
				$Contenido.= date( "d/m/Y", strtotime( $_REQUEST[ 'Pista_Fecha' ]) ) ;
				$Contenido.= " a las ";
				$Contenido.= $_REQUEST[ 'Pista_Hora' ];
				$Contenido.= " . Atentamente PadelApp S.L.";
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( '', 'Cancelación de reserva', $Contenido ,$_REQUEST[ 'Usuario_Dni' ]);
				$NOTIFICACIONES->ADD();
			new MESSAGE( $respuesta, '../Controllers/RESERVA_CONTROLLER.php'.'?Usuario_Dni='.$_REQUEST[ 'Usuario_Dni' ] );
		}}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PISTA_CONTROLLER.php' );
		}

		break;

	default:
		           if($_SESSION['tipo'] == 'Deportista'){
						$RESERVA = new RESERVA_MODEL( $_REQUEST['Usuario_Dni'], '', '', '');
				   }else{
					   $RESERVA = new RESERVA_MODEL( '', '', '', '');
				   }
						
						$datos = $RESERVA->SEARCH();
						$lista = array( 'Pista_Fecha','Pista_Hora','Pista_idPista','Usuario_Dni');
						new RESERVA_SHOWALL( $lista, $datos);		
			
}

?>