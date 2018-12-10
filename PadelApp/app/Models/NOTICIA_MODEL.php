<?php

class NOTICIA_MODEL{ 
	
	var $Titulo; 
	var $Contenido; 
    var $fotopersonal;
	var $mysqli; 



	function __construct($Titulo,$Contenido,$fotopersonal) {
	
		$this->Titulo = $Titulo;
        $this->Contenido=$Contenido;
		$this->fotopersonal = $fotopersonal;

		include_once '../Functions/BdAdmin.php';
		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {
		
		$sql = "select 
					Titulo,
                    Contenido,
					fotopersonal
       			from NOTICIA 
    			where 
    				(
					(BINARY Titulo LIKE '%$this->Titulo%') &&
                    (BINARY Contenido LIKE '%$this->Contenido%') &&
    				(BINARY fotopersonal LIKE '%$this->fotopersonal%') 
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else {
			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->Titulo <> '' ) ) { 
            			
			$sql = "SELECT * FROM NOTICIA WHERE (  Titulo = '$this->Titulo')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows != 0 ) {			
						return 'Ya existe una noticia con el titulo introducido en la base de datos';// ya existe					
					} else {

							$sql = "INSERT INTO NOTICIA (
							     
								 Titulo,
                                 Contenido,	     
					             fotopersonal
								) 
								VALUES(
								'$this->Titulo',
                                '$this->Contenido',
								'$this->fotopersonal'
								)";		
							if ( !$this->mysqli->query( $sql )) { 
								return 'Error en la inserción';
							} else { 											
								return 'Inserción realizada con éxito'; 
							}	
					}
	
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	} 
	
	function DELETE() {

		$sql = "SELECT * FROM NOTICIA WHERE (Titulo = '$this->Titulo')";

		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {	
		
			$sql = "DELETE FROM NOTICIA WHERE (Titulo = '$this->Titulo' )";

			$this->mysqli->query( $sql );
		
			return "Borrado correctamente";
		}else{
			return "No existe";
		}
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM NOTICIA WHERE (Titulo = '$this->Titulo')";
			
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
    

}

?>