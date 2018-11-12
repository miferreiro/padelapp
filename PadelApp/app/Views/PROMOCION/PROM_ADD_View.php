<?php

class PROM_ADD {

	function __construct( $lista ) {
		$this->lista = $lista;
		
		$this->render( $this->lista );
	}

	function render( $lista ) { 
		$this->lista = $lista;
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/PROM_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="">
			<div class="datepicker"></div>
			<div class="col-sm-4">
			<table id="mydatatableAddPromo" class="table table-sm" id="mydatatablePromociones">
				<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['Fecha'];?>
						</th>
						<td class="formThTd"><input type="date" id="Fecha" name="Fecha" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="25" size="25" required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Hora'];?>
						</th>
						<td class="formThTd">
                   <select id="Hora" name="Hora" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->lista ) ) { //este bucle se va a repetir mientras no se devuelvan todos los grupos
?>
				<option value="<?php echo $fila[ 'Hora' ]?>">

<?php 
			
					echo $fila['Hora'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
					</td>
					</tr>

					
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/add_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/PROM_CONTROLLER.php' method="post" style="display: inline">
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