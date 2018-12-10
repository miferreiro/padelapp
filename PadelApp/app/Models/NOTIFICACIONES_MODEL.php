<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class NOTIFICACIONES_MODEL{ 
	
	var $IdNotificacion;
	var $Titulo; 
	var $Contenido; 
    var $Notificado;
	var $mysqli; 



	function __construct($IdNotificacion,$Titulo,$Contenido,$Notificado) {
		
		$this->IdNotificacion = $IdNotificacion;
		$this->Titulo = $Titulo;
        $this->Contenido=$Contenido;
		$this->Notificado = $Notificado;

		include_once '../Functions/BdAdmin.php';
		require_once '../PHPMailer/src/Exception.php';
		require_once '../PHPMailer/src/PHPMailer.php';
		require_once '../PHPMailer/src/SMTP.php';


		$this->mysqli = ConectarBD();

	} 

	function SEARCH() {
		
		$sql = "select 
					IdNotificacion,
					Titulo,
                    Contenido,
					Notificado
       			from NOTIFICACIONES 
    			where 
    				(
					(BINARY IdNotificacion LIKE '%$this->IdNotificacion%') &&
					(BINARY Titulo LIKE '%$this->Titulo%') &&
                    (BINARY Contenido LIKE '%$this->Contenido%') &&
    				(BINARY Notificado LIKE '%$this->Notificado%') 
    				)";

		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else {
			return $resultado;
		}
	} 

	function ADD() {
		if ( ( $this->Titulo <> '' ) ) { 
            			
			$sql = "SELECT * FROM NOTIFICACIONES WHERE (  IdNotificacion = '$this->IdNotificacion')";

			if ( !$result = $this->mysqli->query( $sql ) ) { 
				return 'No se ha podido conectar con la base de datos';
			} else { 

				if ( $result->num_rows != 0 ) {			
						return 'Ya existe esa notificacion';// ya existe					
					} else {

							$sql = "INSERT INTO NOTIFICACIONES (
							     IdNotificacion,
								 Titulo,
                                 Contenido,	     
					             Notificado
								) 
								VALUES(
								'$this->IdNotificacion',
								'$this->Titulo',
                                '$this->Contenido',
								'$this->Notificado'
								)";		
							if ( !$this->mysqli->query( $sql )) { 
								return 'Error en la inserción';
							} else { 	
								$sql = "SELECT Email
											FROM USUARIO
											WHERE (Dni = '$this->Notificado') 
											";
								$resultado = $this->mysqli->query( $sql );
								$tupla = $resultado->fetch_array();
								$email=$tupla[ 'Email' ];
								$mail = new PHPMailer();
								$mail->IsSMTP();
				
								$mail->SMTPAuth = true;
								
								$mail->Host = "smtp.gmail.com";
								
								$mail->Username = "padelapp25@gmail.com";
								
								$mail->Password = "asdf1234.";
								
								$mail->Port = 25;
								
								$mail->From = "padelapp25@gmail.com";
								
								$mail->AddAddress($email);
								
								$mail->IsHTML(true);
								
								$mail->Subject = "$this->Titulo";
								
								$body = "Estimado usuario. <br />";
								
								$body .= $this->Contenido;
								
								$mail->Body = $body; // Mensaje a enviar
								
								$exito = $mail->send(); // Envía el correo.
								
								//También podríamos agregar simples verificaciones para saber si se envió:
								if($exito){
								echo "El correo fue enviado correctamente.";
								}else{
								echo "Hubo un inconveniente. Contacta a un administrador.";
								}
								return 'Inserción realizada con éxito'; 
							}	
					}
	
				}
		} else { 
			return 'Introduzca un valor'; 
		}			
	} 
	
	function DELETE() {

		$sql = "SELECT * FROM NOTIFICACIONES WHERE (IdNotificacion = '$this->IdNotificacion')";

		$result = $this->mysqli->query( $sql );	

		if ( $result->num_rows == 1 ) {	
		
			$sql = "DELETE FROM NOTIFICACIONES WHERE (IdNotificacion = '$this->IdNotificacion' )";

			$this->mysqli->query( $sql );
		
			return "Borrado correctamente";
		}else{
			return "No existe";
		}
	} 

	function RellenaDatos() { 

		$sql = "SELECT * FROM NOTIFICACIONES WHERE (IdNotificacion = '$this->IdNotificacion')";
			
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { 
			$result = $resultado->fetch_array();
			return $result;
		}
	} 
    
}

?>