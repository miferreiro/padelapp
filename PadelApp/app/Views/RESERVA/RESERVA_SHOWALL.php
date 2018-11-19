<?php

class RESERVA_SHOWALL {

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
				<?php echo $strings['Tabla de reservas'];?>
			</h2>
			<div class="datepicker"></div>
			<div class="col-md-4">
			<table id="mydatatableReservaPistas" name="mydatatableReservaPistas" class="table table-sm" align="center" style="width:100%">
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
?>
					<th>
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
 				if($atributo=='Pista_Fecha'){
					echo date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
				}else{
							echo $fila[ $atributo ];
				}
?>
					</td>
<?php
					}
?>
					<td>
<?php
			if($_SESSION['tipo'] == 'Deportista'){	
				if(date("Y-m-d")<>$fila['Pista_Fecha']){
?>
						<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="Usuario_Dni" value="<?php echo $fila['Usuario_Dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $fila['Pista_idPista']; ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo $fila['Pista_Fecha']; ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $fila['Pista_Hora']; ?>">
				
								<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/delete_big.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>				
						</form>
<?php 
													   }
			}
?>						
				</tr>
<?php
						 }
								   
?>
				
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