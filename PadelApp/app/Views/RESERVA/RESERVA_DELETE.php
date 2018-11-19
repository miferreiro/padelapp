<?php

class RESERVA_DELETE {

	function __construct( $valores) { 
		$this->valores = $valores;

		$this->render( $this->valores);
	}

	function render( $valores) { 
		$this->valores = $valores;
	

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Borra una reserva'];?>
			</h2>
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['Dni'];?>
					</th>
					<td>
						<?php echo $this->valores['Usuario_Dni']?>
					</td>
				</tr>			
				<tr>
					<th>
						<?php echo $strings['idPista'];?>
					</th>
					<td>
						<?php echo $this->valores['Pista_idPista']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Fecha'];?>
					</th>
					<td>
						<?php echo date( "d/m/Y", strtotime( $this->valores['Pista_Fecha']) )?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Hora'];?>
					</th>
					<td>
						<?php echo $this->valores['Pista_Hora']?>
					</td>
				</tr>
				</thead>
			</table>
			</div>	
<?php 
			echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];
?>
			<div>
			<form action="../Controllers/RESERVA_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="Usuario_Dni" value="<?php echo $this->valores['Usuario_Dni']; ?>">
				<input type="hidden" name="Pista_idPista" value="<?php echo $this->valores['Pista_idPista']; ?>">
				<input type="hidden" name="Pista_Fecha" value="<?php echo $this->valores['Pista_Fecha']; ?>">
				<input type="hidden" name="Pista_Hora" value="<?php echo $this->valores['Pista_Hora']; ?>">

				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/accept_big.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/RESERVA_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>