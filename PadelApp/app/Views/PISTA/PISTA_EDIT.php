<?php


class PISTA_EDIT {

	function __construct($valores) {
		$this->valores = $valores;
		$this->render($this->valores);
	}

	function render($valores) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			
		<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/PISTA_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<div class="col-md-4">
				<table class="table">
					<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['idPista'];?>
						</th>
						<td class="formThTd"><input type="text" id="idPista" name="idPista" value="<?php echo $this->valores['idPista']?>" readonly required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Hora'];?>
						</th>
						<td class="formThTd"><input type="text" id="Hora" name="Hora" value="<?php echo $this->valores['Hora']?>" readonly required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Fecha'];?>
						</th>
						<td class="formThTd">                       
						<input type="text" value="<?php echo date( "d/m/Y", strtotime( $this->valores['Fecha'] ) ) ?>" readonly required />

					</tr>
			<tr>
						<th class="formThTd">
							<?php echo $strings['Disponibilidad']?>
						</th>
						<td class="formThTd">
<?php
								if( $this->valores['Disponibilidad'] == "1"){
?>	
									<input type="radio"  id="Disponibilidad" name="Disponibilidad" value="1" checked />1<br>
									<input type="radio"  id="Disponibilidad" name="Disponibilidad" value="0"/>0<br>
<?php
								}else{
?>
									<input type="radio"  id="Disponibilidad" name="Disponibilidad" value="1" />1<br>
									<input type="radio"  id="Disponibilidad" name="Disponibilidad" value="0" checked />0<br>
<?php									
								}
?>								
							<tr align="center">
						<td colspan="2">
                            <input type="hidden" name="Fecha" value="<?php echo $this->valores['Fecha'] ?>">
							<button id ="buttonBien" type="submit" name="action" value="EDIT"><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
					    </form>
						<form action='../Controllers/PISTA_CONTROLLER.php' method="post" style="display: inline">
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