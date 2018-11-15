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
		?><br><?php
		$arrayEnfrentamientos= array();

		while($row = mysqli_fetch_array($this->listaEnfrentamientos)) { 

			$pareja1=$row['pareja1'];
			$pareja2=$row['pareja2'];

			
			$numEnfrentamiento=$row['numEnfrentamiento'];
			$resultado11=$row['1ResultadoSet1'];
			$resultado21=$row['1ResultadoSet2'];
			$resultado31=$row['1ResultadoSet3'];
			$resultado12=$row['2ResultadoSet1'];
			$resultado22=$row['2ResultadoSet2'];
			$resultado32=$row['2ResultadoSet3'];
			$arrayEnfrentamientos[] = array('pareja1'=> $pareja1, 'pareja2'=> $pareja2, 'numEnfrentamiento'=> $numEnfrentamiento,
			'1ResultadoSet1'=> $resultado11, '1ResultadoSet2'=> $resultado21, '1ResultadoSet3'=> $resultado31, 
			'2ResultadoSet1'=> $resultado12, '2ResultadoSet2'=> $resultado22, '2ResultadoSet3'=> $resultado32, 
			
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
									<input type="hidden" name="numEnfrentamiento" value="<?php echo $fila['numEnfrentamiento']; ?>">
									<input type="hidden" name="pareja1" value="<?php echo $fila['pareja1']; ?>">
									<input type="hidden" name="pareja2" value="<?php echo $fila['pareja2']; ?>">
<input type="hidden" name="1ResultadoSet1" value="<?php echo $fila2['1ResultadoSet1']; ?>">
													<input type="hidden" name="1ResultadoSet2" value="<?php echo $fila2['1ResultadoSet2']; ?>">
														<input type="hidden" name="1ResultadoSet3" value="<?php echo $fila2['1ResultadoSet3']; ?>">
												<input type="hidden" name="2ResultadoSet1" value="<?php echo $fila2['2ResultadoSet1']; ?>">
													<input type="hidden" name="2ResultadoSet2" value="<?php echo $fila2['2ResultadoSet2']; ?>">
														<input type="hidden" name="2ResultadoSet3" value="<?php echo $fila2['2ResultadoSet3']; ?>">
											
									<?php echo $fila['1ResultadoSet1'];?> 
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