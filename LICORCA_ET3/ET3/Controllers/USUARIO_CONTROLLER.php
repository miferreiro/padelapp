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
include '../Models/USU_GRUPO_MODEL.php';//incluye el contendio del modelo usuarios grupo
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
	$dni = $_REQUEST[ 'DNI' ]; //Variable que almacena el valor de dni
	$nombre = $_REQUEST[ 'nombre' ]; //Variable que almacena el valor de nombre
	$apellidos = $_REQUEST[ 'apellidos' ]; //Variable que almacena el valor de apellidos
	$correo = $_REQUEST[ 'email' ]; //Variable que almacena el valor de correo
	$direccion = $_REQUEST[ 'direc' ]; //Variable que almacena el valor de direccion
	$telefono = $_REQUEST[ 'telefono' ]; //Variable que almacena el valor de telefono
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de USUARIO
	$USUARIO = new USUARIO_MODEL(
		$login,
		$password,
		$dni,
		$nombre,
		$apellidos,
		$correo,
		$direccion,
		$telefono
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista ADD
				new USUARIO_ADD();
			}else{//si no es administrador
           //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
           $cont=0;//iniciamos la variable a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de Gestión de usuarios
				if($fila['IdAccion']=='0'){//miramos si este usuario tiene la acción de añadir
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//si se cumple estos if incrementamos el contador a uno
				}
			   } 
			}
			if($cont==1){//miramos si la variable contador es 1, si es así mostramos la vista ADD
			new USUARIO_ADD();
			}else{//si no es igual a unose muestra un mensaje de que este usuario no tiene dichos permisos
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacenas un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano para saber si este usuario es administrador
			if($ADMIN == true){//miramos si este usuario es administrador
			//Variable que recoge un objecto model con solo el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			
            
            $dependencias = $USUARIO->dependencias($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias2 = $USUARIO->dependencias2($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias3 = $USUARIO->dependencias3($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias4 = $USUARIO->dependencias4($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias5 = $USUARIO->dependencias5($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias6 = $USUARIO->dependencias6($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias7 = $USUARIO->dependencias7($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
                
            //Crea una vista delete para ver la tupla
			new USUARIO_DELETE( $valores,$dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5, $dependencias6, $dependencias7 );
			}else{//si el usuario no es administrador
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;//inicializamos la variable cont a 0.
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene dicho usuario
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de Gestión de Usuarios
				if($fila['IdAccion']=='1'){//miramos si el usuario tiene la acción para borrar
			   
			     $cont=$cont+1;//incrementamos la variable cont a uno
				}
			  }
			}
			if($cont==1){//si la variable cont es igual a uno
			//Variable que recoge un objecto model con solo el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			
              
            $dependencias = $USUARIO->dependencias($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias2 = $USUARIO->dependencias2($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias3 = $USUARIO->dependencias3($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias4 = $USUARIO->dependencias4($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias5 = $USUARIO->dependencias5($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias6 = $USUARIO->dependencias6($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
			$dependencias7 = $USUARIO->dependencias7($_REQUEST['login']);//Variable que almacena las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
                
            //Crea una vista delete para ver la tupla
			new USUARIO_DELETE($valores, $dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5, $dependencias6,$dependencias7 );
			}else{//si la variable cont no es uno mostramos un mensaje diciendo que dicho usuario no tiene permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si el usuario es administrador
			if($ADMIN == true){//si es el usuario es administrador
						//Variable que almacena un objeto USUARIO model con el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena un objecto USUARIO(modelo) con los datos de los atibutos rellenados a traves de login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );

			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores);
			}else{//si el usuaio no es administrador inicializamos la variable cont a 0.
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle va a seguir mientras haya permisos

			if($fila['IdFuncionalidad']=='1'){//mira si este usuario tiene la funcionalidad de gestion de usuarios
				if($fila['IdAccion']=='2'){//mira si este usuario tiene la acción de editar
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//Incrementamos cont
				}
			   }
			}
			//Si se han encontado que el usuario tiene esos permisos
			if($cont>=1){
			//Variable que almacena un objeto model USUARIO con el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores);
			}else{//si la variable cont no es mayor o igual a uno muestra una vista diciendo que el usuario no tiene dichos permisos
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el login del usuario conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano para saber si el usuario conectado es administrador
			if($ADMIN == true){//miramos si es administrador, si lo es, nos muestra la vista SEARCH
				new USUARIO_SEARCH();
			}else{//si no es administrador el usuario
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;//instanciamos la variable cont a 0.
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos tiene el usuario
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos

			if($fila['IdFuncionalidad']=='1'){//mira si el usuario tiene la funcionalidad de gestión de usuarios
				if($fila['IdAccion']=='3'){//mira si el usuario tiene la acción de buscar
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//incrementa la variable cont a 1.
				}
			   }
			}
			if($cont>=1){//si la variable con es mayor o igual a uno muestra la vista search, ya que tiene dichos permisos
			new USUARIO_SEARCH();
			}else{//en caso de que no tenga dichos permisos se muestra una vista diciendo que este usuario no tiene dichos permisos
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
		//Si se reciben datos	
		} else {
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene dicho usuario
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano para saber si es administrador el usuario
			//Variable que almacena los datos recogidos de los atributos
			$USUARIO = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $USUARIO->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			if($ADMIN == true){//si el usuario es administrador mostramos  una vista showall con todos los iconos y permisos
				new USUARIO_SHOWALL( $lista, $datos,$PERMISO,true );
			}else{//en caso de que no sea administrador no se le mostrará los demás iconos y permisos.
				new USUARIO_SHOWALL( $lista, $datos,$PERMISO,false );
			}
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si es administrador el usuario
			if($ADMIN == true){//miramos si el usuario es administrador
					//Variable que almacena un objeto USUARIO model con el login
		           $USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		           $valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
		           //Creación de la vista showcurrent
		           new USUARIO_SHOWCURRENT( $valores );
			}else{//en el caso de que no sea administrador
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;//instanciamos la variabel cont a 0.
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene dicho usuario
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos
	
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de gestión de usuarios
				if($fila['IdAccion']=='4'){//miramos si este usuario tiene la acción showcurrent
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//incrementamos cont a uno
				}
			   }
			}
			if($cont>=1){//miramos si cont es mayor o igual a uno
		//Variable que almacena un objeto model con el login
		$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
		//Creación de la vista showcurrent
		new USUARIO_SHOWCURRENT( $valores );
		}else{//si cont no es mayor o igual a uno nos muestra un mensaje de que el usuario no tiene dichos permisos
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
		}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		$USER = new USU_GRUPO(  $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		$ADMIN = $USER->comprobarAdmin();//Variable que almacena un booleano de si es administrador el usuario
			if($ADMIN == true){//miramos si el usuario es administrador
				if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIO = new USUARIO_MODEL( '', '', '', '', '', '', '', '');//Variable que almacena la un objeto del modelo USUARIO
		//Si se reciben datos
		} else {
			$USUARIO = get_data_form();//Variable que almacena los valores de un objeto USUARIO_MODEL
		}
		//Variable que almacena los datos de la busqueda
		$datos = $USUARIO->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
		//Variable que almacena los permisos del usuario
		$PERMISO = $USER->comprobarPermisos();
		new USUARIO_SHOWALL( $lista, $datos, $PERMISO,true);//nos muestra una vista showall con todos los permisos
			}else{//en el caso de que el usuario no sea administrador
		//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
		$cont=0;//instanciamos el contador a 0.
		$PERMISO = $USER->comprobarPermisos();//Variable que almacena los permisos de este usuario
		while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos

			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de gestión de usuarios
				if($fila['IdAccion']=='5'){//mira si el usuario tiene la acción de buscar
			   
			     $cont=$cont+1;//incrementamos el cont a uno
				}
			   }
			}
			if($cont>=1){//miramos si cont es mayor o igual a uno
		if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIO = new USUARIO_MODEL( '', '', '', '', '', '', '', '');//Variable que almacena la intancia de un objeto del modelo USUARIO
		//Si se reciben datos
		} else {
			$USUARIO = get_data_form();//Variable que almacena los valores de un objeto USUARIO_MODEL
		}
		//Variable que almacena un recordset con el resultado de los datos de la busqueda
		$datos = $USUARIO->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
		//Variable que almacena los permisos del usuario
		$PERMISO = $USER->comprobarPermisos();
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new USUARIO_SHOWALL( $lista, $datos, $PERMISO,false);

   }else{//en el caso de que el usuario no tenga permisos le sale una vista vacía
				new USUARIO_DEFAULT();
			}
			}
}

?>