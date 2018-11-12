<?php

class Pista_Showall{
	
    //es el constructor de la clase Pista_Showall
	function __construct( $lista, $datos,$datos2) {
		$this->lista = $lista;//pasamos los campos de la tabla PISTAS
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->datos2 = $datos2;//pasamos los valores de cada campo
		$this->render($this->lista,$this->datos,$this->datos2);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	function render($lista,$datos,$datos2){
		$this->lista = $lista;//pasamos los campos de la tabla PISTAS
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->datos2 = $datos2;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego

  
	include '../Views/Header.php';//incluimos la cabecera
	

?>
<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
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
						<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/delete_big.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
	
						<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT"><img src="../Views/icon/verdetalles_2.jpg" alt="BUSCAR" width="20" height="20"/></button>	
						</form>
					</th>
<?php					
				}
?>
				</tr>
				</thead>	
				
<?php
						while ($fila2 = mysqli_fetch_array( $this->datos2) ) {

						while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
					<td>
					
<?php
							echo date( "d/m/Y", strtotime( $fila2[ 'Fecha' ] ) );
?>
					
					</td>
<?php
					for($i=0;$i<$c;$i++){
						if(Comprobar_Disponibilidad($aux[$i+1],$fila['Hora'],$fila2['Fecha'])==1){
?>
						<td bgcolor="#35B109">
							
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
							
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<button type="submit" name="action" value="EDIT" style="background-color: #35B109; width: 100%">
							<input type="hidden" name="idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Fecha" value="<?php echo $fila2['Fecha'] ?>">	
<?php
						}else{
?>						    
							<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<button type="submit" name="action" value="ADD" style="background-color: #35B109; width: 100%">
							<input type="hidden" name="Usuario_Dni" value="<?php echo $_SESSION['dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo $fila2['Fecha'] ?>">
<?php
						}
																						  
						}else{
							
?>						
						<td bgcolor="#E80408">
							
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
							
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<button  type="submit" name="action" value="EDIT" style="background-color: #E80408; width: 100%">
							<input type="hidden" name="idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Fecha" value="<?php echo $fila2['Fecha'] ?>">	
<?php
						}else{
?>	
							<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<button  type="submit" name="action" value="ADD" style="background-color: #E80408; width: 100%" disabled>
							<input type="hidden" name="Usuario_Dni" value="<?php echo $_SESSION['dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $aux[$i+1] ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo $fila2['Fecha'] ?>">	
<?php 
						
							}
						}
							echo $fila['Hora'];						
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
					<form action='../Controllers/PISTA_CONTROLLER.php' method="get" style="display:inline">
						<button id="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/add_big.png" alt="AÑADIR" /></button>
					</form>
		</div>
			<form action='../Controllers/DEFAULT_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>