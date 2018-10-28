<?php

class USUARIO_ADD {

	function __construct() {
		$this->render();
	}

	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddUsuario()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Dni'];?>
						</th>
						<td class="formThTd"><input type="text" id="Dni" name="Dni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="12" size="12" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarDni(this)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="25" size="25" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'25') && comprobarTexto(this,'25')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="20" size="25" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'20') && comprobarTexto(this,'20')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="45" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'45') && comprobarTexto(this,'45') && comprobarAlfabetico(this,'45')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo "Sexo"?>
						</th>
						<td class="formThTd">
							<input type="radio"  id="sexo" name="sexo" value="Hombre" checked/>Hombre<br>
							<input type="radio"  id="sexo" name="sexo" value="Mujer"/>Mujer<br>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono'];?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="14" size="14" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'14') && comprobarTexto(this,'14') && comprobarTelf(this)"/>
					</tr>
					<tr>
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>