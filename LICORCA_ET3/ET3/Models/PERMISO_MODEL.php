<!--Modelo que contiene un constructor permisos y las funciones de la base de datos como insertar, buscar, etc-->
<!--Fecha: 24-11-2017 Autor: Brais Rodríguez Dedicados: 25 minutos-->

<?php


//Clase del modelo de PERMISO
    class PERMISO_MODEL{
        var $IdFuncionalidad;//declaración de la variable IdFuncionalidad
        var $IdAccion;//declaración de la variable IdAccion
        var $IdGrupo;//declaracion de la variable IdGrupo
        
        var $NombreGrupo;//declaración de la variable NombreGrupo
        var $NombreFuncionalidad;//declaración de la variable NombreFuncionalidad
        var $NombreAccion;//declaración de la variable NombreAccion

        var $mysqli;//declaración de la variable que se conectará a la base de datos
        
        //Constructor de la clase
        function __construct($IdGrupo, $IdFuncionalidad, $IdAccion, $NombreGrupo, $NombreFuncionalidad, $NombreAccion){
            $this->IdFuncionalidad = $IdFuncionalidad;//declaracion de la variable que almacena IdFuncionalidad
            $this->IdAccion = $IdAccion;//declaracion de la variable que almacena IdAccion
            $this->IdGrupo = $IdGrupo;//declaracion de la variable que almacena IdGrupo
           
            $this->NombreGrupo = $NombreGrupo;//declaracion de la variable que almacena NombreGrupo
            $this->NombreFuncionalidad = $NombreFuncionalidad;//declaracion de la variable que almacena NombreFuncionalidad
            $this->NombreAccion = $NombreAccion;//declaracion de la variable que almacena NombreAccion
            
            include_once '../Functions/BdAdmin.php';  // incluimos la funcion de acceso a la bd
            $this->mysqli=ConectarBD();	// conectamos con la bd y guardamos el manejador en un atributo de la clase
        }
   
    //Metodo ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
//existe ya en la tabla
function ADD() {
        if ( ( $this->IdGrupo <> '' && $this->IdFuncionalidad <> '' && $this->IdAccion <> '' ) ) { // si el atributo clave de la entidad no esta vacio

           
            $sql = "SELECT * FROM PERMISO 
                             WHERE ( 
                                    IdGrupo = '$this->IdGrupo' &&
                                    IdFuncionalidad = '$this->IdFuncionalidad' &&
                                    IdAccion = '$this->IdAccion'
                                    )"; // construimos el sql para buscar esa clave en la tabla

            if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
                return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            } else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
                    $sql = "INSERT INTO PERMISO (
                                IdGrupo,
                                IdFuncionalidad,
                                IdAccion) 
                                VALUES(
                                '$this->IdGrupo',
                                '$this->IdFuncionalidad',
                                '$this->IdAccion'
                                )";
                }
                    else{//si el resultado de la consulta no es vacío
                        return 'Ya existe la acción introducida en la base de datos'; // ya existe
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

        
//Esta funcion sirve para borrar un permiso de la base de datos
function DELETE() {
        
        $sql = "SELECT * FROM PERMISO 
                         WHERE (
                                IdGrupo = '$this->IdGrupo' &&
                                IdFuncionalidad = '$this->IdFuncionalidad' &&
                                IdAccion = '$this->IdAccion'
                                )";// se construye la sentencia sql de busqueda con los atributos de la clase
        // se ejecuta la query
        $result = $this->mysqli->query( $sql );
        

        if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
            
            $sql = "DELETE FROM PERMISO 
                           WHERE (
                                  IdGrupo = '$this->IdGrupo' &&
                                  IdFuncionalidad = '$this->IdFuncionalidad' &&
                                  IdAccion = '$this->IdAccion' 
                                 )";// se construye la sentencia sql de borrado
            // se ejecuta la query
            $this->mysqli->query( $sql );
            // se devuelve el mensaje de borrado correcto
            return "Borrado correctamente";
        } // si no existe el login a borrar se devuelve el mensaje de que no existe
        else // si no existe una tupla con ese valor de clave
            return "No existe";
    } // fin metodo DELETE

 //funcion SEARCH: hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
