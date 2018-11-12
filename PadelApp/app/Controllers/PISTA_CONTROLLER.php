  <?php

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
include '../Functions/Comprobar_Disponibilidad.php'; 
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}
include '../Models/RESERVA_MODEL.php';
include '../Models/PISTA_MODEL.php'; //incluye el contendio del modelo PISTAS
include '../Views/PISTA/PISTA_SHOWALL.php'; //incluye la vista del showall
include '../Views/PISTA/PISTA_EDIT.php'; //incluye la vista EDIT
include '../Views/PISTA/PISTA_SHOWCURRENT.php'; //incluye la vista SEARCH
include '../Views/PISTA/PISTA_DELETE.php'; //incluye la vista SEARCH
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


//Esta función crea un objeto tipo PISTA_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
	
	$idPista = $_REQUEST[ 'idPista' ]; //Variable que almacena el valor de idPista
	$hora = $_REQUEST[ 'Hora' ]; //Variable que almacena el valor de Hora
	$fecha = $_REQUEST[ 'Fecha' ]; //Variable que almacena el valor de Fecha
	$disponibilidad = $_REQUEST[ 'Disponibilidad' ]; //Variable que almacena el valor de disponibilidad
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de PISTA
	$PISTA = new PISTA_MODEL(
		$idPista,
		$hora,
		$fecha,
		$disponibilidad
		
	);//Creamos un objeto de pista con las variables que se han recibido del formulario
	//Devuelve el valor del objecto model creado
	
	return $PISTA;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			
         	$PISTA = new PISTA_MODEL( '', '', '', '');
			$ultimaPista = $PISTA->	getLastIdPista();
			$PISTA = new PISTA_MODEL( $ultimaPista+1, '', '', '');
			$respuesta = $PISTA->ADD();
			
			new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );
			
		
		} else {
			new MESSAGE( 'La PISTA no tiene los permisos necesarios', '../Controllers/PISTA_CONTROLLER.php' );
		}
		
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE

				//Variable que recoge un objecto model con solo el login
				$PISTA = new PISTA_MODEL( $_REQUEST[ 'idPista' ], '', '', '');
				//Variable que almacena el relleno de los datos utilizando el login
				$valores = $PISTA->RellenaDatos( $_REQUEST[ 'idPista' ] );
				$lista = array('Usuario_Dni','Pista_Fecha','Pista_Hora');
				$RESERVA = new RESERVA_MODEL('',$_REQUEST[ 'idPista' ],'',''); 
				$lista2 = $RESERVA->SEARCH();
            
				//Crea una vista delete para ver la tupla
				new PISTA_DELETE( $valores,$lista,$lista2);
			
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de PISTA_MODEL borra los datos
			//Variable que almacena un objecto PISTA(modelo) con los datos recogidos de los atributos
			$PISTA = new PISTA_MODEL( $_REQUEST[ 'idPista' ], '', '', '');
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $PISTA->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT

			
			$PISTA = new PISTA_MODEL( $_REQUEST[ 'idPista' ], $_REQUEST['Hora'], $_REQUEST['Fecha'], '');
			//Variable que almacena un objecto PISTA(modelo) con los datos de los atibutos rellenados a traves de login
			$valores = $PISTA->RellenaDatos2( );

			//Muestra la vista del formulario editar
			new PISTA_EDIT( $valores);
			
			
			//Si se reciben valores
		} else {
			//Variable que almacena un objecto PISTA model de los datos recogidos
			$PISTA = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $PISTA->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/PISTA_CONTROLLER.php' );
		}
		//Fin del bloque
		break;

	case 'SHOWCURRENT'://Caso showcurrent
		           $PISTA = new PISTA_MODEL(  $_REQUEST[ 'idPista' ],'','','');
		//Variable que almacena los valores rellenados a traves de login
					$valores = $PISTA->SEARCH();
				   	$lista = array('Fecha','Hora','Disponibilidad');
					$lista2 = array('Pista_Fecha','Pista_Hora','Usuario_Dni');
					$RESERVA = new RESERVA_MODEL('',$_REQUEST[ 'idPista' ],'','');
					$valores2= $RESERVA->SEARCH();
		           //Creación de la vista showcurrent
		           new PISTA_SHOWCURRENT($lista,$lista2,$valores, $valores2);
			
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
						if ( !$_POST ) {//Si no se han recibido datos 
							$PISTA = new PISTA_MODEL( '', '','', '');//Variable que almacena la un objeto del modelo PISTA
							//Si se reciben datos
						} else {
							$PISTA = get_data_form();//Variable que almacena los valores de un objeto PISTA_MODEL
						}
						//Variable que almacena los datos de la busqueda
						$datos = $PISTA->HORAS();
						$datos2 = $PISTA->FECHAS();
						//Variable que almacena array con el nombre de los atributos
						$lista = $PISTA->PISTAS();
						
						new PISTA_SHOWALL( $lista, $datos, $datos2);//nos muestra una vista showall con todos los permisos

   				
			
}

?>