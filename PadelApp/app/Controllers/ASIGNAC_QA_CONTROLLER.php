<?php
/*
	Archivo php
	Nombre: ASIGNA_QA_CONTROLLER.php
	Autor: 	Jonatan Couto
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas a la hora de asignar Qas
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/ASIGNAC_QA_MODEL.php'; //incluye el contendio del modelo ASIGNAC_QA_MODEL
include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo EVALUACION_MODEL
include '../Models/HISTORIA_MODEL.php'; ////incluye el contendio del modelo HISTORIA_MODEL
include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo ENTREGA_MODEL
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo TRABAJO_MODEL
include '../Functions/permisosAcc.php';//incluye la función permisosACC
include '../Views/ASIGNAC_QA/ASIGNAC_QA_GENERAR_View.php'; //incluye la vista de ASIGNAC_QA_GENERAR_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_HISTORIAS_View.php'; //incluye la vista de ASIGNAC_QA_HISTORIAS_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_ADD_View.php'; //incluye la vista de ASIGNAC_QA_ADD_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_DELETE_View.php'; //incluye la vista de ASIGNAC_QA_ADD_View_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_EDIT_View.php'; //incluye la vista de ASIGNAC_QA_EDIT_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_SEARCH_View.php'; //incluye la vista de ASIGNAC_QA_SEARCH_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_SHOWCURRENT_View.php'; //incluye la vista de ASIGNAC_QA_SHOWCURRENT_View
include '../Views/ASIGNAC_QA/ASIGNAC_QA_SHOWALL_View.php'; //incluye la vista de ASIGNAC_QA_SHOWALL_View
include '../Views/DEFAULT_View.php';//incluye la vista de DEFAULT_View
include '../Views/MESSAGE_View.php'; //incluye la vista de MESSAGE_View

//Esta función crea un objeto tipo ASIGNAC_QA_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo']; //Variable que almacena el idTrabajo
	$LoginEvaluador = $_REQUEST['LoginEvaluador']; //Variable que almacena el LoginEvaluador
	$LoginEvaluado = $_REQUEST['LoginEvaluado']; //Variable que almacena el LoginEvaluado
	$AliasEvaluado = $_REQUEST['AliasEvaluado']; //Variable que almacena el AliasEvaluado
	$action= $_REQUEST['action'];//Variable que almacena el action
	//Variable que almacena un objeto de ASIGNAC_QA_MODEL
	$ASIGNACION = new ASIGNAC_QA_MODEL(
		$IdTrabajo,
		$LoginEvaluador,
		$LoginEvaluado,
		$AliasEvaluado
	);
	//devuelve el objecto modelo
	return $ASIGNACION;
}

//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'HISTORIAS'://Caso generar HISTORIAS
		//Si no se reciben parametros crea un vista de generar historias
		if ( !$_POST ) {
			//Si el usuario tiene permisos puede ir a la vista de generar historias
			if(permisosAcc($_SESSION['login'],6,9)==true){			
				//Variable que almacena un nuevo objecto ASIGNAC_QA_MODEL 
				$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
				//Variable que almacena un nuevo objecto TRABAJO(modelo)
				$TRABAJO = new TRABAJO('', '', '', '', '');
				//Variable que almacena el array de las tuplas de entrega.
				$QA = $TRABAJO->DevolverQA();
				//Creación vista para generación de qas
				new ASIGNAC_QA_HISTORIAS($QA);
     	//Si no tiene permisos crea una vista por defecto que mostrará el espacio de trabajo en blanco
    	}else{
		   //Crea una vista de defecto de usuario para que se vea el espacio de trabajo vacio
		   new USUARIO_DEFAULT();
	    }			
		//Si se reciben parametros
		} else {
			//Variable que almacena el mensaje por defecto
			$mensaje = 'No se encuentra la asignacion de QAs';
			//Variable que almacena un nuevo objecto ASIGNAC_QA_MODEL
			$ASIGNACION = new ASIGNAC_QA_MODEL($_REQUEST['IdTrabajo'], '', '', '');
			//Variable que almacena el array de las tuplas de entrega.
			$QAs = $ASIGNACION->DevolverQAs();
			//Variable que almacena un nuevo objeto HISTORIA_MODEL
			$HISTORIA = new HISTORIA_MODEL( '', '', '');
			//Variable que guarda el nombre de la QA cambio las letras ET por QA concatenado al resto de valores
			$NombreET = "ET" . substr($_REQUEST['IdTrabajo'], 2);
			//Variable que recoge el array de historias asociados al id trabajo
			$HISTORIAS = $HISTORIA->DevolverHistorias($NombreET);
			//Si no hay historias pero hay QAs cambia el mensaje de salida
		if (count($HISTORIAS) <= 0 && count($QAs) != 0) {
			//Variable que almacena el mensaje si no hay historias para la QA
			$mensaje = 'No se encuentran las historias de la QA';
		}
		//Bucle que recorre todos las QA
		for ($i=0; $i < count($QAs); $i++) { 	
			//Bucle que recorre las historias
			for ($j=0; $j < count($HISTORIAS); $j++) { 
				$IdTrabajo = $QAs[$i][0];//Variable que almacena $IdTrabajo
				$LoginEvaluador = $QAs[$i][1];//Variable que almacena $LoginEvaluador
				$AliasEvaluado = $QAs[$i][2];//Variable que almacena $AliasEvaluado
				$IdHistoria = $HISTORIAS[$j][0];//Variable que almacena IdHistoria
				//Variable que almacena un nuevo objecto Evaluación
				$EVALUACION = new EVALUACION($IdTrabajo,$LoginEvaluador,$AliasEvaluado,$IdHistoria,'2', ' ', '2', ' ', '2');
				//Variable que almacena el mensaje de retorno de la sentencia
				$mensaje = $EVALUACION->ADD();//Añadimos los datos a la tabla
				}
			}
			//Variable que almacena la accion a la que tiene que volever 
			$at = "?action=HISTORIAS";
		//crea una vista mensaje con la respuesta y la dirección de vuelta
		new MESSAGE( $mensaje, '../Controllers/ASIGNAC_QA_CONTROLLER.php'.$at );
		}
		break;//Finaliza el bloque
	case 'GENERAR'://Caso generar QA
		//Si no se reciben parametros
		if ( !$_POST ) {
            //Si el usuario tiene permisos puede ir a la vista de generar
			if(permisosAcc($_SESSION['login'],6,8)==true){
			//Variable que almacena un nuevo objecto model
			$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
			//Variable que almacena un nuevo objecto model
			$TRABAJO = new TRABAJO('', '', '', '', '');
			//Variable que almacena el array de las tuplas de entrega.
			$ET = $TRABAJO->DevolverET();
			//Creación de una nueva vista para generar QAs
			new ASIGNAC_QA_GENERAR($ET);
		//Si no tiene permisos crea una vista por defecto que mostrará el espacio de trabajo en blanco
		}else{
			//Crea una vista de defecto de usuario para que se vea el espacio de trabajo vacio
			new USUARIO_DEFAULT();
		}
		//Si se reciben parámetros
		} else {
		//Variable que almacena un nuevo objecto model
		$ASIGNACION = new ASIGNAC_QA_MODEL($_REQUEST['IdTrabajo'], '', '', '');
		//Variable que almacena un nuevo objecto model
		$TRABAJO = new TRABAJO($_REQUEST['IdTrabajo'], '', '', '', '');
		//Si no se encuentra la ET que se desea generar, muestra un mensaje y no se realiza
		if ($TRABAJO->DevolverArray($_REQUEST['IdTrabajo']) == null) {
			//Variable que almacena la accion a la que tiene que volever 
			$at = "?action=GENERAR";
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( 'No hay entregas para realizar la asignación', '../Controllers/ASIGNAC_QA_CONTROLLER.php'.$at );
		}
		//Variable que almacena el array de las tuplas de entrega.
		$miarray = $TRABAJO->DevolverArray($_REQUEST['IdTrabajo']);
		//Comprobamos que haya un minimo de entregas para generar el número solicitado
		//Si no hay un minimo enviamos mensaje de que no se puede generar
		if (count($miarray) <= $_REQUEST['num']) {
			//Variable que almacena la accion a la que tiene que volever 
			$at = "?action=GENERAR";
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( 'No hay suficiente número de entregas para asignar el número de QAs solicitado', '../Controllers/ASIGNAC_QA_CONTROLLER.php' .$at );
		//Si hay un número suficiente de entregas inserta las qas en la tabla asignac_qa
		} else {
			//Variable que guarda el nombre de la QA
		$NombreQA = "QA" . substr($_REQUEST['IdTrabajo'], 2);
		//Bucle que llena las posiciones de cada trabajo, que nos sirve para ver que tengan el número deseado
		for ($i=0; $i < count($miarray); $i++) { $veces[] = 0; }
		//Variable que almacena el número de la posición del array en el que estamos
		$cont = 0;
		//Bucle que recorre todas las tuplas para obtener el LoginEvaluador.
		for ($i=0; $i < count($miarray); $i++) { 
				//Variable que almacena el número de pasadas a realizar con cada login sobre el array de trabajos
				$pasadas = 0;//Inicializamos la variable a 0
                //Mientras la variable pasadas sea distinto del número de QAs a generar
				while($pasadas != $_REQUEST['num']){
					$pasadas++;//Se incrementa la variable
					//Si el contador llega al número de datos, reinicia el contador
					if($cont == count($miarray)){ $cont = 0; }
					//Si coinciden los logins salta la posción
					if($miarray[$cont][1] == $miarray[$i][1]){ $cont++; }
					//Si la variable ya se asigno 5 veces pasa a la siguiente mientras sea 5 el valor
					while($veces[$cont] >= $_REQUEST['num']){ 
						$cont++;//Se incrementa contador
						//Si la variable es mayor que el tamaño del array reinicia la variable contador
						if($cont == count($miarray)){ $cont = 0; }
					}
					
					$IdTrabajo=$NombreQA;//Variable que almacena $IdTrabajo
					$LoginEvaluador=$miarray[$i][1];//Variable que almacena $LoginEvaluador
					$LoginEvaluado=$miarray[$cont][1];//Variable que almacena $LoginEvaluado
					$AliasEvaluado=$miarray[$cont][2];//Variable que almacena $AliasEvaluado
					//Creamos un nuevo objecto Asignacion Model para instanciar las variables
					$ASIGNACION = new ASIGNAC_QA_MODEL($IdTrabajo,$LoginEvaluador,$LoginEvaluado,$AliasEvaluado);

					$resultado = $ASIGNACION->ADD();//Añadimos los datos a la tabla
					$veces[$cont]++; //Incrementamos la posición del trabajo
					$cont++;//Incrementamos posición del array
					
				}
			}
			//Variable que almacena la accion a la que tiene que volever 
			$at = "?action=GENERAR";
			//crea una vista mensaje con la respuesta y la dirección de vuelta 
			new MESSAGE( $resultado, '../Controllers/ASIGNAC_QA_CONTROLLER.php' . $at);
			//new MESSAGE( 'Asignacion generada con exito', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
			//Finaliza el bloque
		}

	}
		break;//Finaliza el bloque
	case 'ADD'://Caso añadir 
		//Si no se reciben datos POST crear la vista para añadir una tupla a la tabla ASIGNAC_QA
		if ( !$_POST ) {
			//Si el usuario tiene permisos pues le muestra la vista con el formulario de añadir
			if(permisosAcc($_SESSION['login'],6,0)==true){
				//Variable que almacena un objeto TRABAJO(modelo)
				$TRABAJO= new TRABAJO('','','','','');
				//Variable que almacena un recordset con todos los trabjaos
				$TRABAJOS=$TRABAJO->SEARCH3();
				//Variable que almacena un objecto ENTREGA_MODEL
				$USU= new ENTREGA_MODEL('','','','','');
				//Variable que almacena un recordset con todos los usuarios
				$USU=$USU->obtenerUsuarios();
				//Crea una vista de añadir ASIGNAC_QA
				new ASIGNAC_QA_ADD($TRABAJOS,$USU);
			//Si no tiene permisos muestra una vista con el mensaje informando que no tiene permisos
			}else{
				//Crea una vista mensaje con el mensaje a mostrar
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
			}
		//Si se reciben datos POST se añade una nueva tupla a la tabla ASIGNAC_QA
		} else {
			//Variable que almacena un objecto ASIGNAC_QA_MODEL con los datos recogidos
			$ASIGNACION = get_data_form();
            //Variable que llama al modelo de entregas y guarda dichas entregas
            $ENTREGA = new ENTREGA_MODEL('','','','','');
            
            //Se llama a la función del modelo de entrega que cogerá un alias según el login evaluado y el id del trabajo
            $datos = $ENTREGA->recuperarEntrega($_REQUEST['LoginEvaluado'], $_REQUEST['IdTrabajo']);
            //Si el alias recuperado no se corresponde con el seleccionado nos dará un aviso de ello
            if($datos[0] != $_REQUEST['AliasEvaluado']){
                //Se define un mensaje determinado
                $respuesta = 'El alias evaluado no se corresponde con LoginEvaluado';
                //Se crea la vista con el mensaje definido anteriormente
                new MESSAGE($respuesta, '../Controllers/ASIGNAC_QA_CONTROLLER.php');
            }
			else{
            //Variable que almacena la respuesta de realizar la insercion
			 $respuesta = $ASIGNACION->ADD2();
			//Crea la vista mensaje con el mensaje informativo
			new MESSAGE( $respuesta, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
            }
		}
		break;//Finaliza el bloque
	case 'DELETE'://Caso borrar
		//Si no se reciben datos POST
		if ( !$_POST ) {
			//Comprobamos si el usuario se tiene permisos para borrar una tupla de la tabla delete
			if(permisosAcc($_SESSION['login'],6,1)==true){
				//Variable que almacena un objecto ASIGNAC_QA_MODEL
				$ASIGNACION = new ASIGNAC_QA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], '', $_REQUEST['AliasEvaluado']);
				//Variable que almacena un recordset de la ASIGNACION_qa que se relaciona con IDtrabajo LoginEvaluador,AliasEvaluado que se pasa como parametro
				$valores = $ASIGNACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
				//Variable que almacena un recordset de las dependencias a la hora de borrar que se relacionan con IDtrabajo LoginEvaluador,AliasEvaluado que se pasa como parametro
				$dependencias = $ASIGNACION->dependencias( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
				//Variable que almacena un recordset de la la dependencias a la hora de borrar que se relacionan con IDtrabajo LoginEvaluador,AliasEvaluado que se pasa como parametro
				$dependencias2 = $ASIGNACION->dependencias2( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
				//Crea una nueva vista para borrar una tupla de la tabla ASINAC_QA
				new ASIGNAC_QA_DELETE( $valores, $dependencias, $dependencias2 );
			//Si no se tiene permisos se crea vista con un mensaje indicando que no tiene permisos
			}else{
				//Crea una nueva vista mostrarndo un mensaje de que no tiene permisos
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
			}
		//Si se reciben datos, borra la tupla que contenga la información recogida
		} else {
			//Variable que almacena un objecto ASIGNAC_QA_MODEL con los datos recogidos
			$ASIGNACION = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $ASIGNACION->DELETE();
			//Crea una vista mensaje para mostrar el mensaje de la sentencia
			new MESSAGE( $respuesta, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		break;//Finaliza el bloque
	case 'EDIT'://Caso editar
		//Si no se reciben datos se muestra una vista con un formulario para editar la tupla deseada
		if ( !$_POST ) {
			//Comprobamos si el usuario tiene permisos, si tiene le muestra la vista para editar
			if(permisosAcc($_SESSION['login'],6,2)==true){
				//Variable que almacena un objecto ASIGNAC_QA_MODEL
				$ASIGNACION = new ASIGNAC_QA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], '', $_REQUEST['AliasEvaluado']);
				//Variable que almacena un recodset de la informacion de los datos relacionados con IdTrabajo,LoginEvaluador,AliasEvaluado que se pasan como parametro
				$valores = $ASIGNACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
				//Crea una nueva vista con el formulario editar
				new ASIGNAC_QA_EDIT( $valores );
			//Si no se tiene permisos, se muestra un vista mensaje informanco que no tiene los permisos
			}else{
				//Crea una vista que muestra el mensaje informando de que no tiene permisos
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
			}
		//Si se reciben datos actualiza la tupla con los datos recogidos
		} else {
			//Variable que almacena un objecto ASIGNAC_QA_MODEL con los datos recogidos
			$ASIGNACION = get_data_form();
			//Variable que almacena la respuesta de realizar la actualización
			$respuesta = $ASIGNACION->EDIT();
			//Crea una vista que muestra el mensaje informando de que no tiene permisos
			new MESSAGE( $respuesta, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		break;//Finaliza el bloque
	case 'SEARCH'://caso buscar
		//Si no se reciben datos POST muestra una vista con un formulario de busqueda
		if ( !$_POST ) {
			//Comprueba que el usuario tiene permisos para buscar, si los tiene le muestra la vista de buscar
			if(permisosAcc($_SESSION['login'],6,3)==true){
				//Crea la vista de buscar
				new ASIGNAC_QA_SEARCH();
			//Si no se tienen permisos muestra una vista con un mensaje de que no tiene permisos
			}else{
				//Crea una vista que muestra el mensaje informando de que no tiene permisos
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
			}
		//Si ser reciben datos POST busca en la base de datos y muestra el resultado en la vista showall
		} else {
			//Variable que almacena un objecto ASIGNAC_QA_MODEL con los datos recogidos
			$ASIGNACION = get_data_form();
			//Variable que almacena un recordset de la busqueda de los parametros recogidos
			$datos = $ASIGNACION->SEARCH();
			//Variable que almacena un array con los atributos a mostrar en el showall
			$lista = array( 'NombreTrabajo','LoginEvaluador','LoginEvaluado', 'AliasEvaluado' );
			//Crea una nueva vista showall mostrando el resultado de la busqueda
			new ASIGNAC_QA_SHOWALL( $lista, $datos );
		}
		break;//Finaliza el bloque
	case 'SHOWCURRENT'://caso mostrar en detalle
		//Si tiene permisos el usuario muestra una vista con los datos de la tupla elegida
		if(permisosAcc($_SESSION['login'],6,4)==true){
			//Variable que almacena un nuevo objecto ASIGNAC_QA_MODEL
			$ASIGNACION = new ASIGNAC_QA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], '', $_REQUEST['AliasEvaluado']);
			//Variable que almacena un recordset de la ASIGNACION_qa que se relaciona con IDtrabajo LoginEvaluador,AliasEvaluado que se pasa como parametro
			$valores = $ASIGNACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
			//Crea una vista de showcurrent para los valores 
			new ASIGNAC_QA_SHOWCURRENT( $valores );
		//Si no tiene permisos se muestra una vista mensaje con un mensaje indicando que no tiene permisos
		}else{
				//Crea una vista que muestra el mensaje informando de que no tiene permisos
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		break;//Finaliza el bloque
	default://caso por defecto
	//Comprueba que el usuario tiene permisos para ver el showall, si los tiene le muestra la vista de showall
	if(permisosAcc($_SESSION['login'],6,5)==true){
		//Si no se reciben datos POST crea un modelo general para recoger todos los datos
		if ( !$_POST ) {
			////Variable que almacena un objecto ASIGNAC_QA_MODEL
			$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
		//Si se reciben parametros crea un modelo con los datos recogidos
		} else {
			//Variable que almacena un objecto ASIGNAC_QA_MODEL con los datos recogidos
			$ASIGNACION = get_data_form();
		}
		//Variable que almacena un recordset con todos los valores de la tabla ASICNAC_QA
		$datos = $ASIGNACION->SEARCH();
		//Variable que almacena un array con todos los atributos a mostrar en la vista
		$lista = array( 'NombreTrabajo','LoginEvaluador','LoginEvaluado', 'AliasEvaluado' );
		//Crea una vista showall para mostrar las tuplas
		new ASIGNAC_QA_SHOWALL( $lista, $datos );
	//Si no tiene permisos crea una vista por defecto que mostrará el espacio de trabajo en blanco
	}else{
		//Crea una vista de defecto de usuario para que se vea el espacio de trabajo vacio
		new USUARIO_DEFAULT();
	}
	
}
//finaliza el controlador

?>