<?php
/*  Archivo php
	Nombre: REGISTRO_View.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 23/10/2017 
	Función: vista del formulario de registro(register) realizada con una clase donde se muestran todos los campos necesarios para añadir un nuevo usuario a la base de datos
*/
//Es la clase Register que nos permite mostrar la vista para registrarse
class Register {
	//es el constructor de la clase Register
	function __construct() {
		$this->render();//Llamada a la función dónde se encuentra el formulario de registro
	}
	//función render donde se mostrará el formulario registro con los campos correspondientes
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//establecer el idioma de la página
		include '../Views/Header.php'; //header necesita los strings
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Registro']; ?>
			</h2>
			<form name="ADD" action='../Controllers/Registro_Controller.php' method="post" enctype="multipart/form-data" onsubmit="return comprobarAddUsuario()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario']; ?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña']; ?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="20" size="20" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'20') && comprobarTexto(this,'20')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DNI']; ?>
						</th>
						<td class="formThTd"><input type="text" id="DNI" name="DNI" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="9" size="9" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarDni(this)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre']; ?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="30" size="34" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos']; ?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="50" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'50') && comprobarTexto(this,'50') && comprobarAlfabetico(this,'50')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Correo electrónico']; ?>
						</th>
						<td class="formThTd"><input type="text" id="email" name="email" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="40" size="50" required onBlur=" comprobarVacio(this) && comprobarLongitud(this,'40') && comprobarTexto(this,'40') && comprobarEmail(this)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Direccion']; ?>
						</th>
						<td class="formThTd"><input type="text" id="direc" name="direc" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="60" size="70" required onBlur=" comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
                    
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono']; ?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="11" size="13" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'11') && comprobarTexto(this,'11') && comprobarTelf(this)"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="REGISTER"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario'] ?>" /></button>
			</form>
				<a href='../index.php'><img src="../Views/icon/atras.png" width="32" height="32" alt="<?php echo $strings['Atras'] ?>"></a>
					</tr>
			</table>

		</div>

		<?php
		include '../Views/Footer.php';//incluida la vista del footer
		} //fin metodo render

		} //fin REGISTER

		?>