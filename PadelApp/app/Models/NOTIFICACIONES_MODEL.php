<?php

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
								//Definir que vamos a usar SMTP
								$mail->IsSMTP();
								//Esto es para activar el modo depuración en producción
								$mail->SMTPDebug  = 0;
								//Ahora definimos gmail como servidor que aloja nuestro SMTP
								$mail->Host       = 'smtp.gmail.com';
								//El puerto será el 587 ya que usamos encriptación TLS
								$mail->Port       = 587;
								//Definmos la seguridad como TLS
								$mail->SMTPSecure = 'tls';
								//Tenemos que usar gmail autenticados, así que esto a TRUE
								$mail->SMTPAuth   = true;
								//Definimos la cuenta que vamos a usar. Dirección completa de la misma
								$mail->Username   = "padelapp25@gmail.com";
								//Introducimos nuestra contraseña de gmail
								$mail->Password   = "asdf1234.";
								//Definimos el remitente (dirección y nombre)
                				$mail->SetFrom('padelapp25@gmail.com', 'PadelApp S.L.');
								//Definimos el tema del email
								$mail->Subject = $this->Titulo;
								//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
								$mail->MsgHTML(utf8_decode($this->Contenido));
								//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
								$mail->AltBody = 'This is a plain-text message body';

								$mail->AddAddress($email);
								$exito = $mail->send(); // Envía el correo.
								
								if($exito){
								return 'Inserción realizada con éxito'; 
								}else{
								return 'Hubo un inconveniente. Contacta a un administrador';
								}
								
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