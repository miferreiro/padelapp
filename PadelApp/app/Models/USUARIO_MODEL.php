<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Santos
*/

//declaración de la clase
class USUARIO_MODEL{ 

	var $Login; // declaración del atributo login
    var $Password;//declaración del atributo password
	var $Dni; // declaración del atributo DNI
	var $Nombre; // declaración del atributo Nombre
	var $Apellidos; // declaración del atributo Apellidos
    var $Sexo;//declaración del atributo Direccion
	var $Telefono; // declaración del atributo Telefono
    var $Tipo;//declaración del atributo idGrupo
	var $mysqli; // declaración del atributo manejador de la bd


    //Constructor de la clase
	function __construct($Login,$Password,$Dni,$Nombre,$Apellidos,$Telefono,$Sexo,$Tipo) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->Login = $Login;//declaracion de la variable que almacena login
        $this->Password=$Password;//declaracion de la variable que almacena password
		$this->Dni = $Dni;//declaracion de la variable que almacena dni
		$this->Nombre = $Nombre;//declaracion de la variable que almacena nombre
		$this->Apellidos = $Apellidos;//declaracion de la variable que almacena apellidos
        $this->Sexo = $Sexo;//declaracion de la variable que almacena correo
        $this->Tipo=$Tipo;//declaracion de la variable que almacena direccion
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
		$sql = "select Dni,
					Login,
                    Password,
					Nombre,
					Apellidos,
                    Sexo,
					Telefono,
                    Tipo
       			from USUARIO 
    			where 
    				(
					(BINARY Login LIKE '%$this->Login%') &&
                    (BINARY Password LIKE '%$this->Password%') &&
    				(BINARY Dni LIKE '%$this->Dni%') &&
					(BINARY Nombre LIKE '%$this->Nombre%') &&
	 				(BINARY Apellidos LIKE '%$this->Apellidos%') &&
                    (BINARY Sexo LIKE '%$this->Sexo%') &&
	 				(BINARY Telefono LIKE '%$this->Telefono%') &&
					(BINARY Tipo LIKE '%$this->Tipo%')
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
		if ( ( $this->Dni <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM USUARIO WHERE (  Dni = '$this->Dni')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				if ( $result->num_rows == 0 ) { // miramos si el resultado de la consulta es vacio (no existe el login)
					// construimos el sql para buscar esa clave candidata en la tabla
					$sql = "SELECT * FROM USUARIO WHERE (Login = '$this->Login')";
					
					if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
						// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
						return 'Ya existe un usuario con el Login introducido en la base de datos';// ya existe
						
					} else {
							//si ninguna de las claves candidatas son iguales, insertamos el usuario
                            //insertamos un usuario
							$sql = "INSERT INTO USUARIO (
							     Login,
                                 Password,
							     Dni,
					             Nombre,
					             Apellidos,
                                 Sexo,
					             Telefono,
								 Tipo) 
								VALUES(
								'$this->Login',
                                '$this->Password',
								'$this->Dni',
								'$this->Nombre',
								'$this->Apellidos',
								'$this->Sexo',
								'$this->Telefono',
								'$this->Tipo'
								)";					
						}

					}
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
												
						return 'Inserción realizada con éxito'; //operacion de insertado correcta

				}		
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
		$sql = "SELECT * FROM USUARIO WHERE (Login = '$this->Login')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
	

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM USUARIO WHERE (Dni = '$this->Dni' )";
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

		$sql = "SELECT * FROM USUARIO WHERE (Dni = '$this->Dni')";// se construye la sentencia de busqueda de la tupla
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Aplicamos fetch_array sobre $resultado para crear un array y se guarda en $result
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM USUARIO WHERE (Dni = '$this->Dni')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase

			//modificamos los atributos de la tabla USUARIO
			$sql = "UPDATE USUARIO SET 
					Login = '$this->Login',
                    Password='$this->Password',
					Dni = '$this->Dni',
					Nombre = '$this->Nombre',
					Apellidos = '$this->Apellidos',
                    Sexo ='$this->Sexo',
					Telefono = '$this->Telefono',
					Tipo = '$this->Tipo'
				WHERE ( Login = '$this->Login'
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
        
		$sql = "select * from USUARIO where Dni = '" . $this->Dni . "'";//miramos los usuarios cuyo login es igual al que nos pasan

		$result = $this->mysqli->query( $sql ); //hacemos la consulta en la base de datos.
		if ( $result->num_rows == 1 ) { // existe el usuario
			return 'El usuario ya existe';
		} else {
			$sql = "SELECT * FROM USUARIO WHERE (Login = '$this->Login')";//miramos si el DNI ya está insertado
					
				if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
					// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Ya existe un usuario con el Login introducido en la base de datos';// ya existe
					
				} else {

					return true; //no existe el usuario	
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
				(Login = '$this->Login') 
			)";
		$resultado = $this->mysqli->query( $sql );//hacemos la consulta en la base de datos
		if ( $resultado->num_rows == 0 ) {//miramos si el numero de filas es 0
			return 'El usuario no existe';
		} else {//si no es 0, el usuario existe
			$tupla = $resultado->fetch_array();//devolvemos la tupla
			if ( $tupla[ 'Password' ] == $this->Password ) {//si la contraseña es correcta entra en la página
				return true;
			} else {//en caso contrario no entra
				return 'La password para este usuario no es correcta';
			}
		}
	} //fin metodo login
   
	function obtenerTipo(){
		$sql = "SELECT Tipo
			FROM USUARIO
			WHERE (
				(Login = '$this->Login') 
			)";
		
		$resultado = $this->mysqli->query( $sql );//hacemos la consulta en la base de datos
		if ( $resultado->num_rows == 0 ) {//miramos si el numero de filas es 0
			return 'El usuario no existe';
		} else {//si no es 0, el usuario existe
			$tupla = $resultado->fetch_array();//devolvemos la tupla
			return $tupla[ 'Tipo' ];
		}
	}
	
	function obtenerDni(){
		$sql = "SELECT Dni
			FROM USUARIO
			WHERE (
				(Login = '$this->Login') 
			)";
		
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return 'El usuario no existe';
		} else {
			$tupla = $resultado->fetch_array();
			return $tupla[ 'Dni' ];
		}
	}

 	}//fin de clase

?>