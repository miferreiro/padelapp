<?php

class CAMPEONATO_SHOWCURRENT {

	function __construct( $valores ) {
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->render( $this->valores );
	}
	//funcion que mostrará la vista SHOWCURRENT con los campos correspondientes y sus valores
	function render( $valores ) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table>
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
				
			
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>