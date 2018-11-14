<?php

class INSPROM_SHOWALL {

	function __construct( $lista, $datos) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos);
	}
	
	function render($lista,$datos){
		$this->lista = $lista;
		$this->datos = $datos;

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
  
	include '../Views/Header.php';		
?>

		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<div class="col-md-3">
			<table class="table">
				<thead class="thead-light">
				
				<tr>
<?php
					foreach ( $lista as $atributo ) { 
?>
						<th>
							<?php echo $strings[$atributo]?>
						</th>
<?php
					}
			if($_SESSION['tipo'] == 'Deportista'){
?>
					<th>
						<?php echo $strings['Opciones']?>
					</th>
<?php
				}
?>
				</tr>
<?php
					
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { 
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { 
?>
					<td>
<?php 
 				if($atributo == 'Fecha'){
					echo date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
				}else{
							echo $fila[ $atributo ];
				}
?>
					</td>
<?php
					}
					if($_SESSION['tipo'] == 'Deportista'){		
?>
					<td align="center">

						<form action="../Controllers/INSPROM_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="Promociones_Fecha" value="<?php echo $fila['Promociones_Fecha']; ?>">
							<input type="hidden" name="Promociones_Hora" value="<?php echo $fila['Promociones_Hora']; ?>">
							<input type="hidden" name="Usuario_Dni" value="<?php echo $fila['Usuario_Dni']; ?>">
								<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/delete_big.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>	
						</form>	
						
<?php
														 
					}
?>
			
				</tr>	
			
<?php			
					   }
					    
					   
?>
							
				</thead>
			</table>
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