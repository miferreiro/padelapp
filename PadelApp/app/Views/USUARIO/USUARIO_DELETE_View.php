<?php
/*  Archivo php
	Nombre: USUARIOS_DELETE_View.php
	Autor: 	Jonatan Couto
	Fecha de creación: 22/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un usuario y da la opción de borrarlos
*/


//es la clase DELETE de USUARIO que nos permite borrar un usuario
class USUARIO_DELETE {
//es el constructor de la clase USUARIO_DELETE
	function __construct( $valores) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos

		$this->render( $this->valores);//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}
//funcion que mostrará el formulario DELETE con los campos correspondientes
	function render( $valores) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
	

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['Usuario'];?>
					</th>
					<td>
						<?php echo $this->valores['login']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Contraseña'];?>
					</th>
					<td>
						<?php echo $this->valores['password']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DNI'];?>
					</th>
					<td>
						<?php echo $this->valores['DNI']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Nombre'];?>
					</th>
					<td>
						<?php echo $this->valores['Nombre']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Apellidos'];?>
					</th>
					<td>
						<?php echo $this->valores['Apellidos']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Teléfono'];?>
					</th>
					<td>
						<?php echo $this->valores['Telefono']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Correo electrónico'];?>
					</th>
					<td>
						<?php echo $this->valores['Correo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Sexo'];?>
					</th>
					<td>
						<?php echo $this->valores['Sexo']?>
					</td>
				</tr>
								<tr>
					<th>
						<?php echo $strings['Tipo'];?>
					</th>
					<td>
						<?php echo $this->valores['Tipo']?>
					</td>
				</tr>
			</table>
            <br>
            <br>
        
            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/USUARIO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value=<?php echo $this->valores['login'] ?> />
				<input type="hidden" name="password" value=<?php echo $this->valores['password'] ?> />
				<input type="hidden" name="DNI" value=<?php echo $this->valores['DNI'] ?> />
				<input type="hidden" name="nombre" value=<?php echo $this->valores['Nombre'] ?> />
				<input type="hidden" name="apellidos" value=<?php echo $this->valores['Apellidos'] ?> />
				<input type="hidden" name="telefono" value=<?php echo $this->valores['Telefono'] ?> />
				<input type="hidden" name="sexo" value=<?php echo $this->valores['Sexo'] ?> />
				<input type="hidden" name="tipo" value=<?php echo $this->valores['Tipo'] ?> />
				<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            
		include '../Views/Footer.php';//incluimos el pie de página
                
            }
        
	}


?>