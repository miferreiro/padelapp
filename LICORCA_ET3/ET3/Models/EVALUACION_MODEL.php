<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos de la tabla EVALUACION
 Fecha de creación:23/11/2017 
 Autor:Brais Rodríguez
*/

//declaración de la clase
class EVALUACION{ 

    var $IdTrabajo; //declaración de idtrabajo
	var $LoginEvaluador; // declaración del atributo LoginEvaluador
    var $AliasEvaluado;//declaración del atributo AliasEvaluado
	var $IdHistoria; // declaración del atributo IdHistoria
	var $CorrectoA; // declaración del atributo CorrectoA
	var $ComenIncorrectoA; // declaración del atributo ComenIncorrectoA
    var $CorrectoP; // declaración del atributo CorrectoP
    var $ComentIncorrectoP;//declaración del atributo ComenIncorrectoP
	var $OK; // declaración del atributo OK
	var $mysqli; // declaración del atributo manejador de la bd

	//Constructor de la clase
	function __construct($IdTrabajo,$LoginEvaluador,$AliasEvaluado,$IdHistoria,$CorrectoA,$ComenIncorrectoA,$CorrectoP,$ComentIncorrectoP,$OK) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->IdTrabajo = $IdTrabajo;//declaracion de la variable que almacena IdTrabajo
		$this->LoginEvaluador = $LoginEvaluador;//declaracion de la variable que almacena LoginEvaluador
        $this->AliasEvaluado=$AliasEvaluado;//declaracion de la variable que almacena AliasEvaluado
		$this->IdHistoria = $IdHistoria;//declaracion de la variable que almacena IdHistoria
		$this->CorrectoA = $CorrectoA;//declaracion de la variable que almacena Correcto
		$this->ComenIncorrectoA = $ComenIncorrectoA;//declaracion de la variable que almacena ComenIncorrectoA
        $this->CorrectoP = $CorrectoP;//declaracion de la variable que almacena CorrectoP
        $this->ComentIncorrectoP=$ComentIncorrectoP;//declaracion de la variable que almacena ComentInCorrectoP
		$this->OK = $OK;//declaracion de la variable que almacena OK
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor
    
	//función que devuelve el CorrectoA y ComenIncorrectoA de De un usuario sobre un alias en una historia dentro de un IdTrabajo 
	function DevolverCommentAlumno($log,$al,$id,$trabajo){
        
    //Variable que almacena la sentencia sql
    $sql = "SELECT CorrectoA,ComenIncorrectoA 
    		FROM EVALUACION
    		WHERE LoginEvaluador = '$log' &&
    			  AliasEvaluado = '$al' && 
    			  IdHistoria = '$id' && 
    			  IdTrabajo = '$trabajo'";
     //Variable que almacena el resultado de una query    
    $resultado = $this->mysqli->query( $sql );
    	//si el resultado de la query tiene 0 filas devuelve null
		if ( $resultado->num_rows == 0 ) { return null; }
		//Cargamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		//retorna el array
		return $miarray;	
        
    }

    //Función que devuelve la todas las evaluaciones de un alias en forma de array
	function EvaluacionesQa($alias){
        
    //Variable que almacena la sentencia sql
    $sql = "SELECT E.IdHistoria,CorrectoA,ComenIncorrectoA,CorrectoP,ComentIncorrectoP,OK,TextoHistoria,LoginEvaluador,AliasEvaluado,E.IdTrabajo,CorrectoA,ComenIncorrectoA
			FROM EVALUACION E,HISTORIA H
			WHERE AliasEvaluado = '$alias' &&
				  E.IdHistoria = H.IdHistoria &&
				  SUBSTRING(E.IdTrabajo,3) = SUBSTRING(H.IdTrabajo,3)
			ORDER BY E.IdHistoria";
    //Variable que almacena la respuesta de la consulta de la query
    $resultado = $this->mysqli->query( $sql );
    //Si la consulta devuelve 0 filas retorna null
		if ( $resultado->num_rows == 0 ) { return null; }
		//Cargamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		//devuelve el array
		return $miarray;	
        
    }
    
