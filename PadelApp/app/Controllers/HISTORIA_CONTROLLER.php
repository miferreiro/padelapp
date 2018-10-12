<?php
/*
	Archivo php
	Nombre: HISTORIA_CONTROLLER.php
	Autor: 	Brais Santos
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas en la tabla HISTORIA
*/

session_start();//solicito trabajar con la sesión
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/HISTORIA_MODEL.php';//incluye el contenido del modelo historia
include '../Models/TRABAJO_MODEL.php';//incluye el contenido del modelo trabajo
include '../Functions/permisosAcc.php';//incluye el contenido de la funcion permisosAcc
include '../Views/HISTORIA/HISTORIA_SHOWALL_View.php';//incluye la vista SHOWALL de HISTORIA
include '../Views/HISTORIA/HISTORIA_SEARCH_View.php';//incluye la vista SEARCH de HISTORIA
include '../Views/HISTORIA/HISTORIA_ADD_View.php';//incluye la vista ADD de HISTORIA
include '../Views/HISTORIA/HISTORIA_EDIT_View.php';//incluye la vista EDIT de HISTORIA
include '../Views/HISTORIA/HISTORIA_DELETE_View.php';//incluye la vista DELETE de HISTORIA
include '../Views/HISTORIA/HISTORIA_SHOWCURRENT_View.php';//incluye la vista SHOWCURRENT de HISTORIA
include '../Views/DEFAULT_View.php';//incluye la vista por defecto
include '../Views/MESSAGE_View.php';//incluye la vista que manda mensajes y vuelta atrás


//Esta función crea un objeto tipo HISTORIA_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo']; //Variable que almacena el valor de IdTrabajo
	$IdHistoria = $_REQUEST['IdHistoria']; //Variable que almacena el valor de IdHistoria
	$TextoHistoria = $_REQUEST['TextoHistoria']; //Variable que almacena el valor de TextoHistoria
	$action= $_REQUEST['action']; //Variable que almacena la acción
	//Variable que almacena un modelo de HISTORIA
	$HISTORIA = new HISTORIA_MODEL(
		$IdTrabajo,
		$IdHistoria,
		$TextoHistoria
	);//Devuelve el valor del objecto model creado
	
	return $HISTORIA;
}

