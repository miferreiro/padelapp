<?php
//modelo que interactuará con el controlador de TRABAJO y llevará datos a la base de datos ó recogerá valores de la base de datos.
//Fecha de creación:23/11/2017 //Autor:Brais Rodríguez


//clase del modelo TRABAJO
class TRABAJO{

    var $IdTrabajo;//clave de la tabla de TRABAJO
    var $NombreTrabajo;//declaración de la variable NombreTrabajo
    var $FechaIniTrabajo;//declaracion de la variable FechaIniTrabajo
    var $FechaFinTrabajo;//declaracion de la variable FechaFinTrabajo
    var $PorcentajeNota; //declaracion de la variable PorcentajeNota
    var $dependencias;//declaracion de la variable dependencias
    var $dependencias2;//declaracion de la variable dependencias2
    var $dependencias3;//declaracion de la variable dependencias3
    var $dependencias4;//declaracion de la variable dependencias4
    var $dependencias5;//declaracion de la variable dependencias5
     var $mysqli;//declaración de la variable que se conectará a la base de datos
    
    //constructor de la clase
    function __construct($IdTrabajo,$NombreTrabajo,$FechaIniTrabajo,$FechaFinTrabajo,$PorcentajeNota){
        //Asignamos valores a los atributos de la clase
        $this->IdTrabajo=$IdTrabajo;//declaracion de la variable que almacena IdTrabajo
        $this->NombreTrabajo=$NombreTrabajo;//declaracion de la variable que almacena NombreTrabajo
        $this->FechaIniTrabajo=$FechaIniTrabajo;//declaracion de la variable que almacena FechaIniTrabajo
        $this->FechaFinTrabajo=$FechaFinTrabajo;//declaracion de la variable que almacena FechaFinTrabajo
        $this->PorcentajeNota=$PorcentajeNota;//declaracion de la variable que almacena PorcentajeNota
        
          // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        
    }//fin del constructor

        

    //funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		
        include_once '../Models/USU_GRUPO_MODEL.php';//incluimos el modelo de USU_GRUPO
         $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del tipo USU_GRUPO
         $ADMIN = $USUARIO->comprobarAdmin();//llamamos a este metodo para comprobar si el usuario es administrador
        
        // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdTrabajo,
                        NombreTrabajo,
                        FechaIniTrabajo,
                        FechaFinTrabajo,
                        PorcentajeNota
       			from TRABAJO
    			where 
    				(
					(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY NombreTrabajo LIKE '%$this->NombreTrabajo%') &&
                    (BINARY DATE_FORMAT(FechaIniTrabajo,'%d/%m/%Y') LIKE '%$this->FechaIniTrabajo%') &&
                    (BINARY DATE_FORMAT(FechaFinTrabajo,'%d/%m/%Y') LIKE '%$this->FechaFinTrabajo%') &&
                    (BINARY PorcentajeNota LIKE '%$this->PorcentajeNota%') 
    				)";//se construye la sentencia sql
        
        
 
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
	
