 <?php

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/INSPROM_MODEL.php'; //incluye el contendio del modelo INSCRIPCIÓN_PROMOCIONES
include '../Models/PROM_MODEL.php'; //incluye el contendio del modelo PISTAS
include '../Views/INSCRIPCIÓN_PROMOCIONES/INSPROM_SHOWALL.php'; //incluye la vista del showall
include '../Views/INSCRIPCIÓN_PROMOCIONES/INSPROM_DELETE.php'; //incluye la vista EDIT
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo INSPROM_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
	$Usuario_Dni=$_REQUEST[ 'Usuario_Dni'];//Variable que almacena el valor de Dni
	$Promociones_fecha = $_REQUEST[ 'Promociones_Fecha' ]; //Variable que almacena el valor de Fecha
	$Promociones_hora = $_REQUEST[ 'Promociones_Hora' ]; //Variable que almacena el valor de Hora
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de PISTA
	$INSPROM = new INSPROM_MODEL(
		$Usuario_Dni,
		$Promociones_fecha,
		$Promociones_hora
);//Creamos un objeto de INSPROM con las variables que se han recibido del formulario
	//Devuelve el valor del objecto model creado
	
	return $INSPROM;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
			if($_SESSION['tipo'] == 'Deportista'){
		    $INSPROM = new INSPROM_MODEL( $_REQUEST[ 'Dni' ], $_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
			$respuesta = $INSPROM->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/INSPROM_CONTROLLER.php' );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}

		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE

		
				//Variable que recoge un objecto model con solo el login
				$INSPROM = new INSPROM_MODEL( $_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Promociones_Fecha' ], $_REQUEST[ 'Promociones_Hora' ]);
				//Variable que almacena el relleno de los datos utilizando el login
				$valores = $INSPROM->RellenaDatos($_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Promociones_Fecha' ], $_REQUEST[ 'Promociones_Hora' ]);

            
				//Crea una vista delete para ver la tupla
				new INSPROM_DELETE( $valores);
			
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de PISTA_MODEL borra los datos
			//Variable que almacena un objecto PISTA(modelo) con los datos recogidos de los atributos
			$INSPROM = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $INSPROM->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/INSPROM_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;

	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			
		//Si se reciben datos	
		} else {
			
			//Variable que almacena los datos recogidos de los atributos
			$INSPROM = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $INSPROM->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('Promociones_Fecha','Promociones_Hora','Usuario_Dni');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		
				new INSPROM_SHOWCURRENT( $lista, $datos );
			
			
		}
		//Final del bloque
		break;

	default: //Caso que se ejecuta por defecto
				if ( !$_POST ) {//Si no se han recibido datos 
					$INSPROM = new INSPROM_MODEL( '', '', '', '');//Variable que almacena la un objeto del modelo PISTA
					//Si se reciben datos
				} else {
					$INSPROM = get_data_form();//Variable que almacena los valores de un objeto PISTA_MODEL
				}
				//Variable que almacena los datos de la busqueda
				$datos = $INSPROM->SEARCH();
				//Variable que almacena array con el nombre de los atributos
				$lista = array( 'Promociones_Fecha','Promociones_Hora','Usuario_Dni');
				
				new INSPROM_SHOWALL( $lista, $datos);//nos muestra una vista showall con todos los permisos
	
   				
			
}

?>