//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			if(permisosAcc($_SESSION['login'],10,0)==true){//miramos si el usuario tiene permisos para añadir en gestión de historias
			$TRABAJO= new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO
			$TRABAJOS=$TRABAJO->SEARCH2();//Variable que almacena un recordset de todos los trabajos
			new HISTORIA_ADD($TRABAJOS);//se muestra la vista ADD de HISTORIA
			}else{//si el usuario no tiene dicho permiso, se le indica en una vista mediante un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con un mensaje diciendo que el usuario  no tiene permiso para añadir en HISTORIA
			}
		} else {//Si se reciben datos
			$HISTORIA = get_data_form();//Variable que almacena un objecto HISTORIA(modelo) con los datos recogidos de los atributos
			$respuesta = $HISTORIA->ADD();//Variable que almacena el resultado de la insercion de los datos
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con el mensaje que viene de la base de datos
		}
		break;//Finaliza el bloque
	case 'DELETE'://caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if(permisosAcc($_SESSION['login'],10,1)==true){//miramos si el usuario tiene permisos para borrar en gestión de historias
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');//Variable que almacena un objeto de tipo HISTORIA
			$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ]);//Variable que almacena un recordset con los valores que se relacionan con IdTrabajo y IdHistoria
			$dependencias = $HISTORIA->dependencias( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ]);//Variable que almacena un recordset con las dependencias que se relacionan con IdTrabajo y IdHistoria
			new HISTORIA_DELETE( $valores, $dependencias);//se muestra la vista DELETE de Historia
			}else{//si el usuario no tiene dicho permiso, se le indica en una vista mediante un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con un mensaje diciendo que el usuario  no tiene permiso para borrar en HISTORIA
			}
		} else {//Si se reciben datos
			$HISTORIA = get_data_form();//Variable que almacena un objecto HISTORIA(modelo) con los datos recogidos de los atributos
			$respuesta = $HISTORIA->DELETE();//Variable que almacena la respuesta del borrado de los datos
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con el mensaje que viene de la base de datos
		}
		break;//Finaliza el bloque
	case 'EDIT'://caso editar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],10,2)==true){//miramos si el usuario tiene permisos para editar en gestión de historias
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');//Variable que almacena un objeto de tipo HISTORIA
			$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] ,$_REQUEST[ 'IdHistoria' ]);//Variable que almacena un recordset de los valores relacionados con IdTrabajo y IdHistoria
			new HISTORIA_EDIT( $valores );//se muestra la vista edit de historia
			}else{//si el usuario no tiene dicho permiso, se le indica en una vista mediante un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con un mensaje diciendo que el usuario  no tiene permiso para editar en HISTORIA
			}
		} else {//Si se reciben datos
			$HISTORIA = get_data_form();//Variable que almacena un objecto HISTORIA(modelo) los datos recogidos de los atributos
			$respuesta = $HISTORIA->EDIT();//Variable que almacena la respuesta de la edicion en la tabla HISTORIA
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con el mensaje que viene de la base de datos
		}
		break;//Finaliza el bloque
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],10,3)==true){//miramos si el usuario tiene permisos para BUSCAR en gestión de historias
			new HISTORIA_SEARCH();//mostramos la vista search de historia
			}else{//si el usuario no tiene dicho permiso, se le indica en una vista mediante un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con un mensaje diciendo que el usuario  no tiene permiso para buscar  en HISTORIA
			}
		} else {//Si se reciben datos
			$HISTORIA = get_data_form();//Variable que almacena un objecto HISTORIA(modelo) con los datos recogidos de los atributos
			$datos = $HISTORIA->SEARCH();//Variable que almacena un recordset con el resultado de la busqueda
			$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria' );//Variable que almacena un array los campos que queremos mostrar.
			new HISTORIA_SHOWALL( $lista, $datos );//se muestra una vista showall con los datos que queríamos buscar
		}
		break;//Finaliza el bloque
	case 'SHOWCURRENT'://Caso ver en detalle
	if(permisosAcc($_SESSION['login'],10,4)==true){//miramos si el usuario tiene permisos para ver en detalle en gestión de historias
		$HISTORIA= new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');//Variable que almacena un objeto tipo HISTORIA pasandole el IdTrabaja y IdHistoria que se eligió
		$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] ,$_REQUEST[ 'IdHistoria' ]);//Variable que almacena un recordset con los valores relacionados con IdTrabajo y IdHistoria
		new HISTORIA_SHOWCURRENT( $valores );//se muestra una vista showcurrent de historia
			}else{//si el usuario no tiene dicho permiso, se le indica en una vista mediante un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/HISTORIA_CONTROLLER.php' );//se muestra una vista con un mensaje diciendo que el usuario  no tiene permiso para ver en detalle  en HISTORIA
			}
		break;//Finaliza el bloque
	default://Caso por defecto
	if(permisosAcc($_SESSION['login'],10,5)==true){//miramos si el usuario tiene permisos de showall en gestión de historia
		if ( !$_POST ) {//Si no se han recibido datos creamos un objeto de tipo HISTORIA_MODEL
			$HISTORIA = new HISTORIA_MODEL( '', '', '');//Variable que almacena un objeto de tipo HISTORIA_MODEL
		} else {//Si se reciben los datos
			$HISTORIA = get_data_form();//Variable que almacena un objecto HISTORIA(modelo) los datos recogidos de los atributos
		}
		$datos = $HISTORIA->SEARCH();//Variable que almacena un recordset con el resultado de la busqueda
		$lista = array( 'NombreTrabajo','IdHistoria','TextoHistoria' );//Variable que almacena un array los campos que queremos mostrar.
		new HISTORIA_SHOWALL( $lista, $datos );//se muestra una vista showall con todos los datos
			}else{//si el usuario no tiene dicho permiso, se le indica en una vista por defecto que está vacía
				new USUARIO_DEFAULT();//se muestra una vista pordefecto(vacía)
			}
}

?>