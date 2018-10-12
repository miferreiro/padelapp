<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:4/12/2017 //Autor Brais Santos
*/

//declaración de la clase
class NOTA_TRABAJO_MODEL{ 

	var $IdTrabajo;//declaracion del atributo IdTrabajo
    var $login;//declaracion del atributo login
    var $NotaTrabajo;//declaracion del atributo NotaTrabajo
	var $mysqli; // declaración del atributo manejador de la bd
  
	
    //Constructor de la clase
	function __construct($IdTrabajo,$login,$NotaTrabajo) {
        //asignación de valores de parámetro a los atributos de la clase
        $this->IdTrabajo = $IdTrabajo;//declaracion de la variable que almacena IdTrabajo
		$this->login = $login;//declaracion de la variable que almacena login
        $this->NotaTrabajo = $NotaTrabajo;//declaracion de la variable que almacena NotaTrabajo
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  N.IdTrabajo,
						T.NombreTrabajo,
                        login,
                        NotaTrabajo
       			from NOTA_TRABAJO N,TRABAJO T
    			where 
    				(
					(BINARY N.IdTrabajo LIKE '%$this->IdTrabajo%') &&
					(N.IdTrabajo=T.IdTrabajo) &&
                    (BINARY login LIKE '%$this->login%') &&
	 				(BINARY NotaTrabajo LIKE '%$this->NotaTrabajo%')
    				)";//se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
    
    
    //funcion SEARCH2: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
		function SEARCH2() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  N.IdTrabajo,
						T.NombreTrabajo,
                        login,
                        NotaTrabajo
       			from NOTA_TRABAJO N,TRABAJO T
    			where 
    				(
					(BINARY N.IdTrabajo LIKE '%$this->IdTrabajo%') &&
					(N.IdTrabajo=T.IdTrabajo) &&
                    (BINARY login = '$this->login') &&
	 				(BINARY NotaTrabajo LIKE '%$this->NotaTrabajo%')
    				)";//se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
  /****************************************************************/
    
    //PARA NOTA DE ENTREGA
    
    //Esta función sirve para calcular la nota en el caso de que sea una ET
     function calcularNota($login,$trabajo){
         $sql = "SELECT  IdHistoria,CorrectoP FROM EVALUACION E,NOTA_TRABAJO N,ENTREGA ET WHERE correctoP=1 AND ET.IdTrabajo=N.IdTrabajo AND N.login=ET.login AND Alias=AliasEvaluado AND N.login='$login' AND N.IdTrabajo='$trabajo' GROUP BY IdHistoria";//Se construye la sentencia sql
         
         $sql2="SELECT DISTINCT IdHistoria FROM HISTORIA H,NOTA_TRABAJO N WHERE H.IdTrabajo=N.IdTrabajo";//Se construye la sentencia sql
         
         $resultado = $this->mysqli->query( $sql );//ejecutamos la query
         $bien = $resultado->num_rows;//nos devuelve en un entero el número de filas
        
         $resultado2 = $this->mysqli->query( $sql2 );//ejecutamos la query
         $total = $resultado2->num_rows;//devolvemos en un entero el numero de filas
    
         if($total !=0){//miramos si el total no es cero
         
         $nota = ($bien*10)/$total;//calculamos la nota de la ET
         }
         else{
             $nota=0.00;//si el total es 0 , la nota será cero.
         }
        
         return $nota;//devolvemos la nota
        
    }
    //Esta funcion sirve para calcular el porcentaje de la nota del trabajo
    function porcentajeNota($trabajo){
         $sql = "SELECT PorcentajeNota FROM NOTA_TRABAJO N,TRABAJO T WHERE N.IdTrabajo=T.IdTrabajo AND N.IdTrabajo='$trabajo'";//Se construye la sentencia sql
        
         $resultado = $this->mysqli->query( $sql );//ejecutamos la query
         $result = $resultado->fetch_array();//nos devuelve una tupla con el porcentaje de la nota
        return $result;
    }
    
    //función que mira si existe una nota del trabajo para un usuario y trabajo concreto
     function siExiste($login,$trabajo){
         $sql = "SELECT IdTrabajo,login FROM NOTA_TRABAJO WHERE IdTrabajo='$trabajo' AND login='$login'";//Se construye la sentencia sql
        
        $resultado = $this->mysqli->query( $sql );//ejecutamos la query
        
        if($resultado->num_rows == 0){ //si el numero de tuplas es 0
            return false;
        }
        else{//si el numero de tuplas no es 0
            return true;
        }
    }
   
    
    //Esta función sirve para actualizar la nota cada vez que se está evaluando a un ususario
    function actualizar($login,$trabajo,$nota){
       $sql= "UPDATE NOTA_TRABAJO SET 
					NotaTrabajo = '$nota'
				WHERE ( login = '$login' AND IdTrabajo = '$trabajo'
				)";//Se construye la sentencia sql de modificacion
          if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {//ejecutamos la query
			         return 'Error en la consulta sobre la base de datos';
		  }
    }
 
    /*****************************************************************************************************************/
       
/**********************************************************************************************************************/
    //Para calcular la nota de QA.
    
     //Esta función sirve para calcular la nota de una QA
     function calcularNotaQA($login,$trabajo){
         
        $sql = "SELECT  OK FROM EVALUACION E,NOTA_TRABAJO N  WHERE N.IdTrabajo=E.IdTrabajo AND N.IdTrabajo='$trabajo'  AND OK=1 AND LoginEvaluador='$login'";//Se construye la sentencia sql
        
         
        $sql2= "SELECT IdHistoria FROM EVALUACION E,NOTA_TRABAJO N WHERE N.IdTrabajo=E.IdTrabajo AND N.IdTrabajo='$trabajo' AND LoginEvaluador='$login'";//Se construye la sentencia sql
         
         
         $resultado = $this->mysqli->query( $sql );//ejecutamos la query
         $ok= $resultado->num_rows;//nos devuelve el número de filas en entero
        
         $resultado2 = $this->mysqli->query( $sql2 );//ejecutamos la query
         $total = $resultado2->num_rows;//nos devuelve el numero de filas en en entero
    
         
         $nota = ($ok*10)/$total;//calculamos la nota final
         
        
         return $nota;//nos devuelve la nota de la QA
        
    }
    
   
    
    
    
    
    
    
    
/***************************************************************************************************************************/
    
  //NOTAS PARA USUARIO
    
   //Esta función nos devuelve el porcentaje de la nota de un trabajo
   function notasUsuario($trabajo){
       $sql = "SELECT PorcentajeNota FROM NOTA_TRABAJO N, TRABAJO T WHERE N.IdTrabajo=T.Idtrabajo AND T.IdTrabajo ='$trabajo'";//ejecutamos la query
       
       if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {//ejecutamos la query
			         return 'Error en la consulta sobre la base de datos';
		  } else { // si existe se devuelve la tupla resultado
           
           $resul = mysqli_fetch_row($resultado);//nos devuelve el porcentaje de la nota del trabajo
            return $resul;
		}
       
   }
    
    


	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->IdTrabajo <> '' && $this->login <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM NOTA_TRABAJO WHERE (  login = '$this->login'  && IdTrabajo = '$this->IdTrabajo')";//Se construye la sentencia sql

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				 if($result->num_rows ==1){//miramos si el numero de tuplas es uno
                     return "ya está almacenada esta nota";
                 }
                    else{//si el numero de tuplas no es uno
							$sql = "INSERT INTO NOTA_TRABAJO (
							     login,
                                 IdTrabajo,
							     NotaTrabajo
					               ) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
								'$this->NotaTrabajo'
								)";//Se construye la sentencia sql de inserción
							
                        
                    }
						}

					
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
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
		$sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo' )";
			
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

		$sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";//Se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
    
    

	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			     //modificamos los atributos de la tabla USUARIO
				$sql = "UPDATE NOTA_TRABAJO SET 
					login = '$this->login',
                    IdTrabajo='$this->IdTrabajo',
					NotaTrabajo = '$this->NotaTrabajo'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";
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
    
} //fin de clase

?>