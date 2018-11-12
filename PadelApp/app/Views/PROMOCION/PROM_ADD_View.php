<?php

class PROM_ADD {

	function __construct($datos,$datos2) {
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->datos2 = $datos2;//pasamos los valores de cada campo
		$this->render($this->datos,$this->datos2);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	function render($datos,$datos2){
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->datos2 = $datos2;
		
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		
		$horas = array();
		$q = 0;
		while ( $fila = mysqli_fetch_array( $datos ) ) {
				
				$horas[$q] = $fila['Hora'];
			//	echo $fila[''];
			//<br><?php
				$q++;

		}
			$fechas = array();
		$z = 0;
		while ( $fila = mysqli_fetch_array( $datos2 ) ) {
				
				$fechas[$z] = $fila['Fecha'];
			//	echo $fila[''];
			//<br><?php
				$z++;

		}
?>

<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<div class="datepicker"></div>
			<br>
			<div class="col-md-6">
			<table id="mydatatableAddPromo" name="mydatatableAddPromo" class="table table-sm table-striped" align="center" style="width:100%">
			<thead>				
				<tr>
					<th>
					<?php echo $strings['Fecha'];?>
					</th>

					<th>
						<?php echo $strings['Hora']?>
				
					</th>
				</tr>
				</thead>	
				
<?php
						for($j=0;$j<$z;$j++){

						for($x=0;$x<$q;$x++){ 
							
				if(Comprobar_Disponibilidad2($horas[$x],$fechas[$j])==1){		
							
?>
				
				<tr>
					<td>
					
<?php
							echo date( "d/m/Y", strtotime( $fechas[$j] ) );
?>	
					
					</td>

						<td>
				
						<form action="../Controllers/PROM_CONTROLLER.php" method="post" style="display:inline" >
						<button type="submit" name="action" value="ADD" style="width: 100%">
							<input type="hidden" name="Hora" value="<?php echo $horas[$x] ?>">
							<input type="hidden" name="Fecha" value="<?php echo $fechas[$j] ?>">	
<?php
							echo $horas[$x];						
?>
						
						</button>
						</form>	
				</td>
<?php
					}
					}	
						}
?>
				</tr>									
										
			</table>
						<form action='../Controllers/PROM_CONTROLLER.php' method="post" style="display: inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
		</div>




<?php
		include '../Views/Footer.php';
		}
	}
	?>