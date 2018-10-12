<?php
/*  Archivo php
	Nombre: EVALUACION_SEARCH_View.php
	Autor: 	Brais Rodriguez
	Fecha de creación: 26/11/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una evaluacion en la base de datos
*/
//Clase Evaluacion_search que contiene la vista para ver el formulario de busqueda de la tabla evaluación
class EVALUACION_SEARCH {
	//Constructor de la clase
	function __construct() {
		//metodo que llama a la función render que contiene todo el código de la vista
		$this->render();
	}
	//Función que contiene el código de la vista
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header

?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" action="../Controllers/EVALUACION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchEvaluacion()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" value="" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')" />
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" value="" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')" />
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur="comprobarCampoNumFormSearch(this, 2, 0, 99)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarCampoNumFormSearch(this, 1, 0, 2)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ComenIncorrectoA'];?>
						</th>
                        <td class="formThTd"><textarea  id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8" onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarCampoNumFormSearch(this, 1, 0, 2)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ComentIncorrectoP'];?>
						</th>
                        <td class="formThTd"><textarea id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8" onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300') "></textarea>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="text" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarCampoNumFormSearch(this, 1, 0, 2)"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>