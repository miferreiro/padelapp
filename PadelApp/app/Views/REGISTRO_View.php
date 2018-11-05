<?php

class Register {
	
	function __construct() {
		$this->render();
	}
	
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php'; 
		?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Registro']; ?>
			</h2>
			<form name="ADD" action='../Controllers/Registro_Controller.php' method="post" enctype="multipart/form-data" onsubmit="return comprobarRegistrar()">
			<div class="col-md-4">
				<table class="table">
				<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario']; ?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="25" size="25" required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña']; ?>
						</th>
						<td class="formThTd"><input type="password" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="20" size="20" required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Dni']; ?>
						</th>
						<td class="formThTd"><input type="text" id="Dni" name="Dni" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="9" size="9" required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre']; ?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="30" size="30" required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos']; ?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="45" size="45" required />
					</tr>

                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Sexo']; ?>
						</th>
						<td class="formThTd">
							<input type="radio" id="sexo" name="sexo" value="Hombre" maxlength="7" size="7" required  /><?php echo $strings['Hombre'] ?><br>
							<input type="radio" id="sexo" name="sexo" value="Mujer" maxlength="7" size="7" required /><?php echo $strings['Mujer'] ?>
					</tr>
                    
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono']; ?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...'] ?>" value="" maxlength="11" size="11" required />
					</tr>
					
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="REGISTER"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario'] ?>" /></button>
					</form>
				<a href='../index.php'><img src="../Views/icon/atras.png" width="32" height="32" alt="<?php echo $strings['Atras'] ?>"></a>
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