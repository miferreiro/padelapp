<?php
/* 
	Fecha de creación: 2/12/2017 
	Función: vista de el formulario de buscar(search) realizada con una clase para buscar datos a la base de datos.
    Autor:Brais Santos
*/


//es la clase SEARCH de HISTORIA que nos permite buscar una historia
class HISTORIA_SEARCH {
//es el constructor de la clase HISTORIA_SEARCH
	function __construct() { 
		$this->render();//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes
	}
//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes
	function render() { 
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form name="SEARCH" action="../Controllers/HISTORIA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchHistoria()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur=" comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur=" comprobarCampoNumFormSearch(this, 2, 0, 99) "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['TextoHistoria'];?>
						</th>
						<td class="formThTd"><textarea id="TextoHistoria" name="TextoHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="50" rows="7"  onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
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