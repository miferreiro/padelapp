<?php

//Modelo que interactúa con el controlador de FUNCIONALIDAD y la tabla de FUNCIONALIDAD de la base de datos.
//Fecha de creación:26/11/2017 //Autor:Brais Santos


//declaración de la clase
class FUNCIONALIDAD {


	var $IdFuncionalidad; //Declaración de la variable IdFuncionalidad, es la clave.
	var $NombreFuncionalidad; //Declaración de la variable NombreFuncionalidad
	var $DescripFuncionalidad; //Declaración de la variable DescripFuncionalidad
	var $dependencias; //Declaración de la variable dependencias
     var $mysqli;//declaración de la variable que se conectará a la base de datos

    //es el constructor de la clase FUNCIONALIDAD
	function __construct( $IdFuncionalidad, $NombreFuncionalidad, $DescripFuncionalidad ) { 
		//Asignamos valores a los atibutos de la clase.
		$this->IdFuncionalidad = $IdFuncionalidad;//declaracion de la variable que almacena IdFuncionalidad
		$this->NombreFuncionalidad = $NombreFuncionalidad;//declaracion de la variable que almacena NombreFuncionalidad
		$this->DescripFuncionalidad = $DescripFuncionalidad;//declaracion de la variable que almacena DescripFuncionalidad

		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();//nos conectamos a la base de datos
	} //fin del constructor.


	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdFuncionalidad,
                        NombreFuncionalidad,
                        DescripFuncionalidad
       			from FUNCIONALIDAD
    			where 
    				(
					(BINARY IdFuncionalidad LIKE '%$this->IdFuncionalidad%') &&
                    (BINARY NombreFuncionalidad LIKE '%$this->NombreFuncionalidad%') &&
                    (BINARY DescripFuncionalidad LIKE '%$this->DescripFuncionalidad%')
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
		if ( ( $this->IdFuncionalidad <> '' ) ) { // si el atributo clave de la entidad no esta vacio

			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM FUNCIONALIDAD WHERE (  IdFuncionalidad  = '$this->IdFuncionalidad')";//se construye la sentencia sql

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
				if ( $result->num_rows == 0 ) { // miramos si el resultado de la consulta es vacio
					//hacemos la inserción en la base de datos
					$sql = "INSERT INTO FUNCIONALIDAD (
							    IdFuncionalidad,
                                NombreFuncionalidad,
                                DescripFuncionalidad) 
								VALUES(
								'$this->IdFuncionalidad',
								'$this->NombreFuncionalidad',
								'$this->DescripFuncionalidad'
								)";//se construye la sentencia sql de inserción
				} else {//En caso de que no sea 0
					return 'Ya existe esa funcionalidad  en la base de datos'; // ya existe
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
		$sql = "SELECT * FROM FUNCIONALIDAD WHERE (IdFuncionalidad = '$this->IdFuncionalidad')";//se construye la sentencia sql
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM FUNCIONALIDAD WHERE (IdFuncionalidad = '$this->IdFuncionalidad' )";//se construye la sentencia sql de borrado
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

		$sql = "SELECT * FROM FUNCIONALIDAD WHERE (IdFuncionalidad = '$this->IdFuncionalidad')";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Se ejecuta fetch_array sobre $resultado para crear un array y se guarda en $result
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()

	//esta función sirve para saber si esta tabla depende de alguna otra a la hora de borrar
	function dependencias() { // se construye la sentencia de busqueda de la tupla

		$dependencias = null;//inicializamos la variable a null

		$sql = "SELECT NombreFuncionalidad, NombreAccion FROM FUNC_ACCION FA, FUNCIONALIDAD F, ACCION A WHERE FA.IdFuncionalidad = '$this->IdFuncionalidad' AND FA.IdFuncionalidad = F.IdFuncionalidad AND A.IdAccion = FA.IdAccion";//se construye la sentencia sql
		$resultado = $this->mysqli->query( $sql );//se ejecuta la query
		if ( $resultado->num_rows >= 1 ) {//miramos si el número de filas es mayor ó igual que uno
			$dependencias = $resultado;//asignamos todas las dependencias
		}

		return $dependencias;
	} // fin del metodo dependencias()

	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM FUNCIONALIDAD WHERE (idFuncionalidad = '$this->IdFuncionalidad')";//se construye la sentencia sql
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase

			//modificamos los atributos de la tabla FUNCIONALIDAD
			$sql = "UPDATE FUNCIONALIDAD SET 
					IdFuncionalidad = '$this->IdFuncionalidad',
                    NombreFuncionalidad='$this->NombreFuncionalidad',
					DescripFuncionalidad = '$this->DescripFuncionalidad'
				WHERE ( IdFuncionalidad = '$this->IdFuncionalidad'
				)";//se construye la sentencia sql de modificación
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		else
			return 'No existe en la base de datos';
	} // fin del metodo EDIT
//esta función sirve ara devolver  los datos referentes a la funcionalidad
function DevolverDatosFuncionalidad($Id){
		//Consulta que recupera la tabla ASIGNAC_QA
		$sql = "select IdFuncionalidad,
					   NombreFuncionalidad
					   from FUNCIONALIDAD
					   where IdFuncionalidad = '$Id'";//se construye la sentencia sql
		$resultado = $this->mysqli->query( $sql );//se ejecuta la query
		if ( $resultado->num_rows == 0 ) { return null; }//miramos si el numero de tuplas es 0
		//Caragamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		return $miarray;		
	}

	//Recupera todas funcionalidades que hay en la base de datos
function recuperarFuncionalidades(){
    //Variable que almacena la query
    $sql = "SELECT F.IdFuncionalidad,NombreFuncionalidad,A.IdAccion,NombreAccion 
            FROM FUNCIONALIDAD F,ACCION A,FUNC_ACCION FA
            WHERE F.IdFuncionalidad = FA.IdFuncionalidad &&
                  A.IdAccion = FA.IdAccion ";//se construye la sentencia sql
    //Variable que almacena el resultado de la query
    $resultado = $this->mysqli->query( $sql );
    //Si no hay tuplas devuelve null
    if ( $resultado->num_rows == 0 ) { return null; }//miramos si el numero de tuplas es 0
    //Caragamos las tuplas resultado de la consulta en un array
    while($datos = mysqli_fetch_row ($resultado)){
    //Variable que almacena el array de las tuplas resultado de la query
        $miarray[] = $datos;
    }
    //retorna un array con las funcionalidades
    return $miarray;
}//Fin de recuperarFuncionalidades


}


?>