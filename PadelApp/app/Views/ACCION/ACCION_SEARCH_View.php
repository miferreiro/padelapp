<?php
/*  Archivo php
	Nombre: ACCION_SEARCH_View.php
    Autor: Alejandro Vila
	Fecha de creación: 23/11/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una acción de la base de datos
*/

//Es la clase SEARCH de ACCION que nos permite buscar una accion
class ACCION_SEARCH {
//es el constructor de la clase ACCION_SEARCH
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes
	}
//función render donde se mostrará el formulario SEARCH con los campos correspondientes
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/ACCION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchAccion()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdAccion" name="IdAccion" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="6" size="10" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreAccion" name="NombreAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="70" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripAccion'];?>
						</th>
						<td class="formThTd"><textarea id="DescripAccion" name="DescripAccion" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="100" cols="50" rows="3" onBlur="comprobarLongitud(this,'100') && comprobarTexto(this,'100')" /></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/ACCION_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la pagina
		}
		}
?>