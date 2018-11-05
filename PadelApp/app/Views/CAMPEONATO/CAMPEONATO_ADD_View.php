<?php

class CAMPEONATO_ADD {

	function __construct() {
		$this->render();
	}
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2 align="center">
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/CAMPEONATO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddCampeonato()">
				<div class="col-md-4">
				<table class="table table-sm">
					<thead class="thead-light">
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
							<?php echo $strings['HoraIni'];?>
						</th>
						<td class="formThTd"><input type="time" id="HoraIni" name="HoraIni" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20"  required onBlur="comprobarVacio(this)"/>
					</tr> 
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFin'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFin" name="FechaFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20" class="tcal" readonly required onBlur=""/>
					</tr>         
					<tr>
					<th class="formThTd">
							<?php echo $strings['HoraFin'];?>
						</th>
						<td class="formThTd"><input type="time" id="HoraFin" name="HoraFin" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20"  required onBlur="comprobarVacio(this)"/>
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria masculina Nivel 1'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Masculina1" /> <br>
 						</td>        
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria masculina Nivel 2'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Masculina2" /> <br>
 						</td>        
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria masculina Nivel 3'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Masculina3" /> <br>
 						</td>        
					</tr>				                    					
					<th class="formThTd">
							<?php echo $strings['Categoria femenina Nivel 1'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Femenina1" /> <br>
 						</td>        
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria femenina Nivel 2'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Femenina2" /> <br>
 						</td>        
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria femenina Nivel 3'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Femenina3" /> <br>
 						</td>        
					</tr>				                    					
					<th class="formThTd">
							<?php echo $strings['Categoria mixta Nivel 1'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Mixta1" /> <br>
 						</td>        
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria mixta Nivel 2'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Mixta2" /> <br>
 						</td>        
					</tr>
					<tr>
					<th class="formThTd">
							<?php echo $strings['Categoria mixta Nivel 3'];?>
						</th>
						<td class="formThTd">		
							<input type="checkbox" name="categoria[]" id="categoria" value="Mixta3" /> <br>
 						</td>        
					</tr>	
				</thead>
					         					         					                                                                    
					<tr align="center">
						<td colspan="2">
							<button id ="buttonBien" type="submit" name="action" value="ADD"><img src="../Views/icon/accept_big.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/CAMPEONATO_CONTROLLER.php' method="post" style="display: inline">
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