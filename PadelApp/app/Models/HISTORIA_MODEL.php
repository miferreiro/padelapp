<?php

//modelo de datos definida con una clase que interactúa con el controlador que gestiona la historia.
//Fecha de creación:2/12/2017 //Autor:Alejandro Vila

//declaración de la clase
    class HISTORIA_MODEL{
        
        //Se definen las vaiables que se utilizarán en esta clase
        var $IdTrabajo; //es la clave de la tabla HISTORIA.
        var $IdHistoria;//Declaracion de la variable IdHistoria
        var $TextoHistoria;//Declaracion de la variable TextoHistoria
        var $dependencias; //declaracion de la variable dependencias
         var $mysqli;//declaración de la variable que se conectará a la base de datos
        
      //Es el constructo de la clase HISTORIA_MODEL      
        function __construct($IdTrabajo,$IdHistoria,$TextoHistoria){
            //Asignamos valores a los atributos de la clase
            $this->IdTrabajo=$IdTrabajo;//declaracion de la variable que almacena Idtrabajo
            $this->IdHistoria=$IdHistoria;//declaracion de la variable que almacena IdHistoria
            $this->TextoHistoria=$TextoHistoria;//declaracion de la variable que almacena TextoHistoria
            
            // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        }//fin del constructor
        
        
        
	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  H.IdTrabajo,
						T.NombreTrabajo,
                        IdHistoria,
                        TextoHistoria
       			from HISTORIA H, TRABAJO T
    			where 
    				(
					(BINARY H.IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY IdHistoria LIKE '%$this->IdHistoria%') &&
                    (BINARY TextoHistoria LIKE '%$this->TextoHistoria%') &&
					T.IdTrabajo=H.IdTrabajo
    				)";//se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
        
        
    //Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->IdTrabajo <> '' && $this->IdHistoria <> '' ) ) { // si el atributo clave de la entidad no esta vacio

          
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM HISTORIA WHERE (  IdTrabajo = '$this->IdTrabajo' AND IdHistoria = '$this->IdHistoria')";//se construye la sentencia sql

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO HISTORIA (
							    IdTrabajo,
                                IdHistoria,
                                TextoHistoria) 
								VALUES(
								'$this->IdTrabajo',
								'$this->IdHistoria',
								'$this->TextoHistoria'
								)";//se construye la sentencia sql para inserción
                }
                    else{//si el resultado de la consulta no es vacío
                        return 'Ya existe la historia introducida en la base de datos'; // ya existe
                    }
                }
					if ( !$this->mysqli->query( $sql ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Inserta un valor'; // ya existe
    
	} // fin del metodo ADD

         // funcion DELETE()
	    // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	    // se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM HISTORIA WHERE (IdTrabajo = '$this->IdTrabajo' AND IdHistoria = '$this->IdHistoria')";//se construye la sentencia sql
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave
        if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM HISTORIA WHERE (IdTrabajo = '$this->IdTrabajo' AND IdHistoria = '$this->IdHistoria' )";//se construye la sentencia sql de borrado
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else
			return "No existe";
	} // fin metodo DELETE
  
        // funcion RellenaDatos()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT * FROM HISTORIA WHERE (IdTrabajo = '$this->IdTrabajo' AND IdHistoria = '$this->IdHistoria')";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Se aplica fetch_array sobre $resultado para crear un array y se guarda en $resultado
			$resultado = $resultado->fetch_array();
			return $resultado;
		}
	} // fin del metodo RellenaDatos()
        
        //Esta función sirve para saber si esta tabla tiene dependencias a la hora de borrar
        function dependencias() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias = null;//inicializamos la varriable a null

		$sql = "SELECT NombreTrabajo,LoginEvaluador, AliasEvaluado, E.IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, HISTORIA H, TRABAJO T WHERE E.IdHistoria = '$this->IdHistoria' AND E.IdHistoria = H.IdHistoria AND H.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de filas es mayor o igual a uno
            $dependencias = $resultado;//asignamos todas las dependencias
        }
        
        return $dependencias;
	} // fin del metodo dependencias()
        		
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM HISTORIA WHERE (IdTrabajo = '$this->IdTrabajo' AND IdHistoria = '$this->IdHistoria')";//se construye la sentencia sql
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			
				$sql = "UPDATE HISTORIA SET 
					IdTrabajo = '$this->IdTrabajo',
					 IdHistoria='$this->IdHistoria',
                     TextoHistoria='$this->TextoHistoria'
				WHERE ( IdTrabajo = '$this->IdTrabajo' AND IdHistoria = '$this->IdHistoria'
				)";//se construye la sentencia sql de modificación
            
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
			return 'No existe en la base de datos';
	} // fin del metodo EDIT

    //Esta función nos devuelve todas las historias de un trabajo
    function DevolverHistorias($Id){
		//Consulta que recupera la tabla trabajo
		$sql = "select IdHistoria
					   from HISTORIA
					   where IdTrabajo = '$Id'";//se construye la sentencia sql
		$resultado = $this->mysqli->query( $sql );//se ejecuta la query
		if ( $resultado->num_rows == 0 ) { return null; }//miramos si el numero de tuplas es 0
		//Caragamos las tuplas resultado de la consulta en un array y lo recorremos
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		return $miarray;	
	}
           
    }
?>