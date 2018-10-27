<?php

class CATEGORIA_SHOWCURRENT {

	function __construct( $valores ) {
		$this->valores = $valores;
		$this->render( $this->valores );
	}

	function render( $valores ) { 
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
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
			</tr>
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/CATEGORIA_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de página
	}
}
?>