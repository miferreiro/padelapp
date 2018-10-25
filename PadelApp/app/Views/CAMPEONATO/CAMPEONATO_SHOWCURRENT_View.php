<?php

class CAMPEONATO_SHOWCURRENT {

	function __construct( $lista ) {
		$this->lista = $lista;//pasamos los valores de cada uno de los campos
		$this->render( $this->lista );//llamamos a la función render donde se mostrará el formulario SHOWCURRENT con los campos correspondientes y sus valores
	}
	//funcion que mostrará la vista SHOWCURRENT con los campos correspondientes y sus valores
	function render( $lista ) {
		$this->lista = $lista;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
					<th>
						<?php echo $strings['IdCampeonato'];?>
					</th>
					<td>
						<?php echo $this->lista['IdCampeonato']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['FechaIni'];?>
					</th>
					<td>
						<?php echo $this->lista['FechaIni']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['FechaFin'];?>
					</th>
					<td>
						<?php echo $this->lista['FechaFin']?>
					</td>
				</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>