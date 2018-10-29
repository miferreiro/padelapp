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
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['Dni'];?>
					</th>
					<td>
						<?php echo $this->valores['Dni']?>
					</td>
				</tr>			
				<tr>
					<th>
						<?php echo $strings['idPista'];?>
					</th>
					<td>
						<?php echo $this->valores['idPista']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Fecha'];?>
					</th>
					<td>
						<?php echo $this->valores['Fecha']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Hora'];?>
					</th>
					<td>
						<?php echo $this->valores['Hora']?>
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
				<input type="hidden" name="Dni" value="<?php echo $fila['Dni']; ?>">
				<input type="hidden" name="idPista" value="<?php echo $fila['idPista']; ?>">
				<input type="hidden" name="Fecha" value="<?php echo $fila['Fecha']; ?>">
				<input type="hidden" name="Hora" value="<?php echo $fila['Hora']; ?>">

				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/RESERVA_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>