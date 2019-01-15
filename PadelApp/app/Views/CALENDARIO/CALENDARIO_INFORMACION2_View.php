<?php

class CALENDARIO_INFORMACION2{

	function __construct( $valores ,$valores2,$numParejaActual) {
		$this->valores = $valores;
		$this->valores2 = $valores2;
		$this->numParejaActual = $numParejaActual;
		$this->render( $this->valores,$this->valores2,$this->numParejaActual );
	}

	function render( $valores,$valores2,$numParejaActual ) { 
		$this->valores = $valores;
		$this->valores2 = $valores2;
		$this->numParejaActual = $numParejaActual;
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
					<?php echo $this->valores['IdCampeonato'];?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Tipo'];?>
				</th>
				<td>
					<?php echo $this->valores['Tipo'];?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Nivel'];?>
				</th>
				<td>
					<?php echo $this->valores['Nivel'];?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Letra'];?>
				</th>
				<td>
					<?php echo $this->valores['Letra'];?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['NumEnfrentamiento'];?>
				</th>
				<td>
					<?php echo $this->valores['NumEnfrentamiento'];?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['NumPareja'] . "1";?>
				</th>
				<td>
					<?php echo $this->valores['pareja1'];?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['NumPareja'] . "2";?>
				</th>
				<td>
					<?php echo $this->valores['pareja2'];?>
				</td>
			</tr>
				<?php if($this->valores['propuestaPareja1'] == 3){?> 
					<tr>
						<th>
							<?php echo $strings['Fecha'];?>
						</th>			
							
						<td style ="background-color: #7BB661;">
							<?php echo $this->valores2['Fecha'];?>
						</td>
					</tr>	
					<tr>
						<th>
							<?php echo $strings['Hora'];?>
						</th>
						<td style ="background-color: #7BB661;">
							<?php echo $this->valores2['Hora'];?>
						</td>
					</tr>
				<?php }else{
					if(($this->valores['propuestaPareja1'] == 2 && $this->valores['pareja1'] == $this->numParejaActual) || ( $this->valores['propuestaPareja2'] == 2 && $this->valores['pareja2'] == $this->numParejaActual)){//Naranja
					?>
					
					<tr>
						<th>
							<?php echo $strings['Fecha'];?>
						</th>
						<td style ="background-color: #E49E56;">
							<?php echo $this->valores2['Fecha'];?>
						</td>
					</tr>	
					<tr>
						<th>
							<?php echo $strings['Hora'];?>
						</th>
						<td  style ="background-color: #E49E56;">
							<?php echo $this->valores2['Hora'];?>
						</td>
					</tr>
					<?php }else{
					if(($this->valores['propuestaPareja1'] == 1 && $this->valores['pareja1'] == $this->numParejaActual) || ( $this->valores['propuestaPareja2'] == 1 && $this->valores['pareja2'] == $this->numParejaActual)){//Naranja
					?>	
					<tr>
						<th>
							<?php echo $strings['Fecha'];?>
						</th>
					<td style ="background-color: #FDFD96;">
							<?php echo $this->valores2['Fecha'];?>
						</td>	
					</tr>	
					<tr>
						<th>
							<?php echo $strings['Hora'];?>
						</th>
						<td style ="background-color: #FDFD96;">
							<?php echo $this->valores2['Hora'];?>
						</td>	
					</tr>						
					<?php }else{ ?>
					<?php if(($this->valores['propuestaPareja1'] == 0)){?>
					<tr>
						<th>
							<?php echo $strings['Fecha'];?>
						</th>
						<td>
							<?php echo $this->valores2['Fecha'];?>						
						</td>
					</tr>	
						<tr>
						<th>
							<?php echo $strings['Hora'];?>
						</th>
						<td>
							<?php echo $this->valores2['Hora'];?>
						</td>
						</tr>
					<?php	}
							  }
					}
				}	?>		
					
			<tr>
				<th>
					<?php echo $strings['Resultado'];?>
				</th>
				<td>
					<?php echo 'Set 1: ' . $this->valores['ResultadoSet1Par1'] . '-' . $this->valores['ResultadoSet1Par2'] ;?>
					<br>
					<?php echo 'Set 2: ' .$this->valores['ResultadoSet2Par1'] . '-' . $this->valores['ResultadoSet2Par2'] ;?>
					<br>
					<?php echo 'Set 3: ' .$this->valores['ResultadoSet3Par1'] . '-' . $this->valores['ResultadoSet3Par2'] ;?>
				</td>
			</tr>
		
			</thead>
			</table>
			

		</div>
			<p>
				<?php echo $strings['Color blanco : no hay ofertas lanzadas ni recibidas'];?><br>
				<?php echo $strings['Color Verde : hora y fecha establecidas'];?><br>
				<?php echo $strings['Color amarillo : hora y fecha propuestas a la otra pareja'];?><br>
				<?php echo $strings['Color naranja : hora y fechas propuestas por la otra pareja'];?><br>
				
			</p>
				<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get">
					<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
					<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
					<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
					<input type="hidden" name="Letra" value="<?php echo $this->valores['Letra']; ?>">
						<button id ="buttonBien" name="action" type="submit" value ="CUADRO"> <img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>


<?php
		include '../Views/Footer.php';//incluimos el pie de página
	}
}
?>