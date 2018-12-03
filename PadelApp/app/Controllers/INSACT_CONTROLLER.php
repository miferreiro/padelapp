 <?php

session_start(); 
include '../Functions/Authentication.php';
include '../Functions/ComprobarInscritos.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Views/INSACT/INSACT_SHOWALL.php'; 
include '../Views/INSACT/INSACT_SHOWCURRENT.php'; 
include '../Models/INSACT_MODEL.php'; 
include '../Models/ACT_MODEL.php'; 
include '../Views/ACTIVIDADES/ACT_SHOWALL_View.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';

function get_data_form() {
	$Usuario_Dni=$_REQUEST[ 'Usuario_Dni'];
	$EscuelaDeportiva_fecha = $_REQUEST[ 'EscuelaDeportiva_Fecha' ]; 
	$EscuelaDeportiva_hora = $_REQUEST[ 'EscuelaDeportiva_Hora' ];
	$EscuelaDeportiva_actividad = $_REQUEST[ 'EscuelaDeportiva_Actividad' ];
	$action = $_REQUEST[ 'action' ]; 
	$INSACT = new INSACT_MODEL(
		$Usuario_Dni,
		$EscuelaDeportiva_fecha,
		$EscuelaDeportiva_hora,
		$EscuelaDeportiva_actividad
);
	return $INSACT;
}
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'INSCRIPCION':
			if($_SESSION['tipo'] == 'Deportista'){
				$INSACT = get_data_form();
				$respuesta = $INSACT->ADD();//Variable que almacena la respuesta de la inserción
				new MESSAGE( $respuesta, '../Controllers/ACT_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACT_CONTROLLER.php' );
			}
		break;
		
	case 'DELETE':
	if($_SESSION['tipo'] == 'Deportista'){

			$INSACT = get_data_form();
			
			$respuesta = $INSACT->DELETE();
			
			new MESSAGE( $respuesta, '../Controllers/INSACT_CONTROLLER.php?Usuario_Dni='.$_SESSION['dni'] );

			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/INSACT_CONTROLLER.php' );
			}
		break;
		
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Deportista'){
		   $ACT = new ACT_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ], $_REQUEST[ 'Actividad' ]);
		   $lista = $ACT->RellenaDatos();
		   $INSACT = new INSACT_MODEL('', $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ], $_REQUEST[ 'Actividad' ]);
		   $lista2 = array('EscuelaDeportiva_Fecha', 'EscuelaDeportiva_Hora', 'EscuelaDeportiva_Actividad', 'Usuario_Dni');
		   $valores = $INSACT->SEARCH();
		   new INSACT_SHOWCURRENT($lista, $lista2, $valores );
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;		
		
		
	default: 
			if($_SESSION['tipo'] == 'Deportista'){

						$INSACT = new INSACT_MODEL($_SESSION['dni'],'', '','');
	
						$datos = $INSACT->SEARCH();
						
						$lista = array('EscuelaDeportiva_Fecha','EscuelaDeportiva_Hora', 'EscuelaDeportiva_Actividad' ,'Usuario_Dni');
					
						new INSACT_SHOWALL( $lista, $datos);
				}else{
					new DEFAULT_View();
			}
			
}

?>