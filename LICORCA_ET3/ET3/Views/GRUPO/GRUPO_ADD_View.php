<?php
/*  Archivo php
	Nombre: GRUPO_ADD_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 20/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir un grupo a la base de datos
*/
//Clase GRUPO_ADD que contiene la vista del formulario para añadir un grupo
class GRUPO_ADD {
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
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/GRUPO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddGrupo()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdGrupo" name="IdGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreGrupo" name="NombreGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="65" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripGrupo'];?>
						</th>
						<td class="formThTd"><textarea cols="50" rows="3" id="DescripGrupo" name="DescripGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="100" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'100') && comprobarTexto(this,'100')"/></textarea>
						
					</tr>
						
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/GRUPO_CONTROLLER.php' method="post" style="display: inline">
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