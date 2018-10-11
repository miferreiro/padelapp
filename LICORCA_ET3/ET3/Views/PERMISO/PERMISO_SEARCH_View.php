<?php
/*  Archivo php
	Nombre: PERMISOS_SEARCH_View.php
	Fecha de creación: 27/11/2017 
	Autor: Jonatan Couto
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar un permiso en la base de datos
*/
//Es la clase SEARCH de PERMISO que nos permite buscar permisos 
class PERMISO_SEARCH {
	//es el constructor de la clase PERMISO_SEARCH
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
			<form id="SEARCH" name= "SEARCH" action="../Controllers/PERMISO_CONTROLLER.php" method="post" enctype="multipart/form-data" onSubmit="return comprobarSearchPermisos()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreGrupo" name="NombreGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="60" size="61" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>					
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreFuncionalidad" name="NombreFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="60" size="61" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreAccion" name="NombreAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="60" size="61" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60') "/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" />
							</button>
			</form>
						<form action='../Controllers/PERMISO_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';//incluimos el footer
		}
		}
?>