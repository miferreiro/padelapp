<?php

session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/CAMPEONATO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/CAMPEONATO/CAMPEONATO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/CAMPEONATO/CAMPEONATO_SEARCH_View.php'; //incluye la vista search
include '../Views/CAMPEONATO/CAMPEONATO_ADD_View.php'; //incluye la vista add
include '../Views/CAMPEONATO/CAMPEONATO_DELETE_View.php'; //incluye la vista edit
include '../Views/CAMPEONATO/CAMPEONATO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo USUARIO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
	
	$idCampeonato = $_REQUEST[ 'IdCampeonato' ]; //Variable que almacena el valor de login
	$fechaIni = $_REQUEST[ 'FechaIni' ]; //Variable que almacena el valor de password
	$fechaFin = $_REQUEST[ 'FechaFin' ]; //Variable que almacena el valor de dni

    //Variable que almacena un modelo de USUARIO
	$CAMPEONATO = new CAMPEONATO_MODEL(
		$idCampeonato,
		$fechaIni,
		$fechaFin
	);//Creamos un objeto de usuario con las variables que se han recibido del formulario
	//Devuelve el valor del objecto model creado
	
	return $CAMPEONATO;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD

			if($_SESSION['tipo'] == 'Admin'){//si el usuario es administrador mostramos la vista ADD
				new CAMPEONATO_ADD();
			}else{//si no es administrador
         
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );
			
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de USUARIO_MODEL inserta los datos
			$CAMPEONATO = get_data_form();//Variable que almacena un objecto USUARIO(modelo) con los datos recogidos
			$respuesta = $CAMPEONATO->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/CAMPEONATO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE

			if($_SESSION['tipo'] == 'Admin'){//miramos si este usuario es administrador
				//Variable que recoge un objecto model con solo el login
				$CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '');
				//Variable que almacena el relleno de los datos utilizando el login
				$valores = $CAMPEONATO->RellenaDatos( $_REQUEST[ 'IdCampeonato' ] );

            
				//Crea una vista delete para ver la tupla
				new CAMPEONATO_DELETE( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );
			
			}
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de USUARIO_MODEL borra los datos
			//Variable que almacena un objecto USUARIO(modelo) con los datos recogidos de los atributos
			$CAMPEONATO = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $CAMPEONATO->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/CAMPEONATO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			
			if($_SESSION['tipo'] == 'Admin'){//miramos si es administrador, si lo es, nos muestra la vista SEARCH
				new CAMPEONATO_SEARCH();
			}else{
	
			//en caso de que no tenga dichos permisos se muestra una vista diciendo que este usuario no tiene dichos permisos
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );
			
			}
		//Si se reciben datos	
		} else {
			
			//Variable que almacena los datos recogidos de los atributos
			$CAMPEONATO = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $CAMPEONATO->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'IdCampeonato','FechaIni','FechaFin');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		
			new CAMPEONATO_SHOWALL( $lista, $datos );
			
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if($_SESSION['tipo'] == 'Admin'){//miramos si el usuario es administrador
					//Variable que almacena un objeto USUARIO model con el login

			$CAMPEONATO = new CAMPEONATO_MODEL( $_REQUEST[ 'IdCampeonato' ], '', '');
		//Variable que almacena los valores rellenados a traves de login
		           $valores = $CAMPEONATO->RellenaDatos( $_REQUEST[ 'IdCampeonato' ] );
		           //Creación de la vista showcurrent
		           new CAMPEONATO_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );
			}
		
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
			if($_SESSION['tipo'] == 'Admin'){//miramos si el usuario es administrador
						if ( !$_POST ) {//Si no se han recibido datos 
						$CAMPEONATO = new CAMPEONATO_MODEL( '', '', '');//Variable que almacena la un objeto del modelo USUARIO
						//Si se reciben datos
						} else {
							$CAMPEONATO = get_data_form();//Variable que almacena los valores de un objeto USUARIO_MODEL
						}
						//Variable que almacena los datos de la busqueda
						$datos = $CAMPEONATO->SEARCH();
						//Variable que almacena array con el nombre de los atributos
						$lista = array( 'IdCampeonato','FechaIni','FechaFin');
						
						new CAMPEONATO_SHOWALL( $lista, $datos);//nos muestra una vista showall con todos los permisos
			
   				}else{//en el caso de que el usuario no tenga permisos le sale una vista vacía
				new USUARIO_DEFAULT();
			}
			
}

?>