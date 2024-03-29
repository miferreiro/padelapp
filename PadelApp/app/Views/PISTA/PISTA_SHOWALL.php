<?php

class Pista_Showall{
	

	function __construct( $lista, $datos,$datos2) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->datos2 = $datos2;
		$this->render($this->lista,$this->datos,$this->datos2);
	}
	function render($lista,$datos,$datos2){
		$this->lista = $lista;
		$this->datos = $datos;
		$this->datos2 = $datos2;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		
		$horas = array();
		$q = 0;
		while ( $fila = mysqli_fetch_array( $datos ) ) {				
				$horas[$q] = $fila['Hora'];
				$q++;

		}
		$fechas = array();
		$z = 0;
		while ( $fila = mysqli_fetch_array( $datos2 ) ) {				
				$fechas[$z] = $fila['Fecha'];
				$z++;
		}

?>
<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de pistas'];?>
			</h2>
			<div class="datepicker"></div>
			<br>
			<div class="col-md-6">
			<table id="mydatatablePistasShowAll" name="mydatatablePistasShowAll" class="table table-sm table-striped" align="center" style="width:100%">
			<thead>				
				<tr>
					<th>
					<?php echo $strings['Fecha'];?>
					</th>
<?php
		$c=0;
		$aux= array();
		
					while( $li = mysqli_fetch_array( $this->lista) ){
						
						$c++;$aux[$c] =  $li['idPista'];
?>
					<th>
						<?php echo $strings['idPista'];echo(' ');echo $li['idPista']?>
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<input type="hidden" name="idPista" value="<?php echo $li['idPista'] ?>">
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
						<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/delete_big.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>	
						<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT"><img src="../Views/icon/verdetalles_2.jpg" alt="BUSCAR" width="20" height="20"/></button>	
						</form>
					</th>
<?php					
				}
?>
				</tr>
				</thead>	
				
<?php
						for($j=0;$j<$z;$j++){

						for($x=0;$x<$q;$x++){ 
							
						
							
?>
				<tr>
					<td>
					
<?php
							echo date( "d/m/Y", strtotime( $fechas[$j] ) );
?>	
					
					</td>
<?php
					for($i=0;$i<$c;$i++){
						if(Comprobar_Disponibilidad($aux[$i+1],$horas[$x],$fechas[$j])==1){
?>
						<td bgcolor="#35B109">
							
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
							
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<button type="submit" name="action" value="EDIT" style="background-color: #35B109; width: 100%">
							<input type="hidden" name="idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Hora" value="<?php echo $horas[$x] ?>">
							<input type="hidden" name="Fecha" value="<?php echo $fechas[$j] ?>">	
<?php
						}else{
?>						    
							<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<button type="submit" name="action" value="ADD" alt="<?php echo $strings['Reservar pista'] ?>" style="background-color: #35B109; width: 100%" >
							<input type="hidden" name="Usuario_Dni" value="<?php echo $_SESSION['dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $horas[$x] ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo $fechas[$j] ?>">
<?php
						}
																						  
						}else{
							
?>						
						<td bgcolor="#E80408">
							
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
							
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<button  type="submit" name="action" value="EDIT" style="background-color: #E80408; width: 100%">
							<input type="hidden" name="idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Hora" value="<?php echo $horas[$x] ?>">
							<input type="hidden" name="Fecha" value="<?php echo $fechas[$j] ?>">	
<?php
						}else{
?>	
							<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<button  type="submit" name="action" value="ADD" style="background-color: #E80408; width: 100%" disabled>
							<input type="hidden" name="Usuario_Dni" value="<?php echo $_SESSION['dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $horas[$x] ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo $fechas[$j] ?>">	
<?php 
							}
						}
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
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
					<form action='../Controllers/PISTA_CONTROLLER.php' method="get" style="display:inline">
						<button id="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/add_big.png" alt="AÑADIR" /></button>
					</form>
<?php }?>
		</div>
			<form action='../Controllers/DEFAULT_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>