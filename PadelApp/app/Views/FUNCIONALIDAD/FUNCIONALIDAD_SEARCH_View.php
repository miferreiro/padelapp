<?php
/*  Archivo php
	Nombre: FUNCIONALIDAD_SEARCH_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 22/11/2017  
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una funcionalidad de la base de datos
*/


//es la clase SEARCH de FUNCIONALIDAD que nos permite buscar una funcionalidad
class FUNCIONALIDAD_SEARCH {
//es el constructor de la clase FUNCIONALIDAD_SEARCH
	function __construct() { 
		$this->render();//llamamos a la función render donde se mostrará el formulario search con los campos correspondientes
	}

    //función render donde se mostrará el formulario search con los campos correspondientes
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" action="../Controllers/FUNCIONALIDAD_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchFuncionalidad()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdFuncionalidad" name="IdFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreFuncionalidad" name="NombreFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripFuncionalidad'];?>
						</th>
						<td class="formThTd"><textarea id="DescripFuncionalidad" name="DescripFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" cols="50" rows="3" value="" maxlength="100"  onBlur="comprobarLongitud(this,'100') && comprobarTexto(this,'100')"/></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>