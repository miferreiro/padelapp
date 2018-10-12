<?php
/*
	Archivo php
	Nombre: TRABAJO_CONTROLLER.php
	Autor: 	Brais Rdodríguez
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas de la tabla TRABAJO
*/

session_start();//solicito trabajar con la sesión
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/TRABAJO_MODEL.php';//incluye el contendio del modelo TRABAJO_MODEL
include '../Functions/permisosAcc.php';//incluye el contendio de la función permisosAcc
include '../Views/TRABAJO/TRABAJO_SHOWALL_View.php';//incluye el contendio de la vista SHOWALL de TRABAJO
include '../Views/TRABAJO/TRABAJO_SEARCH_View.php';//incluye el contendio de la vista SEARCH de TRABAJO
include '../Views/TRABAJO/TRABAJO_ADD_View.php';//incluye el contendio de la vista ADD de TRABAJO
include '../Views/TRABAJO/TRABAJO_EDIT_View.php';//incluye el contendio de la vista EDIT de TRABAJO
include '../Views/TRABAJO/TRABAJO_DELETE_View.php';//incluye el contendio de la vista DELETE de TRABAJO
include '../Views/TRABAJO/TRABAJO_SHOWCURRENT_View.php';//incluye el contendio de la vista SHOWCURRENT de TRABAJO
include '../Views/DEFAULT_View.php';//incluye el contendio de la vista  por defecto que no muestra nada
include '../Views/MESSAGE_View.php';//incluye el contenido de una vista que te muestra un mensaje de la base de datos


//Esta función crea un objeto tipo TRABAJO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo'];//Variable que almacena el valor de IdTrabajo
	$NombreTrabajo = $_REQUEST['NombreTrabajo'];//Variable que almacena el valor de NombreTrabajo
	$FechaIniTrabajo = $_REQUEST['FechaIniTrabajo'];//Variable que almacena el valor de FechaIniTrabajo
	$FechaFinTrabajo = $_REQUEST['FechaFinTrabajo'];//Variable que almacena el valor de FechaFinTrabajo
    $PorcentajeNota = $_REQUEST['PorcentajeNota'];//Variable que almacena el valor del porcentaje de la nota
	$action= $_REQUEST['action'];//Variable que almacena la acción
	//Variable que almacena el modelo de TRABAJO
	$TRABAJO = new TRABAJO(
		$IdTrabajo,
		$NombreTrabajo,
		$FechaIniTrabajo,
		$FechaFinTrabajo,
        $PorcentajeNota
	);//Se crea un objeto de clase TRABAJO con los atributos llegados del formulario
	
	return $TRABAJO;//Devuelve el valor del objecto model creado
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {//Si la variable action no tiene contenido le asignamos ''
	$_REQUEST[ 'action' ] = '';
}

