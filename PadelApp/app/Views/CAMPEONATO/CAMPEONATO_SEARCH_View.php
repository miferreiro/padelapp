<?php

class CAMPEONATO_SEARCH {
	//es el constructor de la clase CAMPEONATO_SEARCH
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes y sus valores
	}
	//funcion que mostrará el formulario SEARCH con los campos correspondientes y sus valores
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH"name="SEARCH" action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchCampeonato()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdCampeonato'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdCampeonato" name="IdCampeonato" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="11" size="11" onBlur="comprobarLongitud(this,'11') && comprobarTexto(this,'11') && comprobarEntero(this,0,999999999)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['FechaIni'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIni" class="tcal" name="FechaIni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" onBlur="" readonly/>
					</tr>                   
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFin'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFin" class="tcal" name="FechaFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" onBlur="" readonly/>
					</tr>
                  		<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>