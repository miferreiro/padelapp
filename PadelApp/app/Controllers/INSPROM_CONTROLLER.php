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
include '../Models/NOTICIA_MODEL.php';
include '../Models/NOTIFICACIONES_MODEL.php';
include '../Views/PROMOCION/PROM_SHOWALL_View.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php';
require_once('../PHPMailer/class.phpmailer.php');

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
				$Contenido =  "Se ha inscrito correctamente en el partido ";
				$Contenido.= " del día ";
				$Contenido.= date( "d/m/Y", strtotime( $_REQUEST[ 'Promociones_Fecha' ]) ) ;
				$Contenido.= " a las ";
				$Contenido.= $_REQUEST[ 'Promociones_Hora' ];
				$Contenido.= ". Atentamente PadelApp S.L.";
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( '', 'Inscripción en partido', $Contenido ,$_REQUEST[ 'Usuario_Dni' ]);
				$NOTIFICACIONES->ADD();
				new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PROM_CONTROLLER.php' );
			}
		break;
		
	case 'DELETE':
	if($_SESSION['tipo'] == 'Deportista'){

			$INSPROM = get_data_form();
			
			$respuesta = $INSPROM->DELETE();
			$Contenido =  "Se ha borrado correctamente del partido ";
				$Contenido.= " disputado el día ";
				$Contenido.= date( "d/m/Y", strtotime( $_REQUEST[ 'Promociones_Fecha' ]) ) ;
				$Contenido.= " a las ";
				$Contenido.= $_REQUEST[ 'Promociones_Hora' ];
				$Contenido.= ". Atentamente PadelApp S.L.";
				$NOTIFICACIONES = new NOTIFICACIONES_MODEL( '', 'Baja de partido', $Contenido ,$_REQUEST[ 'Usuario_Dni' ]);
				$NOTIFICACIONES->ADD();
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

						$INSPROM = new INSPROM_MODEL($_SESSION['dni'],'', '');
	
						$datos = $INSPROM->SEARCH();
						
						$lista = array('Promociones_Fecha','Promociones_Hora','Usuario_Dni');
					
						new INSPROM_SHOWALL( $lista, $datos);
				}else{
					$NOTICIA = new NOTICIA_MODEL( '', '', '');
					$datos = $NOTICIA->SEARCH();
					new USUARIO_DEFAULT($datos);
			}
			
}

?>