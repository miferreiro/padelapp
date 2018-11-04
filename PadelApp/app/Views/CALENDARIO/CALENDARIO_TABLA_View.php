<?php

class CALENDARIO_TABLA{

	function __construct( $listaParejas, $listaEnfrentamientos,$listaEnfrentamientos2,$vuelta,$capitan) {
		$this->listaParejas = $listaParejas;
		$this->listaEnfrentamientos = $listaEnfrentamientos;
		$this->listaEnfrentamientos2 = $listaEnfrentamientos2;
		$this->vuelta = $vuelta;
		$this->capitan = $capitan;
		$this->render($this->listaParejas,$this->listaEnfrentamientos,$this->listaEnfrentamientos2,$this->vuelta,$this->capitan);
	}
	
	function render($listaParejas,$listaEnfrentamientos,$listaEnfrentamientos2,$vuelta,$capitan){
		$this->listaParejas = $listaParejas;
		$this->listaEnfrentamientos = $listaEnfrentamientos;
		$this->listaEnfrentamientos2 = $listaEnfrentamientos2;
		$this->vuelta = $vuelta;
		$this->capitan = $capitan;
		
		
		$arrayListadoParejas = array();
		$q = 0;
		while ( $fila = mysqli_fetch_array( $listaParejas ) ) {
			
				$arrayListadoParejas[$q] = $fila['NumPareja'];
				$q++;

		}
		$numParejas = sizeof($arrayListadoParejas);
		
		$arrayEnfrentamientos= array();

		while($row = mysqli_fetch_array($this->listaEnfrentamientos)) { 

			$pareja1=$row['pareja1'];
			$pareja2=$row['pareja2'];
			$numEnfrentamiento=$row['numEnfrentamiento'];
			$resultado=$row['resultado'];

			$arrayEnfrentamientos[] = array('pareja1'=> $pareja1, 'pareja2'=> $pareja2, 'numEnfrentamiento'=> $numEnfrentamiento, 'resultado'=> $resultado); 
		}
		
		$arrayEnfrentamientos2= array();

		while($row = mysqli_fetch_array($this->listaEnfrentamientos2)) { 

			$pareja1=$row['pareja1'];
			$pareja2=$row['pareja2'];
			$numEnfrentamiento=$row['numEnfrentamiento'];
			$resultado=$row['resultado'];
			$propuestaPareja1=$row['propuestaPareja1'];
			$propuestaPareja2=$row['propuestaPareja2'];
			$arrayEnfrentamientos2[] = array('pareja1'=> $pareja1, 'pareja2'=> $pareja2, 'numEnfrentamiento'=> $numEnfrentamiento, 'resultado'=> $resultado, 'propuestaPareja1'=> $propuestaPareja1, 'propuestaPareja2'=> $propuestaPareja2); 
		}
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
?>

		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<p>
				Color blanco 0 : no hay ofertas lanzadas ni recibidas<br>
				Color Verde  3: hora y fecha establecidas<br>
				Color amarillo 1: hora y fecha propuestas a la otra pareja<br>
				Color naranja 2: hora y fechas propuestas por la otra pareja<br>
			</p>
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
	
$cont = 0;
		for($i = 1;$i <= $numParejas;$i++){//echo 'i ' . $i;
			?><tr>
				<th><?php echo $arrayListadoParejas[$i-1] ;?></th>
			<?php
			for($j = 1;$j <= $numParejas;$j++){ //echo 'j ' . $j;?><?php
				
				if($i == $j){
					?><td style="background-color: #ccc;"></td> <?php
				}else{
						$NoEncontrado = True;
						$aux = True;						
						foreach($arrayEnfrentamientos as $fila){							
							if($j == $fila['pareja1'] && $i == $fila['pareja2'] ){			
								foreach($arrayEnfrentamientos2 as $fila2){		
									if( $j == $fila2['pareja1'] && $i == $fila2['pareja2'] ){										
										if($fila2['propuestaPareja1'] == 3){?> 
											<td style ="background-color: #7BB661;">
										<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
											<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
											<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
											<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
											<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
											<input type="hidden" name="numEnfrentamiento" value="<?php echo $fila2['numEnfrentamiento']; ?>">
											<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
											<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
											<input type="hidden" name="resultado" value="<?php echo $fila2['resultado']; ?>">
											<?php echo $fila2['resultado'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['numEnfrentamiento'];?> 
												<button id ="buttonBien"  type="submit" name="action" value="INFORMACION" ><img src="../Views/icon/calendario.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>	
											</form>											
<?php 
										} else { 
											if($fila2['propuestaPareja2'] == 2){//Naranja
?> 
												<td style ="background-color: #E49E56;"> 
											<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
												<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
												<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
												<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
												<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
												<input type="hidden" name="numEnfrentamiento" value="<?php echo $fila2['numEnfrentamiento']; ?>">
												<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
												<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
												<input type="hidden" name="resultado" value="<?php echo $fila2['resultado']; ?>">
													<?php echo $fila2['resultado'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['numEnfrentamiento'];?> 
													<button id ="buttonBien"  type="submit" name="action" value="INFORMACION" ><img src="../Views/icon/calendario.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>			
													<?php if($this->capitan){ ?>
													<button id ="buttonBien"  type="submit" name="action" value="ACEPTAR" ><img src="../Views/icon/recibido.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>			
													<?php } ?>
												</form>												
<?php 
											}else{ 
												if($fila2['propuestaPareja1'] == 1){ //Amarillo
?> 
													<td style ="background-color: #FDFD96;"> 
												<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
													<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
													<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
													<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
													<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
													<input type="hidden" name="numEnfrentamiento" value="<?php echo $fila2['numEnfrentamiento']; ?>">
													<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
													<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
													<input type="hidden" name="resultado" value="<?php echo $fila2['resultado']; ?>">
													<?php echo $fila2['resultado'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['numEnfrentamiento'];?> 
														<button id ="buttonBien"  type="submit" name="action" value="INFORMACION" ><img src="../Views/icon/calendario.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>			
													</form>														
<?php 
												}else{ 																																
?>
														<td> 
													<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
														<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
														<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
														<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
														<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
														<input type="hidden" name="numEnfrentamiento" value="<?php echo $fila2['numEnfrentamiento']; ?>">
														<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
														<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
														<input type="hidden" name="resultado" value="<?php echo $fila2['resultado']; ?>">
														<?php echo $fila2['resultado'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['numEnfrentamiento'];?> 
															<button id ="buttonBien"  type="submit" name="action" value="INFORMACION" ><img src="../Views/icon/calendario.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>			
															<?php if($this->capitan){ ?>
															<button id ="buttonBien"  type="submit" name="action" value="PROPONER" ><img src="../Views/icon/enviar.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>															
															<?php } ?>
														</form>														
<?php
												} 
											}
										}
?>
									
										
										
										</td><?php
											$NoEncontrado = False;	
											$aux = False;
									}
								}
								if($aux){
									$NoEncontrado = False;	
									?><td style="background-color: #f4f4f4;"><?php echo $fila['resultado'];?> </td> <?php
								}
							}							
						}										
						if($NoEncontrado){				
							?><td style="background-color: #ccc;"></td> <?php		
						}
				}	
			}
			?></tr><?php
		}
?>		
				</thead>
			</table>
			</div>
			<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get">
				<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">					
				<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">	
				<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>