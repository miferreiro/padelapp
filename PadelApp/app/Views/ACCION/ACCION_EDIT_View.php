<?php
/*  Archivo php
	Nombre: ACCIONES_EDIT_View.php
    Autor: 	Alejandro Vila
	Fecha de creación: 23/11/2017  
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una acción en la base de datos
*/

//Es la clase EDIT de ACCION que nos permite editar una accion
class ACCION_EDIT {
//es el constructor de la clase ACCION_EDIT
	function __construct( $valores ) { 
		$this->valores = $valores;//le pasamos el valor de los campos de la tabla ACCION
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes
	}
//función render donde se mostrará el formulario EDIT con los campos correspondientes
	function render( $valores ) {
		$this->valores = $valores;//le pasamos el valor de los campos de la tabla ACCION
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/ACCION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditAccion()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdAccion" name="IdAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdAccion']?>" maxlength="6" size="10"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreAccion" name="NombreAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NombreAccion']?>" maxlength="60" size="70" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripAccion'];?>
						</th>
						<td class="formThTd"><textarea id="DescripAccion" name="DescripAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" cols="50" rows="3" maxlength="100"  required onBlur="comprobarVacio(this) && comprobarLongitud(this,'100') && comprobarTexto(this,'100')"/><?php echo $this->valores['DescripAccion']?></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/ACCION_CONTROLLER.php' style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>

			</table>
		</div>

		<?php
		include '../Views/Footer.php';//incluimos el pie de la pagina
		}
		}
		?>