function SEARCH()
{ 	
     $sql = "SELECT P.IdGrupo,G.NombreGrupo,P.IdFuncionalidad,F.NombreFuncionalidad,P.IdAccion,A.NombreAccion
                     FROM PERMISO P,GRUPO G,FUNCIONALIDAD F,FUNC_ACCION FA,ACCION A 
                     WHERE (
                            G.IdGrupo = P.IdGrupo &&
                            F.IdFuncionalidad = P.IdFuncionalidad &&
                            A.IdAccion = P.IdAccion &&
                            F.IdFuncionalidad = FA.IdFuncionalidad &&
                            A.IdAccion = FA.IdAccion &&
                            P.IdGrupo LIKE '$this->IdGrupo'
                           )";// construimos la sentencia de busqueda con LIKE y los atributos de la entidad

    // si se produce un error en la busqueda m&&amos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH

        
//funcion SEARCH2: hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
function SEARCH2()
{   
     $sql = "SELECT P.IdGrupo,G.NombreGrupo,P.IdFuncionalidad,F.NombreFuncionalidad,P.IdAccion,A.NombreAccion
                     FROM PERMISO P,GRUPO G,FUNCIONALIDAD F,FUNC_ACCION FA,ACCION A 
                     WHERE (
                            G.IdGrupo = P.IdGrupo &&
                            F.IdFuncionalidad = P.IdFuncionalidad &&
                            A.IdAccion = P.IdAccion &&
                            F.IdFuncionalidad = FA.IdFuncionalidad &&
                            A.IdAccion = FA.IdAccion &&
                            F.NombreFuncionalidad LIKE '%$this->NombreFuncionalidad%' &&
                            A.NombreAccion LIKE '%$this->NombreAccion%' &&
                            G.NombreGrupo LIKE '%$this->NombreGrupo%'
                           )";// construimos la sentencia de busqueda con LIKE y los atributos de la entidad

    // si se produce un error en la busqueda m&&amos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
        return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
    }
    else{ // si la busqueda es correcta devolvemos el recordset resultado
        return $resultado;
    }
} // fin metodo SEARCH

// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se m&&a un mensaje de que ese valor de clave no existe
// funcion RellenaDatos()
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
function RellenaDatos()
{	
    $sql = "SELECT P.IdGrupo,G.NombreGrupo,P.IdFuncionalidad,F.NombreFuncionalidad,P.IdAccion,A.NombreAccion
                     FROM PERMISO P,GRUPO G,FUNCIONALIDAD F,FUNC_ACCION FA,ACCION A 
                     WHERE (
                            G.IdGrupo = P.IdGrupo &&
                            F.IdFuncionalidad = P.IdFuncionalidad &&
                            A.IdAccion = P.IdAccion &&
                            F.IdFuncionalidad = FA.IdFuncionalidad &&
                            A.IdAccion = FA.IdAccion &&
                            G.IdGrupo = '$this->IdGrupo' &&
                            F.IdFuncionalidad = '$this->IdFuncionalidad' &&
                            A.IdAccion = '$this->IdAccion'
                           )";// se construye la sentencia de busqueda de la tupla
    // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
    if (!($resultado = $this->mysqli->query($sql))){
		return 'No existe en la base de datos'; // 
	}
    else{ // si existe se devuelve la tupla resultado
        //Aplicamos fetch_array a $resultado para crear un array y lo almacenamos en $result
		$result = $resultado->fetch_array();
		return $result;
	}
} // fin del metodo RellenaDatos()

        
//Esta funcion sirve para comprobar los permisos que tiene un usuario
function comprobarPermisos($login){
	
	$sql = "SELECT DISTINCT U.login, P.IdGrupo, P.IdFuncionalidad FROM PERMISO P, USU_GRUPO U WHERE U.login = '$login' &&  (U.IdGrupo = P.IdGrupo && P.IdFuncionalidad = '$this->IdFuncionalidad' && P.IdAccion = '$this->IdAccion') ";//se construye la sentencia sql
    
			$resultado = $this->mysqli->query( $sql );//hacemos la query
			if ( $resultado->num_rows == 0 ) { //miramos si el numero de filas es 0 devolvemos false
				return false;
			} else {//si el numero de filas no es 0, devolvemos true
				return true;
			}
}


    }
?>