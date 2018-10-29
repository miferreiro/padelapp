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
<div class="seccion" align="center">
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<div class="col-md-4">
		<table class="table table-sm">
			<thead class="thead-light">
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
			
			</thead>
		</table>
	</div>
				<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			
</div>
<?php
		include '../Views/Footer.php';
	}
}
?>