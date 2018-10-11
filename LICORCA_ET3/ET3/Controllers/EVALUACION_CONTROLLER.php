
<?php
/*
	Archivo php
	CorrectoA: EVALUACION_CONTROLLER.php
	Autores:Brais Rodriguez,Brais Santos,Alex Vila,Miguel Ferreiro
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas de la tabla EVALUACION
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/HISTORIA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Functions/permisosAcc.php';//incluye el contendio de la vista permisosAcc
include '../Views/EVALUACION/EVALUACION_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA/ENTREGA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/EVALUACION/EVALUACION_SEARCH_View.php'; //incluye la vista search
include '../Views/EVALUACION/EVALUACION_ADD_View.php'; //incluye la vista add
include '../Views/EVALUACION/EVALUACION_EDIT_View.php'; //incluye la vista edit
include '../Views/EVALUACION/EVALUACION_DELETE_View.php'; //incluye la vista delete
include '../Views/EVALUACION/EVALUACION_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje
include '../Views/EVALUACION/EVALUACION_MOSTRAR_CORRECCION_ET_View.php';//incluye el contendio de la vista CORRECION_ENTREGA
include '../Views/EVALUACION/EVALUACION_RESULTADOS_ENTREGAS_View.php';//incluye el contendio de la vista
include '../Views/EVALUACION/EVALUACION_RESULTADO_QA_View.php'; //incluye el contendio de la vista CORRECION_QA
include '../Views/EVALUACION/EVALUACION_RESULTADOS_QAS_View.php'; //incluye el contendio de la CORRECION_QA_RESULTADO
include '../Views/EVALUACION/EVALUACION_MOSTRAR_CORRECCION_QA_View.php';//incluye el contendio de la CORRECION_QA_RESULTADOS
include '../Views/EVALUACION/EVALUACION_EVALUACION_HISTORIAS_ASIGNADAS_View.php'; //incluye la vista del showall
include '../Views/EVALUACION/EVALUACION_EVALUACION_HISTORIAS_View.php'; //incluye la vista del showall
include '../Views/EVALUACION/EVALUACION_EDITUSU_View.php'; //incluye la vista del showall
include '../Views/DEFAULT_View.php';//incluye la vista por defecto
include '../Views/EVALUACION/EVALUACION_EVALUARADMIN_View.php';//incluye la vista donde donde el administrador evalua
include '../Views/EVALUACION/EVALUACION_EVALUARUSU_View.php';//incluye la vista donde donde el usuario evalua


//Esta función crea un objeto tipo EVALUACION_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {

	$IdTrabajo = $_REQUEST[ 'IdTrabajo' ]; //Variable que almacena el valor de IdTrabajo
	$LoginEvaluador = $_REQUEST[ 'LoginEvaluador' ]; //Variable que almacena el valor de LoginEvaluador
	$AliasEvaluado = $_REQUEST[ 'AliasEvaluado' ]; //Variable que almacena el valor de AliasEvaluado
	$IdHistoria = $_REQUEST[ 'IdHistoria' ]; //Variable que almacena el valor de IdHistoria
	$CorrectoA = $_REQUEST[ 'CorrectoA' ]; //Variable que almacena el valor de CorrectoA
	$ComenIncorrectoA = $_REQUEST[ 'ComenIncorrectoA' ]; //Variable que almacena el valor de ComenIncorrectoA
	$CorrectoP = $_REQUEST[ 'CorrectoP' ]; //Variable que almacena el valor de CorrectoP
	$ComentIncorrectoP = $_REQUEST[ 'ComentIncorrectoP' ]; //Variable que almacena el valor de ComentIncorrectoP
	$OK = $_REQUEST[ 'OK' ]; //Variable que almacena el valor de OK
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Varible que guarda un modelo de EVALUACION
	$EVALUACION = new EVALUACION(
		$IdTrabajo,
		$LoginEvaluador,
		$AliasEvaluado,
		$IdHistoria,
		$CorrectoA,
		$ComenIncorrectoA,
		$CorrectoP,
		$ComentIncorrectoP,
		$OK
	);
	//Devuelve el valor del objecto model creado
	return $EVALUACION;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			if(permisosAcc($_SESSION['login'],12,0)==true){//miramos si el usuario conectado tiene permiso para añadir una evaluación
				$TRABAJO= new TRABAJO('','','','','');//se crea un objeto de tipo TRABAJO
				$trabs=$TRABAJO->SEARCH3();//variable que almacena todos los trabajos
				$USUARIOS= new ENTREGA_MODEL('','','','','');//variable que almacena un objeto de tipo ENTREGA_MODEL
				$users=$USUARIOS->SEARCH();//variable que almacena todos los usuarios
				$users2=$USUARIOS->SEARCH();//variable que almacena todos los usuarios
				$HISTORIAS= new HISTORIA_MODEL('','','');//variable que almacena un objeto de tipo HISTORIA
				$hists=$HISTORIAS->SEARCH();//variable que almacena las historias
				new EVALUACION_ADD($trabs,$users,$users2,$hists);//mostramos la vista ADD de EVALUACION
			}else{//si el usuario no tiene permiso para añadir la evaluacion 
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );//mostramos una vista diciendo que el usuario no tiene los permisos necesarios
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de EVALUACION_MODEL inserta los datos
			$EVALUACION = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $EVALUACION->ADD();//Variable que almacena la respuesta de la inserción
			
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );//Crea la vista con la respuesta y la ruta para volver
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if(permisosAcc($_SESSION['login'],12,1)==true){//miramos si el usuario conectado tiene permiso para borrar una evaluación
			//Variable que recoge un objecto model con solo el LoginEvaluador
			$EVALUACION = new EVALUACION( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');//se crea un objeto de tipo EVALUACION pasandole todos esos parametros
		
			$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ]);//Variable que almacena el relleno de los datos utilizando el LoginEvaluador
			
			new EVALUACION_DELETE( $valores );//Crea una vista delete para ver la tupla
			}else{//si el usuario no tiene permiso para borrar la evaluacion
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );//mostramos una vista diciendo que el usuario no tiene los permisos necesarios
			}
			
		} else {//Si recibe valores ejecuta el borrado
			//Variable que almacena los datos recogidos de los atributos
			$EVALUACION = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $EVALUACION->DELETE();
			//crea una vista mensaje con la respuesta y la ComentIncorrectoPción de vuelta
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],12,2)==true){//miramos si el usuario conectado tiene permiso para edit una evaluación
                $EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');//variable que almacena un objeto de tipo EVALUACION pasandole todos esos parametros
                    //Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
                $valores = $EVALUACION->RellenaDatos();
                //Muestra la vista del formulario editar
                new EVALUACION_EDIT( $valores );
               

            }else{//si el usuario no tiene permiso
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );	 //mostramos una vista diciendo que el usuario no tiene los permisos necesarios
			 }	
		} else { //Si se reciben valores
			//Variable que almacena los datos recogidos
			$EVALUACION = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $EVALUACION->EDIT();
			//crea una vista mensaje con la respuesta y la ComentIncorrectoPción de vuelta
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );

		}
		//Fin del bloque
		break;
	case 'EDITUSU'://caso editar en usuario
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],12,12)==true){//miramos si el usuario conectado tiene permiso para editar una evaluación
                $EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');//variable que almacena un objeto de tipo EVALUACION pasandole todos esos parametros
                    //Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
                $valores = $EVALUACION->RellenaDatos();
                //Muestra la vista del formulario editar
                new EVALUACION_USUARIO_EDIT_HISTORIAS( $valores );
                //Si se reciben valores
            }else{//si el usuario no tiene el permiso
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php?action=EVALUACION_HISTORIAS_ASIGNADAS' );	 //mostramos una vista diciendo que el usuario no tiene los permisos necesarios
			 }
            } else {//Si se reciben valores
			$EVALUACION = get_data_form();//Variable que almacena los datos recogidos de los atributos
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $EVALUACION->EDIT();
			
			$at = "?IdTrabajo=".$_REQUEST['IdTrabajo']."&AliasEvaluado=".$_REQUEST['AliasEvaluado']."&action=EVALUARUSU";//variable que almacena la variable el IdTrabajo seguido del aliasEvaluado para la ruta de vuelta atras
			//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php'.$at );
			}
	case 'EVALUARADMIN'://Caso para evaluar el administrador
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EVALUAR
			if((permisosAcc($_SESSION['login'],12,11)==true)){//miramos si el usuario conectado tiene permiso para evaluar
				//Variable que almacena un objeto model 
                $EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ],'', $_REQUEST[ 'AliasEvaluado' ], '', '', '', '', '','');//se crea un objeto de tipo EVALUACION pasandole todos esos parametros
                   
                $valores = $EVALUACION->EvaluacionesQa($_REQUEST['AliasEvaluado']); //Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
                
                new EVALUACION_ADMIN_EVALUAR( $valores );//Muestra la vista del formulario evaluar
                

            }
            else{//si el usuario no tiene permisos
				if(permisosAcc($_SESSION['login'],12,10)==true){//miramos si el usuario conectado tiene permiso para evaluar
	            $EVALUACION = new EVALUACION($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado'], '', '', '', '', '', '');//variable que almacena un objeto de tipo EVALUACION pasandole todos esos parametros
	            $lista = array( 'IdTrabajo','LoginEvaluador','AliasEvaluado','CorrectoA','ComenIncorrectoA');//metemos en el array los campos  que queremos mostrar
	            
	    		$datos = $EVALUACION->SEARCH2();//Variable que almacena los datos de la busqueda
	    		
	    
	    		
	    		new EVALUACION_USUARIO_EVALUAR( $lista, $datos );//Creacion de la vista showall con el array $lista y los datos 
				}else{//si el usuario no tiene el permiso
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );	 //mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			 }
            }
		} else {//Si se reciben valores
			$contenido = $_SESSION['contenido'];//se crea una variable contenido, pasandole el contenido de la evaluación
			$EVALUACION = new EVALUACION('','', '', '', '', '', '', '','');//creamos un objeto de tipo EVALUACION
			for ($i=0; $i < count($contenido); $i++) { //este bucle se va a repetir hasta que el contenido de la evaluación no acabe
				$id = $contenido[$i][0];//variable que almacena el id del contenido
				$login = $contenido[$i][1];//variable que almacena el login del contenido
				$Alias = $contenido[$i][2];//variable que almacena el alias

				$OK = $_REQUEST[$login . $id];//variable que almacena el OK del contenido
				$ComentIncorrectoP = $_REQUEST[$id . $Alias];//variable que almacena el ComenIncorrectoP 
				$CorrectoP = $_REQUEST[$id];//variable que almacena el CorrectoP

				$miarray = $EVALUACION->DevolverCommentAlumno($login,$Alias,$id,$_REQUEST['IdTrabajo']);//variable que almacena el comentario del alumno especificando el login,alias,id y idTrabajo

				$CorrectoA = $miarray[0][0];//variable que almacena la respuesta correcta del alumno
				$ComentIncorrectoA = $miarray[0][1];//variable que almacena el comentario incorrecto del alumno

				$EVALUACION = new EVALUACION($_REQUEST['IdTrabajo'],$login,$Alias,$id,$CorrectoA,$ComentIncorrectoA,$CorrectoP,$ComentIncorrectoP,$OK);//creamos un objeto de tipo evaluación pasando todos los parametros que nos vinieron 
				$respuesta = $EVALUACION->EDIT();//hacemos el edit de la evaluacion y lo almacenamos en la variable respuesta
				

 			}
 			
			$at = "?action=EVALUACION_HISTORIAS";//le pasamos a la variable $at la acción de evaluar historias
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' . $at);//muestra un mensaje después de editar en una vista
		}
		//Fin del bloque
		break;
	case 'EVALUARUSU'://Caso evaluar en usuario	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario evaluar usuario

				if(permisosAcc($_SESSION['login'],12,10)==true){//miramos si el usuario conectado tiene permiso para evaluar
	            $EVALUACION = new EVALUACION($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado'], '', '', '', '', '', '');//variable que almacena un objeto de tipo EVALUACION pasandole todos esos parametros
	            $lista = array( 'NombreTrabajo','LoginEvaluador','AliasEvaluado','CorrectoA','ComenIncorrectoA');//metemos en un array los campos que queremos mostrar
	           
	    		$datos = $EVALUACION->SEARCH2(); //Variable que almacena los datos de la busqueda
	    		
	    
	    		
	    		new EVALUACION_USUARIO_EVALUAR( $lista, $datos );//Creacion de la vista showall con el array $lista, los datos
				}else{
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php?action=EVALUACION_HISTORIAS_ASIGNADAS' );	 //mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			 }
         
		} 
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],12,3)==true){//miramos si el usuario conectado tiene permiso para buscar
				new EVALUACION_SEARCH();//si es así,mostramos la vista search de evaluacion
			}else{//si no tiene permiso para buscar mostramos un mensaje de que no tiene dicho permiso
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );//mostramos en pantalla un mensaje con la diciendo que no tiene permiso el usuario y un enlace para volver al principio.
			}
			
		} else {//Si se reciben datos
			//Variable que almacena los datos recogidos de los atributos
			$EVALUACION = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $EVALUACION->SEARCH();
			
			$lista = array( 'NombreTrabajo','LoginEvaluador','AliasEvaluado','IdHistoria','CorrectoA','ComenIncorrectoA','CorrectoP','ComentIncorrectoP','OK');//variable que almacena los campos que queremos mostrar
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new EVALUACION_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if(permisosAcc($_SESSION['login'],12,4)==true){//miramos si el usuario conectado tiene permiso de ver en detalle
		//Variable que almacena un objeto model con el LoginEvaluador
		$EVALUACION = new EVALUACION( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
		//Variable que almacena los valores rellenados a traves de LoginEvaluador
		$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ] );
		//Creación de la vista showcurrent
		new EVALUACION_SHOWCURRENT( $valores );
			}else{//si el usuario no tiene permiso
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );//mostramos en pantalla un mensaje con la diciendo que no tiene permiso el usuario y un enlace para volver al principio.
			}
		//Final del bloque
		break;
    case 'EVALUACION_HISTORIAS':  //Caso evaluacion_historias
    	if ( !$_POST ) {//Si no se han recibido datos 
    		if(permisosAcc($_SESSION['login'],12,11)==true){//miramos si el usuario conectado tiene permiso para evaluar historias
                 $EVALUACION = new EVALUACION('','', '', '', '', '', '', '', '');//variable que almacena un objeto de tipo EVALUACION
                 $datos=$EVALUACION->DevolverEntregas(); //variable que almacena todas las entregas
                 $lista = array('login','NombreTrabajo','Alias','Horas','Ruta');//variable que almacena un array los campos que queremos mostrar	
            	new EVALUACION_SELECT_ALL_QA( $lista, $datos );//mostramos en una vista la evaluación de historias, donde se evalúa a otros usuarios
			}else{//si no tiene permiso el usuario
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );//mostramos en pantalla un mensaje con la diciendo que no tiene
			}
			 
		}
    break;//Finaliza el bloque
    case 'EVALUACION_HISTORIAS_ASIGNADAS':	//Caso evaluacion_historias_asignadas
    	if ( !$_POST ) {//Si no se han recibido datos	
			if(permisosAcc($_SESSION['login'],12,10)==true){//miramos si el usuario conectado tiene permiso para evaluar historias asignadas
				//variable que almacena un objecto EVALUACION(modelo)
                $EVALUACION = new EVALUACION('','', '', '', '', '', '', '', '');
                //variable que almacena un array con las entregas de usuario
                $datos=$EVALUACION->entregasUsu($_SESSION['login']);
                //Variable que almacena array con el CorrectoA de los atributos
		        $lista = array('NombreTrabajo','Alias','Horas','Ruta');
		       //Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		    //se muestra la vista para evaluar las entregas de otros
			new EVALUACION_SELECT_QA( $lista, $datos );
		    }else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );//mostramos en pantalla un mensaje con la diciendo que no tiene
			}
		}
    break;//Finaliza el bloque

    case 'RESULTADOS_ENTREGAS'://caso donde se muestran todas las correciones por parte del  profesor
    if(permisosAcc($_SESSION['login'],12,7)==true){	//miramos si el usuario conectado tiene permiso para ver los resultados de sus entregas
        $CORRECION = new EVALUACION('','','','','','','','','');//variable que almacena un objeto de tipo EVALUACION
        $lista=array('NombreTrabajo','CorrectoP','ComentIncorrectoP');//variable que almacena un arrray con los atributos que queremos mostrar
        
        $datos =$CORRECION->mostrarCorrecion1($_REQUEST['IdTrabajo'],$_REQUEST['login'],$_REQUEST['Entrega']);//variable que almacena todas las correciones de nuestras ETs por parte de alumnos y profesor
        
        new CORRECION_ENTREGA_RESULTADO($lista,$datos);//se nos muestra la vista con las correciones de nuestras ETs
	}else{//si no tiene permisos 
	 new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_ET' );//mostramos en pantalla un mensaje con la diciendo que no tiene
    }
        break;//Finaliza el bloque
    
   
    case 'MOSTRAR_CORRECCION_ET'://caso por defecto con vista SHOWALL
    if(permisosAcc($_SESSION['login'],12,7)==true){	//miramos si el usuario conectado tiene permiso para ver las entregas que hizo
        $CORRECION = new EVALUACION('','','','','','','','','');//variable que almacena un objeto de tipo EVALUACION
        $lista = array('login','NombreTrabajo','Entrega');//variable que almacena un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarEntregas($_SESSION['login']);//variable que almacena todas las entregas que realizó dicho usuario

        new CORRECION_ENTREGA($lista,$datos);//se nos muestra la vista 
		} else {//Si no tiene permisos muestra pantalla en blanco
				new USUARIO_DEFAULT();//se muestra una vista por defecto
		}
        break;//Finaliza el bloque	
		
				
    case 'RESULTADOS_QAS'://caso donde nos aparecen los resultados de nuestras QAs
	    if(permisosAcc($_SESSION['login'],12,14)==true){	//miramos si el usuario conectado tiene permiso para ver los resultados de sus QAs
        $CORRECION = new EVALUACION('','','','','','','','','');//variable que almacena un objeto de tipo EVALUACION
        $lista=array('LoginEvaluador','AliasEvaluado','NombreTrabajo','CorrectoA','ComenIncorrectoA','OK');//variable que almacena un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarCorrecion3($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado']);//variable que almacena los resultados de nuestras QAs y se mete en la vista
        new CORRECION_QA_RESULTADOS($lista,$datos);//Se crea la vista que muestra los resultados de las correcciones de QA
		}else{//si no tiene permiso 
	      new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_QA' );//mostramos en pantalla un mensaje con la diciendo que no tiene
        }  
        break;//Finaliza el bloque
        
    case 'RESULTADO_QA'://caso donde se muestran todas las QAs que corregimos
		if(permisosAcc($_SESSION['login'],12,14)==true){	//miramos si el usuario conectado tiene permiso para ver cuantas personas evalúo en un mismo trabajo
        $CORRECION = new EVALUACION('','','','','','','','','');//variable que almacena un objeto de tipo EVALUACION
        $lista=array('LoginEvaluador','AliasEvaluado','NombreTrabajo');//svariable que almacena un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarCorrecion2($_REQUEST['IdTrabajo'],$_SESSION['login']);//variable que almacena todas las Qas que tenemos que corregir
        new CORRECION_QA_RESULTADO($lista,$datos);
	    }else{//si no tiene permiso
	     new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_QA' );//mostramos en pantalla un mensaje con la diciendo que no tiene
        }
        break;//Finaliza el bloque
        
        
     case 'MOSTRAR_CORRECCION_QA'://caso por defecto con vista SHOWALL
	    if(permisosAcc($_SESSION['login'],12,14)==true){	//miramos si el usuario conectado tiene permiso para ver los login que corrigieron su entrega
        $CORRECION =new EVALUACION('','','','','','','','','');//variable que almacena un objeto de tipo EVALUACION
        $lista = array('LoginEvaluador','NombreTrabajo');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarQAS($_SESSION['login']);//llamamos a esta función para mostrar todas las entregas que realizó dicho usuario
        new CORRECION_QA($lista,$datos);//se nos muestra la vista    	  
		} else {//Si no tiene permisos muestra pantalla en blanco
				new USUARIO_DEFAULT();//se muestra una vista por defecto
			}
      break;//Finaliza el bloque		
		

	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
		   //Comprobamos los permisos, si tiene permisos se ejecuta el código dentro del if
           if(permisosAcc($_SESSION['login'],12,5)==true){ //miramos si el usuario conectado tiene permiso showall
	            $EVALUACION = new EVALUACION('','','', '', '', '', '', '', '');//variable que almacena un objeto de tipo EVALUACION
	            $lista = array( 'NombreTrabajo','LoginEvaluador','AliasEvaluado','CorrectoA','ComenIncorrectoA','CorrectoP','ComentIncorrectoP','OK');//svariable que almacena el array los campos que queremos mostrar
				//Variable que almacena los datos de la busqueda
				$datos = $EVALUACION->SEARCH();
				//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
				new EVALUACION_SHOWALL( $lista, $datos );
			
			} else {//Si no tiene permisos muestra pantalla en blanco
				new USUARIO_DEFAULT();//se muestra una vista por defecto
			}
		}
	}

?>
