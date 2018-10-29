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
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
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
				
			</table>
            <br>
            <br>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/USUARIO_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="login" value=<?php echo $this->valores['idPista'] ?> />
				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>