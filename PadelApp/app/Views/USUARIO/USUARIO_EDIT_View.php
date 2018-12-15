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
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de modificación de usuario'];?>
			</h2>
			<form name="EDIT" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditUsuario()">
				<div class="col-sm-4">
				<table class="table table-sm">
					<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['Dni'];?>
						</th>
						<td class="formThTd"><input type="text" id="Dni" name="Dni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Dni']?>" maxlength="9" size="9"  required readonly/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Login']?>" maxlength="25" size="25" readonly required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Password']?>" maxlength="128" size="40" required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Nombre']?>" maxlength="30" size="30" required  readonly/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Apellidos']?>" maxlength="45" size="45" required readonly/>
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
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Telefono']?>" maxlength="14" size="14" required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd">
<?php
								if($this->valores['Tipo'] == "Deportista"){
?>	
									<input type="radio"  id="Tipo" name="Tipo" value="Deportista" checked/>Deportista<br>
									<input type="radio"  id="Tipo" name="Tipo" value="Entrenador"/>Entrenador<br>
<?php
								}else{
?>
									<input type="radio"  id="Tipo" name="Tipo" value="Deportista"/>Deportista<br>
									<input type="radio"  id="Tipo" name="Tipo" value="Entrenador" checked/>Entrenador<br>
<?php
								}
?>											
					</tr>	
					<tr>
						<th class="formThTd">
							<?php echo $strings['Email'];?>
						</th>
						<td class="formThTd"><input type="text" id="email" name="email" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Email']?>" maxlength="60" size="30" required /> 
					</tr>
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="EDIT"><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						</thead>
				</table>
			</div>
			<form action='../Controllers/USUARIO_CONTROLLER.php' style="display: inline">
				<button id ="buttonBien"type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>
			
		</div>

		<?php
		include '../Views/Footer.php';
		}
		}
		?>