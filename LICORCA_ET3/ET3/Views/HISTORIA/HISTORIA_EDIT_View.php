<?php
/*
	Fecha de creación: 2/12/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una historia en la base de datos
    Autor:Brais Santos
*/


//es la clase EDIT de HISTORIA que nos permite editar una historia
class HISTORIA_EDIT {
//es el constructor de la clase HISTORIA_EDIT
	function __construct( $valores ) { 
		$this->valores = $valores;//pasamos los valores de cada campo de la tupla que fue seleccionada en el showall
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes
	}
//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes
	function render( $valores ) { 
		$this->valores = $valores;//pasamos los valores de cada campo de la tupla que fue seleccionada en el showall
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/HISTORIA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditHistoria()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $valores['IdTrabajo'] ?>" maxlength="6" size="6"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdHistoria'] ?>" maxlength="2" size="2" readonly required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,99)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['TextoHistoria'];?>
						</th>
						<td class="formThTd"><textarea id="TextoHistoria" name="TextoHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="300" cols="50" rows="7"  required onBlur="comprobarVacio(this) && comprobarLongitud(this,'300') && comprobarTexto(this,'300')" ><?php echo $this->valores['TextoHistoria'] ?></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/HISTORIA_CONTROLLER.php' style="display: inline">
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