<?php

class USUARIO_SHOWCURRENT {


	function __construct( $lista ) {
		$this->lista = $lista;
		$this->render( $this->lista );
	}

	function render( $lista ) { 
		$this->lista = $lista;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
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
					<?php echo $this->lista['Login']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Contraseña'];?>
				</th>
				<td>
					<?php echo $this->lista['Password']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Dni'];?>
				</th>
				<td>
					<?php echo $this->lista['Dni']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Nombre'];?>
				</th>
				<td>
					<?php echo $this->lista['Nombre']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Apellidos'];?>
				</th>
				<td>
					<?php echo $this->lista['Apellidos']?>
				</td>
			</tr>

			<tr>
				<th>
					<?php echo $strings['Sexo'];?>
				</th>
				<td>
					<?php echo $this->lista['Sexo']?>
				</td>
			</tr>
							<tr>
				<th>
					<?php echo $strings['Tipo'];?>
				</th>
				<td>
					<?php echo $this->lista['Tipo']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Teléfono'];?>
				</th>
				<td>
					<?php echo $this->lista['Telefono']?>
				</td>
			</tr>
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';
	}
}
?>