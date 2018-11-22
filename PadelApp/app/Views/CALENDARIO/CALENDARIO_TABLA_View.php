<?php

class CALENDARIO_TABLA{

	function __construct( $listaParejas, $listaEnfrentamientos,$listaEnfrentamientos2,$vuelta,$capitan,$numParejaActual) {
		$this->listaParejas = $listaParejas;
		$this->listaEnfrentamientos = $listaEnfrentamientos;
		$this->listaEnfrentamientos2 = $listaEnfrentamientos2;
		$this->vuelta = $vuelta;
		$this->capitan = $capitan;
		$this->numParejaActual = $numParejaActual;
		$this->render($this->listaParejas,$this->listaEnfrentamientos,$this->listaEnfrentamientos2,$this->vuelta,$this->capitan,$this->numParejaActual);
	}
	
	function render($listaParejas,$listaEnfrentamientos,$listaEnfrentamientos2,$vuelta,$capitan,$numParejaActual){
		$this->listaParejas = $listaParejas;
		$this->listaEnfrentamientos = $listaEnfrentamientos;
		$this->listaEnfrentamientos2 = $listaEnfrentamientos2;
		$this->vuelta = $vuelta;
		$this->capitan = $capitan;
		$this->numParejaActual = $numParejaActual;
		
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

			
			$NumEnfrentamiento=$row['NumEnfrentamiento'];
			$resultado11=$row['ResultadoSet1Par1'];
			$resultado21=$row['ResultadoSet2Par1'];
			$resultado31=$row['ResultadoSet3Par1'];
			$resultado12=$row['ResultadoSet1Par2'];
			$resultado22=$row['ResultadoSet2Par2'];
			$resultado32=$row['ResultadoSet3Par2'];
			$arrayEnfrentamientos[] = array('pareja1'=> $pareja1, 'pareja2'=> $pareja2, 'NumEnfrentamiento'=> $NumEnfrentamiento,
			'ResultadoSet1Par1'=> $resultado11, 'ResultadoSet2Par1'=> $resultado21, 'ResultadoSet3Par1'=> $resultado31, 
			'ResultadoSet1Par2'=> $resultado12, 'ResultadoSet2Par2'=> $resultado22, 'ResultadoSet3Par2'=> $resultado32
			
			); 
		}
		
		$arrayEnfrentamientos2= array();

		while($row = mysqli_fetch_array($this->listaEnfrentamientos2)) { 

			$pareja1=$row['pareja1'];
			$pareja2=$row['pareja2'];

			$NumEnfrentamiento=$row['NumEnfrentamiento'];
			$resultado11=$row['ResultadoSet1Par1'];
			$resultado21=$row['ResultadoSet2Par1'];
			$resultado31=$row['ResultadoSet3Par1'];
			$resultado12=$row['ResultadoSet1Par2'];
			$resultado22=$row['ResultadoSet2Par2'];
			$resultado32=$row['ResultadoSet3Par2'];
			$propuestaPareja1=$row['propuestaPareja1'];
			$propuestaPareja2=$row['propuestaPareja2'];
			$arrayEnfrentamientos2[] = array('pareja1'=> $pareja1, 'pareja2'=> $pareja2, 'NumEnfrentamiento'=> $NumEnfrentamiento,
			'ResultadoSet1Par1'=> $resultado11, 'ResultadoSet2Par1'=> $resultado21, 'ResultadoSet3Par1'=> $resultado31, 
			'ResultadoSet1Par2'=> $resultado12, 'ResultadoSet2Par2'=> $resultado22, 'ResultadoSet3Par2'=> $resultado32, 
			
			'propuestaPareja1'=> $propuestaPareja1, 'propuestaPareja2'=> $propuestaPareja2); 
		}
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
?>

		<div class="seccion" align="left">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<p>
				<?php echo $strings['Color blanco : no hay ofertas lanzadas ni recibidas'];?><br>
				<?php echo $strings['Color Verde : hora y fecha establecidas'];?><br>
				<?php echo $strings['Color amarillo : hora y fecha propuestas a la otra pareja'];?><br>
				<?php echo $strings['Color naranja : hora y fechas propuestas por la otra pareja'];?><br>
			</p>
			<div class="col-md-4" align="left">
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
							
