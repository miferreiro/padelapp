<?php
/*  Archivo php
	Nombre: FUNCIONALIDAD_EDIT_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 22/11/2017  
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una Funcionalidad en la base de datos
*/


//es la clase EDIT de FUNCIONALIDAD que nos permite editar una funcionalidad
class FUNCIONALIDAD_EDIT {
//es el constructor de la clase FUNCIONALIDAD_EDIT
	function __construct( $valores ) { 
		$this->valores = $valores;//pasamos los valores de los campos
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes
	}
//función render donde se mostrará el formulario EDIT con los campos correspondientes
	function render( $valores ) {
		$this->valores = $valores;//pasamos los valores de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/FUNCIONALIDAD_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit = "return comprobarEditFuncionalidad()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdFuncionalidad" name="IdFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdFuncionalidad']?>" maxlength="6" size="6"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreFuncionalidad" name="NombreFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NombreFuncionalidad']?>" maxlength="60" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripFuncionalidad'];?>
						</th>
						<td class="formThTd"><textarea id="DescripFuncionalidad" name="DescripFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="100" cols="50" rows="3" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'100') && comprobarTexto(this,'100')"/><?php echo $this->valores['DescripFuncionalidad']?></textarea>
					</tr>
				
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>

			</table>
		</div>

		<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
		?>