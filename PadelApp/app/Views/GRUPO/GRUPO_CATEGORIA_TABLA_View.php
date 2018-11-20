<?php

class GRUPO_CATEGORIA_TABLA{

	function __construct( $listaParejas, $listaEnfrentamientos,$vuelta) {
		$this->listaParejas = $listaParejas;
		$this->listaEnfrentamientos = $listaEnfrentamientos;
		$this->vuelta = $vuelta;
		$this->render($this->listaParejas,$this->listaEnfrentamientos,$this->vuelta);
	}
	
	function render($listaParejas,$listaEnfrentamientos,$vuelta){
		$this->listaParejas = $listaParejas;
		$this->listaEnfrentamientos = $listaEnfrentamientos;
		$this->vuelta = $vuelta;
	
		$arrayListadoParejas = array();
		$q = 0;
		while ( $fila = mysqli_fetch_array( $listaParejas ) ) {
				
				$arrayListadoParejas[$q] = $fila['NumPareja'];
			//	echo $fila['NumPareja'];
			//<br><?php
				$q++;

		}
		$numParejas = sizeof($arrayListadoParejas);
		//echo 'numParejas:' . $numParejas;
		?><?php
		$arrayEnfrentamientos= array();

		while($row = mysqli_fetch_array($this->listaEnfrentamientos)) { 

			$pareja1=$row['pareja1'];
			$pareja2=$row['pareja2'];

			
			$NumEnfrentamiento=$row['NumEnfrentamiento'];
			$resultado11=$row['ResultadoSet1Par1'];
			$resultado21=$row['ResultadoSet2Par1'];
			$resultado31=$row['ResultadoSet3Par1'];
			$resultado12=$row['ResultadoSet1Par2'];
			$resultado22=$row['ResultadoSet2Par2'];
			$resultado32=$row['ResultadoSet3Par2'];
			$arrayEnfrentamientos[] = array('pareja1'=> $pareja1, 'pareja2'=> $pareja2, 'NumEnfrentamiento'=> $NumEnfrentamiento,
			'ResultadoSet1Par1'=> $resultado11, 'ResultadoSet2Par1'=> $resultado21, 'ResultadoSet3Par1'=> $resultado31, 
			'ResultadoSet1Par2'=> $resultado12, 'ResultadoSet2Par2'=> $resultado22, 'ResultadoSet3Par2'=> $resultado32, 
			
			); 
		}
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
?>

		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<div class="col-md-4">
			<table class="table table-sm">
				<thead class="thead-light">
			<tr>
				<th></th>
<?php
				foreach( $arrayListadoParejas  as $fila) {	
?>
					<th>
						<?php echo $fila?>
					</th>
<?php
				}
?>
			</tr>			
				
		<?php  
		
		$contadorfila = 1;
		$contadorcolumna = 1;
		
		?>
		<tr></tr>
		<?php
	

		for($i = 1;$i <= $numParejas;$i++){//echo $i;
			?><tr>
				<th><?php echo $arrayListadoParejas[$i-1] ;?></th>
			<?php
			for($j = 1;$j <= $numParejas;$j++){ //echo $j;?><?php
				//echo '...' . $arrayListadoParejas[$i-1];
				//echo '---' . $arrayListadoParejas[$j-1];
				if($arrayListadoParejas[$i-1] == $arrayListadoParejas[$j-1]){
					?><td style="background-color: #ccc;"></td> <?php
				}else{
						$NoEncontrado = True;
						foreach($arrayEnfrentamientos as $fila){
						//	echo  $fila['pareja1'] . '-' . $fila['pareja2'] . ' ';
							
							
							if($arrayListadoParejas[$j-1] == $fila['pareja1'] && $arrayListadoParejas[$i-1] == $fila['pareja2']){
								?><td>
									<form action="../Controllers/GRUPO_CONTROLLER.php" method="get" style="display:inline" >
									<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
									<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
									<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
									<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
									<input type="hidden" name="NumEnfrentamiento" value="<?php echo $fila['NumEnfrentamiento']; ?>">
									<input type="hidden" name="pareja1" value="<?php echo $fila['pareja1']; ?>">
									<input type="hidden" name="pareja2" value="<?php echo $fila['pareja2']; ?>">
									<input type="hidden" name="ResultadoSet1Par1" value="<?php echo $fila2['ResultadoSet1Par1']; ?>">
									<input type="hidden" name="ResultadoSet2Par1" value="<?php echo $fila2['ResultadoSet2Par1']; ?>">
									<input type="hidden" name="ResultadoSet3Par1" value="<?php echo $fila2['ResultadoSet3Par1']; ?>">
									<input type="hidden" name="ResultadoSet1Par2" value="<?php echo $fila2['ResultadoSet1Par2']; ?>">
									<input type="hidden" name="ResultadoSet2Par2" value="<?php echo $fila2['ResultadoSet2Par2']; ?>">
									<input type="hidden" name="ResultadoSet3Par2" value="<?php echo $fila2['ResultadoSet3Par2']; ?>">
											
									<?php //echo $fila['ResultadoSet1'];?> 
										<button id ="buttonBien"  type="submit" name="action" value="EDITAR" ><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['modificar']?>"  width="15" height="15" /></button>			
									</form>
								</td><?php
								$NoEncontrado = False;
							}
						}
						
						if($NoEncontrado){
						
							?><td style="background-color: #ccc;"></td> <?php
							$NoEncontrado = True;
								
						}
				}	
					
				
			}
			?></tr><?php
		}
?>
							
				</thead>
			</table>
			</div>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="get">
				<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">					
				<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">	
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>