 <?php

session_start(); 
include '../Functions/Authentication.php';
include '../Functions/ComprobarInscritos.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Views/INSCRIPCIÓN_PROMOCIONES/INSPROM_SHOWALL.php'; 
include '../Views/INSCRIPCIÓN_PROMOCIONES/INSPROM_SHOWCURRENT.php'; 
include '../Models/INSPROM_MODEL.php'; 
include '../Models/PROM_MODEL.php'; 
include '../Views/PROMOCION/PROM_SHOWALL_View.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';

function get_data_form() {
	$Usuario_Dni=$_REQUEST[ 'Usuario_Dni'];
	$Promociones_fecha = $_REQUEST[ 'Promociones_Fecha' ]; 
	$Promociones_hora = $_REQUEST[ 'Promociones_Hora' ]; 
	$action = $_REQUEST[ 'action' ]; 
	$INSPROM = new INSPROM_MODEL(
		$Usuario_Dni,
		$Promociones_fecha,
		$Promociones_hora
);
	return $INSPROM;
}
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'INSCRIPCION':
			if($_SESSION['tipo'] == 'Deportista'){
				$INSPROM = get_data_form();
				$respuesta = $INSPROM->ADD();//Variable que almacena la respuesta de la inserción
				new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PROM_CONTROLLER.php' );
			}
		break;
		
	case 'DELETE':
	if($_SESSION['tipo'] == 'Deportista'){

			$INSPROM = get_data_form();
			
			$respuesta = $INSPROM->DELETE();
			
			new MESSAGE( $respuesta, '../Controllers/INSPROM_CONTROLLER.php?Usuario_Dni='.$_SESSION['dni'] );

			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/INSPROM_CONTROLLER.php' );
			}
		break;
		
	case 'SHOWCURRENT':
		if($_SESSION['tipo'] == 'Deportista'){
		   $PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		   $lista = $PROM->RellenaDatos();
		   $INSPROM = new INSPROM_MODEL('', $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		   $lista2 = array('Promociones_Fecha', 'Promociones_Hora', 'Usuario_Dni');
		   $valores = $INSPROM->SEARCH();
		   new INSPROM_SHOWCURRENT($lista, $lista2, $valores );
		}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		break;		
		
		
	default: 
			if($_SESSION['tipo'] == 'Deportista'){

						$INSPROM = new INSPROM_MODEL($_REQUEST['Usuario_Dni'],'', '');
	
						$datos = $INSPROM->SEARCH();
						
						$lista = array('Promociones_Fecha','Promociones_Hora','Usuario_Dni');
					
						new INSPROM_SHOWALL( $lista, $datos);
				}else{
					new DEFAULT_View();
			}
			
}

?>