<!--Modelo que contiene un constructor de usuarios de grupo y las funciones de la base de datos como insertar, buscar, etc-->
<!--Fecha: 23-11-2017 Autor: Brais Rodríguez -->

<?php
 include_once '../Functions/BdAdmin.php';//incluimos este fichero para conectarnos a la base de datos


//declaracion de la clase USU_GRUPO
    class USU_GRUPO{
        var $login;//declaración de la variable login
        var $IdGrupo;//declaración de la variable IdGrupo
        
         var $mysqli;//declaración de la variable que se conectará a la base de datos
        
        //constuctor de la clase
        public function __construct($login, $IdGrupo){
            $this->login = $login;//declaracion de la variable que almacena login
            $this->IdGrupo = $IdGrupo;//declaracion de la variable que almacena IdGrupo
           
            
            $this->mysqli=ConectarBD();//nos conectamos a la base de datos
        }//fin del constructor
   
    //Metodo ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
//existe ya en la tabla
function ADD()
{
    if (($this->login <> '' && $this->IdGrupo <> '')){ // si el atributo clave de la entidad no esta vacío'
        
		
		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO USU_GRUPO (
                    login,
                    IdGrupo
					) 
						VALUES (
                    '$this->login',
                    '$this->IdGrupo')";
				
				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					return 'Error en la inserción, login ya en uso';//operación no insertada
				}
				else{ //si no da error en la insercion devolvemos mensaje de exito
					 return 'Inserción realizada con éxito'; //operacion de insertado correcta
				}
				
			}
			else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
				return 'Ya existe en la base de datos'; // ya existe
		}
    }
    else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
            return 'Introduzca un valor'; // introduzca un valor para el usuario
	}
} // fin del metodo ADD

 //funcion SEARCH: hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select U.login,
                    U.IdGrupo,G.NombreGrupo
       			from USU_GRUPO U, GRUPO G
    			where 
    				(
    				U.login LIKE '$this->login' && G.IdGrupo LIKE U.IdGrupo
    				)";
    // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH

    // funcion DELETE()
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
function DELETE()
{	// se construye la sentencia sql de busqueda con los atributos de la clase
    $sql = "SELECT login,IdGrupo FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si existe una tupla con ese valor de clave
    if ($result->num_rows == 1)
    {
    	// se construye la sentencia sql de borrado
        $sql = "DELETE FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";
        // se ejecuta la query
        $this->mysqli->query($sql);
        // se devuelve el mensaje de borrado correcto
    	return "Borrado correctamente";
    } // si no existe el login a borrar se devuelve el mensaje de que no existe
    else
        return "No existe";
} // fin metodo DELETE
    
// funcion RellenaDatos()
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
function RellenaDatos($login, $IdGrupo)
{	// se construye la sentencia de busqueda de la tupla
    $sql = "SELECT U.login,U.IdGrupo,G.NombreGrupo FROM USU_GRUPO U,GRUPO G WHERE (U.login = '$this->login' && U.IdGrupo = '$this->IdGrupo' && U.IdGrupo LIKE G.IdGrupo)";
   
    if (!($resultado = $this->mysqli->query($sql))){ // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		return 'No existe en la base de datos';
	}
    else{ // si existe se devuelve la tupla resultado
        //Se aplica fetch_array a $resultado para crear un array y se almacena en $result
		$result = $resultado->fetch_array();
		return $result;
	}
} // fin del metodo RellenaDatos()
    
   //esta función nos permite comprobar los permisos de cada grupo
   function comprobarPermisos(){
	   $sql = "SELECT DISTINCT P.IdGrupo, P.IdFuncionalidad, P.IdAccion FROM PERMISO P, USU_GRUPO U WHERE U.login = '$this->login' && (U.IdGrupo = P.IdGrupo || P.IdGrupo ='00000A')";//se construye la sentencia sql 
       
	   $resultado = $this->mysqli->query( $sql );//hacemos la consulta en la base de datos
       return $resultado;

   }//fin del método comprobarPermisos
   
    //esta función nos permite saber si un usuario es administrador o no.
   function comprobarAdmin(){
		
		$sql = "SELECT * FROM USU_GRUPO WHERE login = '$this->login' && IdGrupo = '00000A'";//se construye la sentencia sql.
		
		$resultado = $this->mysqli->query($sql); //hacemos la consulta en la base de datos
		
		if($resultado->num_rows == 0){//miramos si el numero de filas es 0
			return false;
		}else{//miramos si el número de filas es mayor que 0.
			return true;
		}
	
   }//fin del método comprobarAdmin
    
    //Esta funcion devuelve el id del grupo y nombre del grupo de los usuarios
	function RellenaShowCurrent() {
        //se construye la sentencia sql
		$sql = "SELECT NombreGrupo,IdGrupo FROM GRUPO WHERE ( IdGrupo NOT IN (SELECT IdGrupo FROM USU_GRUPO WHERE login='$this->login'))";
        
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos';  
		} else { // si existe se devuelve la tupla resultado
			return $resultado;
		}
	} // fin del metodo RellenaShowCurrent()
    }
?>