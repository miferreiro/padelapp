<?php

class PROM_SHOWCURRENT {


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
					<?php echo $strings['Fecha'];?>
				</th>
				<td>
					<?php echo $this->lista['Fecha']?>
				</td>
			</tr>

			<tr>
				<th>
					<?php echo $strings['Hora'];?>
				</th>
				<td>
					<?php echo $this->lista['Hora']?>
				</td>
			</tr>
						
			
			</thead>
		</table>
	</div>
				<form action='../Controllers/PROM_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			
</div>
<?php
		include '../Views/Footer.php';
	}
}
?>