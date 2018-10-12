<?php
/*  Archivo php
	Nombre: GRUPO_EDIT_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 21/11/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de un grupo en la base de datos
*/
//Clase GRUPO_EDIT que contiene la vista para mostar un formulario de edición de una tupla
class GRUPO_EDIT {
	//Constructor de la clase
	function __construct( $valores ) {
		$this->valores = $valores;//Variable que almacena la información de la tupla a editar
		//metodo que llama a la función render que contiene todo el código de la vista
		$this->render( $this->valores);
	}
//función render que contiene todo el código de la vista
	function render( $valores) {
 		$this->valores = $valores;//Variable que almacena la información de la tupla a editar
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/GRUPO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditGrupo()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdGrupo" name="IdGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $valores['IdGrupo'] ?>" maxlength="6" size="10"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreGrupo" name="NombreGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NombreGrupo'] ?>" maxlength="60" size="65" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripGrupo'];?>
						</th>
						<td class="formThTd"><textarea cols="50" rows="3" id="DescripGrupo" name="DescripGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="100"  required onBlur="comprobarVacio(this) && comprobarLongitud(this,'100') && comprobarTexto(this,'100')"/><?php echo $this->valores['DescripGrupo'] ?></textarea>
					</tr>
				
					
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
					</form>
					<form action='../Controllers/GRUPO_CONTROLLER.php' style="display: inline">
						<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
					</form>
				</tr>

			</table>
		</div>

		<?php
		include '../Views/Footer.php';
		}
		}
		?>