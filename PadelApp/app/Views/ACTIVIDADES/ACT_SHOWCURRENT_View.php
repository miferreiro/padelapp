<?php

class PROM_SHOWCURRENT {


	function __construct( $lista,$lista2,$valores ) {
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->valores = $valores;
		$this->render( $this->lista, $this->lista2, $this->valores );
	}

	function render( $lista,$lista2,$valores  ) { 
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
<div class="seccion" align="center">
		<h2>
			<?php echo $strings['Información de la promoción'];?>
		</h2>
		<div class="col-md-4">
		<table class="table table-sm">
			<thead class="thead-light">
			<tr>
				<th>
					<?php echo $strings['Fecha'];?>
				</th>
				<td>
					<?php echo date( "d/m/Y", strtotime($this->lista['Fecha']) )?>
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
<div class="seccion" align="center">
			<h2>
			<?php echo $strings['Inscritos en la promoción'];?>
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
						while ( $fila = mysqli_fetch_array( $this->valores ) ) {
						
?>
				<tr>
<?php
					foreach ( $lista2 as $atributo ) { 
?>
					<td>
<?php 
 				if($atributo=='Promociones_Fecha'){
					echo date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
				}else{
							echo $fila[ $atributo ];
				}
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
				<form action='../Controllers/PROM_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			
</div>
<?php
		include '../Views/Footer.php';
	}
}
?>