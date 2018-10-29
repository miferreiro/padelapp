<?php

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/PROM_MODEL.php'; //incluye el contendio del modelo PROMS
include '../Models/PISTA_MODEL.php'; //incluye el contendio del modelo PISTAS
include '../Views/PROMOCIÓN/PROM_SHOWALL.php'; //incluye la vista del showall
include '../Views/PROMOCIÓN/PROM_DELETE.php'; //incluye la vista EDIT
include '../Views/PROMOCIÓN/PROM_SHOWCURRENT.php'; //incluye la vista SEARCH
include '../Views/PROMOCIÓN/PROM_ADD.php'; //incluye la vista SEARCH
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo PROM_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
	$fecha = $_REQUEST[ 'Fecha' ]; //Variable que almacena el valor de Fecha
	$hora = $_REQUEST[ 'Hora' ]; //Variable que almacena el valor de Hora
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de PISTA
	$PROM = new PROM_MODEL(
		$fecha,
		$hora
);//Creamos un objeto de PROM con las variables que se han recibido del formulario
	//Devuelve el valor del objecto model creado
	
	return $PROM;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( $_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
		
		} else {//Si recibe datos los recoge y mediante las funcionalidad de PROM_MODEL inserta los datos
		    $PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
			$respuesta = $PROM->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE

		
				//Variable que recoge un objecto model con solo el login
				$PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
				//Variable que almacena el relleno de los datos utilizando el login
				$valores = $PROM->RellenaDatos($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);

            
				//Crea una vista delete para ver la tupla
				new PROM_DELETE( $valores);
			
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de PISTA_MODEL borra los datos
			//Variable que almacena un objecto PISTA(modelo) con los datos recogidos de los atributos
			$PROM = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $PROM->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/PROM_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;

		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		           $PROM = new PROM_MODEL($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		//Variable que almacena los valores rellenados a traves de login
		           $valores = $PROM->RellenaDatos($_REQUEST[ 'Fecha' ], $_REQUEST[ 'Hora' ]);
		           //Creación de la vista showcurrent
		           new PROM_SHOWCURRENT( $valores );
			
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
			if($_SESSION['tipo'] == 'Admin'){//miramos si el usuario es administrador
						if ( !$_POST ) {//Si no se han recibido datos 
							$PROM = new PROM_MODEL( '', '', '', '');//Variable que almacena la un objeto del modelo PISTA
							//Si se reciben datos
						} else {
							$PROM = get_data_form();//Variable que almacena los valores de un objeto PISTA_MODEL
						}
						//Variable que almacena los datos de la busqueda
						$datos = $PROM->SEARCH();
						//Variable que almacena array con el nombre de los atributos
						$lista = array('Hora','Fecha');
						
						new PROM_SHOWALL( $lista, $datos);//nos muestra una vista showall con todos los permisos
			}else{//en el caso de que el usuario no tenga permisos le sale una vista vacía
				new USUARIO_DEFAULT();
			}
   				
			
}

?>