   //funcion SEARCH2: hace una búsqueda de ETs en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH2() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdTrabajo,
                        NombreTrabajo,
                        FechaIniTrabajo,
                        FechaFinTrabajo,
                        PorcentajeNota
       			from TRABAJO
    			where 
    				(
					(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY NombreTrabajo LIKE '%ET%') &&
                    (BINARY DATE_FORMAT(FechaIniTrabajo,'%d/%m/%Y') LIKE '%$this->FechaIniTrabajo%') &&
                    (BINARY DATE_FORMAT(FechaFinTrabajo,'%d/%m/%Y') LIKE '%$this->FechaFinTrabajo%') &&
                    (BINARY PorcentajeNota LIKE '%$this->PorcentajeNota%') &&  CURDATE() >= FechaIniTrabajo
    				)";//se construye la sentencia sql
        
        
 
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
    
    
    //funcion SEARCH3: hace una búsqueda de ETs en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
    function SEARCH3() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdTrabajo,
                        NombreTrabajo,
                        FechaIniTrabajo,
                        FechaFinTrabajo,
                        PorcentajeNota
       			from TRABAJO
    			where 
    				(
					(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY NombreTrabajo LIKE '%QA%') &&
                    (BINARY DATE_FORMAT(FechaIniTrabajo,'%d/%m/%Y') LIKE '%$this->FechaIniTrabajo%') &&
                    (BINARY DATE_FORMAT(FechaFinTrabajo,'%d/%m/%Y') LIKE '%$this->FechaFinTrabajo%') &&
                    (BINARY PorcentajeNota LIKE '%$this->PorcentajeNota%') &&  CURDATE() >= FechaIniTrabajo
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
		if ( ( $this->IdTrabajo <> '' ) ) { // si el atributo clave de la entidad no esta vacio

			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM TRABAJO WHERE (  IdTrabajo  = '$this->IdTrabajo')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO TRABAJO (
							    IdTrabajo,
                                NombreTrabajo,
                                FechaIniTrabajo, 
                                FechaFinTrabajo,
                                PorcentajeNota) 
								VALUES(
								'$this->IdTrabajo',
								'$this->NombreTrabajo',
								STR_TO_DATE(REPLACE('$this->FechaIniTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
								STR_TO_DATE(REPLACE('$this->FechaFinTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
                                '$this->PorcentajeNota'
								)";
                }
                    else{ //si el resultado de la consulta no es vacio
                        return 'Ya existe el trabajo introducido en la base de datos'; // ya existe
                    }
					}
					if ( !$this->mysqli->query( $sql ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Introduzca un valor'; // ya existe
    
	} // fin del metodo ADD

         // funcion DELETE()
	    // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	    // se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo' )";
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else//si no existe una tupla con ese valor de clave
			return "No existe";
	} // fin metodo DELETE
    
    
   
    
  
        // funcion RellenaDatos()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaDatos() { 

		$sql = "SELECT * FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo')";// se construye la sentencia de busqueda de la tupla
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();//tupla del resultado
			$result[ 'FechaIniTrabajo' ] = date( "d/m/Y", strtotime( $result[ 'FechaIniTrabajo' ] ) );//se pone la fecha en formato europeo
			$result[ 'FechaFinTrabajo' ] = date( "d/m/Y", strtotime( $result[ 'FechaFinTrabajo' ] ) );//de pone la fecha en formato europeo
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
    
    //Esta funcion sirve para obtener el porcentaje total de todos los trabajos
    function obtenerPorcentajeTotal(){
        $sql = "SELECT SUM(PorcentajeNota) FROM TRABAJO";//se construye la sentencia sql
        
        if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} 
        else {//si no da error
            $result = mysqli_fetch_row($result);//devolvemos el resultado
            return $result;
        }
            
    }
    
    //Esta funcion sirve para obtener el porcentaje de un trabajo
    function obtenerPorcentaje($trabajo){
        $sql = "SELECT PorcentajeNota FROM TRABAJO WHERE IdTrabajo = '$trabajo'";//se construye la sentencia sql
        
        if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} 
        else { // si no da error la ejecución de la query
            $result = mysqli_fetch_row($result);//devolvemos el resultado
            return $result;
        }
            
    }
    
    //Esta función se utiliza para saber las dependencias de la tabla a la hora de borrar
    function dependencias() { 
        
        $dependencias = null;//inicializamos la variable a null

		$sql = "SELECT NombreTrabajo, LoginEvaluador, AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, TRABAJO T WHERE E.IdTrabajo = '$this->IdTrabajo' AND E.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//si el numero de tuplas es mayor o igual a uno
            $dependencias = $resultado;//asignamos las dependecias
        }
        
        return $dependencias;
	} // fin del metodo dependencias()
    
     //Esta función se utiliza para saber las dependencias de la tabla a la hora de borrar
    function dependencias2() { 
        
        $dependencias2 = null;//inicializamos la variable a null

		$sql = "SELECT NombreTrabajo, IdHistoria, TextoHistoria FROM HISTORIA H, TRABAJO T WHERE H.IdTrabajo = '$this->IdTrabajo' AND H.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//si el numero de tuplas es mayor o igual a uno
            $dependencias2 = $resultado;//asignamos las dependecias
        }
        
        return $dependencias2;
	} // fin del metodo dependencias2()
    
     //Esta función se utiliza para saber las dependencias de la tabla a la hora de borrar
    function dependencias3() { 
        
        $dependencias3 = null;//inicializamos la variable a null

		$sql = "SELECT login, NombreTrabajo, NotaTrabajo FROM NOTA_TRABAJO NT, TRABAJO T WHERE NT.IdTrabajo = '$this->IdTrabajo' AND NT.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//si el numero de tuplas es mayor o igual a uno
            $dependencias3 = $resultado;//asignamos las dependecias
        }
        
