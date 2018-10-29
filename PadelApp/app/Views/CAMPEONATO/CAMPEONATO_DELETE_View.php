<?php

class CAMPEONATO_DELETE {

	function __construct( $valores) {
		$this->valores = $valores;
		$this->render( $this->valores);//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes y sus valores
	}

	function render($valores) {
		$this->valores = $valores;//pasamos los valores de cada uno de los campos

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
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
						<?php echo $strings['IdCampeonato'];?>
					</th>
					<td>
						<?php echo $this->valores['IdCampeonato']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['FechaIni'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaIni']?>
					</td>
				</tr>
                <tr>
					<th>
						<?php echo $strings['HoraIni'];?>
					</th>
					<td>
						<?php echo $this->valores['HoraIni']?>
					</td>
				</tr>
                <tr>
					<th>
						<?php echo $strings['FechaFin'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaFin']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['HoraFin'];?>
					</th>
					<td>
						<?php echo $this->valores['HoraFin']?>
					</td>
				</tr>
				</thead>
			</table>
            <br>           
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato'] ?>" />
				<input type="hidden" name="FechaIni" value="<?php echo $this->valores['FechaIni'] ?>" />
				<input type="hidden" name="FechaFin" value="<?php echo $this->valores['FechaFin'] ?>" />
               	<input type="hidden" name="HoraIni" value="<?php echo $this->valores['HoraIni'] ?>" />
               	<input type="hidden" name="HoraFin" value="<?php echo $this->valores['HoraFin'] ?>" />
                <button id ="buttonBien" type="submit" id="DELETE" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php             
		include '../Views/Footer.php';//incluimos el pie de la página
               
	}
}

?>