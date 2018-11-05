<?php

class CATEGORIA_INSCRIPTION {

	function __construct($valores) {
		$this->render($valores);
	}
	function render($valores) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de inscripcion'];?>
			</h2>
			<form name="INSCRIPTION" action="../Controllers/CATEGORIA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="">
			<div class="col-sm-4">
			<table class="table table-sm">
			<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdCampeonato'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdCampeonato" name="IdCampeonato" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdCampeonato']?>" maxlength="25" size="25" required readonly onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'25') && comprobarTexto(this,'25')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd"><input type="text" id="Tipo" name="Tipo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Tipo']?>" maxlength="20" size="25" required readonly onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'20') && comprobarTexto(this,'20')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nivel'];?>
						</th>
						<td class="formThTd"><input type="text" id="Nivel" name="Nivel" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Nivel']?>" maxlength="12" size="12" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Login del miembro 1 de la pareja'];?>
						</th>
						<td class="formThTd"><input type="text" id="Login1" name="Login1" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $_SESSION['login']?>" maxlength="25" size="25" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Login del miembro 2 de la pareja'];?>
						</th>
						<td class="formThTd"><input type="text" id="Login2" name="Login2" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="25" size="25" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'45') && comprobarTexto(this,'45') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Capitan de la pareja'];?>
						</th>
						<td class="formThTd"><input type="text" id="Capitan" name="Capitan" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $_SESSION['login']?>" maxlength="25" size="25" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') "/>
					</tr>
					<tr>
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="INSCRIPTION"><img src="../Views/icon/add_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/CATEGORIA_CONTROLLER.php' method="post" style="display: inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</thead>
				</table>
				</div>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>