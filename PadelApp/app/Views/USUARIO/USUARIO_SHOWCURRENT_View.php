<?php
/*  Archivo php
	Nombre: USUARIOS_SHOWCURRENT_View.php
	Autor: 	Jonatan Couto
	Fecha de creación: 29/11/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de un usuario
*/

//es la clase SHOWCURRENT de USUARIO que nos permite ver en detalle un usuario
class USUARIO_SHOWCURRENT {

     //es el constructor de la clase USUARIO_SHOWCURRENT
	function __construct( $lista ) {
		$this->lista = $lista;//pasamos los campos de la tabla usuario
		$this->render( $this->lista );//llamamos a la función render donde se mostrará el formulario SHOWCURRENT con los campos correspondientes
	}
//funcion que mostrará el formulario SHOWCURRENT con los campos correspondientes
	function render( $lista ) { 
		$this->lista = $lista;//pasamos los campos de la tabla usuario
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['Usuario'];?>
				</th>
				<td>
					<?php echo $this->lista['login'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Contraseña'];?>
				</th>
				<td>
					<?php echo $this->lista['password'] ?>
				</td>
			</tr>

			<tr>
				<th>
					<?php echo $strings['DNI'];?>
				</th>
				<td>
					<?php echo $this->lista['DNI'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Nombre'];?>
				</th>
				<td>
					<?php echo $this->lista['Nombre'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Apellidos'];?>
				</th>
				<td>
					<?php echo $this->lista['Apellidos'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Teléfono'];?>
				</th>
				<td>
					<?php echo $this->lista['Telefono'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Correo electrónico'];?>
				</th>
				<td>
					<?php echo $this->lista['Correo'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Direccion'];?>
				</th>
				<td>
					<?php echo $this->lista['Direccion'] ?>
				</td>
			</tr>

			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de página
	}
}
?>