<?php

//modelo de datos definida con una clase que interactúa con el controlador que gestiona el grupo.
//Fecha de creación:23/11/2017 Autor:Brais Santos


//declaración de la clase
    class GRUPO{
        
        //Se definen las vaiables que se utilizarán en esta clase
        var $IdGrupo; //es la clave de la tabla GRUPO.
        var $NombreGrupo;//Declaracion de la variable NombreGrupo
        var $DescripGrupo;//Declaracion de la variable DescripGrupo
        var $dependencias;//Declaracion de la variable dependencias
        var $dependencias2;//Declaracion de la variable dependencias
         var $mysqli;//declaración de la variable que se conectará a la base de datos 
        
        //Es el constructor de la clase GRUPO
        function __construct($IdGrupo,$NombreGrupo,$DescripGrupo){
            //Asignamos valores a los atributos de la clase
            $this->IdGrupo=$IdGrupo;//declaracion de la variable que almacena Idgrupo
            $this->NombreGrupo=$NombreGrupo;//declaracion de la variable que almacena NombreGrupo
            $this->DescripGrupo=$DescripGrupo;//declaracion de la variable que almacena DescripGrupo
            
            // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        }//fin del constructor
        
    //Devuelve el número de tuplas que hay el la tabla grupo
    function NumRows(){
    	//Variable que almacena una sentencia sql
    	$sql = "SELECT * FROM GRUPO";//se construye la sentencia sql
    	//Variable que almacena el resultado de una query sql
        $resultado = $this->mysqli->query( $sql );
			$cont = 0;//Variable que almacena un contador de tuplas
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Incrementa contador de vueltas
				$cont++;
			}
			//Devuelve el número de tuplas
			return $cont;
    }   
	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdGrupo,
                        NombreGrupo,
                        DescripGrupo
       			from GRUPO
    			where 
    				(
					(BINARY IdGrupo LIKE '%$this->IdGrupo%') &&
                    (BINARY NombreGrupo LIKE '%$this->NombreGrupo%') &&
                    (BINARY DescripGrupo LIKE '%$this->DescripGrupo%')
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
		if ( ( $this->IdGrupo <> '' ) ) { // si el atributo clave de la entidad no esta vacio

			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM GRUPO WHERE (  IdGrupo = '$this->IdGrupo')";//se construye la sentencia sql

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO GRUPO (
							    IdGrupo,
                                NombreGrupo,
                                DescripGrupo) 
								VALUES(
								'$this->IdGrupo',
								'$this->NombreGrupo',
								'$this->DescripGrupo'
								)";//se construye la sentencia sql de inserción
                }
                    else{//si el resultado de la consulta no es vacío
                        return 'Ya existe el grupo introducido en la base de datos'; // ya existe
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
		$sql = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";//se construye la sentencia sql
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave
        if($this->IdGrupo == '00000A' || $this->IdGrupo == '00001A'){//miramos si los grupos son los 2 creados por defecto
			return 'No puedes eliminar ese grupo';
		}else{
		if ( $result->num_rows == 1 ) {//miramos si el numero de filas es uno
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo' )";//se construye la sentencia sql de borrado
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else //si el numero de filas no es uno
			return "No existe";
		}
	} // fin metodo DELETE
  
        // funcion RellenaDatos()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Se aplica fetch_array a $resultado para crear un array y se guarda en $resultado
			$resultado = $resultado->fetch_array();
			return $resultado;
		}
	} // fin del metodo RellenaDatos()
        
	// funcion RellenaSelect()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function RellenaSelect() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT A.IdAccion,A.NombreAccion,F.IdFuncionalidad,F.NombreFuncionalidad FROM FUNC_ACCION FA, FUNCIONALIDAD F, ACCION A, GRUPO G, PERMISO P WHERE(FA.IdFuncionalidad = F.IdFuncionalidad && FA.IdAccion = A.IdAccion && P.IdFuncionalidad = FA.IdFuncionalidad && P.IdAccion = FA.IdAccion && P.IdGrupo = '$this->IdGrupo') ";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
            //Se aplica fetch_array a $resultado para crear un array y se guarda en $result
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaSelect()
        
	//esta función mira si esta tabla tiene dependencias a la hora de borrar
	function dependencias() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias = null;//inicializamos la variable a null
        
        $sql = "SELECT NombreGrupo, NombreFuncionalidad, NombreAccion FROM PERMISO P, GRUPO G, FUNCIONALIDAD F, ACCION A WHERE P.IdGrupo= '$this->IdGrupo' AND P.IdGrupo = G.IdGrupo AND F.IdFuncionalidad = P.IdFuncionalidad AND A.IdAccion = P.IdAccion";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor que uno
            $dependencias = $resultado;//le asignamos todas las dependencias
        }
        
        return $dependencias;
	} // fin del metodo dependencias()
        
        //esta función mira si esta tabla tiene dependencias a la hora de borrar
        function dependencias2() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias2 = null;//inicializamos la variable a null
        
        $sql = "SELECT login, NombreGrupo FROM USU_GRUPO UG, GRUPO G WHERE UG.IdGrupo= '$this->IdGrupo' AND UG.IdGrupo = G.IdGrupo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el numero de tuplas es mayor o igual a uno
            $dependencias = $resultado;//le asignamos todas las dependencias
        }
        
        return $dependencias;
	} // fin del metodo dependencias2()

		
        // funcion RellenaShowCurrent()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaShowCurrent() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT * FROM USU_GRUPO WHERE (IdGrupo = '$this->IdGrupo')";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			return $resultado;
		}
	} // fin del metodo RellenaShowCurrent()		
		
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";//se construye la sentencia sql
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase
		
			     //modificamos los atributos de la tabla USUARIO
				$sql = "UPDATE GRUPO SET 
					IdGrupo= '$this->IdGrupo',
                    NombreGrupo='$this->NombreGrupo',
					DescripGrupo = '$this->DescripGrupo'
				WHERE ( IdGrupo = '$this->IdGrupo'
				)";//se construye la sentencia sql de modificacion
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
    
	//Esta función recupera los datos de grupo
function recuperarGrupo($id){
    //Variable que almacena la query
    $sql = "SELECT GRUPO.IdGrupo,NombreGrupo 
            FROM GRUPO
            WHERE IdGrupo = '$id'";//se construye la sentencia sql
    //Variable que almacena el resultado de la query
    $resultado = $this->mysqli->query( $sql );
    //Si no se encuentra ningún resultado, se retorna null
    if ( $resultado->num_rows == 0 ) { return null; }
    //Caragamos las tuplas resultado de la consulta en un array
    while($datos = mysqli_fetch_row ($resultado)){
    //Variable que almacena el array de las tuplas resultado de la query
        $miarray[] = $datos;
    }
    //Devuelve el array con el grupo
    return $miarray;
}
            
    }
?>