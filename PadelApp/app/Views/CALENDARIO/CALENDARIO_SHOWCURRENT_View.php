<?php

class CALENDARIO_SHOWCURRENT {

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
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<div class="col-md-2">
		<table class="table table-sm">
			<thead class="thead-light">
			<tr>
				<th>
					<?php echo $strings['IdCampeonato'];?>
				</th>
				<td>
					<?php echo $this->valores['IdCampeonato']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['FechaIni'];?>
				</th>
				<td>
					<?php echo $this->valores['FechaIni']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['HoraIni'];?>
				</th>
				<td>
					<?php echo $this->valores['HoraIni']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['FechaFin'];?>
				</th>
				<td>
					<?php echo $this->valores['FechaFin']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['HoraFin'];?>
				</th>
				<td>
					<?php echo $this->valores['HoraFin']?>
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
					<?php echo $strings['Nivel'];?>
				</th>
				<td>
					<?php echo $this->valores['Nivel']?>
				</td>
			</tr>
			</thead>
			</table>
		</div>
				<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>


<?php
		include '../Views/Footer.php';//incluimos el pie de página
	}
}
?>