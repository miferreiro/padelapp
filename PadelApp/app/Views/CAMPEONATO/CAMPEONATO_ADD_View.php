<?php

class CAMPEONATO_ADD {

	function __construct() {
		$this->render();
	}
	//funcion que mostrará el formulario ADD con los campos correspondientes y sus valores
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddCampeonato()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdCampeonato'];?>
						</th>
						<td class="formThTd"><input type="number" id="IdCampeonato" name="IdCampeonato" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="11" size="11" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'11') && comprobarTexto(this,'11') && comprobarEntero(this,0,999999999)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['FechaIni'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIni" name="FechaIni" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20" class="tcal" readonly required onBlur=""/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFin'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFin" name="FechaFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20" class="tcal" readonly required onBlur=""/>
					</tr>                  
					<tr>
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display: inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?><strong></strong>