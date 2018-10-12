<?php
/*
	Controlador que gestiona las entregas
    Autor:Brais Santos
    Fecha de creación:28/11/2017
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Functions/permisosAcc.php'; //incluye el contendio de la función permisosAcc
include '../Functions/comprobarAdministrador.php';//incluye el contenido de la función comprobarAdministrador
include '../Views/ENTREGA/ENTREGA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA/ENTREGA_SEARCH_View.php'; //incluye la vista search
include '../Views/ENTREGA/ENTREGA_ADD_View.php'; //incluye la vista add
include '../Views/ENTREGA/ENTREGA_EDIT_View.php'; //incluye la vista edit
include '../Views/ENTREGA/ENTREGA_DELETE_View.php'; //incluye la vista delete
include '../Views/ENTREGA/ENTREGA_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/ENTREGA/ENTREGA_SUBIRET_View.php'; //incluye la vista de las entregas
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include_once '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include_once '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo usuarios


//Esta función genera un alias aleatorio de 6 letras o números
function aleatorio(){
		//Variable que almacena los caracteres a usar en el algoritmo
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $numerodeletras=6; //Variable que almacena el numero de letras para generar el texto
        $cadena = ""; //variable para almacenar la cadena generada
        for($i=0;$i<$numerodeletras;$i++)//este bucle se va a repetir 6 veces para generar un alias de 6 letras ó números
        {       
            $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
                entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
        
        
    }

//Esta función crea un objeto tipo ENTREGA_MODEL con los valores que se le pasan con $_REQUEST y se utiliza para el add que es donde se genera el alias aleatorio
function get_data_form2() {
    
  
    
	$login = $_REQUEST['login'];//Variable que almacena el valor de login
    $IdTrabajo = $_REQUEST['IdTrabajo'];//Variable que almacena el valor de IdTrabajo
    
    $ENTREGA = new ENTREGA_MODEL('','','','','');// Variable que almacena un objeto tipo ENTREGA_MODEL
    
    $Alias = aleatorio();//Variable que almacena un alias aleatorio
    $buscar=$ENTREGA->buscarAlias($Alias);//lVariable que almacena los alias por si existe ese mismo alias
    
    
        while($Alias == $buscar){//este bucle se va a repetir mientras el alias este repetido
            $Alias = aleatorio();//se le asigna a la variable Alias un alias aleatorio
        }
    
    
    
    $Horas = $_REQUEST['Horas'];//Variable que almacena el valor de Horas
  
    
    	if ( isset( $_FILES[ 'Ruta' ][ 'name' ] ) ) {//mira si existe una ruta
		$nombreRuta = $_FILES[ 'Ruta' ][ 'name' ];//Variable que almacena el nombreRuta la ruta del archivo
	} else {//si no existe la ruta le asignamos a la variable el valor null
		$nombreRuta = null;
	}

	if ( isset( $_FILES[ 'Ruta' ][ 'tmp_name' ] ) ) {//mira si existe una ruta con un nombre temporal
		$nombreTempRuta = $_FILES[ 'Ruta' ][ 'tmp_name' ];//Variable que almacena el nombreRuta de la ruta del archivo con un nombre temporal
	} else {//si no existe la ruta le asignamos a la variable el valor null
		$nombreTempRuta = null;
	}
   
    if (!file_exists("../Files/$Alias")){ //miramos si no existe este fichero, en el caso de que no exista lo creamos
              //Da permisos a la carpete
              mkdir("../Files/$Alias", 0777);
   }
    
    if ( $nombreRuta != null ) {//mira si la variable nombreRuta no es vacía
		$dir_subida = '../Files/'.$Alias.'/';//Variable que almacena la ruta donde se va a subir el archivo
		$rutapersonal = $dir_subida . $nombreRuta;//Variable que almacena la dirección de subida.
		move_uploaded_file( $nombreTempRuta, $rutapersonal );//movemos el archivo a la dirección especificada
	}
   else{//mira si la variable nombreRuta no es vacía
    if(isset($_POST['ruta2'])){//si existe la anterior ruta del archivo  le asignamos a la variable rutapersonal ese valor
                        $rutapersonal=$_POST['ruta2'];
                }else{//si no tiene una ruta anterior el archivo, le asignamos el valor null

                    $rutapersonal=null;
                }
                }
    
    
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
	//Variable que almacena un nuevo ojecto ENTREGA_MODEL con los datos pasados como paramentro
	$ENTREGA = new ENTREGA_MODEL(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $rutapersonal
	);//Devuelve el valor del objecto model creado
	
    
	return $ENTREGA;
}


//Esta función crea un objeto tipo ENTREGA_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {
    
    
	$login = $_REQUEST['login'];//Variable que almacena el valor de login
    $IdTrabajo = $_REQUEST['IdTrabajo'];//Variable que almacena el valor de IdTrabajo
    $Alias = $_REQUEST['Alias'];//Variable que almacena el valor del Alias
    $Horas = $_REQUEST['Horas'];//Variable que almacena el valor de Horas
  
    
    	if ( isset( $_FILES[ 'Ruta' ][ 'name' ] ) ) {//mira si existe una ruta
		$nombreRuta = $_FILES[ 'Ruta' ][ 'name' ];//Variable que almacena la ruta del archivo
	} else {//si no existe la ruta le asignamos a la variable el valor null
		$nombreRuta = null;
	}

	if ( isset( $_FILES[ 'Ruta' ][ 'tmp_name' ] ) ) {//mira si existe una ruta con un nombre temporal
		$nombreTempRuta = $_FILES[ 'Ruta' ][ 'tmp_name' ];//Variable que almacena la ruta del archivo con un nombre temporal
	} else {//si no existe la ruta le asignamos a la variable el valor null
		$nombreTempRuta = null;
	}

     if (!file_exists("../Files/$Alias")){ //miramos si no existe este fichero, en el caso de que no exista lo creamos
              //Da permisos a la carpeta personal
              mkdir('../Files/'.$Alias.'/', 0777);
    }

	if ( $nombreRuta != null ) {//mira si la variable nombreRuta no es vacía
		$dir_subida = '../Files/'.$Alias.'/';//lVariable que almacena la ruta donde se va a subir el archivo
		$rutapersonal = $dir_subida . $nombreRuta;;//Variable que almacena la dirección de subida.
		move_uploaded_file( $nombreTempRuta, $rutapersonal );//movemos el archivo a la dirección especificada
	}
   else{//mira si la variable nombreRuta no es vacía
    if(isset($_POST['ruta2'])){//si existe la anterior ruta del archivo  le asignamos a la variable rutapersonal ese valor
                        $rutapersonal=$_POST['ruta2'];
                }else{//si no tiene una ruta anterior el archivo, le asignamos el valor null

                    $rutapersonal=null;
                }
                }
 
    
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
	//Variable que almacena un objecto ENTREGA_MODEL
	$ENTREGA = new ENTREGA_MODEL(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $rutapersonal
	);	//Devuelve el valor del objecto model creado

	return $ENTREGA;
}

//Esta función crea un objeto tipo ENTREGA_MODEL con los valores que se le pasan con $_REQUEST en el caso de hacer un SEARCH(busqueda)
function getSearch(){
    
      
	$login = $_REQUEST['login'];//Variable que almacena el valor de login
    $IdTrabajo = $_REQUEST['IdTrabajo'];//Variable que almacena el valor de IdTrabajo
    $Alias = $_REQUEST['Alias'];//Variable que almacena el valor del Alias
    $Horas = $_REQUEST['Horas'];//Variable que almacena el valor de Horas
    
    
    
    
    	if ( isset( $_FILES[ 'Ruta' ][ 'name' ] ) ) {//mira si existe una ruta
		$nombreRuta = $_FILES[ 'Ruta' ][ 'name' ];//Variable que almacena la ruta del archivo
	} else {//si no existe la ruta le asignamos a la variable el valor null
		$nombreRuta = null;
	}

	if ( isset( $_FILES[ 'Ruta' ][ 'tmp_name' ] ) ) {//mira si existe una ruta con un nombre temporal
		$nombreTempRuta = $_FILES[ 'Ruta' ][ 'tmp_name' ];//Variable que almacena la ruta del archivo con un nombre temporal
	} else {//si no existe la ruta le asignamos a la variable el valor null
		$nombreTempRuta = null;
	}
    
	if ( $nombreRuta != null ) {//mira si la variable nombreRuta no es vacía
		$dir_subida = '../Files/'.$Alias.'/';//Variable que almacena la ruta donde se va a subir el archivo
		$rutapersonal = $dir_subida . $nombreRuta;;//lVariable que almacena la dirección de subida.
		move_uploaded_file( $nombreTempRuta, $rutapersonal );//movemos el archivo a la dirección especificada
	}
   else{//mira si la variable nombreRuta no es vacía
    if(isset($_POST['ruta2'])){//si existe la anterior ruta del archivo  le asignamos a la variable rutapersonal ese valor
                        $rutapersonal=$_POST['ruta2'];
                }else{//si no tiene una ruta anterior el archivo, le asignamos el valor null

                    $rutapersonal=null;
                }
                }
 
    
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
	//Variable que almacena un objecto ENTREGA_MODEL
	$ENTREGA = new ENTREGA_MODEL(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $rutapersonal
	);	//Devuelve el valor del objecto model creado

	return $ENTREGA;
    
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {//Si la variable action no tiene contenido le asignamos ''
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto tipo USU_GRUPO
			$ADMIN = $ENTREGA->comprobarAdmin();//Variable que almacena un booleano para comprobar si dicho usuario es administrador
			if($ADMIN == true){//miramos si es administrador
				$USUARIO= new USUARIO_MODEL('','','','','','','','');//Variable que almacena un objeto de tipo USUARIO_MODEL
				$USUARIOS=$USUARIO->SEARCH();//Variable que almacena un recordset con todos los usuarios			
				$TRABAJO= new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO
				$TRABAJOS=$TRABAJO->SEARCH2();//Variable que almacena que almacena un recordset con todos los trabajos
				new ENTREGA_ADD($USUARIOS,$TRABAJOS);//instanciamos una vista para añadir una entrega con un select de todos los ususarios y trabajos
			}else{// si no es administrador
            //Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
            $cont=0;//inicializamos la variable cont a 0
			$PERMISO = $ENTREGA->comprobarPermisos();//Variable que almacena un recordset con permisos que tiene este usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='8'){//miramos si el usuario tiene la funcionalidad de gestion de entregas
				if($fila['IdAccion']=='0'){//miramos si el usuario tiene la acción de insertar
			    
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   } 
			}
			if($cont==1){//si la variable cont es 1, por tanto si tiene el permiso
			$USUARIO= new USUARIO_MODEL('','','','','','','','');//Variable que almacena un objeto de tipo USUARIO_MODEL
			$USUARIOS=$USUARIO->SEARCH();	//Variable que almacena un recordset con todos los usuarios			
			$TRABAJO= new TRABAJO('','','','','');//Variable que almacena un objeto de tipo TRABAJO
			$TRABAJOS=$TRABAJO->SEARCH2();//Variable que almacena un recordset con todos los trabajos
				new ENTREGA_ADD($USUARIOS,$TRABAJOS);//instanciamos una vista para añadir una entrega con un select de todos los ususarios y trabajos
			}else{//si el usuario no tiene dicho permiso , se muestra un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
			}
			}
		} else {//Si recibe datos los recoge y mediante la clase ENTREGA_MODEL inserta los datos
			$ENTREGA = get_data_form2();//Variable que almacena los datos recogidos
			$respuesta = $ENTREGA->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto tipo USU_GRUPO
			$ADMIN = $ENTREGA->comprobarAdmin();//llamamos a esta función para comprobar si dicho usuario es administrador
			if($ADMIN == true){//miramos si es administrador
			//Variable que recoge un objecto model.
			$ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '','', '');
			//Variable que almacena el relleno de los datos.
			$valores = $ENTREGA->RellenaDatos();
			$dependencias = $ENTREGA->dependencias();//Variable que almacena las dependencias de borrado
			$dependencias2 = $ENTREGA->dependencias2();//Variable que almacena dependencias de borrado
            //Crea una vista delete para ver la tupla
			new ENTREGA_DELETE($valores, $dependencias, $dependencias2);
			}else{//si no es administrador
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;//iniciamos la variable cont a 0
			$PERMISO = $ENTREGA->comprobarPermisos();//lVariable que almacena los permisos que tiene este usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='8'){//miramos si el usuario tiene la funcionalidad de gestion de entregas
				if($fila['IdAccion']=='1'){//miramos si el usuario tiene la acción de borrar
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			  }
			}
			if($cont==1){//si la variable cont es uno, por tanto si el usuario tiene permiso
			//Variable que recoge un objecto model.
			$ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '','', '');
            //Variable que almacena el relleno de los datos.
			$valores = $ENTREGA->RellenaDatos();
			$dependencias = $ENTREGA->dependencias();//Variable que almacena las dependencias de borrado
			$dependencias2 = $ENTREGA->dependencias2();//Variable que almacenalas dependencias de borrado
            //Crea una vista delete para ver la tupla
			new ENTREGA_DELETE($valores, $dependencias, $dependencias2);
			//Si recibe valores ejecuta el borrado
			}else{//si el usuario no tiene dicho permiso, se muestra un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
			}
			}
		} else {//Si recibe datos los recoge y mediante la clase ENTREGA_MODEL borra los datos
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $ENTREGA->DELETE();
			//crea una vista mensaje con la respuesta.
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			
			if(permisosAcc($_SESSION['login'],8,2)==true){//Variable que almacena un booleano de si tiene permiso para editar	            
            
			$ENTREGA = new ENTREGA_MODEL($_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ],'', '', '');//Variable que almacena un objeto de tipo ENTREGA_MODEL
			//Variable que almacena los datos de los atibutos rellenados 
			$valores = $ENTREGA->RellenaDatos();
			//Muestra la vista del formulario editar
			new ENTREGA_EDIT( $valores );
			}else{//si no tiene dicho permiso se muestra un mensaje indicandolo
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
			}
			//Si se reciben valores
		} else {//Si recibe datos los recoge y mediante la clase ENTREGA_MODEL edita los datos
			//Variable que almacena un objecto ENTREGA_MODEL con los datos recogidos
			$ENTREGA = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $ENTREGA->EDIT();
			//crea una vista mensaje con la respuesta
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto tipo USU_GRUPO
			$ADMIN = $ENTREGA->comprobarAdmin();//llamamos a esta función para comprobar si dicho usuario es administrador
			if($ADMIN == true){//miramos si es administrador
				new ENTREGA_SEARCH();//mostramos una vista SEARCH
			}else{//si no es administrador
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;//iniciamos la variable cont a 0
			
			$PERMISO = $ENTREGA->comprobarPermisos();//Variable que almacena los permisos que tiene este usuario
            while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos

			if($fila['IdFuncionalidad']=='8'){//miramos si el usuario tiene la funcionalidad de gestion de entregas
				if($fila['IdAccion']=='3'){//miramos si el usuario tiene la acción de buscar
			  
			     $cont=$cont+1;//incrementamos la variable
				}
			   }
			}
			if($cont>=1){//si la variable cont es uno, por tanto si el usuario tiene permiso
            //Se crea la vista de search
			new ENTREGA_SEARCH();
			}else{//si el usuario no tiene dicho permiso, se muestra un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
			}
			}
			
		} else {//Si se reciben datos
          
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = getSearch();
			//Variable que almacena el resultado de la busqueda
			$datos = $ENTREGA->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('login','IdTrabajo','Alias','Horas','Ruta');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta

				new ENTREGA_SHOWALL( $lista, $datos);
  
      
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
        $USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ],'');//Variable que almacena un objeto tipo USU_GRUPO
			$ADMIN = $USUARIO->comprobarAdmin();//llamamos a esta función para comprobar si dicho usuario es administrador
			if($ADMIN == true){//miramos si el usuario es administrador
					//Variable que almacena un objeto model
		          $ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '', '','');
		         //Variable que almacena los valores rellenados 
		          $valores = $ENTREGA->RellenaDatos();
                    //Creación de la vista showcurrent
		          new ENTREGA_SHOWCURRENT( $valores );
			}else{//si el usuario no es administrador
			//Variable que almacena el valor númerico para indicar si tiene permiso '1' tiene '0' no tiene permisos
			$cont=0;//iniciamos la variable cont a 0
			$USUARIO = $ENTREGA->comprobarPermisos();//Variable que almacena los permisos que tiene dicho usuario
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos 
	
			if($fila['IdFuncionalidad']=='8'){//miramos si el usuario tiene la funcionalidad de gestion de entregas
				if($fila['IdAccion']=='4'){//miramos si el usuario tiene la acción de showcurrent
			    
			     $cont=$cont+1;//incementamos la variable
				}
			   }
			}
			if($cont>=1){//si la variable cont es 1 y por tanto el usuario tiene dicho permiso
		///Variable que almacena un objeto model
		          $ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '', '','');
		         //Variable que almacena los valores rellenados 
		          $valores = $ENTREGA->RellenaDatos();
				  //Creación de la vista showcurrent
		          new ENTREGA_SHOWCURRENT( $valores );
		}else{//si el usuario no tiene dicho permiso se muestra un mensaje indicandolo
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		}
		break;//Finaliza el bloque
        
    case 'SUBIR_ENTREGA'://caso para añadir una entrega cuando un usuario entra a gestión de entregas
		if(permisosAcc($_SESSION['login'],8,10)==true){	//miramos si el usuario tiene dicho permiso	
           $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//Variable que almacena un objeto tipo USU_GRUPO
           $PERMISO = $USUARIO->comprobarPermisos();//Variable que almacena los permisos que tiene este usuario
        
          $ENTREGA = new ENTREGA_MODEL($_SESSION['login'],$_REQUEST['IdTrabajo'],'','','');//Variable que almacena un objeto de tipo ENTREGA_MODEL
          $respuesta=$ENTREGA->comprobarCreacion();//Variable que almacena si la entrega ya esta creada
        
        if($respuesta == false){//si la entrega no esta creada
              $alias = aleatorio();//Variable que almacena un alias aleatorio
              $comprobar=$ENTREGA->buscarAlias($alias);//lVariable que almacena el alias esta repetido
             
              while($comprobar == true){//mienttras el alias este repetido 
                 $alias = aleatorio();//Variable que almacena un alias
                $buscar=buscarAlias($Alias_Usuario);//Variable que almacena un alias para saber si esta repetido
            }
                  $ENTREGA = new ENTREGA_MODEL($_SESSION['login'],$_REQUEST['IdTrabajo'],$alias,'','');//Variable que almacena un objeto de tipo ENTREGA_MODEL
                   $ENTREGA->ADD();//añadimos la entrega
         }
          
                  
         $ENTREGA = new ENTREGA_MODEL($_SESSION['login'],$_REQUEST['IdTrabajo'],'','','');//Variable que almacena un objeto de tipo ENTREGA_MODEL
         $datos=$ENTREGA->SEARCH2();//Variable que almacena todas las entregas
          $lista = array('login','NombreTrabajo','Alias','Horas','Ruta');//Variable que almacena un array almacenamos los campos a mostrar
          new ENTREGA_SHOWALL( $lista, $datos/*,$PERMISO,false */);//mostramos la vista showall 
		}else{//si el usuario no tiene dicho permiso se indica
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php?action=SUBIRET' );
		}
        break;//Finaliza el bloque
		
	case 'SUBIRET'://caso subir directorio
		if(permisosAcc($_SESSION['login'],8,10)==true){	//miramos si el usuario tiene dicho permiso	
	    if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SHOWALL
			$TRABAJO = new TRABAJO('','','','','');//se crea un objeto de tipo TRABAJO para buscar todos los trabajos
		} 
        else {//Si recibe datos los recoge y mediante la funcionalidad de TRABAJO_MODEL muestra  los datos.
			$TRABAJO = get_data_form();//le pasamos a $TRABAJO un objeto de tipo TRABAJO_MODEL con los valores correspondientes
		}
		$datos = $TRABAJO->SEARCH2();//Variable que almacena todos los trabajos
		$lista = array( 'NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo' );//Variable que almacena los campos que queremos mostrar
		new ENTREGA_SHOWET( $lista, $datos );//muestra una vista SHOWALL con todos los trabajos
	    }else{//si el usuario no tiene dicho permiso se muestra una vista por defecto sin nada
		
			new USUARIO_DEFAULT();
		
		}
	break;//Finaliza el bloque
		
		
	default: //Caso que se ejecuta por defecto
	if(permisosAcc($_SESSION['login'],8,5)==true){  //miramos si el usuario es administrador      
		if ( !$_POST ) {//Si no se han recibido datos 
                  $ENTREGA = new ENTREGA_MODEL( '','', '', '', '');//Variable que almacena un objeto de tipo ENTREGA_MODEL
		//Si se reciben datos
		} 
        else {//Si  se han recibido datos 
			      $ENTREGA = get_data_form();//Variable que almacena un objeto de tipo ENTREGA_MODEL pasandole los parametros
		}
		//Variable que almacena los datos de la busqueda
        $datos = $ENTREGA->SEARCH();
		//Variable que almacena array con el CorrectoA de los atributos
		$lista = array('login','NombreTrabajo','Alias','Horas','Ruta');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ENTREGA_SHOWALL( $lista, $datos);
	}else{//si el usuario no tiene dicho permiso se muestra una vista por defecto sin nada
		
			new USUARIO_DEFAULT();
		
		}
}

?>