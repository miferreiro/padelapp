<?php
class USUARIO_EDIT {

	function __construct( $valores ) { 
		$this->valores = $valores;
		$this->render( $this->valores );
	}
 
	function render( $valores ) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditUsuario()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Dni'];?>
						</th>
						<td class="formThTd"><input type="text" id="Dni" name="Dni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Dni']?>" maxlength="12" size="12" onBlur="comprobarVacio(this) && comprobarLongitud(this,'12') && comprobarTexto(this,'12') && comprobarDni(this)" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Login']?>" maxlength="25" size="25" readonly onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'25') && comprobarTexto(this,'25')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Password']?>" maxlength="128" size="128" onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,128) && comprobarTexto(this,128)" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Nombre']?>" maxlength="30" size="31" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Apellidos']?>" maxlength="45" size="45" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'45') && comprobarTexto(this,'45') && comprobarAlfabetico(this,'45')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo "Sexo"?>
						</th>
						<td class="formThTd">
<?php
								if($this->valores['Sexo'] == "Hombre"){
?>	
									<input type="radio"  id="sexo" name="sexo" value="Hombre" checked/>Hombre<br>
									<input type="radio"  id="sexo" name="sexo" value="Mujer"/>Mujer<br>
<?php
								}else{
?>
									<input type="radio"  id="sexo" name="sexo" value="Hombre"/>Hombre<br>
									<input type="radio"  id="sexo" name="sexo" value="Mujer" checked/>Mujer<br>
<?php
								}
?>											
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono'];?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Telefono']?>" maxlength="14" size="14" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'14') && comprobarTexto(this,'14') && comprobarTelf(this)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd"><input type="text" id="Tipo" name="Tipo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Tipo']?>" maxlength="12" size="12" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'12') && comprobarTexto(this,'12') "/>
					</tr>
					<tr>
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' style="display: inline">
				<button id ="buttonBien"type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>

			</table>
		</div>

		<?php
		include '../Views/Footer.php';
		}
		}
		?>