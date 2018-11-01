<?php

class CAMPEONATO_SHOWALL {

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
		<div align="center" class="seccion">
			<h2 align="center">
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<div class="col-md-7">
			<table align="center" class="table">
		
				<thead class="thead-light">
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<th scope="col">
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
					<th scope="col" colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
				</tr>
				</thead>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 					
					if ( $atributo == 'FechaIni' ) {
						$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
					if ( $atributo == 'FechaFin' ) {
							$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
						echo $fila[ $atributo ];			
?>
					</td>

<?php
					}
?>
					<td>
						<form action="../Controllers/CAMPEONATO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">
				
								<button id ="buttonBien"type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
					
								<button id ="buttonBien"type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
						</form>	
						<form action="../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php" method="get" style="display:inline" >				
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">
								<button id ="buttonBien"type="submit" ><img src="../Views/icon/categoria.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>	
						</form>
						

				</tr>
				
<?php
				}
?>
			
			</table>
					<form action='../Controllers/CAMPEONATO_CONTROLLER.php'>
				

						<button id ="buttonBien" type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>

	  
						<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>

					</form>
			
			
			

			<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</div>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>