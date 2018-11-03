<?php

class USUARIO_SHOWCURRENT {


	function __construct( $valores,$lista,$lista2,$valores2,$valores3) { 
		$this->valores = $valores;
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->valores2 = $valores2;
		$this->valores3 = $valores3;


		$this->render( $this->valores,$this->lista,$this->lista2,$this->valores2,$this->valores3);
	}

	function render( $valores,$lista,$lista2,$valores2,$valores3) { 
		$this->valores = $valores;
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->valores2 = $valores2;
		$this->valores3 = $valores3;


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
					<?php echo $this->valores['Login']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Dni'];?>
				</th>
				<td>
					<?php echo $this->valores['Dni']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Nombre'];?>
				</th>
				<td>
					<?php echo $this->valores['Nombre']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Apellidos'];?>
				</th>
				<td>
					<?php echo $this->valores['Apellidos']?>
				</td>
			</tr>

			<tr>
				<th>
					<?php echo $strings['Sexo'];?>
				</th>
				<td>
					<?php echo $this->valores['Sexo']?>
				</td>
			</tr>
							<tr>
				<th>
					<?php echo $strings['Tipo'];?>
				</th>
				<td>
					<?php echo $this->valores['Tipo']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Teléfono'];?>
				</th>
				<td>
					<?php echo $this->valores['Telefono']?>
				</td>
			</tr>
			
			</thead>
		</table>
	</div>
	
	
<div class="seccion" align="center">
			<h2>
			<?php echo $strings['Promociones asociadas'];?>
			</h2>
			<div class="col-md-3">
			<table class="table table-sm" align="center">
			<thead class="thead-light">
				<tr>
<?php
					foreach ( $lista as $atributo ) { 
?>
						<th>
							<?php echo $strings[$atributo]?>
						</th>
<?php
					}
?>
				</tr>
				<tr>
					<?php
						while ( $fila = mysqli_fetch_array( $this->valores2 ) ) {
						
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { 
?>
					<td>
<?php 
							echo $fila[ $atributo ];
?>
					</td>
<?php
					}
?>
														
				</tr>
<?php
					}
?>
				</thead>
			</table>
		</div>
<div class="seccion" align="center">
			<h2>
			<?php echo $strings['Reservas asociadas'];?>
			</h2>
			<div class="col-md-3">
			<table class="table table-sm" align="center">
			<thead class="thead-light">
				<tr>
<?php
					foreach ( $lista2 as $atributo ) { 
?>
						<th>
							<?php echo $strings[$atributo]?>
						</th>
<?php
					}
?>
				</tr>
				<tr>
					<?php
						while ( $fila2 = mysqli_fetch_array( $this->valores3 ) ) {
						
?>
				<tr>
<?php
					foreach ( $lista2 as $atributo ) { 
?>
					<td>
<?php 
							echo $fila2[ $atributo ];
?>
					</td>
<?php
					}
?>
														
				</tr>
<?php
					}
?>
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