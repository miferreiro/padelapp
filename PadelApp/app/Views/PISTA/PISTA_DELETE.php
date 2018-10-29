<?php

class PISTA_DELETE {

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
			<div class="col-md-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['idPista'];?>
					</th>
					<td>
						<?php echo $this->valores['idPista']?>
					</td>
				</tr>			
				</thead>
			</table>
			</div>
<?php 
			echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];
?>
			<div>
			<form action="../Controllers/PISTA_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="login" value=<?php echo $this->valores['idPista'] ?> />
				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/PISTA_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>