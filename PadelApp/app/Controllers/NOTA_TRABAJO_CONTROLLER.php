<?php
/*
	Fecha de creación: 4/12/2017 
    Autor:Brais Santos
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas en la tabla NOTA_TRABAJO
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/NOTA_TRABAJO_MODEL.php'; //incluye el contendio del modelo NOTA_TRABAJO
include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo ENTREGA
include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo EVALUACION
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo USU_GRUPO
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo TRABAJO
include_once '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo USUARIO
include '../Functions/permisosAcc.php';//incluye el contenido del fichero permisosAcc.php
include '../Functions/comprobarAdministrador.php';//incluye el contenido del fichero comprobarAministrador.php
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SHOWMISNOTAS_View.php'; //incluye la vista del showall
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_GENERAR_NOTA_ENTREGA_View.php'; //incluye la vista del fichero NOTA_TRABAJO_GENERAR_NOTA_ENTREGA_View.php
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_GENERAR_NOTA_QA_View.php'; //incluye la vista del fichero NOTA_TRABAJO_GENERAR_NOTA_QA_View.php
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SEARCH_View.php'; //incluye la vista search
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_ADD_View.php'; //incluye la vista add
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_EDIT_View.php'; //incluye la vista edit
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_DELETE_View.php'; //incluye la vista delete
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php';//incluye una vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo NOTA_TRABAJO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {


	$IdTrabajo = $_REQUEST['IdTrabajo'];//Variable que almacena el valor de IdTrabajo
    $login = $_REQUEST['login'];//Variable que almacena el valor de login
    $NotaTrabajo = $_REQUEST['NotaTrabajo'];//Variable que almacena el valor de NotaTrabajo
    $action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
    //Variable que almacena un modelo de NOTA_TRABAJO
	$NOTAS = new NOTA_TRABAJO_MODEL(
		$IdTrabajo,
        $login,
        $NotaTrabajo
	);
	//Devuelve el valor del objecto model creado
	return $NOTAS;
}



//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			if(permisosAcc($_SESSION['login'],7,0)==true){//miramos si el usuario tiene permiso para añadir
			$USUARIO= new USUARIO_MODEL('','','','','','','','');//Variable que almacena un objeto de tipo USUARIO_MODEL
			$USUARIOS=$USUARIO->SEARCH();//Variable que almacena la respuesta al método SEARCH para obtener todos los usuarios			
			$TRABAJO= new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO
			$TRABAJOS=$TRABAJO->SEARCH2();//Variable que almacena la respuesta al método SEARCH2 para obtener todos los trabajos
			//Crea una vista add para ver la tupla
			new NOTA_TRABAJO_ADD($USUARIOS,$TRABAJOS);
			}else{ //si el usuario no tiene permiso para añadir 
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );//s muestra un mensaje indicando que el usuario no tiene dicho permiso y un enlace para volver atrás
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de NOTA_TRABAJO_MODEL inserta los datos
			$NOTAS = get_data_form();//Variable que almacena un objecto NOTA(modelo) con los datos recogidos
			$respuesta = $NOTAS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if(permisosAcc($_SESSION['login'],7,1)==true){//miramos si el usuario tiene permiso para borrar
			//Variable que recoge un objecto model NOTA
			$NOTAS = new NOTA_TRABAJO_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena un recordset con todos los valores dependientes de IdTrabajo y login
			$valores = $NOTAS->RellenaDatos();
            //Crea una vista delete para ver la tupla
			new NOTA_TRABAJO_DELETE($valores);
			}else{//si el usuario no tiene permiso para borrar
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );//s muestra un mensaje indicando que el usuario no tiene dicho permiso y un enlace para volver atrás
			}
			
		} else {//Si recibe valores ejecuta el borrado
			//Variable que almacena un objecto NOTA (modelo) conlos datos recogidos de los atributos
			$NOTAS = get_data_form();
           
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $NOTAS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],7,2)==true){//miramos si el usuario tiene permiso para editar
			//Variable que almacena un objeto model NOTA
			$NOTAS = new NOTA_TRABAJO_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $NOTAS->RellenaDatos();
			new NOTA_TRABAJO_EDIT($valores);//mostramos una vista para editar la nota del trabajo
			}else{//si el usuario no tiene permiso para editar
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );//s muestra un mensaje indicando que el usuario no tiene dicho permiso y un enlace para volver atrás
			}
			
		} else {//Si se reciben valores
			//Variable que almacena un objecto NOTA(modelo) con los datos recogidos
			$NOTAS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $NOTAS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
        
    case 'GENERAR_NOTA_ENTREGA': //en este caso generamos la nota de la entrega(ET)
             $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto USU_GRUPO
             $ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena la respuesta de la función para comprobar si este usuario es administrador
             
        
           if(!$_POST){//si no se recibieron datos
                 if(permisosAcc($_SESSION['login'],7,13)==true){//miramos que permisos tiene este usuario
                 $TRABAJOS= new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO
			     $datos=$TRABAJOS->SEARCH2();//Variable que almacena aquellos trabajos que son ET
                 new GENERAR_NOTA_ET($datos);//mostramos la vista para generar nota de entrega
                
            }
            else{//si el usuario no tiene dicho permiso  
                new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );//s muestra un mensaje indicando que el usuario no tiene dicho permiso y un enlace para volver atrás
            }
        }
        
      else{//si se reciben datos
                 $ENTREGA = new ENTREGA_MODEL('','','','','');//Variable que almacena un objeto de tipo entrega
                 $dat=$ENTREGA->cogerDatos($_REQUEST['IdTrabajo']);//lVariable que almacena los login que tienen el Idtrabajo elegido
                 $NOTAS = new NOTA_TRABAJO_MODEL('','','','','');//Variable que almacena un objeto de tipo NOTA_TRABAJO_MODEL
                 
                 while($fila = mysqli_fetch_array($dat)){//recorremos el bucle hasta que no queden mas usuarios asociados a esa entrega
                     $existe=$NOTAS->siExiste($fila['login'],$fila['IdTrabajo']);//Variable que almacena un booleano de si ya existe ese login y IdTrabajo en la tabla NOTA_TRABAJO
                     
                     if($existe == false){//Si no existe 
                         $NOTAS = new NOTA_TRABAJO_MODEL($fila['IdTrabajo'],$fila['login'], '');//creamos un objeto de tipo NOTA_TRABAJO_MODEL
                         $NOTAS->ADD();//añadimos esto en la tabla NOTA_TRABAJO
                         
                            
                     $nota = $NOTAS->calcularNota($fila['login'],$fila['IdTrabajo']);//Variable que almacena la nota de la entrega
                  
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);//Variable que almacena el porcentaje del trabajo
                     
                     $notaET = $nota * ($porcentaje[0]/100);//Variable que almacena la nota aplicada al porcentaje
                    
                     $NOTAS->actualizar($fila['login'],$fila['IdTrabajo'],$notaET);//actualizamos la nota en la base de datos
                     $respuesta="Notas generadas correctamente";//Variable que almacena mensaje de éxito
                     new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');//se muestra el mensaje de éxito y un enlace para volver atrás
                         
                     }
                    else{//si ya existe ese usuario con es e IdTrabajo 
                         
                     $nota = $NOTAS->calcularNota($fila['login'],$fila['IdTrabajo']);//Variable que almacena la nota de la entrega
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);//Variable que almacena el porcentaje del trabajo
                     $notaET = $nota * ($porcentaje[0]/100);//Variable que almacena la nota aplicada al porcentaje
                      
                     $NOTAS->actualizar($fila['login'],$fila['IdTrabajo'],$notaET);//actualizamos la nota en la base de datos
                     $respuesta="Notas generadas correctamente";//Variable que almacena mensaje de éxito
                      new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');//se muestra el mensaje de éxito y un enlace para volver atrás
                    }
                     
                     
                  
                 }
                    $respuesta="Las notas no se pudieron generar";//Variable que almacena mensaje de que no se pudieron generar las notas
                    new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');//se muestra el mensaje de fracaso y un enlace para volver atrás

      }
        
    break;//Finaliza el bloque
        
    case 'GENERAR_NOTA_QA'://en este caso generamos la nota de la QA(QA)
        
         $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto USU_GRUPO
         $ADMIN = $USUARIO->comprobarAdmin();//Variable que almacena la repuesta de la de si este usuario es administrador
        
        if(!$_POST){//si no se recibieron datos
        
           if(permisosAcc($_SESSION['login'],7,8)==true){//miramos que permisos tiene este usuario
               $TRABAJOS= new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO
			   $datos=$TRABAJOS->SEARCH3();//Variable que almacena aquellos trabajos que son QA
               new GENERAR_NOTA_QA($datos);  //mostramos la vista para generar nota de QA
               
            }
            else{//si el usuario no tiene dicho permiso 
                
                new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );//s muestra un mensaje indicando que el usuario no tiene dicho permiso y un enlace para volver atrás
            }
        }
            
        
         else{//si se reciben datos
            
                 $EVALUACION = new EVALUACION('','','','','','','','','');//Variable que almacena un objeto de tipo EVALUACION
                 $dat=$EVALUACION->cogerDatosQA($_REQUEST['IdTrabajo']);//lVariable que almacena login que tienen el Idtrabajo elegido
                 $NOTAS = new NOTA_TRABAJO_MODEL('','','','','');//Variable que almacena un objeto de tipo NOTA_TRABAJO_MODEL
                
                 
                 while($fila = mysqli_fetch_array($dat)){//recorremos el bucle hasta que no queden mas usuarios asociados a esa QA
                     
                     $existe=$NOTAS->siExiste($fila['LoginEvaluador'],$fila['IdTrabajo']);//Variable que almacena un booleano de si ya existe ese login y IdTrabajo en la tabla NOTA_TRABAJO
                     
                     if($existe == false){//Si no existe
                         $NOTAS = new NOTA_TRABAJO_MODEL($fila['IdTrabajo'],$fila['LoginEvaluador'], '');//Variable que almacena un objeto de tipo NOTA_TRABAJO_MODEL
                         $NOTAS->ADD();//añadimos esto en la tabla NOTA_TRABAJO
                         
                     $nota = $NOTAS->calcularNotaQA($fila['LoginEvaluador'],$fila['IdTrabajo']);//Variable que almacena la nota de la QA
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);//Variable que almacena el porcentaje del trabajo
                     $notaET = $nota * ($porcentaje[0]/100);//Variable que almacena la nota aplicada al porcentaje
                     
                     $NOTAS->actualizar($fila['LoginEvaluador'],$fila['IdTrabajo'],$notaET);//actualizamos la nota en la base de datos
                     $respuesta="Notas generadas correctamente";//Variable que almacena mensaje de exito
                     new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');//se muestra el mensaje de éxito y un enlace para volver atrás
                         
                     }
                    else{//si existe el usuario asciado  a esa QA
                     $nota = $NOTAS->calcularNotaQA($fila['LoginEvaluador'],$fila['IdTrabajo']);//Variable que almacena la nota de la QA
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);//Variable que almacena el porcentaje del trabajo
                     $notaET = $nota * ($porcentaje[0]/100);//Variable que almacena la nota aplicada al porcentaje
                    
                     $NOTAS->actualizar($fila['LoginEvaluador'],$fila['IdTrabajo'],$notaET);//Variable que almacena la nota en la base de datos
                      $respuesta="Notas generadas correctamente";//Variable que almacena mensaje de exito
                      new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');//se muestra el mensaje de éxito y un enlace para volver atrás
                    
                    }
        }
                    $respuesta="Las notas no se pudieron generar";//Variable que almacena mensaje de fracaso
                    new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');//se muestra el mensaje de fracaso y un enlace para volver atrás
        
         }
        break;//Finaliza el bloque
        
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],7,3)==true){//miramos si el usuario tiene permiso para buscar
			new NOTA_TRABAJO_SEARCH();//se muestra la vista search de NOTA_TRABAJO
			}else{//si no tien dicho permiso se indica en un mensaje en una vista
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
			}
			
		} else {//Si se reciben datos
			//Variable que almacena un objecto NOTA(modelo) con los datos recogidos de los atributos
			$NOTAS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $NOTAS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('NombreTrabajo','login','NotaTrabajo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
            if(comprobarAdministrador($_SESSION['login']) == true){//comprobamos si el usuario es administrador
                new NOTA_TRABAJO_SHOWALL( $lista, $datos,false );//se muestra la vista de NOTA_TRABAJO_SHOWALL
            }
            else//si no es administrador
                 new NOTA_TRABAJO_SHOWALL( $lista, $datos,true );//se muestra la vista de NOTA_TRABAJO_SHOWALL con la nota final
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if(permisosAcc($_SESSION['login'],7,4)==true){//miramos si el usuario tiene permiso para ver en detalle
		//Variable que almacena un objeto model NOTA con el login y IdTrabajo
		$NOTAS = new NOTA_TRABAJO_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST['login'],'');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $NOTAS->RellenaDatos();
		//Creación de la vista showcurrent
		new NOTA_TRABAJO_SHOWCURRENT( $valores );
		}else{//si no tiene permisos para ver ene detalle, se muestra en una vista indicandolo con un mensaje
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Final del bloque
		break;
	case 'SHOWMISNOTAS'://Caso ver mis notas
		if(permisosAcc($_SESSION['login'],7,10)==true){    //miramos si el usuario tiene permiso SHOWMISNOTAS       
                      $NOTAS=new NOTA_TRABAJO_MODEL('',$_SESSION['login'],''); // Variable que almacena un objeto model con el login
                 	  $datos = $NOTAS->SEARCH2();//llamamos a este metodo para sacar las notas de ese usuario
		              //Variable que almacena array con el nombre de los atributos
		              $lista = array('NombreTrabajo','login','NotaTrabajo');
		              //Creacion de la vista showall con el array $lista, los datos y la una variable booleana que al ser true indica la nota final
		              new NOTA_TRABAJO_SHOWMISNOTAS( $lista, $datos,true );
		}else{//si el usuario no tiene permiso SHOWMISNOTAS
			new USUARIO_DEFAULT();	//va a una vista por defecto 
			
		}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
             if(permisosAcc($_SESSION['login'],7,5)==true){ //miramos si el usuario tiene permiso showall
  				$NOTAS=new NOTA_TRABAJO_MODEL('','','');         // Variable que almacena un objeto model NOTA       
                $datos = $NOTAS->SEARCH();//llamamos a este metodo para sacar las notas de todos los usuarios
		        //Variable que almacena array con el nombre de los atributos
		        $lista = array('login','NombreTrabajo','NotaTrabajo');
                
                new NOTA_TRABAJO_SHOWALL( $lista, $datos,false );//se muestra una vista showall con las notas de todos en porcentaje
                  
            }else{//si el usuario no tiene permiso SHOWALL
				new USUARIO_DEFAULT();	//va a una vista por defecto			
			}
                               
	
	
}

?>