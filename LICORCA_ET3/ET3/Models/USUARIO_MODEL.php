<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Santos
*/

//declaración de la clase
class USUARIO_MODEL{ 

	var $login; // declaración del atributo login
    var $password;//declaración del atributo password
	var $DNI; // declaración del atributo DNI
	var $Nombre; // declaración del atributo Nombre
	var $Apellidos; // declaración del atributo Apellidos
    var $Correo; // declaración del atributo Correo
    var $Direccion;//declaración del atributo Direccion
	var $Telefono; // declaración del atributo Telefono
	var $mysqli; // declaración del atributo manejador de la bd
    var $dependencias;//declaración del atributo dependencias
    var $dependencias2;//declaración del atributo dependencias
    var $dependencias3;//declaración del atributo dependencias
    var $dependencias4;//declaración del atributo dependencias
    var $dependencias5;//declaración del atributo dependencias
    var $dependencias6;//declaración del atributo dependencias
    var $dependencias7;//declaración del atributo dependencias
	

    //Constructor de la clase
	function __construct($login,$password,$DNI,$Nombre,$Apellidos,$Correo,$Direccion,$Telefono) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->login = $login;//declaracion de la variable que almacena login
        $this->password=$password;//declaracion de la variable que almacena password
		$this->DNI = $DNI;//declaracion de la variable que almacena dni
		$this->Nombre = $Nombre;//declaracion de la variable que almacena nombre
		$this->Apellidos = $Apellidos;//declaracion de la variable que almacena apellidos
        $this->Correo = $Correo;//declaracion de la variable que almacena correo
        $this->Direccion=$Direccion;//declaracion de la variable que almacena direccion
		$this->Telefono = $Telefono;//declaracion de la variable que almacena telefono
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  login,
                    password,
					DNI,
					Nombre,
					Apellidos,
                    Correo,
                    Direccion,
					Telefono
       			from USUARIO 
    			where 
    				(
					(BINARY login LIKE '%$this->login%') &&
                    (BINARY password LIKE '%$this->password%') &&
    				(BINARY DNI LIKE '%$this->DNI%') &&
					(BINARY Nombre LIKE '%$this->Nombre%') &&
	 				(BINARY Apellidos LIKE '%$this->Apellidos%') &&
                    (BINARY Correo LIKE '%$this->Correo%') &&
                    (BINARY Direccion LIKE '%$this->Direccion%') &&
	 				(BINARY Telefono LIKE '%$this->Telefono%')
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH


	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->login <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM USUARIO WHERE (  login = '$this->login')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				if ( $result->num_rows == 0 ) { // miramos si el resultado de la consulta es vacio (no existe el login)
					// construimos el sql para buscar esa clave candidata en la tabla
					$sql = "SELECT * FROM USUARIO WHERE (DNI = '$this->DNI')";
					
					if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
						// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
						return 'Ya existe un usuario con el DNI introducido en la base de datos';// ya existe
						
					} else {
						// construimos el sql para buscar esa clave candidata en la tabla
						$sql = "SELECT * FROM USUARIO WHERE  (Correo = '$this->Correo')";

						if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el Correo)
							// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
							return 'Ya existe un usuario con el Correo introducido en la base de datos';// ya existe
							
						} else { //si ninguna de las claves candidatas son iguales, insertamos el usuario
                            //insertamos un usuario
							$sql = "INSERT INTO USUARIO (
							     login,
                                 password,
							     DNI,
					             Nombre,
					             Apellidos,
                                 Correo,
                                 Direccion,
					             Telefono) 
								VALUES(
								'$this->login',
                                '$this->password',
								'$this->DNI',
								'$this->Nombre',
								'$this->Apellidos',
								'$this->Correo',
								'$this->Direccion',
								'$this->Telefono'
								)";
							include_once '../Models/USU_GRUPO_MODEL.php';//incluimos el modelo USU_GRUPO
							$USU_GRUPO = new USU_GRUPO($this->login,'00001A');//instanciamos un objeto del modelo USU_GRUPO donde metemos un  usuario en el grupo alumnos
							$mensaje = $USU_GRUPO->ADD();//insertamos el login en el grupo alumnos
							

						}

					}
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						
						if($mensaje == 'Inserción realizada con éxito'){//miramos si la inserción en USU_GRUPO tuvo exito
							return 'Inserción realizada con éxito'; //operacion de insertado correcta
						}else{//si la insercion no tuvo exito
							return $mensaje;
						}
						
						
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Ya existe el usuario introducido en la base de datos'; // ya existe
			}
		} else { // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
			return 'Introduzca un valor'; // introduzca un valor para el usuario
		}
	} // fin del metodo ADD

    
	//funcion de destrucción del objeto: se ejecuta automaticamente
	//al finalizar el script
	function __destruct() {

	} // fin del metodo destruct

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM USUARIO WHERE (login = '$this->login' )";
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
	function RellenaDatos() { 

		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";// se construye la sentencia de busqueda de la tupla
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Aplicamos fetch_array sobre $resultado para crear un array y se guarda en $result
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
   
    //Esta funcion mira las dependencias de la tabla a la hora de borrar
	function dependencias() { 
        
        $dependencias = null;//inicializamos la variable a null

		$sql = "SELECT UG.login, NombreGrupo FROM USU_GRUPO UG, USUARIO U, GRUPO G WHERE UG.login = '$this->login' AND U.login = UG.login AND G.IdGrupo = UG.IdGrupo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor o igual a uno
            $dependencias = $resultado;//asignamos las dependencias
        }
        
        return $dependencias;
	} // fin del metodo dependencias()
    
    //Esta funcion mira las dependencias de la tabla a la hora de borrar
    function dependencias2() { 
        
        $dependencias2 = null;//inicializamos la variable a null

        
        $sql = "SELECT E.login, NombreTrabajo, Alias, Horas, Ruta FROM ENTREGA E, USUARIO U, TRABAJO T WHERE E.login = '$this->login' AND E.login = U.login AND E.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor o igual a uno
            
            $dependencias2 = $resultado;//asignamos las dependencias
        }
        
        return $dependencias2;
	} // fin del metodo dependencias2()
    
    //Esta funcion mira las dependencias de la tabla a la hora de borrar
    function dependencias3() { 
        
        $dependencias3 = null;//inicializamos la variable a null
        
        $sql = "SELECT NombreTrabajo, LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, USUARIO U, TRABAJO T WHERE LoginEvaluador = '$this->login' AND LoginEvaluador=login AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) { //miramos si el numero de tuplas es mayor o igual a uno
            $dependencias3 = $resultado;//asignamos las dependencias
        }
        
        return $dependencias3;
	} // fin del metodo dependencias3()
    
    //Esta funcion mira las dependencias de la tabla a la hora de borrar
    function dependencias4() { 
        
        $dependencias4 = null;//inicializamos la variable a null
        
		
        $sql = "SELECT NombreTrabajo, LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, USUARIO U, TRABAJO T WHERE LoginEvaluado = '$this->login' AND LoginEvaluado=login AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) { //miramos si el numero de tuplas es mayor o igual a uno
            $dependencias4 = $resultado;//asignamos las dependencias
        }
        
        return $dependencias4;
	} // fin del metodo dependencias4()
    
     //Esta funcion mira las dependencias de la tabla a la hora de borrar
    function dependencias5() { 
        
        $dependencias5 = null;//inicializamos la variable a null
        
        $sql = "SELECT NombreTrabajo,NotaTrabajo FROM NOTA_TRABAJO NT, USUARIO U, TRABAJO T WHERE NT.login = '$this->login' AND U.login=NT.login AND NT.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor o igual a uno
            $dependencias5 = $resultado;//asignamos las dependencias
        }
        
        return $dependencias5;
	} // fin del metodo dependencias5()

    //Esta funcion mira las dependencias de la tabla a la hora de borrar
    function dependencias6() { 
        
        $dependencias6 = null;//inicializamos la variable a null
        
        $sql = "SELECT NombreTrabajo, LoginEvaluador, AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, USUARIO U, TRABAJO T WHERE LoginEvaluador = '$this->login' AND LoginEvaluador = login AND E.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor o igual a uno
            $dependencias6 = $resultado;//asignamos las dependencias
        }
        
        return $dependencias6;
	} // fin del metodo dependencias6()
       //Esta funcion mira las dependencias de la tabla a la hora de borrar
     function dependencias7() { 
        
        $dependencias7 = null;//inicializamos la variable a null
        
        $sql = "SELECT NombreTrabajo, LoginEvaluador, AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, ENTREGA ET, TRABAJO T, USUARIO U WHERE AliasEvaluado = Alias AND ET.IdTrabajo = T.IdTrabajo AND U.login = ET.login AND ET.login = '$this->login'";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor o igual a uno
            $dependencias7 = $resultado;//asignamos las dependencias
        }
        
        return $dependencias7;
	} // fin del metodo dependencias7()
    

	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase

			//modificamos los atributos de la tabla USUARIO
			$sql = "UPDATE USUARIO SET 
					login = '$this->login',
                    password='$this->password',
					DNI = '$this->DNI',
					Nombre = '$this->Nombre',
					Apellidos = '$this->Apellidos',
                    Correo = '$this->Correo',
                    Direccion ='$this->Direccion',
					Telefono = '$this->Telefono'
				WHERE ( login = '$this->login'
				)";
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		else {
			return 'No existe en la base de datos';
		}
	} // fin del metodo EDIT



	//Con esta función vemos si ya está registrado el usuario, sino lo registramos
	function Register() {
        
		$sql = "select * from USUARIO where login = '" . $this->login . "'";//miramos los usuarios cuyo login es igual al que nos pasan

		$result = $this->mysqli->query( $sql ); //hacemos la consulta en la base de datos.
		if ( $result->num_rows == 1 ) { // existe el usuario
			return 'El usuario ya existe';
		} else {
			$sql = "SELECT * FROM USUARIO WHERE (DNI = '$this->DNI')";//miramos si el DNI ya está insertado
					
				if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
					// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Ya existe un usuario con el DNI introducido en la base de datos';// ya existe
					
				} else {
					// construimos el sql para buscar esa clave candidata en la tabla
					$sql = "SELECT * FROM USUARIO WHERE  (Correo = '$this->Correo')";//miramos si el Correo está insertado

					if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el Correo)
						// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
						return 'Ya existe un usuario con el Correo introducido en la base de datos';// ya existe
						
					}else{
								return true; //no existe el usuario
					}
				}
		}

	} //fin del método Register
        
        // funcion login: realiza la comprobación de si existe el usuario en la bd y despues si la pass
	   // es correcta para ese usuario. Si es asi devuelve true, en cualquier otro caso devuelve el 
	   // error correspondiente
	function login() {
        //hacemos la consulta para saber que usuario tiene dicho login
		$sql = "SELECT *
			FROM USUARIO
			WHERE (
				(login = '$this->login') 
			)";
		$resultado = $this->mysqli->query( $sql );//hacemos la consulta en la base de datos
		if ( $resultado->num_rows == 0 ) {//miramos si el numero de filas es 0
			return 'El usuario no existe';
		} else {//si no es 0, el usuario existe
			$tupla = $resultado->fetch_array();//devolvemos la tupla
			if ( $tupla[ 'password' ] == $this->password ) {//si la contraseña es correcta entra en la página
				return true;
			} else {//en caso contrario no entra
				return 'La password para este usuario no es correcta';
			}
		}
	} //fin metodo login
   

} //fin de clase

?>