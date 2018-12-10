<?php

class NOTICIA_ADD {

	function __construct() {
		$this->render();
	}

	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de inserción de noticia'];?>
			</h2>
			<form name="ADD" action="../Controllers/NOTICIA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit=""/> 
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['Titulo'];?>
						</th>
						<td class="formThTd"><input type="text" id="Titulo" name="Titulo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="25" size="25" required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contenido'];?>
						</th>
						<td class="formThTd">
							<textarea id="Contenido" name="Contenido" rows="10" cols="50" required>
							</textarea>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Foto'];?>
						</th>
						<td class="formThTd"><input type="file" id="fotopersonal" name="fotopersonal"/>
					</tr>
					
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/accept_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/NOTICIA_CONTROLLER.php' method="post" style="display: inline">
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