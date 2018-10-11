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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano para saber si un usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista ADD
				new GRUPO_ADD();
			}else{//si el usuario no es administrador
             //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='2'){//mira si este usuario tiene la funcionalidad de gestión de grupos
				if($fila['IdAccion']=='0'){//mira si este usuario tiene la acción de añadir
			    
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont==1){//miramos si el usuario tiene permiso, si lo tiene mostramos la vista ADD de GRUPO
			new GRUPO_ADD();
		}else{//si el usuario no tiene permiso,mostramos un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si el usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista DELETE
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
			}else{//si el usuario no es administrador
             //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='2'){//mira si este usuario tiene la funcionalidad de gestión de grupos
				if($fila['IdAccion']=='1'){//mira si este usuario tiene la acción de borrar
			   
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont==1){//si la variable cont es 1, es decir, si el usario tiene dicho permiso
			
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '');//Variable que recoge un objecto model con solo el idgrupo
			
			$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );//Variable que almacena el relleno de los datos utilizando el IdGrupo
			$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );//Variable que almacena el relleno de los datos utilizando el IdGrupo
                
                
            $dependencias = $GRUPOS->dependencias($_REQUEST['IdGrupo']);//Variable que almacena las dependencias de la tabla GRUPO a la hora de borrar  
            $dependencias2 = $GRUPOS->dependencias2($_REQUEST['IdGrupo']);//Variable que almacena las dependencias de la tabla GRUPO a la hora de borrar  
			
			$lista = array( 'login', 'IdGrupo');//Variable que almacena array con el nombre de los atributos
			
			new GRUPO_DELETE( $valores, $valores2, $lista, $dependencias, $dependencias2);//Crea una vista delete para ver la tupla
		}else{//si el usuario no tiene permiso para borrar, se muestra un mensaje indicando que no tiene dicho permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si un usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista EDIT
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '');//Variable que recoge un objecto model con solo el idgrupo
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );//Variable que almacena el relleno de los datos utilizando el IdGrupo
			
			new GRUPO_EDIT( $valores);//Muestra la vista del formulario editar
			}else{//Si el usuario no es administrador
             //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='2'){//mira si este usuario tiene la funcionalidad de gestión de grupos
				if($fila['IdAccion']=='2'){//mira si este usuario tiene la acción de editar
			   
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont==1){//si la variable cont es 1, es decir, si el usario tiene dicho permiso
			//Variable que almacena un objeto model con el IdGrupo
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de IdGrupo
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
			//Muestra la vista del formulario editar
			new GRUPO_EDIT( $valores);
		}else{//si el usuario no tiene dicho permiso, se muestra un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista SEARCH
            new GRUPO_SEARCH();
			}else{//Si el usuario no es administrador
             //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='2'){//mira si este usuario tiene la funcionalidad de gestión de grupos
				if($fila['IdAccion']=='3'){//mira si este usuario tiene la acción de buscar
			   
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont==1){//si la variable cont es 1, es decir, si el usario tiene dicho permiso
			new GRUPO_SEARCH();//mostramos la vista SEARCH de GRUPO
		}else{//si el usuario no tiene dicho permiso, mostramos un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}
			
		} else {//Si se reciben datos
			//Variable que almacena los datos recogidos de los atributos
			$GRUPOS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $GRUPOS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','DescripGrupo');
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si este usuario es administrador
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			if($ADMIN == true){//si el usuario es administrador mostramos la vista SHOWALL
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new GRUPO_SHOWALL( $lista, $datos,$PERMISO,true);
			}else{
			new GRUPO_SHOWALL( $lista, $datos,$PERMISO,false );	//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			}
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si este usuario es administrador
			if($ADMIN == true){//miramos si este usuario es administrador
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
			}else{//si el usuario no es administrador
             //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='2'){//mira si este usuario tiene la funcionalidad de gestión de grupos
				if($fila['IdAccion']=='4'){//mira si este usuario tiene la acción de ver en detalle
			   
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont==1){//si la variable cont es 1, es decir, si el usario tiene dicho permiso
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
		}else{//si el usuario no tiene dicho permiso, se le indica en un mensaje
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		$ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena un booleano de si este usuario es administrador
			if($ADMIN == true){//miramos si este usuario es administrador
				if ( !$_POST ) {//Si no se han recibido datos 
			$GRUPOS = new GRUPO( '', '', '', '');//Variable que almacena un objeto de tipo GRUPO
		
		} else {//Si se reciben datos
			$GRUPOS= get_data_form();//Variable que almacena un objecto GRUPO con los datos recogidos de los atributos
		}
		//Variable que almacena los datos de la busqueda
		$datos = $GRUPOS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array('NombreGrupo','DescripGrupo');
		//Variable que almacena los permisos de un usuario
		$PERMISO = $USUARIO->comprobarPermisos();//llamamos a la función comprobarPermisos para saber los permisos que tiene el usuario
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new GRUPO_SHOWALL( $lista, $datos,$PERMISO,true );
			}else{//si el usuario no es administrador
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
             //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='2'){//mira si este usuario tiene la funcionalidad de gestión de grupos
				if($fila['IdAccion']=='5'){//mira si este usuario tiene la acción de showall
			   
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont==1){//si la variable cont es 1, es decir, si el usuario tiene el permiso showall
		if ( !$_POST ) {//Si no se han recibido datos 
			$GRUPOS = new GRUPO( '', '', '','');//creamos un objeto de tipo GRUPO
		
		} else {//Si se reciben datos
			$GRUPOS = get_data_form();//Variable que almacena un objecto GRUPO(modelo) los datos recogidos de los atributos
		}
		//Variable que almacena los datos de la busqueda
		$datos = $GRUPOS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'NombreGrupo','DescripGrupo');
		$PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene el usuario
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new GRUPO_SHOWALL( $lista, $datos,$PERMISO,false );
		}else{//si el usuario no tiene el permiso de showall se muestra una vista por defecto que no tiene nada
		 new USUARIO_DEFAULT();
		}
			}
}

?>