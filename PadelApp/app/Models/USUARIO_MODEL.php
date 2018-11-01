<?php

class USUARIO_MODEL{ 
	
	var $Dni; 
	var $Login; 
    var $Password;
	var $Nombre; 
	var $Apellidos; 
    var $Sexo;
	var $Tipo;
	var $Telefono;
   
	var $mysqli; 



	function __construct($Login,$Password,$Dni,$Nombre,$Apellidos,$Telefono,$Sexo,$Tipo) {
	
		$this->Login = $Login;
        $this->Password=$Password;
		$this->Dni = $Dni;
		$this->Nombre = $Nombre;
		$this->Apellidos = $Apellidos;
        $this->Sexo = $Sexo;
        $this->Tipo=$Tipo;
		$this->Telefono = $Telefono;
        
		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {
		
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

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else {
			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->Dni <> '' ) ) { 
            			
			$sql = "SELECT * FROM USUARIO WHERE (  Dni = '$this->Dni')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows == 0 ) { 
					
					$sql = "SELECT * FROM USUARIO WHERE (Login = '$this->Login')";
					
					if ( $result->num_rows != 0 ) {			
						return 'Ya existe un usuario con el Login introducido en la base de datos';// ya existe					
					} else {

							$sql = "INSERT INTO USUARIO (
							     Dni,
								 Login,
                                 Password,	     
					             Nombre,
					             Apellidos,
                                 Sexo,
								 Tipo,
					             Telefono
								) 
								VALUES(
								'$this->Dni',
								'$this->Login',
                                '$this->Password',	
								'$this->Nombre',
								'$this->Apellidos',
								'$this->Sexo',
								'$this->Tipo',
								'$this->Telefono'
								)";					
						}
					}
					if ( !$this->mysqli->query( $sql )) { 
						return 'Error en la inserción';
					} else { 											
						return 'Inserción realizada con éxito'; 
					}		
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	} 
	
	function DELETE() {

		$sql = "SELECT * FROM USUARIO WHERE (Dni = '$this->Dni')";

		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {
			
			$sql = "SELECT * FROM inscripcionpromociones WHERE (Usuario_Dni = '$this->Dni')";
			$result = $this->mysqli->query( $sql );
			
			// se construye la sentencia sql de borrado
			if($result->num_rows >= 1){
				$sql = "DELETE FROM inscripcionpromociones WHERE (Usuario_Dni = '$this->Dni')";
				$this->mysqli->query( $sql );
			}
			$sql = "SELECT * FROM RESERVA WHERE (Usuario_Dni = '$this->Dni')";
			$result = $this->mysqli->query( $sql );
			
			// se construye la sentencia sql de borrado
			if($result->num_rows >= 1){
				$sql = "DELETE FROM RESERVA WHERE (Usuario_Dni = '$this->Dni')";
				$this->mysqli->query( $sql );
			}
			$sql = "SELECT * FROM UsuarioParejas WHERE (Usuario_Dni = '$this->Dni')";
			$result = $this->mysqli->query( $sql );
			
			// se construye la sentencia sql de borrado
			if($result->num_rows >= 1){
				$sql = "DELETE FROM UsuarioParejas WHERE (Usuario_Dni = '$this->Dni')";
				$this->mysqli->query( $sql );
			}
			
			$sql = "DELETE FROM USUARIO WHERE (Dni = '$this->Dni' )";

			$this->mysqli->query( $sql );
	
			return "Borrado correctamente";
		}else{
			return "No existe";
		}
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM USUARIO WHERE (Dni = '$this->Dni')";
			
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
    

	function EDIT() {
		
		$sql = "SELECT * FROM USUARIO WHERE (Dni = '$this->Dni')";

		$result = $this->mysqli->query( $sql );
		
		if ( $result->num_rows == 1 ) {
			
			$sql = "UPDATE USUARIO SET 
					Dni = '$this->Dni',
					Login = '$this->Login',
                    Password='$this->Password',
					Nombre = '$this->Nombre',
					Apellidos = '$this->Apellidos',
                    Sexo ='$this->Sexo',
					Tipo = '$this->Tipo',
					Telefono = '$this->Telefono'
				WHERE ( Dni = '$this->Dni'
				)";
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { 
				return 'Modificado correctamente';
			}

		}else {
			return 'No existe en la base de datos';
		}
	}


	function Register() {
        
		$sql = "select * from USUARIO where Dni = '" . $this->Dni . "'";

		$result = $this->mysqli->query( $sql ); 
		if ( $result->num_rows == 1 ) { 
			return 'El usuario ya existe';
		} else {
			$sql = "SELECT * FROM USUARIO WHERE (Dni = '$this->Dni')";
					
				if ( $result->num_rows != 0 ) {
					return 'Ya existe un usuario con el Login introducido en la base de datos';
					
				} else {
					return true; 
				}
		}

	} 

	function login() {
     
		$sql = "SELECT *
			FROM USUARIO
			WHERE (
				(Login = '$this->Login') 
			)";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return 'El usuario no existe';
		} else {
			$tupla = $resultado->fetch_array();
			if ( $tupla[ 'Password' ] == $this->Password ) {
				return true;
			} else {
				return 'La password para este usuario no es correcta';
			}
		}
	} 
   
	function obtenerTipo(){
		$sql = "SELECT Tipo
			FROM USUARIO
			WHERE (
				(Login = '$this->Login') 
			)";
		
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return 'El usuario no existe';
		} else {
			$tupla = $resultado->fetch_array();
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

 }

?>