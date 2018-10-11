<?php
/*
	Archivo php
	Nombre: PERMISO_CONTROLLER.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 25/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas en la tabla PERMISO.
*/

session_start();//solicito trabajar con la sesión
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/PERMISO_MODEL.php';//Inclueye el contenido del modelo de permiso
include '../Models/USU_GRUPO_MODEL.php';//Inclueye el contenido del modelo de usu_grupo
include '../Models/GRUPO_MODEL.php'; ////Inclueye el contenido del modelo de grupo
include '../Models/FUNCIONALIDAD_MODEL.php'; ////Inclueye el contenido del modelo de permiso
include '../Views/PERMISO/PERMISO_SEARCH_View.php';//Incluye la vista de buscar permisos
include '../Views/PERMISO/PERMISO_SHOWALL_View.php';//Incluye la vista de mostrar todos los permisos
include '../Views/PERMISO/PERMISO_ADD_View.php';//Incluye la vista de añadir permisos
include '../Views/PERMISO/PERMISO_ASSIGN_View.php';//Incluye la vista de asignar permisos
include '../Views/PERMISO/PERMISO_DELETE_View.php';//Incluye la vista de borrar permisos
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';//Incluye la vista de mostrar mensaje
//Esta función crea un objeto tipo PERMISO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form(){
	
	
	$IdGrupo = $_REQUEST['IdGrupo'];//Variable que almacena el valor de IdGrupo
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];//Variable que almacena el valor de IdFuncionalidad
	$IdAccion = $_REQUEST['IdAccion'];//Variable que almacena el valor de IdAccion

	$NombreGrupo = $_REQUEST['NombreGrupo'];//Variable que almacena el valor de NombreGrupo
	$NombreFuncionalidad = $_REQUEST['NombreFuncionalidad'];//Variable que almacena el valor de NombreFuncionalidad
	$NombreAccion = $_REQUEST['NombreAccion'];//Variable que almacena el valor de NombreAccion

	$action= $_REQUEST['action'];//Variable que almacena el valor de la acion que indicara el case al que entrará en el switch
	//Variable que almacena un nuevo PERMISO_MODEL con la información recogida
	$PERMISO = new PERMISO_MODEL(
		$IdGrupo,
		$IdFuncionalidad,
		$IdAccion,

		$NombreGrupo,
		$NombreFuncionalidad,
		$NombreAccion
	);
	
	return $PERMISO;
}
//Si no se obtiene valor de IdGrupo le asignamos el valor ''
if ( !isset( $_REQUEST[ 'IdGrupo' ] ) ) {
	$_REQUEST[ 'IdGrupo' ] = '';
}
//Si no se obtiene valor de IdFuncionalidad le asignamos el valor ''
if ( !isset( $_REQUEST[ 'IdFuncionalidad' ] ) ) {
	$_REQUEST[ 'IdFuncionalidad' ] = '';
}
//Si no se obtiene valor de IdAccion le asignamos el valor ''
if ( !isset( $_REQUEST[ 'IdAccion' ] ) ) {
	$_REQUEST[ 'IdAccion' ] = '';
}
//Si no se obtiene valor de NombreGrupo le asignamos el valor ''
if ( !isset( $_REQUEST[ 'NombreGrupo' ] ) ) {
	$_REQUEST[ 'NombreGrupo' ] = '';
}
//Si no se obtiene valor de NombreFuncionalidad le asignamos el valor ''
if ( !isset( $_REQUEST[ 'NombreFuncionalidad' ] ) ) {
	$_REQUEST[ 'NombreFuncionalidad' ] = '';
}
//Si no se obtiene valor de NombreAccion le asignamos el valor ''
if ( !isset( $_REQUEST[ 'NombreAccion' ] ) ) {
	$_REQUEST[ 'NombreAccion' ] = '';
}
//Si no se obtiene valor de action le asignamos el valor ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	//caso añadir tupla
	case 'ADD':
		//Si no recibe datos por POST muestra un formulario de añadir
		if ( !$_POST ) { 
			//Variable que almacena un objeto de USU_GRUPO (modelo) pasandole la información del usuario logeado
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena un boleano, si el usuario conectado es o no el admin
			$ADMIN = $USUARIO->comprobarAdmin();
			//Si es administrador permite crear una vista de un formulario para añadir permisos
			if($ADMIN == true){
				//Variable que almacena un objecto Grupo(modelo)
				$GRUPO = new GRUPO( '', '', '');
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
				//Variable que almacena un objetoc FUNCIONALIDAD(modelo)
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
				//Variable que almacena un array con la información de un grupo con el id pasado como parametro
			    $DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
			    //Variable que almacena un array con las funcionalidades-accion existentes
				$Funcionalidad_accion= $FUNCIONALIDAD->recuperarFuncionalidades();
				//Crea una nueva vista para poder añadir permisos a un grupo
				new PERMISO_ADD($DatosGrupo,$Funcionalidad_accion);
		//Si no es usuario administrador
			}else{
	            $cont=0;//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
				//Variable que almacena un recordset con la info de los permisos que tiene un usuario
				$PERMISO = $USUARIO->comprobarPermisos();
				//Bucle que recorre todo el recordset de los permisos de usuario y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				//Si tiene la funcionalidad de permiso comprueba la la accion
				if($fila['IdFuncionalidad']=='2'){
					//Si tiene la accion para añadir incrementa el contador indicando que tiene el permiso
					if($fila['IdAccion']=='6'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;//Incrementamos $cont
					}
				   } 
				}
				//Si la variable $cont es 1 indica que el usuario tiene permisos
				if($cont==1){
					//Variable que almacena un nuevo objecto GRUPO(modelo)
					$GRUPO = new GRUPO( '', '', '');
					//Variable que almacena un nuevo objecto de PERMISO MODEL
					$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
					//Variable que almacena un nuevo objecto de FUNCIONALIDAD(modelo)
					$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
					//Variable que almacena un array la información de un grupo que corresponde con el IdGrupo pasado como parametro
				    $DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
				     //Variable que almacena un array con las funcionalidades-accion existentes
					$Funcionalidad_accion= $FUNCIONALIDAD->recuperarFuncionalidades();
					//Crea una nueva vista para poder añadir permisos a un grupo
					new PERMISO_ADD($DatosGrupo,$Funcionalidad_accion);
				//Si no tiene permisos se muestra un mensaje de que no tiene permisos
				} else {
					//crea un vista con el mensaje
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
				}
			}
		//Si se reciben datos de POST
		} else {
			//Variable que almacena un objecto PERMISO(modelo) con los datos recogidos
			$PERMISO = get_data_form();
			//Si en la funcionalidad recibimos ',' significa que no hay funcionalidad-accion disponible y mostramos el mensaje informando de ello
			if($_REQUEST['IdFuncionalidad'] == ','){
				//Variable que almacena los datos necesarios para poder volver a la vista anterior concatenandola a la ruta
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( 'No hay funcionalidad-accion disponible', "../Controllers/GRUPO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
			//Si recibimos funcionalidades-acciones
			else{
				//Variable que almacena un array que divide en dos lo recogido con funcionalidad-accion dado que e se pasa tanto Idfuncionalidad y idAccion en la misma variable separada por ','
				$Porciones = explode(',',$_REQUEST['IdFuncionalidad']);
				//Asignamos a la variable IdFuncionalidad el valor de la primera parte que corresponde con el IdFuncionalidad
				$PERMISO->IdFuncionalidad = $Porciones[0];
				//Comprovamos que el tamaño de los datos recogidos es mayor a 0 para evitar offset
				if (strlen($_REQUEST['IdFuncionalidad']) > 0) {
					//Asignamos a la variable IdAccion el valor de la primera parte que corresponde con el IdFuncionalidad
					$PERMISO->IdAccion = $Porciones[1];
				}
				//Variable que almacena la respuesta que viene del método ADD() del modelo PERMISO
				$respuesta = $PERMISO->ADD();
				//Variable que almacena los datos necesarios para poder volver a la vista anterior concatenandola a la ruta
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( $respuesta, "../Controllers/PERMISO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
		}
		break;//fin del case add
	case 'DELETE'://Caso borrar tupla
		//Si no recibe datos por POST muestra un formulario de añadir
		if ( !$_POST ) { 
			//Variable que almacena un objeto de USU_GRUPO (modelo) pasandole la información del usuario logeado
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena un boleano, si el usuario conectado es o no el admin
			$ADMIN = $USUARIO->comprobarAdmin();
			//Si es administrador permite crear una vista de un formulario para borrar permisos
			if($ADMIN == true){
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], $_REQUEST['IdFuncionalidad'], $_REQUEST['IdAccion'], '', '', '');
				//Variable que almacena un recordset con la información de los permisos en una tupla
				$datos = $PERMISO->RellenaDatos();
				//Variable que almacena un array con los atributos a mostrar en la vista delete
				$lista = array('NombreGrupo','NombreFuncionalidad','NombreAccion');
				//Crea una nueva vista permiso delete
				new PERMISO_DELETE($datos,$lista);
		//Si el usuario no es administrador se comprueban los permisos
			}else{
				//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
	            $cont=0;
	            //Variable que almacena un recordset con la info de los permisos que tiene un usuario
				$PERMISO = $USUARIO->comprobarPermisos();
				//Bucle que recorre todo el recordset de los permisos de usuario y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
					//Si tiene la funcionalidad de permiso comprueba la la accion
				if($fila['IdFuncionalidad']=='2'){
					//Si tiene la accion para añadir incrementa el contador indicando que tiene el permiso
					if($fila['IdAccion']=='6'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;//Se aumenta el contador
					}
				   } 
				}
				//Si la variable $cont es 1 indica que el usuario tiene permisos
				if($cont==1){
					//Variable que almacena un objecto de PERMISO_MODEL
					$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], $_REQUEST['IdFuncionalidad'], $_REQUEST['IdAccion'], '', '', '');
					//Variable que almacena un recordset con la información de los permisos en una tupla
					$datos = $PERMISO->RellenaDatos();
					//Variable que almacena un array con los atributos a mostrar en la vista delete
					$lista = array('NombreGrupo','NombreFuncionalidad','NombreAccion');
					//Crea una nueva vista de permiso delete
					new PERMISO_DELETE($datos,$lista);
				//Si no tiene permisos se muestra un mensaje de que no tiene permisos
				} else {
					//Crea una nueva vista de mensaje
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
				}
			}
		//Si se reciben datos por $POST
		} else { 
			//Variable que almacena un objecto de PERMISO(modelo) con la información de los datos recibidos
			$PERMISO = get_data_form();
			//Si en la funcionalidad recibimos ',' significa que no hay funcionalidad-accion disponible y mostramos el mensaje informando de ello
			if($_REQUEST['IdFuncionalidad'] == ','){
				//Variable que almacena los datos necesarios para poder volver a la vista anterior concatenandola a la ruta
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( 'No hay funcionalidad-accion disponible', "../Controllers/GRUPO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
			//Si hay funcionalidades-accion se borra la tupla deseada
			else{
				//Variable que almacena un objecto de PERMISO(modelo) con la información de los datos recibidos
				$PERMISO = get_data_form();
				//Variable que almacena la respuesta que viene del método DELETE() del modelo PERMISO
				$respuesta = $PERMISO->DELETE();
				//Variable que almacena los datos necesarios para poder volver a la vista anterior concatenandola a la ruta
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( $respuesta, "../Controllers/PERMISO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
		}
		break;//fin del caso DELETE
	case 'SEARCH'://Caso buscar tuplas
		//Si no recibe datos por POST muestra un formulario de buscar
		if ( !$_POST ) {
			//Variable que almacena un objeto de USU_GRUPO (modelo) pasandole la información del usuario logeado
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena un boleano, si el usuario conectado es o no el admin
			$ADMIN = $USUARIO->comprobarAdmin();
			//Si es administrador permite crear una vista de un formulario para buscar permisos
			if($ADMIN == true){
				//Crea una nueva vista de formulario buscar
				new PERMISO_SEARCH();
			}else{//Si no es del grupo administrador
				//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
	            $cont=0;
	            //Variable que almacena un recordset con la info de los permisos que tiene el usuario
				$ACL = $USUARIO->comprobarPermisos();
				//Bucle que recorre todo el recordset de los permisos de usuario y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $ACL) ) {
					//Si tiene la funcionalidad de permiso comprueba la la accion
				if($fila['IdFuncionalidad']=='5'){
					//Si tiene la accion para añadir incrementa el contador indicando que tiene el permiso
					if($fila['IdAccion']=='3'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;//Se aumenta el contador
					}
				   }
				}
				//Si la variable $cont es 1 indica que el usuario tiene permisos
				if($cont==1){
				//Crea una nueva vista de formulario buscar
				new PERMISO_SEARCH();
		//Si no tiene permisos se muestra un mensaje de que no tiene permisos
		}else{
			//Crea una vista de mensaje
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PERMISO_CONTROLLER.php' );
		}
			};
		//Si se recibe datos por POST muestra devuelve un recodset con la información y lo muestra en la vista showall
		} else {
			//Variable que almacena un objeto PERMISO(modelo) con los datos recogidos
			$PERMISO = get_data_form();
			//Variable que almacena un recordset con la informacion a buscar en la base de datos
			$datos = $PERMISO->SEARCH2();
			//Variable que almacena un array con los atributos a mostrar en la vista
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			//Variable que almacena un objecto USU_GRUPO(modelo)
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena un booleano, para saber si es administrador o no
			$ADMIN = $USUARIO->comprobarAdmin();
			//Variable que almacena un recordset con la info de los permisos de un usuario
			$ACL = $USUARIO->comprobarPermisos();
			//Si el usuario es administrador se pasa la vista la información de que estamos con el admin 'true'
			if($ADMIN == true){
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new PERMISO_SHOWALL( $lista, $datos,$ACL,true);
			//si no estamos con el administrador la variable a enviar es 'false' que indica que no somos admin
			}else{
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new PERMISO_SHOWALL( $lista, $datos,$ACL,false );	
			}
		}
		break;//fin del case buscar
	case 'ASSIGN'://Caso asignar permisos
		//Variable que almacena un objeto de USU_GRUPO (modelo) pasandole la información del usuario logeado
		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		//Variable que almacena un boleano, si el usuario conectado es o no el admin
		$ADMIN = $USUARIO->comprobarAdmin();
		//Si es administrador seleciona un objecto modelo PERMISO y si no otro objecto de modelo PERMISO
		if($ADMIN == true){
			//Si no se han recibido datos POST se crea un modelo pasando el id de grupo 
			if ( !$_POST ) {
				//Variable que almacena el objecto PERMISO(modelo)
				$PERMISO = new PERMISO_MODEL($_REQUEST['IdGrupo'], '', '', '','','');
			//Si se reciben datos se crea un modelo pasando el id de grupo
			} else {
				//Variable que almacena el objecto PERMISO(modelo)
				$PERMISO = new PERMISO_MODEL($_REQUEST['IdGrupo'], '', '', '','','');
			}
			//Variable que almacena los datos de la busqueda de permisos
			$datos = $PERMISO->SEARCH();
			//Variable que almacena un nuevo ojecto de GRUPO(modelo)
			$GRUPO = new GRUPO( '', '', '');
			//Variable que almacena un array con los datos de un grupo asociado a un IdGrupo
			$DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new PERMISO_ASSIGN( $lista, $datos, $DatosGrupo );
		//Si no es administrador se comprueban los permisos 
		}else{
			//Variable que almacena un objecto USU_GRUPO(modelo)
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;
            //Variable que almacena un recordset con la info de los permisos del usuario
			$ACL = $USUARIO->comprobarPermisos();
			//Bucle que recorre todo el recordset de los permisos de usuario y pasa estos valores a array y los muestra
			while ( $fila = mysqli_fetch_array( $ACL ) ) {
				//Si tiene la funcionalidad de permiso comprueba la la accion
			if($fila['IdFuncionalidad']=='2'){
				//Si tiene la accion para añadir incrementa el contador indicando que tiene el permiso
				if($fila['IdAccion']=='6'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//Se aumenta el contador
				}
			   }
			}
			//Si la variable $cont es 1 indica que el usuario tiene permisos
		if($cont==1){
			//Si no se reciben datos POST
			if ( !$_POST ) {
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
			//Si se reciben datos POST
			} else {
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
			}
			//Variable que almacena un recordset cont todas las tuplas de la tabla PERMISO
			$datos = $PERMISO->SEARCH();
			//Variable que almacena un objecto GRUPO(modelo)
			$GRUPO = new GRUPO( '', '', '');
			//Variable que almacena un array con los datos de un grupo asociado a un IdGrupo
			$DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
			//Variable que almacena un array con los atributos a mostrar en la vista
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			//Crea una vista para asignar permisos
			new PERMISO_ASSIGN( $lista, $datos, $DatosGrupo );
		//Si no tiene permisos se muestra un mensaje de que no tiene permisos
		}else{
			//Crea una vista por defecto
		 	new USUARIO_DEFAULT();
		}
	}											
	break;//Fin del caso ASSING
	default://Caso por defecto
	//Variable que almacena un objeto de USU_GRUPO (modelo) pasandole la información del usuario logeado
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		//Variable que almacena un boleano, si el usuario conectado es o no el admin
		$ADMIN = $USUARIO->comprobarAdmin();
		//Si es administrador 
		if($ADMIN == true){
			//Si no se han recibido datos POST crea un objecto modelo
			if ( !$_POST ) { 
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL('', '', '', '','','');
				//Si se reciben datos crea un objecto modelo
			} else {
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL('', '', '', '','','');
			}
			
			//Variable que almacena los datos de la busqueda
			$datos = $PERMISO->SEARCH2();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion');
			/*$DatosGrupo= $GRUPO->recuperarGrupo('');*/
			$ACL = $USUARIO->comprobarPermisos();
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new PERMISO_SHOWALL( $lista, $datos, /*$DatosGrupo, */$ACL ,true);
		//Si no es administrador comprueba los permisos
		}else{
			//Variable que almacena un nuevo objecto USU_GRUPO (modelo)
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;
            //Variable que almacena un recordset con los permisos del usuario
			$ACL = $USUARIO->comprobarPermisos();
			//Bucle que recorre todo el recordset de los permisos de usuario y pasa estos valores a array y los muestra
			while ( $fila = mysqli_fetch_array( $ACL ) ) {
				//Si tiene la funcionalidad de permiso comprueba la la accion
			if($fila['IdFuncionalidad']=='5'){
				//Si tiene la accion para añadir incrementa el contador indicando que tiene el permiso
				if($fila['IdAccion']=='5'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//Se aumenta el contador
				}
			   }
			}
			//Si la variable $cont es 1 indica que el usuario tiene permisos
		if($cont==1){
			//Si no se reciben datos crea un modelo de PERMISO
			if ( !$_POST ) {
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL( '', '', '', '', '', '');
			//Si se reciben datos crea un modelo de PERMISO
			} else {
				//Variable que almacena un objecto de PERMISO_MODEL
				$PERMISO = new PERMISO_MODEL( '', '', '', '', '', '');
			}
			//Variable que almacena un recordset con todas las tuplas de la tabla permiso
			$datos = $PERMISO->SEARCH2();
			//Variable que almacena un array con los atributos a mostrar en la vista showall
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			//Variable que almacena un recodset con todos los permisos del usuario
			$ACL = $USUARIO->comprobarPermisos();
			//crea una vista de permiso showall
			new PERMISO_SHOWALL( $lista, $datos, /*$DatosGrupo,*/$ACL,false);
		//Si no tiene permisos se muestra la vista por defecto
		}else{
			//crea una nueva vista de por defecto
		 	new USUARIO_DEFAULT();
		}
	}

		
}//final del Controlador


?>

