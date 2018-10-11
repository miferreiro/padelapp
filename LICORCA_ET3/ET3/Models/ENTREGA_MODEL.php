<?php

//Función: modelo de datos definida con una clase que interactúa con el controlador que gestiona las entregas.
//Autor:Brais Santos
//Fecha de creación:28/11/2017 
    class ENTREGA_MODEL{
        
        //Se definen las vaiables que se utilizarán en esta clase
        var $login; //es la clave de la tabla ENTREGA
        var $IdTrabajo;// es la clave de la tabla ENTREGA
        var $Alias;//Declaracion de la variable Alias
        var $Horas; //Declaracion de la variable Horas
        var $Ruta; //Declaracion de la variable Ruta
        var $dependencias; //Declaracion de la variable dependencias
        var $dependencias2; //Declaracion de la variable dependencias2
         var $mysqli;//declaración de la variable que se conectará a la base de datos
        
        //constructor de la clase
        function __construct($login,$IdTrabajo,$Alias,$Horas,$Ruta){
            //Asignamos valores a los atributos de la clase
            $this->login=$login;//declaracion variable que almacena login
            $this->IdTrabajo=$IdTrabajo;//declaracion variable que almacena IdTrabajo
            $this->Alias=$Alias;//declaracion variable que almacena alias
            $this->Horas=$Horas;//declaracion variable que almacena horas
            $this->Ruta=$Ruta;//declaracion variable que almacena ruta
            
            // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        }//fin del constructor
        
    //Esta funcion coge el login y Idtrabajo de todas las entregas
    function cogerDatos($trabajo){
        //Variable que almacena la sentencia sql
        $sql = "SELECT IdTrabajo,login FROM ENTREGA WHERE IdTrabajo LIKE '%et%' AND IdTrabajo='$trabajo'";//Se construye la sentencia sql
            //Si la consulta falla devuelve mensaje de error          
            if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {//ejecutamos la query
			         return 'Error en la consulta sobre la base de datos';
        // si existe se devuelve la tupla resultado
		  } else { 
           
            return $resultado;
		}
    }
	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// Variable que almacena la sentencia sql
		$sql = "select login,
                        E.IdTrabajo,
						T.NombreTrabajo,
                        Alias,
                        Horas,
                        Ruta
       			from ENTREGA E, TRABAJO T
    			where 
    				(
					(BINARY login LIKE '%$this->login%') &&
                    (BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY Alias LIKE '%$this->Alias%') &&
                    (BINARY Horas LIKE '%$this->Horas%') &&
                    (BINARY Ruta LIKE '%$this->Ruta%') &&
					(E.IdTrabajo = T.IdTrabajo)
    				)";// se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
        // si la busqueda es correcta devolvemos el recordset resultado
		} else { 

			return $resultado;
		}
	} // fin metodo SEARCH
        
    //funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
    //Se utiliza en case SUBIR_ENTREGA de ENTREGA_CONTROLLER cuando queramos buscar todas las tuplas
	function SEARCH2() {
		//Variable que almacena la sentencia sql
		$sql = "select login,
                        E.IdTrabajo,
						T.NombreTrabajo,
                        Alias,
                        Horas,
                        Ruta
       			from ENTREGA E, TRABAJO T
    			where 
    				(
					(BINARY login = '$this->login') &&
                    (BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY Alias LIKE '%$this->Alias%') &&
                    (BINARY Horas LIKE '%$this->Horas%') &&
                    (BINARY Ruta LIKE '%$this->Ruta%')&&
					(E.IdTrabajo = T.IdTrabajo)
    				)";//se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
        // si la busqueda es correcta devolvemos el recordset resultado
		} else { 

			return $resultado;
		}
	}//fin de la funcion SEARCH2
        
    //esta función sirve para generar las QAs generando una palabra aleatoria
    function aleatorio(){
        //Variable que almacena un array de caracteres disponibles para generar los aleatorios
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $numerodeletras=6; //Variable que almacena el numero de letras para generar el texto
        $cadena = ""; //variable para almacenar la cadena generada
        //bucle que recorre el numero de letras y numero indicado en $numero de letras
        for($i=0;$i<$numerodeletras;$i++)//se genera una palabra de 10 caracteres
        {       
            //Variable que almacena el alias generado
            $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
                entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
        
        
    }//fin de método aleatorio.
        
    //Esta función sirve para buscar un alias y servirá para comprobar que un alias no se repita    
     function buscarAlias($Alias_Usuario){
        //Variable que almacena la sentencia sql
        $sql = "select Alias
       			from ENTREGA
    			where 
    				(Alias = '$Alias_Usuario')";//Se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
        // si la busqueda es correcta devolvemos el recordset resultado
		} else { 
            //miramos si el número de filas es igual a uno y si es devolvemos true
			if($resultado->num_rows == 1){
                return true;
            }
            // si no es devolvemos false
            else
                return false;
		}
         return false;
    }
		//Funcion que devuelve un array de todos los usuarios
        function obtenerUsuarios(){
        //Variable que almacena la consulta sql
        $sql = "select login,Alias
       			from ENTREGA";
		//se ejecuta la query
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows == 0 ) { return null; }//miramos si el número de filas es 0.
        //Caragamos las tuplas resultado de la consulta en un array
        while($datos = mysqli_fetch_row ($resultado)){
            //Variable que almacena el array de las tuplas resultado de la query
            $miarray[] = $datos;
        }
        return $miarray;
    }    
            //Funcion que devuelve todos los alias
          function obtenerAlias($LOG){
            //variable que almacena la sentencia sql
        $sql = "select Alias
       			from ENTREGA WHERE login='$LOG'";//Se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
        // si la busqueda es correcta devolvemos el recordset resultado
		} else { 

			return $resultado;
		}
    }

       //Función que devuelve los alias referidos a un login y un IdTrabajo
       function obtenerAlias2($LOG,$id){
        //Variable que almacena la sentencia sql
        $sql = "select Alias
                from ENTREGA WHERE login='$LOG' && Idtrabajo = $id";//Se construye la sentencia sql
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
            if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
            return 'Error en la consulta sobre la base de datos';
        } else { // si la busqueda es correcta devolvemos el recordset resultado

            return $resultado;
        }
    }  

    //Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave esta vacia y si 
	//existe ya en la tabla
	function ADD() {
         // si el atributo clave de la entidad no esta vacio
		if ( ( $this->login <> '' && $this->IdTrabajo <> '' ) ) {
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM ENTREGA WHERE (  login = '$this->login' && IdTrabajo = '$this->IdTrabajo')";
            // si da error la ejecución de la query
			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            // si la ejecución de la query no da error
			} else { 
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //Variable que almacena la sentencia sql
					$sql = "INSERT INTO ENTREGA (
							    login,
                                IdTrabajo,
                                Alias,
                                Horas,
                                Ruta) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
								'$this->Alias',
                                '$this->Horas',
                                '$this->Ruta'
								)";//se contruye la sentencia sql para insertar la entrega
     
                    
                   
                }
                    //si el número de tuplas no es 0
                    else{
                        return 'Ya existe la entrega introducida en la base de datos'; // ya existe
                    }
                }
                    // si da error en la ejecución del insert devolvemos mensaje
					if ( !$this->mysqli->query( $sql )) { 
						return "Error en la inserción";
					}
                 
                    //si no da error en la insercion devolvemos mensaje de exito
                    else { 
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}
                // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
				} else 
					return 'Inserta un valor'; // ya existe
    
	} // fin del metodo ADD
    
    //esta función la utiliaremos para comprobar si un usuario ya tiene una entrega ó no
    function comprobarCreacion(){
        //Variable que almacena la sentencia sql
        $sql = "SELECT * FROM ENTREGA WHERE login='$this->login' AND IdTrabajo='$this->IdTrabajo'";
        //se ejecuta la query y miramos si da error
         if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		}
            // si no error
            else{
                //miramos si el número de tuplas es 1
                if($resultado->num_rows == 1){
                    return true;
                }
                //si el número de tuplas mo es uno 
                else{
                    return false;
                }
            }
        
        
        
    }
    //Función que devuelve un alias de una entrega según un login y el número de un trabajo
    function recuperarEntrega($login, $trabajo){
        //Se construye la sentencia sql
        $sql = "SELECT Alias FROM ENTREGA WHERE login = '$login' && SUBSTRING(IdTrabajo,3) = SUBSTRING('$trabajo',3)";
        //se ejecuta la query y si da error informa de ello con un return
        if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
        // si la busqueda es correcta devolvemos el recordset resultado
		} else { 
            //Hacemos un mysqli_fetch_row para guardar ese resultado único en una variable
            $result = mysqli_fetch_row($resultado);
			return $result;
		}
        
    }

         // funcion DELETE()
	    // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	    // se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave
        //miramos si el número de tuplas es uno
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo' )";//se construye la sentencia sql
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else//si el número de tuplas no es 0
			return "No existe";
	} // fin metodo DELETE
  
        // funcion RellenaDatos()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla
        //Variable que almacena la sentencia sq
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; 
        // si existe se devuelve la tupla resultado 
		} else { 
            //Se guarda un array en $result con fetch_array
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
        
        //Busca las dependencias en asignac_qa en las que el usuario sea evaluador
        function dependencias() { // se construye la sentencia de busqueda de la tupla
        //Variable que almacena las dependencias
        $dependencias = null;//inicializamos la variable a null
        //Variable que almacena la consulta sql
		$sql = "SELECT NombreTrabajo, QA.LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, ENTREGA E, TRABAJO T WHERE QA.LoginEvaluador = '$this->login' AND QA.LoginEvaluador = E.login AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        //Variable que almacena el resultado de la query
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        //Si el numero de columnas que devuelve es mayor o igual a 1 pasamos las dependencias de todas las tablas que depende
        if ( $resultado->num_rows >= 1 ) {
            $dependencias = $resultado;//le pasamos a la variable dependencias todas las tablas de las que depende
        }
        
        return $dependencias;
	} // fin del metodo dependencias()
         //Busca las dependencias en asignac_qa en las que el usuario sea evaluado
        function dependencias2() { // se construye la sentencia de busqueda de la tupla
        //Variable que almacena las dependencias
        $dependencias2 = null;//inicializamos la variable a null
        //Variable que almacena la sentencia sql
		$sql = "SELECT NombreTrabajo, QA.LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, ENTREGA E, TRABAJO T WHERE QA.LoginEvaluado = '$this->login' AND QA.LoginEvaluado = E.login AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        //miramos si el número de tuplas es mayor o igual que uno
        if ( $resultado->num_rows >= 1 ) {
            $dependencias2 = $resultado;//le pasamos a la variable dependencias2 todas las tablas de las que depende
        }
        
        return $dependencias2;
	} // fin del metodo dependencias2()
        
        
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
        
		// Variable que almacena la sentencia sql
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			//Si la ruta no es vacia actualiza la entrega
            if($this->Ruta <> null){
                //Variable que almacena la sentencia sql
				$sql = "UPDATE ENTREGA SET 
					login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     Alias='$this->Alias',
                     Horas='$this->Horas',
                     Ruta='$this->Ruta'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";//se construye la sentencia sql de modificacion

            }
            //Si la ruta es vacia
            else{
                //Variable que almacena la sentencia sql
                $sql = "UPDATE ENTREGA SET 
					login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     Alias='$this->Alias',
                     Horas='$this->Horas'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";//se construye la sentencia sql de modificacion
           
            }
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			}
           
            // si no hay problemas con la modificación se indica que se ha modificado
            else { 
				return 'Modificado correctamente';
			}
        // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		} else 
			return 'No existe en la base de datos';
	} // fin del metodo EDIT

            
    }



?>