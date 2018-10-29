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
		<div align="center" class="seccion">
			<h2 align="center">
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH"name="SEARCH" action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchCampeonato()">
				<div class="col-md-4">
				<table class="table table-sm">
					<thead class="thead-light">
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
							<?php echo $strings['HoraIni'];?>
						</th>
						<td class="formThTd"><input type="time" id="HoraIni" name="HoraIni" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20"   onBlur=""/>
					</tr>                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFin'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFin" class="tcal" name="FechaFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" onBlur="" readonly/>
					</tr>
                 	<tr>
					<th class="formThTd">
							<?php echo $strings['HoraFin'];?>
						</th>
						<td class="formThTd"><input type="time" id="HoraFin" name="HoraFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20"   onBlur=""/>
					</tr>
				</thead>
                  		<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
					</form>
						<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display:inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
					
				</table>
			</div>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>