							if($arrayListadoParejas[$j-1] == $fila['pareja1'] && $arrayListadoParejas[$i-1] == $fila['pareja2'] ){			//echo $fila['pareja1'];
								foreach($arrayEnfrentamientos2 as $fila2){		
									if( $arrayListadoParejas[$j-1]== $fila2['pareja1'] && $arrayListadoParejas[$i-1] == $fila2['pareja2'] ){										
										if($fila2['propuestaPareja1'] == 3){?> 
											<td style ="background-color: #7BB661;">
										<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
											<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
											<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
											<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
											<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
											<input type="hidden" name="NumEnfrentamiento" value="<?php echo $fila2['NumEnfrentamiento']; ?>">
											<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
											<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
											<input type="hidden" name="ResultadoSet1Par1" value="<?php echo $fila2['ResultadoSet1Par1']; ?>">
											<input type="hidden" name="ResultadoSet2Par1" value="<?php echo $fila2['ResultadoSet2Par1']; ?>">
											<input type="hidden" name="ResultadoSet3Par1" value="<?php echo $fila2['ResultadoSet3Par1']; ?>">
											<input type="hidden" name="ResultadoSet1Par2" value="<?php echo $fila2['ResultadoSet1Par2']; ?>">
											<input type="hidden" name="ResultadoSet2Par2" value="<?php echo $fila2['ResultadoSet2Par2']; ?>">
														<input type="hidden" name="ResultadoSet3Par2" value="<?php echo $fila2['ResultadoSet3Par2']; ?>">
											<?php //echo $fila2['ResultadoSet1Par1'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['NumEnfrentamiento'];?> 
												<button id ="buttonBien"  type="submit" name="action" value="INFORMACION" ><img src="../Views/icon/calendario.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>	
											</form>											
<?php 
										} else { 
											if(($fila2['propuestaPareja1'] == 2 && $fila2['pareja1'] == $this->numParejaActual) || ( $fila2['propuestaPareja2'] == 2 && $fila2['pareja2'] == $this->numParejaActual)){//Naranja
?> 
												<td style ="background-color: #E49E56;"> 
											<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
												<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
												<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
												<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
												<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
												<input type="hidden" name="NumEnfrentamiento" value="<?php echo $fila2['NumEnfrentamiento']; ?>">
												<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
												<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
												<input type="hidden" name="ResultadoSet1Par1" value="<?php echo $fila2['ResultadoSet1Par1']; ?>">
													<input type="hidden" name="ResultadoSet2Par1" value="<?php echo $fila2['ResultadoSet2Par1']; ?>">
														<input type="hidden" name="ResultadoSet3Par1" value="<?php echo $fila2['ResultadoSet3Par1']; ?>">
												<input type="hidden" name="ResultadoSet1Par2" value="<?php echo $fila2['ResultadoSet1Par2']; ?>">
													<input type="hidden" name="ResultadoSet2Par2" value="<?php echo $fila2['ResultadoSet2Par2']; ?>">
														<input type="hidden" name="ResultadoSet3Par2" value="<?php echo $fila2['ResultadoSet3Par2']; ?>">
													<?php //echo $fila2['ResultadoSet1Par1'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['NumEnfrentamiento'];?> 
													<button id ="buttonBien"  type="submit" name="action" value="INFORMACION" ><img src="../Views/icon/calendario.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>			
													<?php if($this->capitan){ ?>
													<button id ="buttonBien"  type="submit" name="action" value="ACEPTAR" ><img src="../Views/icon/recibido.png" alt="<?php echo $strings['modificar']?>"  width="20" height="20" /></button>			
													<?php } ?>
												</form>												
<?php 
											}else{ 
											if(($fila2['propuestaPareja1'] == 1 && $fila2['pareja1'] == $this->numParejaActual) || ( $fila2['propuestaPareja2'] == 1 && $fila2['pareja2'] == $this->numParejaActual)){//Naranja
?> 
													<td style ="background-color: #FDFD96;"> 
												<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
													<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
													<input type="hidden" name="Tipo" value="<?php echo $this->vuelta['Tipo']; ?>">		
													<input type="hidden" name="Nivel" value="<?php echo $this->vuelta['Nivel']; ?>">	
													<input type="hidden" name="Letra" value="<?php echo $this->vuelta['Letra']; ?>">
													<input type="hidden" name="NumEnfrentamiento" value="<?php echo $fila2['NumEnfrentamiento']; ?>">
													<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
													<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
												<input type="hidden" name="ResultadoSet1Par1" value="<?php echo $fila2['ResultadoSet1Par1']; ?>">
													<input type="hidden" name="ResultadoSet2Par1" value="<?php echo $fila2['ResultadoSet2Par1']; ?>">
														<input type="hidden" name="ResultadoSet3Par1" value="<?php echo $fila2['ResultadoSet3Par1']; ?>">
												<input type="hidden" name="ResultadoSet1Par2" value="<?php echo $fila2['ResultadoSet1Par2']; ?>">
													<input type="hidden" name="ResultadoSet2Par2" value="<?php echo $fila2['ResultadoSet2Par2']; ?>">
														<input type="hidden" name="ResultadoSet3Par2" value="<?php echo $fila2['ResultadoSet3Par2']; ?>">
													<?php// echo $fila2['ResultadoSet1Par1'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['NumEnfrentamiento'];?> 
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
														<input type="hidden" name="NumEnfrentamiento" value="<?php echo $fila2['NumEnfrentamiento']; ?>">
														<input type="hidden" name="pareja1" value="<?php echo $fila2['pareja1']; ?>">
														<input type="hidden" name="pareja2" value="<?php echo $fila2['pareja2']; ?>">
												        <input type="hidden" name="ResultadoSet1Par1" value="<?php echo $fila2['ResultadoSet1Par1']; ?>">
													    <input type="hidden" name="ResultadoSet2Par1" value="<?php echo   $fila2['ResultadoSet2Par1']; ?>">
														<input type="hidden" name="ResultadoSet3Par1" value="<?php echo $fila2['ResultadoSet3Par1']; ?>">
												        <input type="hidden" name="ResultadoSet1Par2" value="<?php echo $fila2['ResultadoSet1Par2']; ?>">
													    <input type="hidden" name="ResultadoSet2Par2" value="<?php echo $fila2['ResultadoSet2Par2']; ?>">
														<input type="hidden" name="ResultadoSet3Par2" value="<?php echo $fila2['ResultadoSet3Par2']; ?>">
														<?php //echo $fila2['ResultadoSet1Par1'] . " PP1: " . $fila2['propuestaPareja1']. " PP2: " . $fila2['propuestaPareja2'] . " enfre: " . $fila2['NumEnfrentamiento'];?> 
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
									?><td style="background-color: #f4f4f4;"><?php //echo $fila['ResultadoSet1Par1'];?> </td> <?php
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
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>