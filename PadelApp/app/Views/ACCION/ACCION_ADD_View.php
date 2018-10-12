<?php
/*  Archivo php
	Nombre: ACCION_ADD_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 23/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos.
*/

//es la clase ADD de ACCION que nos permite añadir una accion
class ACCION_ADD {

    //es el constructor de la clase ACCION_ADD
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes
	}

   //En está función se mostrará el formulario ADD con los campos correspondientes
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/ACCION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddAccion()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdAccion" name="IdAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="10" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreAccion" name="NombreAccion" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="60" size="70" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripAccion'];?>
						</th>
						<td class="formThTd"><textarea id="DescripAccion" name="DescripAccion" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="100" cols="50" rows="3" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'100') && comprobarTexto(this,'100')"/></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/ACCION_CONTROLLER.php' method="post" style="display: inline">
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