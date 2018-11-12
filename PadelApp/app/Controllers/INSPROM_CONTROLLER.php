 <?php

session_start(); 
include '../Functions/Authentication.php';
include '../Functions/ComprobarInscritos.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Views/INSCRIPCIÓN_PROMOCIONES/INSPROM_SHOWALL.php'; 
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
				new MESSAGE( $respuesta, '../Controllers/INSPROM_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/INSPROM_CONTROLLER.php' );
			}
		break;
	default: 
						if($_SESSION['tipo'] == 'Deportista'){
						if ( !$_POST ) {
							$PROM = new PROM_MODEL( '', '');
							
						} else {
							$PROM = get_data_form();
						}
					if($_SESSION['tipo'] == 'Admin'){		
						$datos = $PROM->SEARCH();
					}else{
						$datos = $PROM->SEARCH();
					}
						
						$lista = array('Fecha','Hora');
						
						new INSPROM_SHOWALL( $lista, $datos);
				}else{
					new DEFAULT_View();
			}
			
}

?>