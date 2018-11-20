<?php

class CAMPEONATO_SHOWCURRENT {

	function __construct( $valores ) {
		$this->valores = $valores;
		$this->render( $this->valores );
	}
	
	function render( $valores ) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div align="center">
		<h2 align="center">
			<?php echo $strings['Información de un campeonato'];?>
		</h2>
		<div class="col-md-3">
		<table class="table table-sm" >
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
				</thead>
			</table>
			</div>
			
				<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			
		</div>
	

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>