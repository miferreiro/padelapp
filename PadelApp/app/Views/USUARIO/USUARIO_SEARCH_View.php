<?php

class USUARIO_SEARCH {

	function __construct() {
		$this->render();
	}

	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchUsuario()">
			<div class="col-sm-4">
				<table class="table table-sm">
					<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['Dni'];?>
						</th>
						<td class="formThTd"><input type="text" id="Dni" name="Dni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="25" size="25" />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="128" size="40" />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="45" size="45" />
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
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="14" size="14" />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd"><input type="text" id="Tipo" name="Tipo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="12" size="12" />
					</tr>
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien"type="submit" name="action" value="SEARCH"><img src="../Views/icon/search_big.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display:inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
					</thead>
				</table>
			</div>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>