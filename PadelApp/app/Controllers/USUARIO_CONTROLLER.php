<?php
/*
	Archivo php
	Nombre: USUARIO_CONTROLLER.php
	Autor: 	Jonatan Couto
	Fecha de creación: 18/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/USUARIO/USUARIO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/USUARIO/USUARIO_SEARCH_View.php'; //incluye la vista search
include '../Views/USUARIO/USUARIO_ADD_View.php'; //incluye la vista add
include '../Views/USUARIO/USUARIO_EDIT_View.php'; //incluye la vista edit
include '../Views/USUARIO/USUARIO_DELETE_View.php'; //incluye la vista delete
include '../Views/USUARIO/USUARIO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo USUARIO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
	
	$login = $_REQUEST[ 'login' ]; //Variable que almacena el valor de login
	$password = $_REQUEST[ 'password' ]; //Variable que almacena el valor de password
	$dni = $_REQUEST[ 'Dni' ]; //Variable que almacena el valor de dni
	$nombre = $_REQUEST[ 'nombre' ]; //Variable que almacena el valor de nombre
	$apellidos = $_REQUEST[ 'apellidos' ]; //Variable que almacena el valor de apellidos
	$sexo = $_REQUEST[ 'Sexo' ]; //Variable que almacena el valor de direccion
	$telefono = $_REQUEST[ 'telefono' ]; //Variable que almacena el valor de telefono
	$tipo = $_REQUEST[ 'Tipo' ];
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de USUARIO
	$USUARIO = new USUARIO_MODEL(
		$login,
		$password,
		$dni,
		$nombre,
		$apellidos,
		$sexo,
		$telefono,
		$tipo
	);//Creamos un objeto de usuario con las variables que se han recibido del formulario
	//Devuelve el valor del objecto model creado
	
	return $USUARIO;
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
				new USUARIO_ADD();
			}else{//si no es administrador
         
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de USUARIO_MODEL inserta los datos
			$USUARIO = get_data_form();//Variable que almacena un objecto USUARIO(modelo) con los datos recogidos
			$respuesta = $USUARIO->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE

			if($_SESSION['tipo'] == 'Admin'){//miramos si este usuario es administrador
				//Variable que recoge un objecto model con solo el login
				$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'Dni' ], '', '', '', '', '', '', '', '');
				//Variable que almacena el relleno de los datos utilizando el login
				$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'Dni' ] );

            
				//Crea una vista delete para ver la tupla
				new USUARIO_DELETE( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			
			}
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de USUARIO_MODEL borra los datos
			//Variable que almacena un objecto USUARIO(modelo) con los datos recogidos de los atributos
			$USUARIO = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $USUARIO->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT

			if($_SESSION['tipo'] == 'Admin'){//si es el usuario es administrador
						//Variable que almacena un objeto USUARIO model con el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'Dni' ], '', '', '', '', '', '', '','');
			//Variable que almacena un objecto USUARIO(modelo) con los datos de los atibutos rellenados a traves de login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'Dni' ] );

			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			
			//Si se reciben valores
		} else {
			//Variable que almacena un objecto Usuario model de los datos recogidos
			$USUARIO = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $USUARIO->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			
			if($_SESSION['grupo'] == 'Admin'){//miramos si es administrador, si lo es, nos muestra la vista SEARCH
				new USUARIO_SEARCH();
			}else{
	
			//en caso de que no tenga dichos permisos se muestra una vista diciendo que este usuario no tiene dichos permisos
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			
			}
		//Si se reciben datos	
		} else {
			
			//Variable que almacena los datos recogidos de los atributos
			$USUARIO = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $USUARIO->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		
				new USUARIO_SHOWALL( $lista, $datos );
			
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if($_SESSION['tipo'] == 'Admin'){//miramos si el usuario es administrador
					//Variable que almacena un objeto USUARIO model con el login
		           $USUARIO = new USUARIO_MODEL( $_REQUEST[ 'Dni' ], '', '', '', '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		           $valores = $USUARIO->RellenaDatos( $_REQUEST[ 'Dni' ] );
		           //Creación de la vista showcurrent
		           new USUARIO_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
		
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
			if($_SESSION['tipo'] == 'Admin'){//miramos si el usuario es administrador
						if ( !$_POST ) {//Si no se han recibido datos 
						$USUARIO = new USUARIO_MODEL( '', '', '', '', '', '', '', '', '');//Variable que almacena la un objeto del modelo USUARIO
						//Si se reciben datos
						} else {
							$USUARIO = get_data_form();//Variable que almacena los valores de un objeto USUARIO_MODEL
						}
						//Variable que almacena los datos de la busqueda
						$datos = $USUARIO->SEARCH();
						//Variable que almacena array con el nombre de los atributos
						$lista = array( 'Dni','Login','Nombre','Apellidos','Sexo','Telefono','Tipo');
						
						new USUARIO_SHOWALL( $lista, $datos);//nos muestra una vista showall con todos los permisos
			
   				}else{//en el caso de que el usuario no tenga permisos le sale una vista vacía
				new USUARIO_DEFAULT();
			}
			
}

?>