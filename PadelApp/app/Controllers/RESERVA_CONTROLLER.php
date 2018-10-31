 <?php

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/RESERVA_MODEL.php'; //incluye el contendio del modelo RESERVAS
include '../Models/PISTA_MODEL.php'; //incluye el contendio del modelo PISTAS
include '../Views/RESERVA/RESERVA_SHOWALL.php'; //incluye la vista del showall
include '../Views/RESERVA/RESERVA_DELETE.php'; //incluye la vista EDIT
include '../Views/RESERVA/RESERVA_SHOWCURRENT.php'; //incluye la vista SEARCH
include '../Views/RESERVA/RESERVA_ADD.php'; //incluye la vista SEARCH
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo RESERVA_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
	$Usuario_Dni=$_REQUEST[ 'Usuario_Dni'];//Variable que almacena el valor de Dni
	$Pista_idPista = $_REQUEST[ 'Pista_idPista' ]; //Variable que almacena el valor de idPista
	$Pista_fecha = $_REQUEST[ 'Pista_Fecha' ]; //Variable que almacena el valor de Fecha
	$Pista_hora = $_REQUEST[ 'Pista_Hora' ]; //Variable que almacena el valor de Hora
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de PISTA
	$RESERVA = new RESERVA_MODEL(
		$Usuario_Dni,
		$Pista_idPista,
		$Pista_fecha,
		$Pista_hora
);//Creamos un objeto de reserva con las variables que se han recibido del formulario
	//Devuelve el valor del objecto model creado
	
	return $RESERVA;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
		
		} else {//Si recibe datos los recoge y mediante las funcionalidad de RESERVA_MODEL inserta los datos
		    $RESERVA = new RESERVA_MODEL( $_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);
			$respuesta = $RESERVA->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/RESERVA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE

		
				//Variable que recoge un objecto model con solo el login
				$RESERVA = new RESERVA_MODEL( $_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);
				//Variable que almacena el relleno de los datos utilizando el login
				$valores = $RESERVA->RellenaDatos($_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);

            
				//Crea una vista delete para ver la tupla
				new RESERVA_DELETE($valores);
			
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de PISTA_MODEL borra los datos
			//Variable que almacena un objecto PISTA(modelo) con los datos recogidos de los atributos
			$RESERVA = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $RESERVA->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/RESERVA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;

	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			
		//Si se reciben datos	
		} else {
			
			//Variable que almacena los datos recogidos de los atributos
			$RESERVA = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $RESERVA->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('Usuario_Dni','Pista_idPista','Pista_Hora','Pista_Fecha');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		
				new RESERVA_SHOWCURRENT( $lista, $datos );
			
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		           $RESERVA = new RESERVA_MODEL( $_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);
		//Variable que almacena los valores rellenados a traves de login
		           	$valores = $RESERVA->RellenaDatos($_REQUEST[ 'Usuario_Dni' ], $_REQUEST[ 'Pista_idPista' ], $_REQUEST[ 'Pista_Fecha' ], $_REQUEST[ 'Pista_Hora' ]);
		           //Creación de la vista showcurrent
		           new RESERVA_SHOWCURRENT( $valores );
			
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
			if($_SESSION['tipo'] == 'Admin'){//miramos si el usuario es administrador
						if ( !$_POST ) {//Si no se han recibido datos 
							$RESERVA = new RESERVA_MODEL( '', '', '', '');//Variable que almacena la un objeto del modelo PISTA
							//Si se reciben datos
						} else {
							$RESERVA = get_data_form();//Variable que almacena los valores de un objeto PISTA_MODEL
						}
						//Variable que almacena los datos de la busqueda
						$datos = $RESERVA->SEARCH();
						//Variable que almacena array con el nombre de los atributos
						$lista = array( 'Usuario_Dni','Pista_idPista','Pista_Hora','Pista_Fecha');
						
						new RESERVA_SHOWALL( $lista, $datos);//nos muestra una vista showall con todos los permisos
			}else{//en el caso de que el usuario no tenga permisos le sale una vista vacía
				new USUARIO_DEFAULT();
			}
   				
			
}

?>