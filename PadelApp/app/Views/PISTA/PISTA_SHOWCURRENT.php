<?php

class PISTA_SHOWCURRENT{
	
    
	function __construct( $lista,$lista2,$valores,$valores2) {
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->valores = $valores;
		$this->valores2 = $valores2;
		$this->render($this->lista,$this->lista2,$this->valores,$this->valores2);
	}
	function render($lista,$lista2,$valores,$valores2){
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->valores = $valores;
		$this->valores2 = $valores2;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
  
	include '../Views/Header.php';
	

?>
<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Información de pista'];?>
			</h2>
			<div class="col-md-4">
			<div class="datepicker"></div>
				<br>
			<table id="mydatatablePistas" name="mydatatablePistas" class="table table-sm table-striped" align="center" style="width:100%">
			<thead>
			  <tr style="text-align: center">
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
				</thead>
				
					<?php
						while ( $fila = mysqli_fetch_array( $this->valores ) ) {
						
?>
				<tr style="text-align: center">
<?php
					foreach ( $lista as $atributo ) { 
?>
					<td style="text-align: center">
<?php 
 				if($atributo=='Fecha'){
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
						while ( $fila2 = mysqli_fetch_array( $this->valores2 ) ) {
						
?>
				<tr>
<?php
					foreach ( $lista2 as $atributo ) { 
?>
					<td>
<?php 
 				if($atributo=='Pista_Fecha'){
					echo date( "d/m/Y", strtotime( $fila2[ $atributo ] ) );
				}else{
							echo $fila2[ $atributo ];
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

			<form action='../Controllers/PISTA_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>