<?php
class CALENDARIO_EDIT {

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
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/CALENDARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" /><!--onsubmit="return comprobarEditUsuario()">-->
				<div class="col-sm-4">
				<table class="table table-sm">
					<thead class="thead-light">
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdCampeonato'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdCampeonato" name="IdCampeonato" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdCampeonato']?>" maxlength="12" size="12" readonly  required /> <!-- onBlur="comprobarVacio(this) && comprobarLongitud(this,'12') && comprobarTexto(this,'12') && comprobarDni(this)"-->  
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd"><input type="text" id="Tipo" name="Tipo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Tipo']?>" maxlength="25" size="25" readonly required /> <!-- onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'25') && comprobarTexto(this,'25')"--> 
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nivel'];?>
						</th>
						<td class="formThTd"><input type="text" id="Nivel" name="Nivel" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Nivel']?>" maxlength="128" size="40"  readonly required />  <!-- onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,128) && comprobarTexto(this,128)"--> 
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Letra'];?>
						</th>
						<td class="formThTd"><input type="text" id="Letra" name="Letra" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Letra']?>" maxlength="30" size="31" readonly required  /><!-- onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"-->					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NumEnfrentamiento'];?>
						</th>
						<td class="formThTd"><input type="text" id="NumEnfrentamiento" name="NumEnfrentamiento" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NumEnfrentamiento']?>" maxlength="45" size="40" readonly required /> <!-- onBlur="comprobarVacio(this) && comprobarLongitud(this,'45') && comprobarTexto(this,'45') && comprobarAlfabetico(this,'45')"-->
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NumPareja'] . "1";?>
						</th>
						<td class="formThTd"><input type="text" id="pareja1" name="pareja1" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['pareja1']?>" maxlength="14" size="14" readonly required /> <!-- onBlur="comprobarVacio(this) && comprobarLongitud(this,'14') && comprobarTexto(this,'14') && comprobarTelf(this)"-->
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NumPareja']. "2";?>
						</th>
						<td class="formThTd"><input type="text" id="pareja2" name="pareja2" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['pareja2']?>" maxlength="14" size="14" readonly required /> <!-- onBlur="comprobarVacio(this) && comprobarLongitud(this,'14') && comprobarTexto(this,'14') && comprobarTelf(this)"-->
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Resultado'];?>
						</th>
						<td class="formThTd"><input type="text" id="Resultado" name="Resultado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Resultado']?>" maxlength="12" size="12" required  /> <!-- onBlur="comprobarVacio(this) && comprobarLongitud(this,'12') && comprobarTexto(this,'12') "-->
					</tr>
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="EDITAR"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						</thead>
				</table>
			</div>
			<form action='../Controllers/CALENDARIO_CONTROLLER.php' style="display: inline">
				<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
				<input type="hidden" name="Letra" value="<?php echo $this->valores['Letra']; ?>">
				<button id ="buttonBien"type="submit" name="action" value="TABLA"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>
			
		</div>

		<?php
		include '../Views/Footer.php';
		}
		}
		?>