        return $dependencias3;
	} // fin del metodo dependencias3()
    
     //Esta función se utiliza para saber las dependencias de la tabla a la hora de borrar
    function dependencias4() { 
        
        $dependencias4 = null;//inicializamos la variable a null

		$sql = "SELECT NombreTrabajo, LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, TRABAJO T WHERE QA.IdTrabajo = '$this->IdTrabajo' AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//si el numero de tuplas es mayor o igual a uno
            $dependencias4 = $resultado;//asignamos las dependecias
        }
        
        return $dependencias4;
	} // fin del metodo dependencias4()

     //Esta función se utiliza para saber las dependencias de la tabla a la hora de borrar
    function dependencias5() { 
        
        $dependencias5 = null;//inicializamos la variable a null

		$sql = "SELECT login, NombreTrabajo, Alias, Horas, Ruta FROM ENTREGA E, TRABAJO T WHERE E.IdTrabajo = '$this->IdTrabajo' AND E.IdTrabajo=T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//si el numero de tuplas es mayor o igual a uno
            $dependencias5 = $resultado;//asignamos las dependecias
        }
        
        return $dependencias5;
	} // fin del metodo dependencias5()
        
        
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		
		if ( $result->num_rows == 1 ) { // si el numero de filas es igual a uno es que lo encuentra
			// se construye la sentencia de modificacion en base a los atributos de la clase
				$sql = "UPDATE TRABAJO SET 
					IdTrabajo = '$this->IdTrabajo',
					 NombreTrabajo='$this->NombreTrabajo',
					 FechaIniTrabajo = STR_TO_DATE(REPLACE('$this->FechaIniTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
					 FechaFinTrabajo = STR_TO_DATE(REPLACE('$this->FechaFinTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
                     PorcentajeNota='$this->PorcentajeNota'
				WHERE ( IdTrabajo  = '$this->IdTrabajo'
				)";//se construye la sentencia sql
            
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
			return 'No existe en la base de datos';
	} // fin del metodo EDIT

    //Función de devuelve el array con todas las entregas pertenecientes al trabajo que se pasa como parametro
	function DevolverArray($Entrega){
		//Consulta que recupera la tabla trabajo
			$sql = "select ENTREGA.IdTrabajo,
						   login,
						   Alias
						   from ENTREGA,TRABAJO
						   where ENTREGA.IdTrabajo = TRABAJO.IdTrabajo
						   AND ENTREGA.IdTrabajo = '$Entrega'
						   AND Ruta != ''
						   order by login";
			//variable que almacena el resultado de la query
			$resultado = $this->mysqli->query( $sql );
			if ( $resultado->num_rows == 0 ) { return null; }
			
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Variable que almacena el array de las tuplas resultado de la query
				$miarray[] = $datos;
			}
			//devuelve el array
			return $miarray;
	}

    //Esta función nos devuelve el Idtrabajo y NombreTrabjo de las entregas(ET)
	function DevolverET(){
		$sql = "SELECT IdTrabajo,NombreTrabajo FROM `TRABAJO` WHERE (BINARY IdTrabajo LIKE 'ET%')"; //se construye la sentencia sql
		//variable que almacena el resultado de la query
			$resultado = $this->mysqli->query( $sql );
			if ( $resultado->num_rows == 0 ) { return null; }//si el numero de filas es 0
			
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Variable que almacena el array de las tuplas resultado de la query
				$miarray[] = $datos;
			}
			//devuelve el array
			return $miarray;
	}

    //Esra fucion nos devuelve el IdTrabajo y NombreTrabajo de las QAs
	function DevolverQA(){
		$sql = "SELECT IdTrabajo,NombreTrabajo FROM `TRABAJO` WHERE (BINARY IdTrabajo LIKE 'QA%')"; //se construye la sentencia sql
		//variable que almacena el resultado de la query
			$resultado = $this->mysqli->query( $sql );
			if ( $resultado->num_rows == 0 ) { return null; }//mira si el numero de tuplas es cero
			
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Variable que almacena el array de las tuplas resultado de la query
				$miarray[] = $datos;
			}
			//devuelve el array
			return $miarray;
	}


          
    }


?>