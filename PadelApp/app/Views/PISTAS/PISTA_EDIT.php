<?php

// idPista, horaPista, Disponibilidad, fechaPista
//es la clase ADD de PISTA que nos permite añadir un usuario
class PISTA_EDIT {
//es el constructor de la clase PISTA_ADD
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes
	}
//funcion que  mostrará el formulario ADD con los campos correspondientes
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="ADD" action="../Controllers/PISTA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddPista()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Fecha'];?>
						</th>
						<td class="formThTd"><input type="text" id="Fecha" name="Fecha" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="10" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 1'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja1" name="franja1" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 2'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja2" name="franja2" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 3'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja3" name="franja3" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 4'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja4" name="franja4" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 5'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja5" name="franja5" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 6'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja6" name="franja6" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 7'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja6" name="franja6" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Franja 8'];?>
						</th>
						<td class="formThTd"><input type="text" id="franja6" name="franja6" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" required onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/PISTA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>