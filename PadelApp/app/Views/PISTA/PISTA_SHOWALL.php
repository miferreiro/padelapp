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
<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/PISTA_CONTROLLER.php'>

						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>

					</form>
				</caption>
				<tr>
<?php
		$c=0;
					while( $li = mysqli_fetch_array( $this->lista) ){
						$c++;
?>
					<th>
						<?php echo $li['idPista']?>
						<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
						<input type="hidden" name="Hora" value="<?php echo $li['idPista'] ?>">
						<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
	
						<button id ="buttonBien" type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" width="20" height="20"/></button>	
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
<?php
						}else{
?>
					<td bgcolor="#E80408">
<?php 
						}
							echo $fila['Hora'];
							
?>
						
							<form action="../Controllers/PISTA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="idPista" value="<?php echo $i+1 ?>">
							<input type="hidden" name="Hora" value="<?php echo $fila['Hora'] ?>">
							<input type="hidden" name="Fecha" value="<?php echo date("Y-m-d") ?>">	
								<button id ="buttonBien" type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
	
						</form>	
				</td>
						
						
				
				   
<?php
					}
					}
																	 
?>
						</tr>
					
												
				
			</table>
			<form action='../Controllers/PISTA_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>