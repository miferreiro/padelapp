<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_SEARCH_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de el formulario de search que permite buscar una asig_qa
*/
//Clase Asignac_qa_search que contiene la vista de un formulario para poder buscar las asignaciones de qa
class ASIGNAC_QA_SEARCH {
	//Constructor de la clase
	function __construct() {
		$this->render();//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchAsignQa()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="7" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="9" size="10" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9') "/>
					</tr>
				
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluado" name="LoginEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="9" size="10" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="6" size="7" onBlur="ComprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//Incluye el contenido del pie
		}
		}
?>