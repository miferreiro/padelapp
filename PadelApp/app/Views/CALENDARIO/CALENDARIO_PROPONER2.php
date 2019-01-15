<?php

class CALENDARIO_PROPONER2 {

	function __construct( $valores,$datos,$datos2) { 
		$this->valores = $valores;
		$this->datos = $datos;
		$this->datos2 = $datos2;
		$this->render( $this->valores,$this->datos,$this->datos2);
	}

	function render( $valores,$datos,$datos2) { 
		$this->valores = $valores;
		$this->datos  = $datos;
		$this->datos2 = $datos2;
	
		$horas = array();
		$q = 0;
		while ( $fila = mysqli_fetch_array( $this->datos ) ) {			
				$horas[$q] = $fila['Hora'];
				$q++;
		}
		$fechas = array();
		$z = 0;
		while ( $fila2 = mysqli_fetch_array( $this->datos2 ) ) {
				$fechas[$z] = $fila2['Fecha'];				
				$z++;
		}
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de propuesta'];?>
			</h2>
			<div class="col-sm-4">
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
			<tr>
				<th>
					<?php echo $strings['Letra'];?>
				</th>
				<td>
					<?php echo $this->valores['Grupo_Letra']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['NumEnfrentamiento'];?>
				</th>
				<td>
					<?php echo $this->valores['NumEnfrentamiento']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Pareja'] . "1";?>
				</th>
				<td>
					<?php echo $this->valores['pareja1']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Pareja'] . "2";?>
				</th>
				<td>
					<?php echo $this->valores['pareja2']?>
				</td>
			</tr>
				</thead>
			</table>
			</div>	
<?php 
			echo $strings['¿Quieres ofrecer este horario de este partido a la otra pareja?'];
?>
		<div class="seccion" align="center">
			<div class="datepicker"></div>
			<br>
			<div class="col-md-6">
			<table id="mydatatableProponerHora" name="mydatatableProponerHora" class="table table-sm table-striped" align="center" style="width:100%">
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
					<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="post" style="display: inline" >
						
							<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
							<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
							<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
							<input type="hidden" name="Letra" value="<?php echo $this->valores['Grupo_Letra']; ?>">				
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $this->valores['NumEnfrentamiento']; ?>">	
							<input type="hidden" name="Fecha" value="<?php echo $fechas[$j] ?>">
							<input type="hidden" name="Hora" value="<?php echo $horas[$x] ?>">
							<input type="hidden" name="pareja1" value="<?php echo $this->valores['pareja1']; ?>">
							<input type="hidden" name="pareja2" value="<?php echo $this->valores['pareja2']; ?>">
							<button type="submit" name="action" value="PROPONER2" style="width: 100%">
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
		</div>	
			
			<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
					<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
					<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
					<input type="hidden" name="Letra" value="<?php echo $this->valores['Grupo_Letra']; ?>">
				<button id ="buttonBien" name="action" type="submit" value='CUADRO'><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>