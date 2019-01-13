<?php

class CAMPEONATO_CATEGORIA_DELETE {

	function __construct( $valores) {
		$this->valores = $valores;
		$this->render( $this->valores);
	}

	function render($valores) {
		$this->valores = $valores;

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2 align="center">
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<div class="col-md-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['Borrado de campeonato'];?>
					</th>
					<td>
						<?php echo $this->valores['IdCampeonato']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Tipo'];?>
					</th>
					<td>
						<?php echo $this->valores['Tipo']?>
					</td>
				</tr>
                <tr>
					<th>
						<?php echo $strings['Nivel'];?>
					</th>
					<td>
						<?php echo $this->valores['Nivel']?>
					</td>
				</tr>
				</thead>
			</table>
            <br>           
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato'] ?>" />
				<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo'] ?>" />
				<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel'] ?>" />
                <button id ="buttonBien" type="submit" id="DELETE" name="action" value="DELETE" ><img src="../Views/icon/accept_big.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php             
		include '../Views/Footer.php';
		
               
	}
}

?>