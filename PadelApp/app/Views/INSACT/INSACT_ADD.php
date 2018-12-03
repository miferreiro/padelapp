<?php

class INSPROM_ADD {

	function __construct() {
		$this->render();
	}

	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/INSPROM_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="">
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['Fecha'];?>
						</th>
						<td class="formThTd"><input type="date" id="Promociones_Fecha" name="Promociones_Fecha" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="12" size="12" required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Promociones_Hora'];?>
						</th>
						<td class="formThTd"><input type="time" id="Promociones_Hora" name="Promociones_Hora" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="25" size="25" required />
					</tr>
					
					<tr align="center">
						<td colspan="2">
							<input type="hidden" name="Usuario_Dni" value="<?php $_SESSION[ 'dni' ]?>">
							<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/add_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/INSPROM_CONTROLLER.php' method="post" style="display: inline">
							<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</thead>
				</table>
				</div>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>