<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de el formulario de buscar(search) realizada con una clase donde se muestran todos los campos a buscar 
    Autor:Brais Rodriguez
*/

 //es la clase SEARCH de NOTA_TRABAJO que nos permite buscar una nota
class NOTA_TRABAJO_SEARCH {
//es el constructor de la clase  NOTA_TRABAJO_SEARCH
	function __construct() { 
		$this->render(); //funcion que mostrará el formulario SEARCH con los campos correspondientes
	}
 //funcion que mostrará el formulario SEARCH con los campos correspondientes
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchNotas()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="9"  onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6"  onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nota del Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NotaTrabajo" name="NotaTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="4" size="4"  onBlur="comprobarLongitud(this,'4') && comprobarTexto(this,4)"/>
					</tr>
				
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post" style="display: inline">
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