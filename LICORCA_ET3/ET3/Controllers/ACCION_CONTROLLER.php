<?php
/*
	Archivo php
	Nombre: ACCION_CONTROLLER.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/ACCION_MODEL.php';//incluye el contenido del modelo ACCION_MODEL
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contenido del modelo USU_GRUPO_MODEL
include '../Views/ACCION/ACCION_SHOWALL_View.php';//incluye el contenido de la vista SHOWALL de accion
include '../Views/ACCION/ACCION_SEARCH_View.php';//incluye el contenido de la vista SEARCH de accion
include '../Views/ACCION/ACCION_ADD_View.php';//incluye el contenido de la vista ADD de accion
include '../Views/ACCION/ACCION_EDIT_View.php';//incluye el contenido de la vista EDIT de accion
include '../Views/ACCION/ACCION_DELETE_View.php';//incluye el contenido de la vista DELETE de accion
include '../Views/ACCION/ACCION_SHOWCURRENT_View.php';//incluye el contenido de la vista SHOWCURRENT de accion
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';//incluye el contendio de la vista MESSAGE


//Esta función crea un objeto tipo ACCION_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form(){
	
	
	$IdAccion = $_REQUEST['IdAccion'];//Variable que almacena el valor de IdAccion
	$NombreAccion = $_REQUEST['NombreAccion'];//Variable que almacena el valor de NombreAccion
	$DescripAccion = $_REQUEST['DescripAccion'];//Variable que almacena el valor de DescripAccion
	$action= $_REQUEST['action'];//Variable que almacena el valor de action
	//Variable que almacena un modelo de ACCION
	$ACCION = new ACCION(
		$IdAccion,
		$NombreAccion,
		$DescripAccion
	);
		//Devuelve el valor del objecto model creado
	return $ACCION;
}


//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			//Variable que almacena un recordset de los permisos del usuario
			$ADMIN = $USUARIO->comprobarAdmin();
			//si el usuario es administrador mostramos la vista ADD
			if($ADMIN == true){
				//Crea una vista con el formulario add
				new ACCION_ADD();
			//si no es administrador
			}else{
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;
            //Variable que almacena un recodset con los permisos del usuario
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a la función comprobarPermisos para saber los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='4'){//miramos si este usuario tiene la funcionalidad de Gestión de acciones
				if($fila['IdAccion']=='0'){//miramos si este usuario tiene la acción de añadir
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//si se cumple estos if incrementamos el contador a uno
				}
			   }
			}
			if($cont==1){//miramos si la variable contador es 1, si es así mostramos la vista ADD
			new ACCION_ADD();
		}else{//si no es igual a unose muestra un mensaje de que este usuario no tiene dichos permisos
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de ACCION_MODEL inserta los datos
			$ACCION = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $ACCION->ADD();//Variable que almacena la respuesta de la inserción
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );//Crea la vista con la respuesta y la ruta para volver
		}
		break;//Finaliza el bloque
	case 'DELETE'://caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que almacena un ojecto USU_GRUPO(modelo)
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			//Variable que almacena un booleano de si es administrador o no el usuario
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			
			if($ADMIN == true){//miramos si el usuario es administrador
            //Variable que almacena un objecto ACCION(modelo)
            $ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');//se crea un objeto del modelo ACCION
            //Variable que almacena el relleno de los datos utilizando el IdAccion
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ]);
			//Variable que almacena las dependencias que tiene accion a la hora de borrar
			$dependencias = $ACCION->dependencias( $_REQUEST[ 'IdAccion' ]);
			new ACCION_DELETE( $valores, $dependencias );//se crea una vista de borrado de acción
			}else{//miramos si el usuario no es administrador
	            //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
	            $cont=0;//instanciamos la variable cont a 0
				//Variable que almacena un recordset con los permisos del usuario
				$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
				if($fila['IdFuncionalidad']=='4'){//miramos si este usuario tiene la funcionalidad de Gestión de Accion
					if($fila['IdAccion']=='1'){//miramos si el usuario tiene la acción para borrar
				    
				     $cont=$cont+1;//incrementamos la variable cont a uno
					}
				   }
				}
			if($cont==1){//si la variable cont es igual a uno
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');//Variable que recoge un objecto model con solo el IdAccion
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ]);//Variable que almacena el relleno de los datos utilizando el IdAccion
			$dependencias = $ACCION->dependencias( $_REQUEST[ 'IdAccion' ]);//mostramos todas las dependencias que tiene  tabla ACCION a la hora de realizar el borrado  
			new ACCION_DELETE( $valores, $dependencias );//Crea una vista delete para ver la tupla
		}else{//si cont no es igual a uno muestra un mensaje de que el usuario no tiene dicho permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}

		} else {//Si recibe datos los recoge y mediante las funcionalidad de ACCION_MODEL borra los datos
			$ACCION = get_data_form();//Variable que almacena los datos recogidos de los atributos
			$respuesta = $ACCION->DELETE();//Variable que almacena la respuesta de realizar el borrado
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );//crea una vista mensaje con la respuesta y la dirección de vuelta
		}
		break;//finaliza el bloque
	case 'EDIT'://caso editar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objecto de modelo USU_GRUPO	
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			//Variable que almacena un recordset con todos los permisos del usuario
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//miramos si el usuario es administrador
				//Variable que almacena un objecto ACCION(modelo)
				$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');//se crea un objeto del modelo ACCION
				$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] ); //Variable que almacena el relleno de los datos utilizando el login
				new ACCION_EDIT( $valores );//se crea una vista de edit de acción
			}else{//miramos si el usuario no es administrador
            //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//instanciamos la variable cont a 0
			//Variable que almacena un recordset con los permisos del usuario
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='4'){//miramos si este usuario tiene la funcionalidad de Gestión de Accion
				if($fila['IdAccion']=='2'){//miramos si el usuario tiene la acción para editar
			    
			     $cont=$cont+1;//incrementamos cont a uno
				}
			   }
			}
			if($cont==1){//si la variable cont es igual a uno
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');//Variable que recoge un objecto model con solo el IdAccion
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );//Variable que almacena el relleno de los datos utilizando el IdAccion
			new ACCION_EDIT( $valores );//Crea una vista EDIT para ver la tupla
		}else{//si cont no es igual a uno muestra un mensaje de que el usuario no tiene dicho permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}

		} else {//Si recibe datos los recoge y mediante las funcionalidad de ACCION_MODEL edita los datos
			$ACCION = get_data_form();//Variable que almacena los datos recogidos de los atributos
			$respuesta = $ACCION->EDIT();//se crea una vista de edit de acción
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );//crea una vista mensaje con la respuesta y la dirección de vuelta
		}
		break;//Finaliza el bloque
	case 'SEARCH'://caso buscar
		//Variable que almacena un objecto del modelo USU_GRUPO
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			//Variable que almacena un recordset con los permisos del usuario
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//miramos si el usuario es administrador
				new ACCION_SEARCH();//se crea una vista de SEARCH de acción
			}else{//miramos si el usuario no es administrador
            //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//intanciamos la variabel cont a 0.
			//Variable que almacena un recordset con los permisos del usuario
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='4'){//miramos si este usuario tiene la funcionalidad de Gestión de Accion
				if($fila['IdAccion']=='3'){//miramos si el usuario tiene la acción para buscar
			   
			     $cont=$cont+1;//incrementamos cont a uno
				}
			   }
			}
			if($cont==1){//si la variable cont es igual a uno
			new ACCION_SEARCH();//se crea una vista de search de acción
		}else{//si cont no es igual a uno muestra un mensaje de que el usuario no tiene dicho permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de ACCION_MODEL edita los datos
			//Variable que almacena un recordset con los permisos del usuario
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			//Variable que almacena un booleano indicando si es admin o no
			$ADMIN = $USUARIO->comprobarAdmin();//comprobamos si es administrador el usuario
			
			$ACCION = get_data_form();//Variable que almacena los datos recogidos de los atributos
			
			$datos = $ACCION->SEARCH();//Variable que almacena los datos de realizar el borrado
			//Variable que almacena un array con los atributos a mostrar en la vista
			$lista = array( 'NombreAccion','DescripAccion' );//campos que apareceran en la tabla
			if($ADMIN == true){//si el usuario es administrador mostramos  una vista showall con todos los iconos y permisos
				new ACCION_SHOWALL( $lista, $datos,$PERMISO,true );//se muestra una tabla SHOWALL con los datos que se buscaron
			}else{//en caso de que no sea administrador no se le mostrará los demás iconos y permisos.
				new ACCION_SHOWALL( $lista, $datos,$PERMISO,false );//se muestra una tabla SHOWALL con los datos que se buscaron
			}
			
		}
		break;//Finaliza el bloque
	case 'SHOWCURRENT'://caso ver en detalle
			//Variable que almacena un objecto USU_GRUPO
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			//Variable que almacena un recordset de los permisos de un usuario
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//miramos si el usuario es administrador
			//Variable que almacena un ojeto tipo ACCION(modelo)
			$ACCION= new ACCION( $_REQUEST[ 'IdAccion' ], '', '');//se crea un objeto de tipo ACCION
		    $valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] ); //Variable que almacena el relleno de los datos utilizando el IdAccion
		    new ACCION_SHOWCURRENT( $valores );//se crea una vista de showcurrent de acción
			}else{//si el usuario no es administrador
            //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//instaciamos cont a 0
			//Variable que almacena un recordset de los permisos de un usuario
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='4'){//miramos si este usuario tiene la funcionalidad de Gestión de Accion
				if($fila['IdAccion']=='4'){//miramos si el usuario tiene la acción de ver en detalle
			    
			     $cont=$cont+1;//incrementamos cont a uno
				}
			   }
			}
			if($cont==1){//si la variable cont es igual a uno
		    $ACCION= new ACCION( $_REQUEST[ 'IdAccion' ], '', '');//Variable que almacena un objeto de tipo ACCION
		    $valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );//Variable que almacena el relleno de los datos utilizando el IdAccion
		    new ACCION_SHOWCURRENT( $valores );//se crea una vista de showcurrent de acción
		}else{//si cont no es igual a uno muestra un mensaje de que el usuario no tiene dicho permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}
		break;//Finaliza el bloque
	default://caso por defecto con vista SHOWALL

		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si este usuario es administrador
			if($ADMIN == true){//miramos si el usuario es administrador
				if ( !$_POST ) {//Si no se han recibido datos 
			//Variable que almacena un ojecto ACCION(modelo)
			$ACCION = new ACCION( '', '', '');
		//Si se reciben datos
		} else {//Si recibe datos los recoge
			//Variable que almacena un objecto ACCION(modelo) con todos los datos recogidos
			$ACCION = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ACCION->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array('NombreAccion','DescripAccion');
		//Variable que almacena un recordset de todos los permisos del usuario
		$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ACCION_SHOWALL( $lista, $datos,$PERMISO,true);
			}else{//si el usuario no es administrador
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena objeto del modelo USU_GRUPO pasandole el usuario que está conectado
            //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//instanciamos cont a 0
			//Variable que almacena un recordset con todos los permisos del usuario
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='4'){//miramos si este usuario tiene la funcionalidad de Gestión de Accion
				if($fila['IdAccion']=='5'){//miramos si este usuario tiene la accion showall
			    
			     $cont=$cont+1;//increntamos cont a uno
				}
			   }
			}
			if($cont==1){//si la variable cont es igual a uno
		if ( !$_POST ) {//Si no se han recibido datos 
			//Variable que almacena un ojecto ACCION (modelo)
			$ACCION = new ACCION( '', '', '','');
		//Si se reciben datos
		} else {//Si recibe datos los recoge
			//Variable que almacena un ojecto(modelo) con todos los datos recogidos
			$ACCION = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ACCION->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'NombreAccion','DescripAccion');
		//Variable que almacena un recordset con todos los permisos del usuario
		$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ACCION_SHOWALL( $lista, $datos,$PERMISO,false);
		}else{//si la variable cont no es igual a uno mostramos una vista por defecto que no tiene nada
		 //Crea una nueva vista default
		 new USUARIO_DEFAULT();
		}
			}
}

?>