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
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
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
						<?php echo $strings['FechaFin'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaFin']?>
					</td>
				</tr>
				
			</table>
            <br>
            <br>            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $this->valores['IdTrabajo'] ?>" />
				<input type="hidden" name="FechaIni" value="<?php echo $this->valores['FechaIni'] ?>" />
				<input type="hidden" name="FechaFin" value="<?php echo $this->valores['FechaFin'] ?>" />
                <button id ="buttonBien" type="submit" id="DELETE" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php             
		include '../Views/Footer.php';//incluimos el pie de la página
               
	}
}

?>