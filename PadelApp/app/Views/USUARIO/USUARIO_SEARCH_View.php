<?php

class USUARIO_SEARCH {

	function __construct() {
		$this->render();
	}

	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchUsuario()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Dni'];?>
						</th>
						<td class="formThTd"><input type="text" id="Dni" name="Dni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="128" size="128" onBlur="comprobarLongitud(this,'128') && comprobarTexto(this,'128')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" onBlur="comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="50" size="60" onBlur="comprobarLongitud(this,'50') && comprobarTexto(this,'50') && comprobarAlfabetico(this,'50')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo "Sexo"?>
						</th>
						<td class="formThTd">
							<input type="radio"  id="sexo" name="sexo" value="Hombre"/>Hombre<br>
							<input type="radio"  id="sexo" name="sexo" value="Mujer"/>Mujer<br>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono'];?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="11" size="13" onBlur="comprobarLongitud(this,'11') && comprobarTexto(this,'11')"/>
					</tr>
					<tr>
						<td colspan="2">
							<button id ="buttonBien"type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display:inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>