<?php

class CAMPEONATO_SEARCH {
	
	function __construct() {
		$this->render();
	}
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div align="center" class="seccion">
			<h2 align="center">
				<?php echo $strings['Búsqueda de campeonato'];?>
			</h2>
			<form id="SEARCH"name="SEARCH" action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchCampeonato()">
				<div class="col-md-4">
				<table class="table table-sm">
					<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdCampeonato'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdCampeonato" name="IdCampeonato" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="11" size="11" />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['FechaIni'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIni" class="tcal" name="FechaIni" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" readonly />
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
						<td class="formThTd"><input type="text" id="FechaFin" class="tcal" name="FechaFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" readonly />
					</tr>
                 	<tr>
					<th class="formThTd">
							<?php echo $strings['HoraFin'];?>
						</th>
						<td class="formThTd"><input type="time" id="HoraFin" name="HoraFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20"  />
					</tr>
				</thead>
                  		<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="SEARCH"><img src="../Views/icon/search_big.png" alt="BUSCAR" /></button>
					</form>
						<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display:inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
					
				</table>
			</div>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}

?>