//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			if(permisosAcc($_SESSION['login'],11,0)==true){//miramos si el usuario tiene dichos permisos
			new TRABAJO_ADD(); //mostramos la vista ADD de TRABAJO
			}else{//si el usuario no tiene dicho permiso, se muestra un mensaje indicandolo
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {//Si recibe datos los recoge y mediante la funcionalidad de TRABAJO_MODEL inserta los datos
			$TRABAJO = get_data_form();//Variable que almacena los datos recogidos
            $porcentajeTotal = $TRABAJO->obtenerPorcentajeTotal();//Variable que almacena la repuesta de la función para tener el porcentaje total de todos los trabajos
            $percent = $porcentajeTotal[0] + $_REQUEST['PorcentajeNota'];//Variable que almacena la suma de los porcentajes
            if($percent > 100){//miramos si el porcentaje supera el 100%, si es asi se muestra un mensaje indicandolo
                new MESSAGE ('El porcentaje introducido es incorrecto, el porcentaje total de los trabajos no debe superar el 100%', '../Controllers/TRABAJO_CONTROLLER.php');
            }
            else{//si el porcentaje no es mayor que 100%
			 $respuesta = $TRABAJO->ADD();//Variable que almacena la repuesta de insertar el trabajo y muestra un mensaje
			 new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
            }
		}
		break;//Finaliza el bloque
	case 'DELETE'://caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if(permisosAcc($_SESSION['login'],11,1)==true){//miramos si el usuario tiene dichos permisos
			$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');//Variable que almacena un objeto de tipo TRABAJO
			$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ]);//Variable que almacena un recordset con todos los valores relacionados con IdTrabajo
            
            //Variable que almacena todas las depencias de TRABAJO a la hora de borrar
			$dependencias = $TRABAJO->dependencias( $_REQUEST[ 'IdTrabajo' ]);
			 //Variable que almacena todas las depencias de TRABAJO a la hora de borrar
			$dependencias2 = $TRABAJO->dependencias2( $_REQUEST[ 'IdTrabajo' ]);
			 //Variable que almacena todas las depencias de TRABAJO a la hora de borrar
			$dependencias3 = $TRABAJO->dependencias3( $_REQUEST[ 'IdTrabajo' ]);
			 //Variable que almacena todas las depencias de TRABAJO a la hora de borrar
			$dependencias4 = $TRABAJO->dependencias4( $_REQUEST[ 'IdTrabajo' ]);
			 //Variable que almacena todas las depencias de TRABAJO a la hora de borrar
			$dependencias5 = $TRABAJO->dependencias5( $_REQUEST[ 'IdTrabajo' ]);
			new TRABAJO_DELETE( $valores, $dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5 );//se muestra la vista DELETE de TRABAJO
			}else{//si el usuario no tiene dicho permiso, muestra el mensaje en una vista
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}				
		} else { //Si recibe datos los recoge y mediante la funcionalidad de TRABAJO_MODEL borra los datos
			$TRABAJO = get_data_form();//Variable que almacena un objecto TRABAJO(modelo) con los datos recogidos
			$respuesta = $TRABAJO->DELETE();//Variable que almacena la respuesta de elimninar los datos
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );//mostramos el mensaje tras la eliminación
		}
		break;//Finaliza el bloque
	case 'EDIT'://caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],11,2)==true){	//miramos si el usuario tiene dichos permisos		
			$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');//Variable que almacena un TRABAJO con un IdTrabajo que pasamos
			$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] );//Variable que almacena un recordset con los valores relacionados con IdTrabajo
			new TRABAJO_EDIT( $valores );//muestra una vista EDIT
			}else{//Si el usuario no tiene dicho permiso , se le va a mostrar con un mensaje en una vista
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {//Si recibe datos los recoge y mediante la funcionalidad de TRABAJO_MODEL edita los datos
			$TRABAJO = get_data_form();//Variable que almacena un objeto de tipo TRABAJO_MODEL con los valores correspondientes
            $porcentajeTotal = $TRABAJO->obtenerPorcentajeTotal();//Variable que almacena el porcemtaje total de todos los trabajos
            $porcentajeAntiguo = $TRABAJO->obtenerPorcentaje($_REQUEST[ 'IdTrabajo' ]);//Variable que almacena el porcentaje antiguo de los trabajos
            $percentTemp = $porcentajeTotal [0] - $porcentajeAntiguo[0];//Variable que almacena la diferencia de porcentajes
            $percent = $percentTemp + $_REQUEST['PorcentajeNota'];//Variable que almacena el porcentaje total
            if($percent > 100){//si el porcentaje supera l 100% muestra un mensaje de que no es posible
                new MESSAGE ('El porcentaje introducido es incorrecto, el porcentaje total de los trabajos no debe superar el 100%', '../Controllers/TRABAJO_CONTROLLER.php');
            }
            else{//si no supera el 100%
			$respuesta = $TRABAJO->EDIT();//Variable que almacena la repuesta de editar los datos
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );//muestra un mensaje de que fue editado
		  }
        }
		break;//Finaliza el bloque
	case 'SEARCH'://caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],11,3)==true){//miramos si el usuario tiene permisos
			new TRABAJO_SEARCH();//si lo tiene muestra la vista SEARCH
			}else{//si el usuario no tiene permisos, muestra un mensaje indicandolo
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {//Si recibe datos los recoge y mediante la funcionalidad de TRABAJO_MODEL busca los datos
			$TRABAJO = get_data_form();//lVariable que almacena un objeto de tipo TRABAJO_MODEL con los valores correspondientes
			$datos = $TRABAJO->SEARCH();//Variable que almacena el trabajo correspondiente 
			$lista = array( 'NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo' );//Variable que almacena un array los campos que queremos mostrar
			new TRABAJO_SHOWALL( $lista, $datos );//muestra una vista SHOWALL del TRABAJO buscado
		}
		break;//Finaliza el bloque
    case 'SHOWCURRENT'://caso ver en detalle
			if(permisosAcc($_SESSION['login'],11,4)==true){//miramos si el usuario tiene dichos permisos
		$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');//Variable que almacena un objeto TRABAJO pasandole un IdTrabajo correspondiente
		$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] );//Variable que almacena un recordset de los valores relacionados con dicho trabajo
		new TRABAJO_SHOWCURRENT( $valores );//se muestra la vista en detalle con el trabajo elegido
			}else{//si el usuario no tiene dicho permiso se le indica en un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		break;//Finaliza el bloque
	default://caso por defecto
	if(permisosAcc($_SESSION['login'],11,5)==true ){//miramos si el usuario tiene dichos permisos
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SHOWALL
			$TRABAJO = new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO para buscar todos los trabajos
		} 
        else {//Si recibe datos los recoge y mediante la funcionalidad de TRABAJO_MODEL muestra  los datos.
			$TRABAJO = get_data_form();//Variable que almacena un objeto de tipo TRABAJO_MODEL con los valores correspondientes
		}
		$datos = $TRABAJO->SEARCH();//Variable que almacena todos los trabajos
		$lista = array('NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo' );//Variable que almacena un array todos los campos que queremos mostrar
		new TRABAJO_SHOWALL( $lista, $datos );//muestra una vista SHOWALL con todos los trabajos
		}else{//si el usuario no tiene dicho permiso se muestra una vista por defecto sin nada
		
			new USUARIO_DEFAULT();
		
		}
}

?>