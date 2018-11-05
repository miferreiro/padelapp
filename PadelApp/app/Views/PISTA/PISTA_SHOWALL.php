<?php

class Pista_Showall{
	
    //es el constructor de la clase Pista_Showall
	function __construct( $lista, $datos) {
		$this->lista = $lista;//pasamos los campos de la tabla PISTAS
		$this->datos = $datos;//pasamos los valores de cada campo

		$this->render($this->lista,$this->datos);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	function render($lista,$datos){
		$this->lista = $lista;//pasamos los campos de la tabla PISTAS
		$this->datos = $datos;//pasamos los valores de cada campo

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego

  
	include '../Views/Header.php';//incluimos la cabecera
	

?>
<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<div class="col-md-4">
			<table class="table table-sm" align="center">
			<thead class="thead-light">
				<tr>
<?php
		$c=0;
					while( $li = mysqli_fetch_array( $this->lista) ){
						$c++;
?>
					<th>
						<?php echo $strings['idPista'];echo(' ');echo $li['idPista']?>
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<input type="hidden" name="idPista" value="<?php echo $li['idPista'] ?>">
						<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
	
						<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT"><img src="../Views/icon/verDetalles.png" alt="BUSCAR" width="20" height="20"/></button>	
						</form>
					</th>
<?php					
				}
?>
				</tr>
				<tr>
					<?php
						while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
					<tr>
<?php
					for($i=0;$i<$c;$i++){
						if(Comprobar_Disponibilidad($i+1,$fila['Hora'],date("Y-m-d"))==1){
?>
						<td bgcolor="#35B109" >	
							
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
							
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<button id ="buttonBien" type="submit" name="action" value="EDIT" style="background-color: #35B109">
							<input type="hidden" name="idPista" value="<?php echo $i+1 ?>">
							<input type="hidden" name="Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Fecha" value="<?php echo date("Y-m-d") ?>">	
<?php
						}else{
?>						    
							<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<button id ="buttonBien" type="submit" name="action" value="ADD" style="background-color: #35B109">
							<input type="hidden" name="Usuario_Dni" value="<?php echo $_SESSION['dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $i+1 ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo date("Y-m-d") ?>">
<?php
						}
																						  
						}else{
							
?>						
						<td bgcolor="#E80408">
							
<?php  if($_SESSION['tipo'] == 'Admin'){ ?>
							
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<button id ="buttonBien" type="submit" name="action" value="EDIT" style="background-color: #E80408">
							<input type="hidden" name="idPista" value="<?php echo $i+1 ?>">
							<input type="hidden" name="Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Fecha" value="<?php echo date("Y-m-d") ?>">	
<?php
						}else{
?>	
							<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<button id ="buttonBien" type="submit" name="action" value="ADD" style="background-color: #E80408" >
							<input type="hidden" name="Usuario_Dni" value="<?php echo $_SESSION['dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $i+1 ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo date("Y-m-d") ?>">	
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
?>
						</tr>											
				</thead>
			</table>
					<form action='../Controllers/PISTA_CONTROLLER.php' method="post" style="display:inline">
						<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
					</form>
		</div>
			<form action='../Controllers/DEFAULT_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>