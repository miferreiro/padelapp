<?php
/*
	Archivo php
	Nombre: GRUPO_CONTROLLER.php
	Autor: 	 Jonatan Couto
	Fecha de creación: 19/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas en los grupos
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación

if (!IsAuthenticated()){//Si no esta autenticado se redirecciona al index
	
 	header('Location:../index.php');//Redireción al index
}

include '../Models/GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/GRUPO/GRUPO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/GRUPO/GRUPO_SEARCH_View.php'; //incluye la vista search
include '../Views/GRUPO/GRUPO_ADD_View.php'; //incluye la vista add
include '../Views/GRUPO/GRUPO_EDIT_View.php'; //incluye la vista edit
include '../Views/GRUPO/GRUPO_DELETE_View.php'; //incluye la vista delete
include '../Views/GRUPO/GRUPO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo GRUPO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {

	$IdGrupo = $_REQUEST[ 'IdGrupo' ]; //Variable que almacena el valor de idGrupo
	$NombreGrupo = $_REQUEST[ 'NombreGrupo' ]; //Variable que almacena el valor de NomnbreGrupo
	$DescripGrupo = $_REQUEST[ 'DescripGrupo' ]; //Variable que almacena el valor de DescripGrupo
 
    //Variable que guarda un modelo de GRUPO
	$GRUPOS = new GRUPO(
		$IdGrupo,
		$NombreGrupo,
		$DescripGrupo
	);
	//Devuelve el valor del objecto model creado
	return $GRUPOS;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			//Crea una nueva vista del formulario añadir
			if($_SESSION['grupo'] == 'Admin'){//si el usuario es administrador mostramos la vista ADD
				new GRUPO_ADD();
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de GRUPO inserta los datos
			$GRUPOS = get_data_form();//Variable que almacena un objecto GRUPO(modelo) con los datos recogidos
			$respuesta = $GRUPOS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if($_SESSION['grupo'] == 'Admin'){//si el usuario es administrador mostramos la vista DELETE
			//Variable que recoge un objecto model con solo el idgrupo
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '');
			
			$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );//Variable que almacena el relleno de los datos utilizando el IdGrupo
			$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );	//Variable que almacena el relleno de los datos utilizando el IdGrupo
                
            //Variable que almacena todas las dependencias de la tabla GRUPO a la hora de borrar    
            $dependencias = $GRUPOS->dependencias($_REQUEST['IdGrupo']);
            //Variable que almacena todas las dependencias de la tabla GRUPO a la hora de borrar
            $dependencias2 = $GRUPOS->dependencias2($_REQUEST['IdGrupo']);
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login', 'IdGrupo');
			//Crea una vista delete para ver la tupla
			new GRUPO_DELETE( $valores, $valores2, $lista, $dependencias, $dependencias2);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		
			}
		} else {//Si recibe valores ejecuta el borrado
			//Variable que almacena un objecto GRUPO(modelo) con los datos recogidos de los atributos
			$GRUPOS = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $GRUPOS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if($_SESSION['grupo'] == 'Admin'){//si el usuario es administrador mostramos la vista EDIT
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '');//Variable que recoge un objecto model con solo el idgrupo
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );//Variable que almacena el relleno de los datos utilizando el IdGrupo
			
			new GRUPO_EDIT( $valores);//Muestra la vista del formulario editar
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		
			}
		} else {//Si se reciben valores
			//Variable que almacena un objecto GRUPO(modelo) con los datos recogidos
			$GRUPOS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $GRUPOS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if($_SESSION['grupo'] == 'Admin'){//si el usuario es administrador mostramos la vista SEARCH
            new GRUPO_SEARCH();
			}else{
				
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
			}
			
			
		} else {//Si se reciben datos
			//Variable que almacena los datos recogidos de los atributos
			$GRUPOS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $GRUPOS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','DescripGrupo');
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado

			
			new GRUPO_SHOWALL( $lista, $datos );	//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
			if($_SESSION['grupo'] == 'Admin'){//miramos si este usuario es administrador
		//Variable que almacena un objeto model con el IdGrupo
		$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '');
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login', 'IdGrupo');
		//Creación de la vista showcurrent
		new GRUPO_SHOWCURRENT( $lista, $valores, $valores2 );
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		
			}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto

		if($_SESSION['grupo'] == 'Admin'){//miramos si este usuario es administrador
			if ( !$_POST ) {//Si no se han recibido datos 
				$GRUPOS = new GRUPO( '', '', '', '');//Variable que almacena un objeto de tipo GRUPO

			} else {//Si se reciben datos
				$GRUPOS= get_data_form();//Variable que almacena un objecto GRUPO con los datos recogidos de los atributos
			}
			//Variable que almacena los datos de la busqueda
		$datos = $GRUPOS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array('NombreGrupo','DescripGrupo');

		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new GRUPO_SHOWALL( $lista, $datos );
		}else{ 
			new USUARIO_DEFAULT();
		}
			
}

?>