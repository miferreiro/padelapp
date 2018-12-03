<?php

class PROM_DELETE {

	function __construct( $valores, $lista, $lista2) { 
		$this->valores = $valores;
		$this->lista = $lista;
		$this->lista2 = $lista2;

		$this->render( $this->valores, $this->lista, $this->lista2);
	}

	function render( $valores, $lista, $lista2) { 
		$this->valores = $valores;
	    $this->lista = $lista;
		$this->lista2 = $lista2;

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Borra una promoción'];?>
			</h2>
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['Fecha'];?>
					</th>
					<td>
						<?php echo date( "d/m/Y", strtotime( $this->valores['Fecha'] ) )?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Hora'];?>
					</th>
					<td>
						<?php echo $this->valores['Hora']?>
					</td>
				</tr>
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
						while ( $fila = mysqli_fetch_array( $this->lista2 ) ) {
						
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { 
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
<?php 
			echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];
?>
			<div>
			<form action="../Controllers/PROM_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="Fecha" value="<?php echo $this->valores['Fecha']; ?>">
				<input type="hidden" name="Hora" value="<?php echo $this->valores['Hora']; ?>">

				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/accept_big.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/PROM_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancel_big.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>