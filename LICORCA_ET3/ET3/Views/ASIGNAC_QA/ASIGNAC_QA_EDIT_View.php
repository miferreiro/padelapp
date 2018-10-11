<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_EDIT_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una asignación qa en la base de datos
*/
//Clase Asignac_qa_edit que contiene la vista de un formulario para poder editar una tupla
class ASIGNAC_QA_EDIT {
	//Constructor de la clase
	function __construct( $valores ) {
		$this->valores = $valores;//Variable que almacena un recordset con la info de un tupla
		$this->render( $this->valores );//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render( $valores ) {
 		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form id="EDIT" name="EDIT" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditAsignQa()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdTrabajo']?>" maxlength="6" size="10" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" readonly />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['LoginEvaluador']?>" maxlength="9" size="10" onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') " readonly />
					</tr>
				
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluado" name="LoginEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['LoginEvaluado']?>" maxlength="6" size="7" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6') "/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['AliasEvaluado']?>" maxlength="6" size="7" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" readonly />
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
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