     //Esta función nos devuelve el IdTrabajo y login donde el IdTrabajo sea una QA
    function cogerDatosQA($trabajo){
    	//Variable que almacena la sentencia sql
         $sql = "SELECT IdTrabajo,LoginEvaluador FROM EVALUACION WHERE IdTrabajo LIKE '%qa%' AND IdTrabajo='$trabajo'";
            //Si la query falla devuelve el mensaje de error
            if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			         return 'Error en la consulta sobre la base de datos';
		  //Si no falla devuelve el resultado
		  } else {
           
            return $resultado;
		}
    }

 /*****************************************************************************************************/
    //PARA CORRECCION DE QAS Y ENTREGAS
//Función que devuelve todas las entregas referentes a un usuario
function mostrarEntregas($nombre){
        
    //Variable que almacena la sentencia sql
    $sql = "SELECT DISTINCT login,E.IdTrabajo,ET.IdTrabajo AS Entrega,T.NombreTrabajo  FROM ENTREGA ET,EVALUACION E,TRABAJO T WHERE  ET.Alias=E.AliasEvaluado AND login='$nombre' && E.IdTrabajo=T.IdTrabajo";
     //Si la query da error devuelve el mensaje de error
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		//Si no falla devuelve el resultado
		} else { 
			return $resultado;
		}
        
    }
    
   //Función que devuelve todas las QAs referentes a un usuario
   function mostrarQAS($nombre){
   	//Variable que almacena la sentencia sql
    $sql = "SELECT  DISTINCT LoginEvaluador,E.IdTrabajo,T.NombreTrabajo FROM EVALUACION E, TRABAJO T  WHERE LoginEvaluador='$nombre' && E.IdTrabajo=T.IdTrabajo ";
    //Si la query da error devuelve el mensaje de error
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		//Si no falla devuelve el resultado
	} else {
			return $resultado;
		}
        
    }
    
    //Funcíón que devuelve todas las entregas hechas de un usuario para ver las correciones
    function mostrarCorrecion($IdTrabajo,$nombre){
    	//Variable que almacena la sentencia sql
        $sql = "SELECT DISTINCT LoginEvaluador,ET.login,E.IdTrabajo FROM EVALUACION E,ENTREGA ET WHERE 
        ( Alias = AliasEvaluado && login='$nombre' && E.IdTrabajo='$IdTrabajo')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
	//Si la query da error devuelve el mensaje de error
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		//Si no falla devñuelve el resultado
	} else { 
			return $resultado;
		}
    }
   //Función que devuelve la correción hecha de la entrega de un usuario
  function mostrarCorrecion1($IdTrabajo,$nombre,$entrega){
  		//Variable que almacena una setencia sql 
        $sql ="SELECT DISTINCT H.IdTrabajo,NombreTrabajo,LoginEvaluador,TextoHistoria,H.IdHistoria,CorrectoP,ComentIncorrectoP FROM EVALUACION E,ENTREGA ET,HISTORIA H,TRABAJO T WHERE 
        ( E.IdTrabajo = '$IdTrabajo' && H.IdTrabajo ='$entrega' && H.IdHistoria=E.IdHistoria && Alias = AliasEvaluado && T.IdTrabajo=H.IdTrabajo && login='$nombre') GROUP BY H.IdHistoria;"; 
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		
    //Si la query da error devuelve el mensaje de error
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		//Si no falla devuelve el resultado
	} else { // si existe se devuelve la tupla resultado
 
			return $resultado;
		}
    }
  		 //Función que devuelve los alias que as evaluado de una QA en concreto
        function mostrarCorrecion2($IdTrabajo,$nombre){
        //Variable que almacena una setencia sql 
        $sql = "SELECT DISTINCT LoginEvaluador,AliasEvaluado,E.IdTrabajo,T.NombreTrabajo FROM EVALUACION E, TRABAJO T  WHERE 
        ( E.IdTrabajo = '$IdTrabajo' && LoginEvaluador='$nombre' && E.IdTrabajo=T.IdTrabajo)";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		// si existe se devuelve la tupla resultado
		} else { 
			return $resultado;
		}
}
  //Función que devuelve la correcion de una Qa de un usuario
 function mostrarCorrecion3($IdTrabajo,$nombre,$alias){
       //Variable que almacena una setencia sql 
       $sql ="SELECT LoginEvaluador,AliasEvaluado,NombreTrabajo,E.IdTrabajo,TextoHistoria,E.IdHistoria,CorrectoA,ComenIncorrectoA,OK
			FROM EVALUACION E,HISTORIA H,TRABAJO T
			WHERE T.IdTrabajo=E.IdTrabajo && AliasEvaluado = '$alias' && E.IdTrabajo='$IdTrabajo' && LoginEvaluador='$nombre' &&
				  E.IdHistoria = H.IdHistoria &&
				  SUBSTRING(E.IdTrabajo,3) = SUBSTRING(H.IdTrabajo,3)
			ORDER BY E.IdHistoria";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		// si existe se devuelve la tupla resultado
		} else { 
			return $resultado;
		}
}
    
    
/**************************************************************************************************************************/    
    
 
    

	//funcion SEARCH: hace una búsqueda en la tabla con 
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		//Variable que almacena la sentencia sql
		$sql = "select  E.IdTrabajo,
					T.NombreTrabajo,
                    LoginEvaluador,
                    AliasEvaluado,
					E.IdHistoria,
					CorrectoA,
					ComenIncorrectoA,
                    CorrectoP,
                    ComentIncorrectoP,
					OK,
					TextoHistoria
       			from EVALUACION E,HISTORIA H,TRABAJO T
    			where 
    				(
    				H.IdHistoria = E.IdHistoria &&
					E.IdTrabajo = T.IdTrabajo &&
    				SUBSTRING(E.IdTrabajo,3) = SUBSTRING(H.IdTrabajo,3) &&
					(BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
					(BINARY LoginEvaluador LIKE '%$this->LoginEvaluador%') &&
                    (BINARY AliasEvaluado LIKE '%$this->AliasEvaluado%') &&
    				(BINARY E.IdHistoria LIKE '%$this->IdHistoria%') &&
					(BINARY CorrectoA LIKE '%$this->CorrectoA%') &&
	 				(BINARY ComenIncorrectoA LIKE '%$this->ComenIncorrectoA%') &&
                    (BINARY CorrectoP LIKE '%$this->CorrectoP%') &&
                    (BINARY ComentIncorrectoP LIKE '%$this->ComentIncorrectoP%') &&
	 				(BINARY OK LIKE '%$this->OK%')
    				)
    			ORDER BY AliasEvaluado,E.IdHistoria,T.IdTrabajo,LoginEvaluador	";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		// si la busqueda es correcta devolvemos el recordset resultado
		} else { 

			return $resultado;
		}
	} // fin metodo SEARCH

	//funcion SEARCH2: hace una búsqueda en la tabla con 
	//los datos proporcionados 
	function SEARCH2() {
		//Variable que almacena la sentencia sql
		$sql = "select  E.IdTrabajo,
					T.NombreTrabajo,
                    LoginEvaluador,
                    AliasEvaluado,
					E.IdHistoria,
					CorrectoA,
					ComenIncorrectoA,
                    CorrectoP,
                    ComentIncorrectoP,
					OK,
					TextoHistoria
       			from EVALUACION E,HISTORIA H,TRABAJO T
    			where 
    				(
    				H.IdHistoria = E.IdHistoria &&
					E.IdTrabajo = T.IdTrabajo &&
    				SUBSTRING(E.IdTrabajo,3) = SUBSTRING(H.IdTrabajo,3) &&
					(BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
					(BINARY LoginEvaluador = '$this->LoginEvaluador') &&
                    (BINARY AliasEvaluado LIKE '%$this->AliasEvaluado%') &&
    				(BINARY E.IdHistoria LIKE '%$this->IdHistoria%') &&
					(BINARY CorrectoA LIKE '%$this->CorrectoA%') &&
	 				(BINARY ComenIncorrectoA LIKE '%$this->ComenIncorrectoA%') &&
                    (BINARY CorrectoP LIKE '%$this->CorrectoP%') &&
                    (BINARY ComentIncorrectoP LIKE '%$this->ComentIncorrectoP%') &&
	 				(BINARY OK LIKE '%$this->OK%')
    				)
    			ORDER BY AliasEvaluado,E.IdHistoria	";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		// si la busqueda es correcta devolvemos el recordset resultado
		} else { 
			return $resultado;
		}
	} // fin metodo SEARCH


	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		// si el atributo clave de la entidad no esta vacio
		if ( ( $this->IdTrabajo <> '' && $this->LoginEvaluador <> '' && $this->AliasEvaluado <> '' && $this->IdHistoria <> '' ) ) { 
            //Variable que almacena una consulta sql
           $usuarios="SELECT * FROM USUARIO WHERE (login ='$this->LoginEvaluador')";
            //Variable que almacena el resultado de la query
            $result = $this->mysqli->query($usuarios);
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            if(!$result){
              return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara  
            }
            // si la busqueda es correcta devolvemos el recordset resultado
            else{
            		//Si el resultado de la query devuelve 0 filas devuelve mensaje de que tiene que haber un usuario previo
                    if($result->num_rows == 0){
                        return 'no puedes insertar un login evaluador, debes insertar previamente un usuario.';
                    }
                
            }
            
            //Variable que almacena la consulta sql
            $trabajo= "SELECT * FROM TRABAJO WHERE (IdTrabajo = '$this->IdTrabajo')";
            //Variable que almacena el resultado de la query
            $result = $this->mysqli->query($trabajo);
            
             //Si se produce un error al hacer la consulta devuelve mensaje de error
            if(!$result){
              return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
                
            }
            
            //Si la consulta se ejecuta correctamente comprueba las filas de las respuestas
            else{
            		//Si el numero de filas es igual a 0 devuelve mensaje de que hay que insertar trabajo antes
                      if($result->num_rows == 0){
                          
                        return 'no puedes insertar un id de trabajo, debes insertar previamente un trabajo.';
                    }
            }
            
            //Variable que almacena la consulta sql
              $al="SELECT * FROM ENTREGA WHERE (Alias = '$this->AliasEvaluado')";
            	//Variable que almacena el resultado de la query
                   $result=$this->mysqli->query($al);
                 //Si la query falla devuelve error
                if(!$result){
                    return "No se ha podido conectar a la base de datos";
                }
                //Si la consulta se ejecuta correctamente comprobamos el numero de filas
                else{
                	//Si el numero de filas devueltos es igual a 0
                    if($result->num_rows == 0){
                        return "No puedes insertar una evaluacion debido a que este alias no existe";
                    }
                }   


			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM EVALUACION WHERE (  IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
			 //Si la query falla devuelve mensaje error
			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). 
			//Si la query se ejecuta correctamente	
			} else { // si la ejecución de la query no da error
				// Si el resultado de la query tiene 0 filas realizamos la inserción
                if ($result->num_rows == 0){ 
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO EVALUACION (
							    IdTrabajo,
                                LoginEvaluador,
                                AliasEvaluado,
					            IdHistoria,
					            CorrectoA,
					            ComenIncorrectoA,
                                CorrectoP,
                                ComentIncorrectoP,
					            OK) 
								VALUES(
                                '$this->IdTrabajo',
                                '$this->LoginEvaluador',
                                '$this->AliasEvaluado',
		                        '$this->IdHistoria',
		                        '$this->CorrectoA',
		                        '$this->ComenIncorrectoA',
                                '$this->CorrectoP',
                                '$this->ComentIncorrectoP',
		                        '$this->OK'
								)";
              
                    
                }
                	//Si la consulta devuelve mas de una fila devuelve mensaje que informa de que los datos ya estan en la base de datos
                    else{
                        return 'Ya existe la acción introducida en la base de datos'; // ya existe
                    }
					}
					// si da error en la ejecución del insert devolvemos mensaje
					if ( !$this->mysqli->query( $sql ) ) { 
						return 'Error en la inserción';
					} 
                   
            		 //si no da error en la insercion devolvemos mensaje de exito
                    else {
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}
					// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
				} else 
					return 'Introduzca un valor'; // ya existe
    
	} // fin del metodo ADD

    
	//funcion de destrucción del objeto: se ejecuta automaticamente
	//al finalizar el script
	function __destruct() {

	} // fin del metodo destruct

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		//Variable que almacena una sentencia sql
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave
		if ( $result->num_rows == 1 ) {
			//Variable que almacena la sentencia sql 
			$sql = "DELETE FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} 
		// si no existe el LoginEvaluador a borrar se devuelve el mensaje de que no existe
		else
			return "No existe";
	} // fin metodo DELETE

	// funcion RellenaDatos()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla
		//Variable que almacena la consulta sql
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; 
		// si existe se devuelve la tupla resultado
		} else { 
			//Variable que almacena el resultado en un fetch_array
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()

	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// Variable que almacena la consulta sql
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// Variable que almacena el resultado de la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			     //Variable que almacena la sentencia sql
				$sql = "UPDATE EVALUACION SET 
					IdTrabajo = '$this->IdTrabajo',
					LoginEvaluador = '$this->LoginEvaluador',
                    AliasEvaluado='$this->AliasEvaluado',
					IdHistoria = '$this->IdHistoria',
					CorrectoA = '$this->CorrectoA',
					ComenIncorrectoA = '$this->ComenIncorrectoA',
                    CorrectoP = '$this->CorrectoP',
                    ComentIncorrectoP ='$this->ComentIncorrectoP',
					OK = '$this->OK'
				WHERE ( IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && 
                IdHistoria = '$this->IdHistoria'
				)";
            
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			// si no hay problemas con la modificación se indica que se ha modificado
			} else { 
				return 'Modificado correctamente';
			}
		// si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		} else 
			return 'No existe en la base de datos';
	} // fin del metodo EDIT
    
    //Funcion que permite editar la evaluación por parte de un administrador
	function EDITAR_EVALUACION_ADMIN() {
		// Variable que almacena la sentencia sql
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// Variable que almacena el resultado de la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			     //modificamos los atributos de la tabla EVALUACION
				$sql = "UPDATE EVALUACION SET 
					IdTrabajo = '$this->IdTrabajo',
					LoginEvaluador = '$this->LoginEvaluador',
                    AliasEvaluado='$this->AliasEvaluado',
					IdHistoria = '$this->IdHistoria',
                    CorrectoP = '$this->CorrectoP',
                    ComentIncorrectoP ='$this->ComentIncorrectoP',
					OK = '$this->OK'
				WHERE ( IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && 
                IdHistoria = '$this->IdHistoria'
				)";
            
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			// si no hay problemas con la modificación se indica que se ha modificado
			} else { 
				return 'Modificado correctamente';
			}
		// si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		} else 
			return 'No existe en la base de datos';
	} // fin del metodo EDIT


	//Función que devuelve todas las entregas que hay en la base de datos(para que vea el administrador)
	function DevolverEntregas(){
		//Variable que almacena la sentencia sql
		$sql = "SELECT DISTINCT login,Alias,E.IdTrabajo,Ruta,Horas,T.NombreTrabajo
				FROM ENTREGA EN,EVALUACION E,TRABAJO T
				WHERE Alias = AliasEvaluado && SUBSTRING(E.IdTrabajo,3) = SUBSTRING(EN.IdTrabajo,3)
				&& E.IdTrabajo=T.IdTrabajo
				ORDER BY login,E.IdTrabajo";
		//Si la consulta devuelve error muestra mensaje de error
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		 // si la busqueda es correcta devolvemos el recordset resultado
		} else {
			return $resultado;
		}
	}


	//Función que devuelve todas las entregas para un usuario evaluen las QAs
	function entregasUsu($nombre){
        //Variable que almacena la sentencia sql
        $sql = "SELECT DISTINCT login,Alias,E.IdTrabajo,Ruta,Horas,T.NombreTrabajo
				FROM ENTREGA EN,EVALUACION E,TRABAJO T
				WHERE Alias = AliasEvaluado &&
					  LoginEvaluador = '$nombre' &&
					  E.IdTrabajo=T.IdTrabajo  
				ORDER BY T.NombreTrabajo";
		//Si la consulta devuelve error muestra mensaje de error
        if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		 // si la busqueda es correcta devolvemos el recordset resultado
		} else {
			return $resultado;
		}     
    }

} //fin de clase

?>