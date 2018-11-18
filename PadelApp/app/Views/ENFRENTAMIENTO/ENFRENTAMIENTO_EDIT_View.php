<?php
class ENFRENTAMIENTO_EDIT {

	function __construct( $valores ) { 
		$this->valores = $valores;
		$this->render( $this->valores );
	}
 
	function render( $valores ) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de enfrentamientos'];?>
			</h2>
			<form name="EDIT" action="../Controllers/GRUPO_CONTROLLER.php" method="post" enctype="multipart/form-data" />
				<div class="col-sm-5">
				<table class="table table-sm">
					<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdCampeonato'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdCampeonato" name="IdCampeonato" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdCampeonato']?>" maxlength="12" size="12" readonly  required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd"><input type="text" id="Tipo" name="Tipo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Tipo']?>" maxlength="25" size="25" readonly required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nivel'];?>
						</th>
						<td class="formThTd"><input type="text" id="Nivel" name="Nivel" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Nivel']?>" maxlength="128" size="40"  readonly required />  
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Letra'];?>
						</th>
						<td class="formThTd"><input type="text" id="Letra" name="Letra" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Letra']?>" maxlength="30" size="31" readonly required  />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NumEnfrentamiento'];?>
						</th>
						<td class="formThTd"><input type="text" id="NumEnfrentamiento" name="NumEnfrentamiento" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NumEnfrentamiento']?>" maxlength="45" size="40" readonly required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NumPareja'] . "1";?>
						</th>
						<td class="formThTd"><input type="text" id="pareja1" name="pareja1" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['pareja1']?>" maxlength="14" size="14" readonly required /> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NumPareja']. "2";?>
						</th>
						<td class="formThTd"><input type="text" id="pareja2" name="pareja2" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['pareja2']?>" maxlength="14" size="14" readonly required />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Resultado primer set'];?>
						</th>
						<td class="formThTd">

							<select name="ResultadoSet1Par1" required>
							  <option value = "<?php echo $this->valores['ResultadoSet1Par1']?>"><?php echo $this->valores['ResultadoSet1Par1']?></option>
							  <option value="0">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							</select>
							

							<?php echo(":")?>


							<select name="ResultadoSet1Par2" required>
							   <option value = "<?php echo $this->valores['ResultadoSet1Par2']?>"><?php echo $this->valores['ResultadoSet1Par2']?></option>
							  <option value="0">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							</select>							
					</tr>
						<tr>
						<th class="formThTd">
							<?php echo $strings['Resultado segundo set'];?>
						</th>
						<td class="formThTd">

							<select name="ResultadoSet2Par1" required>
							   <option value = "<?php echo $this->valores['ResultadoSet2Par1']?>"><?php echo $this->valores['ResultadoSet2Par1']?></option>
							  <option value="0">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							</select>
							

							<?php echo(":")?>


							<select name="ResultadoSet2Par2" required>
							   <option value = "<?php echo $this->valores['ResultadoSet2Par2']?>"><?php echo $this->valores['ResultadoSet2Par2']?></option>
							  <option value="0">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							</select>							
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Resultado tercer set'];?>
						</th>
						<td class="formThTd">

							<select name="ResultadoSet3Par1">
							   <option value = "<?php echo $this->valores['ResultadoSet3Par1']?>"><?php echo $this->valores['ResultadoSet3Par1']?></option>
							  <option value="0">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							</select>
							

							<?php echo(":")?>


							<select name="ResultadoSet3Par2">
							   <option value = "<?php echo $this->valores['ResultadoSet3Par2']?>"><?php echo $this->valores['ResultadoSet3Par2']?></option>
							  <option value="0">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							</select>		
					</tr>
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="EDITAR"><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						</thead>
				</table>
			</div>
			<form action='../Controllers/GRUPO_CONTROLLER.php' style="display: inline">
				<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
				<input type="hidden" name="Letra" value="<?php echo $this->valores['Letra']; ?>">
				<button id ="buttonBien"type="submit" name="action" value="TABLA"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>
			
		</div>

		<?php
		include '../Views/Footer.php';
		}
		}
		?>